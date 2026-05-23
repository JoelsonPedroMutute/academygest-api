<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class DocenteFilter
{
    public static function apply(
        Builder $query,
        array $filters
    ): Builder {

        return $query

            /*
            |--------------------------------------------------------------------------
            | SEARCH
            |--------------------------------------------------------------------------
            */
            ->when(
                $filters['search'] ?? null,
                function ($q, $search) {
                    $q->where(function ($sub) use ($search) {
                        $sub->where('nome', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                }
            )

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */
            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            );
    }
}