<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;


class AuthService
{
    public function login(array $credentials): array
    {
        if (!Auth::attempt($credentials)) {
            return [
                'success' => false,
                'message' => 'Credenciais inválidas.'
            ];
        }

        $user = Auth::user();

        if ($user->status !== 'active') {
            Auth::logout();

            return [
                'success' => false,
                'message' => 'Conta não autorizada.'
            ];
        }

        return [
            'success' => true,
            'message' => 'Login realizado com sucesso.',
            'user'    => $user,
            'token'   => $user->createToken('api-token')->plainTextToken
        ];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()?->delete();
    }

    public function forgotPassword(array $data): array
    {
        $status = Password::sendResetLink($data);

        if ($status === Password::RESET_LINK_SENT) {
            return [
                'success' => true,
                'message' => __($status)
            ];
        }

        return [
            'success' => false,
            'message' => __($status)
        ];
    }

    public function resetPassword(array $data): array
    {
        $status = Password::reset(
            $data,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return [
                'success' => true,
                'message' => __($status)
            ];
        }

        return [
            'success' => false,
            'message' => __($status)
        ];
    }
}
