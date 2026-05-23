<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class TurmaFilter
{
    public static function apply(
        Builder $query,
        array $filters
    ): Builder {

        return $query

            ->when(
                $filters['search'] ?? null,
                function ($q, $search) {
                    $q->where('nome', 'like', "%{$search}%");
                }
            )

            ->when(
                $filters['curso_id'] ?? null,
                fn($q, $curso) =>
                $q->where('curso_id', $curso)
            )

            ->when(
                $filters['ano'] ?? null,
                fn($q, $ano) =>
                $q->where('ano_letivo', $ano)
            )

            ->when(
                $filters['turno'] ?? null,
                fn($q, $turno) =>
                $q->where('turno', $turno)
            )

            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            );
    }
}
