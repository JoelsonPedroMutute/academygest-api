<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    public function __construct()
    {
        $this->model = User::class;
    }


    public function criar(array $dados): User
    {
        return User::create([
            'name'     => $dados['name'],
            'email'    => $dados['email'],
            'password' => Hash::make($dados['password']),
            'role'     => $dados['role'],
            'telefone' => $dados['telefone'] ?? null,
            'status'   => $dados['status'] ?? 'active',
        ]);
    }


    public function atualizar(int|User $id, array $dados): User
    {
        $user = $id instanceof User ? $id : $this->buscarPorId($id);

        $user->update([
            'name'  => $dados['name']  ?? $user->name,
            'email' => $dados['email'] ?? $user->email,
        ]);

        if (!empty($dados['password'])) {
            $user->update(['password' => Hash::make($dados['password'])]);
        }

        return $user->fresh();
    }



    public function activar(User $user): bool
    {
        return $user->update([
            'status' => 'active'
        ]);
    }

    public function desactivar(User $user): bool
    {
        return $user->update([
            'status' => 'inactive'
        ]);
    }

    public function listarFiltrado(array $filters)
    {
        return User::query()
            ->filtered($filters)
            ->paginate(10);
    }
}
