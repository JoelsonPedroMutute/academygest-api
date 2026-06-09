<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class SchoolClassFilter
{
    public static function apply(
        Builder $query,
        array $filters
    ): Builder {

        return $query

            ->when(
                $filters['search'] ?? null,
                fn($q, $search) =>
                $q->where('name', 'like', "%{$search}%")
            )

            ->when(
                $filters['course_id'] ?? null,
                fn($q, $course) =>
                $q->where('course_id', $course)
            )

            ->when(
                $filters['academic_year'] ?? null,
                fn($q, $year) =>
                $q->where('academic_year', $year)
            )

            ->when(
                $filters['shift'] ?? null,
                fn($q, $shift) =>
                $q->where('shift', $shift)
            )

            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            );
    }
}