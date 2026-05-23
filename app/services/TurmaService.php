<?php

namespace App\Services;

use App\Models\Turma;
use App\Services\BaseService;
use App\Filters\TurmaFilter;

class TurmaService extends BaseService
{
    public function __construct(
        protected TurmaFilter $filter
    ) {
        $this->model = Turma::class;
    }
    public function listarFiltrado(array $filtros = [])
    {
        $query = Turma::query()
            ->with([
                'curso',
                'alunos',
                'disciplinas'
            ]);

        $this->filter->apply($query, $filtros);

        return $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    public function criar(array $dados): Turma
    {
        if (Turma::where('nome', $dados['nome'])->exists()) {
            throw new \Exception('Já existe uma turma com esse nome.');
        }

        return parent::criar($dados);
    }

    public function atualizar(int $id, array $dados): Turma
    {
        if (Turma::where('nome', $dados['nome'])
            ->where('id', '!=', $id)->exists()
        ) {
            throw new \Exception('Já existe uma turma com esse nome.');
        }

        return parent::atualizar($id, $dados);
    }

    // ❌ disciplinas(), alunos(), docente(), curso(), aulas() removidos
}
