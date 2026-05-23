<?php

namespace App\Policies;

use App\Models\Matricula;
use App\Models\User;
use App\Policies\BasePolicy;

class MatriculaPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isDocente($user);
    }

    public function view(User $user, Matricula $matricula): bool
    {
        if ($this->isDocente($user)) return true;

        if ($this->isAluno($user)) {
            return $user->aluno->matriculas()
                ->where('matricula_id', $matricula->id)
                ->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, Matricula $matricula): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, Matricula $matricula): bool
    {
        return $this->isAdmin($user);
    }
}
