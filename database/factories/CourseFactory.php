<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word() . ' ' . fake()->word(),
            'description' => fake()->paragraph(),
            'duration' => fake()->numberBetween(1, 10),
        ];
    }
}
