<?php

namespace App\Services;

use App\Models\Curso;
use App\Services\BaseService;
use App\Filters\CursoFilter;

class CursoService extends BaseService
{
    public function __construct(
        protected CursoFilter $filter
    ) {
        $this->model = Curso::class;
    }
    public function listarFiltrado(array $filtros = [])
    {
        $query = Curso::query()
            ->with(['disciplinas', 'turmas']);

        $this->filter->apply($query, $filtros);

        return $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }


    // Sobrescreve — validação de nome duplicado
    public function criar(array $dados): Curso
    {
        if (Curso::where('nome', $dados['nome'])->exists()) {
            throw new \Exception('Já existe um curso com esse nome.');
        }

        return parent::criar($dados);
    }

    // Sobrescreve — validação de nome duplicado
    public function atualizar(int $id, array $dados): Curso
    {
        if (Curso::where('nome', $dados['nome'])
            ->where('id', '!=', $id)->exists()
        ) {
            throw new \Exception('Já existe um curso com esse nome.');
        }

        return parent::atualizar($id, $dados);
    }
    public   function eliminar(int $id): bool
    {
        return Curso::destroy($id);
    }
}
