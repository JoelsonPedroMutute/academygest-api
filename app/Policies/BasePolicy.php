<?php

namespace App\Policies;

use App\Models\User;

class BasePolicy
{
    // Método before para todos os policies
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;  // Admin faz tudo
        }

        return null;  // Outros usuários vão para regras específicas
    }

    protected function isAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }

    protected function isDocente(User $user): bool
    {
        return $user->role === 'docente';
    }

    protected function isAluno(User $user): bool
    {
        return $user->role === 'aluno';
    }
}
