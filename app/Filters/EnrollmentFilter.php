<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class EnrollmentFilter
{
    public static function apply(
        Builder $query,
        array $filters
    ): Builder {

        return $query

            ->when(
                $filters['search'] ?? null,
                fn($q, $search) =>
                $q->whereHas(
                    'student',
                    fn($sub) =>
                    $sub->whereHas(
                        'user',
                        fn($u) =>
                        $u->where('name', 'like', "%{$search}%")
                    )
                )
            )

            ->when(
                $filters['student_id'] ?? null,
                fn($q, $student) =>
                $q->where('student_id', $student)
            )

            ->when(
                $filters['course_id'] ?? null,
                fn($q, $course) =>
                $q->whereHas(
                    'schoolClass',
                    fn($sub) =>
                    $sub->where('course_id', $course)
                )
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
