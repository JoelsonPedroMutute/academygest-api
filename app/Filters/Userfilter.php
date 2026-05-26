<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class UserFilter
{
    public static function apply(Builder $query, array $filters): Builder
    {
        return $query

            ->when(
                $filters['search'] ?? null,
                fn($q, $search) =>
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('telefone', 'like', "%{$search}%");
                })
            )

            ->when(
                $filters['role'] ?? null,
                fn($q, $role) =>
                $q->where('role', $role)
            )

            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            );
    }
}
