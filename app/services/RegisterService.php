<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RegisterService
{
    public function __construct(
        private UserService $userService,
        private DocenteService $docenteService
    ) {}

    public function registerDocente(array $data): array
    {
        return DB::transaction(function () use ($data) {

            $user = $this->userService->criar([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => $data['password'],
                'role'     => 'docente',
                'telefone' => $data['telefone'] ?? null,
                'status'   => 'pending',
            ]);

            $docente = $this->docenteService->criar(
                $data,
                'public'
            );

            return [
                'user' => $user,
                'docente' => $docente,
                'message' => 'Registo enviado.'
            ];
        });
    }
}
