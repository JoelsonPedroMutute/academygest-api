<?php

namespace App\Policies;

use App\Models\Aluno;
use App\Models\User;
use App\Policies\BasePolicy;

class AlunoPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isDocente($user);
    }

    public function view(User $user, Aluno $aluno): bool
    {
        if ($this->isDocente($user)) return true;

        if ($this->isAluno($user)) {
            return $user->aluno->id === $aluno->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, Aluno $aluno): bool
    {
        if ($this->isAluno($user)) {
            return $user->aluno->id === $aluno->id;
        }

        return $this->isAdmin($user);
    }

    public function delete(User $user, Aluno $aluno): bool
    {
        return $this->isAdmin($user);
    }
}
