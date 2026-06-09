<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy extends BasePolicy
{
    // before() is inherited from BasePolicy

    public function viewAny(User $user): bool
    {
        return $this->isTeacher($user) || $this->isStudent($user);
    }

    public function view(User $user, Course $course): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        if ($this->isTeacher($user)) {
            return $user->teacher
                ->classes()
                ->where('course_id', $course->id)
                ->exists();
        }

        if ($this->isStudent($user)) {
            return $user->student
                ->schoolClass()
                ->where('course_id', $course->id)
                ->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, Course $course): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, Course $course): bool
    {
        return $this->isAdmin($user);
    }
}
