<?php

namespace App\Policies;

use App\Models\Nota;
use App\Models\User;
use App\Policies\BasePolicy;

class NotaPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isDocente($user);
    }

    public function view(User $user, Nota $nota): bool
    {
        if ($this->isDocente($user)) return true;

        if ($this->isAluno($user)) {
            return $user->aluno->notas()
                ->where('nota_id', $nota->id)
                ->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $this->isDocente($user);
    }

    public function update(User $user, Nota $nota): bool
    {
        return $this->isDocente($user);
    }

    public function delete(User $user, Nota $nota): bool
    {
        return $this->isAdmin($user);
    }
}
