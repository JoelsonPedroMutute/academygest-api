<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Auth;


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
}
