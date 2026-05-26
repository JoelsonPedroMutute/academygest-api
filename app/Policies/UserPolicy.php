<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy extends BasePolicy
{
    public function viewAny(User $authUser): bool
    {
        return $this->isAdmin($authUser);
    }

    public function view(User $authUser, User $user): bool
    {
        return $authUser->id === $user->id || $this->isAdmin($authUser);
    }

    public function create(User $authUser): bool
    {
        return $this->isAdmin($authUser);
    }

    public function update(User $authUser, User $user): bool
    {
        return $authUser->id === $user->id || $this->isAdmin($authUser);
    }

    public function delete(User $authUser, User $user): bool
    {
        return $this->isAdmin($authUser);
    }

    // 🔥 NOVAS PERMISSÕES PARA FLUXO DE APROVAÇÃO

    public function approve(User $authUser, User $user): bool
    {
        return $this->isAdmin($authUser)
            && $user->role === 'docente'
            && $user->status === 'pending';
    }

    public function reject(User $authUser, User $user): bool
    {
        return $this->isAdmin($authUser)
            && $user->role === 'docente'
            && $user->status === 'pending';
    }
}
