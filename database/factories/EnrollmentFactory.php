<?php

namespace Database\Factories;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enrollment>
 */
class EnrollmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'class_id' => SchoolClass::factory(),
            'academic_year' => fake()->year(),
            'semester' => fake()->numberBetween(1, 2),
            'enrollment_date' => fake()->date(),
            'status' => fake()->randomElement(['active', 'suspended', 'cancelled', 'completed']),
        ];
    }
}
