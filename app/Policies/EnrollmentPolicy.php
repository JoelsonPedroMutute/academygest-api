<?php

namespace App\Policies;

use App\Models\Enrollment;
use App\Models\User;
use App\Policies\BasePolicy;

class EnrollmentPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isTeacher($user);
    }

    public function view(User $user, Enrollment $enrollment): bool
    {
        if ($this->isTeacher($user)) return true;

        if ($this->isStudent($user)) {
            return $user->student->enrollments()
                ->where('enrollment_id', $enrollment->id)
                ->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, Enrollment $enrollment): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, Enrollment $enrollment): bool
    {
        return $this->isAdmin($user);
    }
}
