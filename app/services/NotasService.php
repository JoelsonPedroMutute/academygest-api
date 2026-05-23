<?php

namespace App\Services;

use App\Models\Nota;
use App\Services\BaseService;
use App\Filters\NotaFilter;


class NotasService extends BaseService
{
    public function __construct(
        protected NotaFilter $filter 
    )
    {
;        $this->model = Nota::class;
    }
    public function listarFiltrado(array $filtros = [])
    {
        $query = Nota::query()
            ->with([
                'aluno',
                'disciplina',
                'turma'
            ]);

        $this->filter->apply($query, $filtros);

        return $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }


    // Sobrescreve — validação de nota entre 0 e 10
    public function criar(array $dados): Nota
    {
        if ($dados['valor'] < 0 || $dados['valor'] > 10) {
            throw new \Exception('A nota deve ser entre 0 e 10.');
        }

        return parent::criar($dados);
    }

    // Sobrescreve — validação de nota entre 0 e 10
    public function atualizar(int $id, array $dados): Nota
    {
        if ($dados['valor'] < 0 || $dados['valor'] > 10) {
            throw new \Exception('A nota deve ser entre 0 e 10.');
        }

        return parent::atualizar($id, $dados);
    }

    // Método para calcular a média de um aluno em uma disciplina
    public function calcularMedia(int $alunoId, int $disciplinaId): float
    {
        $notas = Nota::where('aluno_id', $alunoId)
            ->where('disciplina_id', $disciplinaId)->get();
        $media = $notas->avg('valor');
        return $media;
    }
    // Método para calcular a média geral de um aluno
    public function calcularMediaGeral(int $alunoId): float
    {
        $notas = Nota::where('aluno_id', $alunoId)->get();
        $mediaGeral = $notas->avg('valor');
        return $mediaGeral;
    }
}
