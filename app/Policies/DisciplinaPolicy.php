<?php

namespace App\Policies;

use App\Models\Disciplina;
use App\Models\User;
use App\Policies\BasePolicy;

class DisciplinaPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isDocente($user) || $this->isAluno($user);
    }

    public function view(User $user, Disciplina $disciplina): bool
    {
        if ($this->isDocente($user)) return true;

        if ($this->isAluno($user)) {
            return $user->aluno->disciplinas()
                ->where('disciplina_id', $disciplina->id)
                ->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, Disciplina $disciplina): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, Disciplina $disciplina): bool
    {
        return $this->isAdmin($user);
    }
}
