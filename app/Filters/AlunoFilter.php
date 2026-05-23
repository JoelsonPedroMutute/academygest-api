<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class AlunoFilter
{
    public static function apply(
        Builder $query,
        array $filters
    ): Builder {

        return $query

            ->when(
                $filters['search'] ?? null,
                function ($q, $search) {

                    $q->where(function ($sub) use ($search) {

                        $sub->where('nome', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('numero_processo', 'like', "%{$search}%");
                    });
                }
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
