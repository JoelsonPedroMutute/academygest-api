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
                'curso',
                'turma'
            ]);

        $this->filter->apply($query, $filtros);

        return $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    // Sobrescreve — impede matrícula duplicada
    public function criar(array $dados): Matricula
    {
        if (Matricula::where('aluno_id', $dados['aluno_id'])->exists()) {
            throw new \Exception('Este aluno já tem uma matrícula.');
        }

        return parent::criar($dados);
    }

    // ❌ atualizar() removido — herda do BaseService
    // Não há validação especial ao actualizar
    // aluno(), turma(), curso(), disciplinas() removidos — são relações do Model
}
