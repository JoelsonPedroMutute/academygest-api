<?php

namespace Database\Factories;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Grade>
 */
class GradeFactory extends Factory
{
    public function definition(): array
    {
        $quarterlyExam = fake()->randomFloat(2, 0, 20);
        $semesterExam = fake()->randomFloat(2, 0, 20);
        $finalExam = fake()->randomFloat(2, 0, 20);
        $finalAverage = round(($quarterlyExam + $semesterExam + $finalExam) / 3, 2);
        $status = $finalAverage >= 10 ? 'passed' : 'failed';

        return [
            'student_id' => Student::factory(),
            'subject_id' => Subject::factory(),
            'class_id' => SchoolClass::factory(),
            'quarterly_exam' => $quarterlyExam,
            'semester_exam' => $semesterExam,
            'final_exam' => $finalExam,
            'final_average' => $finalAverage,
            'status' => $status,
        ];
    }
}
