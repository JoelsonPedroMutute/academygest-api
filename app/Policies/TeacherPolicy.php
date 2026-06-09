<?php

namespace App\Policies;

use App\Models\Teacher;
use App\Models\User;

class TeacherPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function view(User $user, Teacher $teacher): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'teacher') {
            return $user->id === $teacher->user_id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, ?Teacher $teacher = null): bool  // Mude aqui: permitir null
    {
        // Se for o perfil do próprio docente (sem modelo específico)
        if ($teacher === null) {
            return $user->role === 'teacher' || $user->role === 'admin';
        }

        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'teacher') {
            return $user->id === $teacher->user_id;
        }

        return false;
    }

    public function delete(User $user, Teacher $teacher): bool
    {
        return $user->role === 'admin';
    }
}
