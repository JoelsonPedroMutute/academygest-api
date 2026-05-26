<?php

namespace App\Services;

class AdminDashboardService
{
    public function __construct(
        protected AlunoService   $alunoService,
        protected DocenteService $docenteService,
        protected CursoService   $cursoService,
        protected TurmaService   $turmaService,
    ) {}

    public function getData(?string $role = null): array
    {
        $base = [
            'recentes' => [
                'alunos'   => $this->alunoService->recentes(5),
                'docentes' => $this->docenteService->recentes(5),
                'turmas'   => $this->turmaService->recentes(5),
            ],
        ];

        return match ($role) {

            'docente' => array_merge($base, [
                'totais' => [
                    'turmas' => $this->turmaService->total(),
                ],
            ]),

            'aluno' => array_merge($base, [
                'totais' => [
                    'disciplinas' => $this->cursoService->total(),
                ],
            ]),

            default => array_merge($base, [
                'totais' => [
                    'alunos'   => $this->alunoService->total(),
                    'docentes' => $this->docenteService->total(),
                    'cursos'   => $this->cursoService->total(),
                    'turmas'   => $this->turmaService->total(),
                ],
            ]),
        };
    }
}
