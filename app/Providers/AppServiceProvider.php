<?php

namespace App\Providers;

use App\Models\Aluno;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\Docente;
use App\Models\Matricula;
use App\Models\Nota;
use App\Models\Turma;


use App\Policies\CursoPolicy;
use App\Policies\DocentePolicy;
use App\Policies\FrequenciaPolicy;
use App\Policies\AlunoPolicy;
use App\Policies\NotaPolicy;
use App\Policies\DisciplinaPolicy;
use App\Policies\MatriculaPolicy;
use App\Policies\TurmaPolicy;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Curso::class, CursoPolicy::class);
        Gate::policy(Aluno::class, AlunoPolicy::class);
        Gate::policy(Docente::class, DocentePolicy::class);
        Gate::policy(Turma::class, TurmaPolicy::class);
        Gate::policy(Disciplina::class, DisciplinaPolicy::class);
        Gate::policy(Matricula::class, MatriculaPolicy::class);
        Gate::policy(Nota::class, NotaPolicy::class);

    }
}
