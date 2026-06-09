<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class SubjectFilter
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
                        $sub->where('name', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%");
                    });
                }
            )

            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            );
    }
}
