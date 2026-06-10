<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subject>
 */
class SubjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word() . ' ' . fake()->word(),
            'description' => fake()->paragraph(),
            'workload' => fake()->numberBetween(20, 120),
            'course_id' => Course::factory(),
        ];
    }
}
