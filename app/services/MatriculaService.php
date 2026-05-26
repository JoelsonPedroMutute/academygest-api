<?php

namespace App\Services;

use App\Models\Matricula;
use App\Services\BaseService;
use App\Filters\MatriculaFilter;

class MatriculaService extends BaseService
{
    public function __construct(
        protected MatriculaFilter $filter
    ) {
        $this->model = Matricula::class;
    }
    public function listarFiltrado(array $filtros = [])
    {
        $query = Matricula::query()
            ->with([
                'aluno',
                'turma'
            ]);

        $this->filter->apply($query, $filtros);

        return $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }


    public function criar(array $dados): Matricula
    {
        return Matricula::create([
            'aluno_id'       => $dados['aluno_id'],
            'turma_id'       => $dados['turma_id'],
            'ano_letivo'     => $dados['ano_letivo']     ?? null,
            'semestre'       => $dados['semestre']       ?? null,
            'data_matricula' => $dados['data_matricula'] ?? now()->toDateString(),
            'status'         => $dados['status']         ?? 'ativa',
        ]);
    }
    public function atualizar(int $id, array $dados): Matricula
    {
        $matricula = $this->buscarPorId($id);

        $matricula->update(array_filter([
            'aluno_id'       => $dados['aluno_id']       ?? null,
            'turma_id'       => $dados['turma_id']       ?? null,
            'ano_letivo'     => $dados['ano_letivo']     ?? null,
            'semestre'       => $dados['semestre']       ?? null,
            'data_matricula' => $dados['data_matricula'] ?? null,
            'status'         => $dados['status']         ?? null,
        ], fn($v) => $v !== null));

        return $matricula->fresh(['aluno', 'turma']);
    }
}
