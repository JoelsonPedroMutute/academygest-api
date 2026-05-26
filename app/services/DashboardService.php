<?php

namespace App\Services\V1\Dashboard;

use App\Services\AlunoService;
use App\Services\DocenteService;
use App\Services\CursoService;
use App\Services\TurmaService;
use App\Services\AulaService;

class AdminDashboardService
{
    public function __construct(
        protected AlunoService $alunoService,
        protected DocenteService $docenteService,
        protected CursoService $cursoService,
        protected TurmaService $turmaService,
    ) {}

    public function getData(): array
    {
        return [
            'total_alunos'   => $this->alunoService->total(),
            'total_docentes' => $this->docenteService->total(),
            'total_cursos'   => $this->cursoService->total(),
            'total_turmas'   => $this->turmaService->total(),

            'alunos_recentes'   => $this->alunoService->recentes(5),
            'docentes_recentes' => $this->docenteService->recentes(5),
            'cursos_recentes'   => $this->cursoService->recentes(5),
            'turmas_recentes'   => $this->turmaService->recentes(5),
        ];
    }
}
