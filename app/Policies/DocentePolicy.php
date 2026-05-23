<?php

namespace App\Policies;

use App\Models\Docente;
use App\Models\User;
use App\Policies\BasePolicy;

class DocentePolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user);  // Só admin vê lista de docentes
    }

    public function view(User $user, Docente $docente): bool
    {
        if ($this->isDocente($user)) {
            return $user->docente->id === $docente->id;
        }

        return $this->isAdmin($user);
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, Docente $docente): bool
    {
        if ($this->isDocente($user)) {
            return $user->docente->id === $docente->id;
        }

        return $this->isAdmin($user);
    }

    public function delete(User $user, Docente $docente): bool
    {
        return $this->isAdmin($user);
    }
}
