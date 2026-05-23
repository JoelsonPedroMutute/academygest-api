<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class NotaFilter
{
    public static function apply(
        Builder $query,
        array $filters
    ): Builder {

        return $query

            /*
            |--------------------------------------------------------------------------
            | SEARCH (aluno ou disciplina)
            |--------------------------------------------------------------------------
            */
            ->when(
                $filters['search'] ?? null,
                function ($q, $search) {
                    $q->whereHas('aluno', function ($sub) use ($search) {
                        $sub->where('nome', 'like', "%{$search}%");
                    })
                        ->orWhereHas('disciplina', function ($sub) use ($search) {
                            $sub->where('nome', 'like', "%{$search}%");
                        });
                }
            )

            /*
            |--------------------------------------------------------------------------
            | ALUNO
            |--------------------------------------------------------------------------
            */
            ->when(
                $filters['aluno_id'] ?? null,
                fn($q, $aluno) =>
                $q->where('aluno_id', $aluno)
            )

            /*
            |--------------------------------------------------------------------------
            | DISCIPLINA
            |--------------------------------------------------------------------------
            */
            ->when(
                $filters['disciplina_id'] ?? null,
                fn($q, $disciplina) =>
                $q->where('disciplina_id', $disciplina)
            )

            /*
            |--------------------------------------------------------------------------
            | TURMA
            |--------------------------------------------------------------------------
            */
            ->when(
                $filters['turma_id'] ?? null,
                fn($q, $turma) =>
                $q->where('turma_id', $turma)
            )

            /*
            |--------------------------------------------------------------------------
            | TIPO
            |--------------------------------------------------------------------------
            */
            ->when(
                $filters['tipo'] ?? null,
                fn($q, $tipo) =>
                $q->where('tipo', $tipo)
            );
    }
}
