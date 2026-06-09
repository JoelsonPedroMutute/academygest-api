<?php

namespace App\Policies;

use App\Models\Grade;
use App\Models\User;

class GradePolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isTeacher($user) || $this->isStudent($user);
    }

    public function view(User $user, Grade $grade): bool
    {
        if ($this->isTeacher($user)) return true;

        if ($this->isStudent($user)) {
            return $user->student->grades()
                ->where('id', $grade->id)
                ->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $this->isTeacher($user)
            && in_array($user->status, ['active', 'approved']);
    }

    public function update(User $user, Grade $grade): bool
    {
        return $this->isTeacher($user);
    }

    public function delete(User $user, Grade $grade): bool
    {
        return $this->isAdmin($user);
    }
}
