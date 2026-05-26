<?php

namespace App\Policies;

use App\Models\User;

class BasePolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->status !== 'active' && $user->status !== 'approved') {
            return false;
        }

        return null; // deixa continuar para a policy específica
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
