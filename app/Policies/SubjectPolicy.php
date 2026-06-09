<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\User;
use App\Policies\BasePolicy;

class SubjectPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isTeacher($user) || $this->isStudent($user);
    }

    public function view(User $user, Subject $subject): bool
    {
        if ($this->isTeacher($user)) return true;

        if ($this->isStudent($user)) {
            return $user->student->subjects()
                ->where('subject_id', $subject->id)
                ->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, Subject $subject): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, Subject $subject): bool
    {
        return $this->isAdmin($user);
    }
}
