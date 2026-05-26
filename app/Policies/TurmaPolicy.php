<?php

namespace App\Policies;

use App\Models\Turma;
use App\Models\User;
use App\Policies\BasePolicy;

class TurmaPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isDocente($user);
    }

    public function view(User $user, Turma $turma): bool
    {
        if ($this->isDocente($user)) return true;

        if ($this->isAluno($user)) {
            return $user->aluno?->turma_id === $turma->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, Turma $turma): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, Turma $turma): bool
    {
        return $this->isAdmin($user);
    }
}
