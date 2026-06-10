<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;
use App\Policies\BasePolicy;


class StudentPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isTeacher($user);
    }

    public function view(User $user, Student $student): bool
    {
        if ($this->isTeacher($user)) return true;

        if ($this->isStudent($user)) {
            return $user->student->id === $student->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, Student $student): bool
    {
        if ($this->isStudent($user)) {
            return $user->student->id === $student->id;
        }

        return $this->isAdmin($user);
    }

    public function delete(User $user, Student $student): bool
    {
        return $this->isAdmin($user);
    }
}
