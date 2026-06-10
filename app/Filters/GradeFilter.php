<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class GradeFilter
{
    public static function apply(
        Builder $query,
        array $filters
    ): Builder {

        return $query

            ->when(
                $filters['search'] ?? null,
                function ($q, $search) {
                    $q->whereHas('student', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
                    })
                        ->orWhereHas('subject', function ($sub) use ($search) {
                            $sub->where('name', 'like', "%{$search}%");
                        });
                }
            )
            ->when(
                $filters['student_id'] ?? null,
                fn($q, $student) =>
                $q->where('student_id', $student)
            )

            ->when(
                $filters['subject_id'] ?? null,
                fn($q, $subject) =>
                $q->where('subject_id', $subject)
            )

            ->when(
                $filters['class_id'] ?? null,
                fn($q, $class) =>
                $q->where('class_id', $class)
            )

            ->when(
                $filters['tipo'] ?? null,
                fn($q, $tipo) =>
                $q->where('tipo', $tipo)
            );
    }
}
