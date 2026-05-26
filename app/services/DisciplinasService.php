<?php

namespace App\services;

use App\Models\Disciplina;
use App\Services\BaseService;
use App\Filters\DisciplinaFilter;


class DisciplinasService extends BaseService
{
    public function __construct(
        protected DisciplinaFilter $filter
    ) {
        $this->model = Disciplina::class;
    }
    public function listarFiltrado(array $filtros = [])
    {
        $query = Disciplina::query()
            ->with([
                'curso',
                'docentes'
            ]);

        $this->filter->apply($query, $filtros);

        return $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }
    // Sobrescreve — validação de nome duplicado
    public function criar(array $dados): Disciplina
    {
        if (Disciplina::where('nome', $dados['nome'])->exists()) {
            throw new \Exception('Já existe uma disciplina com esse nome.');
        }

        return parent::criar($dados);
    }

    // Sobrescreve — validação de nome duplicado
    public function atualizar(int $id, array $dados): Disciplina
    {
        if (Disciplina::where('nome', $dados['nome'])
            ->where('id', '!=', $id)->exists()
        ) {
            throw new \Exception('Já existe uma disciplina com esse nome.');
        }

        return parent::atualizar($id, $dados);
    }
}
