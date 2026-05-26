<?php

namespace App\Policies;

use App\Models\Curso;
use App\Models\User;
use App\Policies\BasePolicy;

class CursoPolicy extends BasePolicy
{
    // O before já vem do BasePolicy

    public function viewAny(User $user): bool
    {
        return $this->isDocente($user) || $this->isAluno($user);
    }

    public function view(User $user, Curso $curso): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        if ($this->isDocente($user)) {
            return $user->docente
                ->turmas()
                ->where('curso_id', $curso->id)
                ->exists();
        }

        if ($this->isAluno($user)) {
            return $user->aluno
                ->turma()
                ->where('curso_id', $curso->id)
                ->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, Curso $curso): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, Curso $curso): bool
    {
        return $this->isAdmin($user);
    }
}
