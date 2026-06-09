<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class StudentFilter
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
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('student_number', 'like', "%{$search}%");
                    });
                }
            )

            ->when(
                $filters['class_id'] ?? null,
                fn($q, $class) =>
                $q->where('class_id', $class)
            )

            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            );
    }
}
