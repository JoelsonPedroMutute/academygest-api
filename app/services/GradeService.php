<?php

namespace App\Services;

use App\Models\Grade;
use App\Filters\GradeFilter;

class GradeService extends BaseService
{
    public function __construct(
        protected GradeFilter $filter
    ) {
        $this->model = Grade::class;
    }

    public function listFiltered(array $filters = [])
    {
        $query = Grade::query()
            ->with(['student', 'subject', 'schoolClass']);

        $this->filter->apply($query, $filters);

        return $query->latest()->paginate(10)->withQueryString();
    }

    public function create(array $data): Grade
    {
        return Grade::create([
            'student_id'      => $data['student_id'],
            'subject_id'      => $data['subject_id'],
            'school_class_id' => $data['school_class_id'],
            'quarter_exam'    => $data['quarter_exam'] ?? null,
            'semester_exam'   => $data['semester_exam'] ?? null,
            'final_exam'      => $data['final_exam'] ?? null,
            'final_average'   => $this->calculateAverage($data),
            'status'          => $this->calculateStatus($data),
        ]);
    }

    public function update(int|string $id, array $data): Grade
    {
        $grade = $this->findById($id);

        $grade->update(array_filter([
            'student_id'      => $data['student_id'] ?? null,
            'subject_id'      => $data['subject_id'] ?? null,
            'school_class_id' => $data['school_class_id'] ?? null,
            'quarter_exam'    => $data['quarter_exam'] ?? null,
            'semester_exam'   => $data['semester_exam'] ?? null,
            'final_exam'      => $data['final_exam'] ?? null,
            'final_average'   => $this->calculateAverage(
                array_merge($grade->toArray(), $data)
            ),
            'status'          => $this->calculateStatus(
                array_merge($grade->toArray(), $data)
            ),
        ], fn($value) => $value !== null));

        return $grade->fresh(['student', 'subject', 'schoolClass']);
    }

    private function calculateAverage(array $data): ?float
    {
        $grades = array_filter([
            $data['quarter_exam'] ?? null,
            $data['semester_exam'] ?? null,
            $data['final_exam'] ?? null,
        ], fn($value) => $value !== null);

        if (empty($grades)) {
            return null;
        }

        return round(array_sum($grades) / count($grades), 2);
    }

    private function calculateStatus(array $data): ?string
    {
        $average = $this->calculateAverage($data);

        if ($average === null) {
            return null;
        }

        return $average >= 10 ? 'approved' : 'failed';
    }
}
