<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\Curso;
use App\Models\Aluno;
use App\Models\Disciplina;
use App\Models\Docente;
use App\Models\Matricula;
use App\Models\Nota;
use App\Models\Turma;

use App\Policies\CursoPolicy;
use App\Policies\AlunoPolicy;
use App\Policies\DisciplinaPolicy;
use App\Policies\DocentePolicy;
use App\Policies\MatriculaPolicy;
use App\Policies\NotaPolicy;
use App\Policies\TurmaPolicy;


class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Curso::class => CursoPolicy::class,
        Aluno::class => AlunoPolicy::class,
        Disciplina::class => DisciplinaPolicy::class,
        Docente::class => DocentePolicy::class,
        Matricula::class => MatriculaPolicy::class,
        Nota::class => NotaPolicy::class,
        Turma::class => TurmaPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
