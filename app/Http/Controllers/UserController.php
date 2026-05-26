<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Aluno;
use App\Models\Docente;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | CRIAÇÃO
    |--------------------------------------------------------------------------
    */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        $data = $request->validated();

        // proteção: só admin pode criar admin
        if (
            $data['role'] === 'admin' &&
            Auth()->Auth::user()->role !== 'admin'
        ) {
            return $this->error('Acesso negado.', 403);
        }

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
        ]);

        // criação de perfil dependente (regra de domínio)
        $this->createProfile($user);

        return new UserResource($user);
    }

    /*
    |--------------------------------------------------------------------------
    | LÓGICA DE PERFIL (DOMAIN RULE)
    |--------------------------------------------------------------------------
    */
    private function createProfile(User $user): void
    {
        match ($user->role) {
            'aluno' => Aluno::create([
                'user_id' => $user->id,
            ]),

            'docente' => Docente::create([
                'user_id' => $user->id,
            ]),

            default => null,
        };
    }
}
