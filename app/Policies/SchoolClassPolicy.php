<?php

namespace App\Policies;

use App\Models\SchoolClass;
use App\Models\User;

class SchoolClassPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isTeacher($user);
    }

    public function view(User $user, SchoolClass $schoolClass): bool
    {
        return $this->isTeacher($user);
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, SchoolClass $schoolClass): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, SchoolClass $schoolClass): bool
    {
        return $this->isAdmin($user);
    }
}
