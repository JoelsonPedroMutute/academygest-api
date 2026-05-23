<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class MatriculaFilter
{
    public static function apply(
        Builder $query,
        array $filters
    ): Builder {

        return $query

            ->when(
                $filters['search'] ?? null,
                function ($q, $search) {
                    $q->whereHas('aluno', function ($sub) use ($search) {
                        $sub->where('nome', 'like', "%{$search}%");
                    });
                }
            )

            ->when(
                $filters['aluno_id'] ?? null,
                fn($q, $aluno) =>
                $q->where('aluno_id', $aluno)
            )

            ->when(
                $filters['curso_id'] ?? null,
                fn($q, $curso) =>
                $q->where('curso_id', $curso)
            )

            ->when(
                $filters['turma_id'] ?? null,
                fn($q, $turma) =>
                $q->where('turma_id', $turma)
            )

            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            );
    }
}
