<?php

namespace App\Policies;

use App\Models\User;

class BasePolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->status !== 'active' && $user->status !== 'approved') {
            return false;
        }

        return null; // let the specific policy handle it
    }

    protected function isAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }

    protected function isTeacher(User $user): bool
    {
        return $user->role === 'teacher';
    }

    protected function isStudent(User $user): bool
    {
        return $user->role === 'student';
    }
}
