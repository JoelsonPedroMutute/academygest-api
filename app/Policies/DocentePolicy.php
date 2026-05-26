<?php

namespace App\Policies;

use App\Models\Docente;
use App\Models\User;

class DocentePolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function view(User $user, Docente $docente): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'docente') {
            return $user->id === $docente->user_id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, ?Docente $docente = null): bool  // Mude aqui: permitir null
    {
        // Se for o perfil do próprio docente (sem modelo específico)
        if ($docente === null) {
            return $user->role === 'docente' || $user->role === 'admin';
        }

        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'docente') {
            return $user->id === $docente->user_id;
        }

        return false;
    }

    public function delete(User $user, Docente $docente): bool
    {
        return $user->role === 'admin';
    }
}
