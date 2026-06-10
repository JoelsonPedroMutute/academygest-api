<?php

namespace Database\Factories;

use App\Models\SchoolClass;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SchoolClass>
 */
class SchoolClassFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Class ' . fake()->randomLetter() . fake()->randomNumber(1),
            'course_id' => Course::factory(),
            'academic_year' => fake()->year(),
            'semester' => fake()->numberBetween(1, 2),
            'capacity' => fake()->numberBetween(20, 50),
            'shift' => fake()->randomElement(['morning', 'afternoon', 'evening']),
        ];
    }
}
