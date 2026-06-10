<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state([
                'role' => 'student',
                'status' => 'active',
            ]),
            'birth_date' => fake()->date('Y-m-d', '-18 years'),
            'class_id' => SchoolClass::factory(),
            'student_number' => fake()->unique()->numerify('STU-######'),
        ];
    }
}
