<?php

namespace App\Services;

use App\Models\Nota;
use App\Filters\NotaFilter;

class NotasService extends BaseService
{
    public function __construct(
        protected NotaFilter $filter
    ) {
        $this->model = Nota::class;
    }

    public function listarFiltrado(array $filtros = [])
    {
        $query = Nota::query()
            ->with(['aluno', 'disciplina', 'turma']);

        $this->filter->apply($query, $filtros);

        return $query->latest()->paginate(10)->withQueryString();
    }
    public function criar(array $dados): Nota
    {
        $nota = Nota::create([
            'aluno_id'         => $dados['aluno_id'],
            'disciplina_id'    => $dados['disciplina_id'],
            'turma_id'         => $dados['turma_id'],
            'prova_trimestral' => $dados['prova_trimestral'] ?? null,
            'prova_semestral'  => $dados['prova_semestral']  ?? null,
            'exame_final'      => $dados['exame_final']      ?? null,
            'media_final'      => $this->calcularMedia($dados),
            'situacao'         => $this->calcularSituacao($dados),
        ]);

        return $nota;
    }

    public function atualizar(int $id, array $dados): Nota
    {
        $nota = $this->buscarPorId($id);

        $nota->update(array_filter([
            'aluno_id'         => $dados['aluno_id']         ?? null,
            'disciplina_id'    => $dados['disciplina_id']    ?? null,
            'turma_id'         => $dados['turma_id']         ?? null,
            'prova_trimestral' => $dados['prova_trimestral'] ?? null,
            'prova_semestral'  => $dados['prova_semestral']  ?? null,
            'exame_final'      => $dados['exame_final']      ?? null,
            'media_final'      => $this->calcularMedia(array_merge($nota->toArray(), $dados)),
            'situacao'         => $this->calcularSituacao(array_merge($nota->toArray(), $dados)),
        ], fn($v) => $v !== null));

        return $nota->fresh(['aluno', 'disciplina', 'turma']);
    }

    private function calcularMedia(array $dados): ?float
    {
        $notas = array_filter([
            $dados['prova_trimestral'] ?? null,
            $dados['prova_semestral']  ?? null,
            $dados['exame_final']      ?? null,
        ], fn($v) => $v !== null);

        if (empty($notas)) return null;

        return round(array_sum($notas) / count($notas), 2);
    }


    private function calcularSituacao(array $dados): ?string
    {
        $media = $this->calcularMedia($dados);

        if ($media === null) return null;

        return $media >= 10 ? 'aprovado' : 'reprovado';
    }
}
