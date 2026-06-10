<?php

namespace Database\Factories;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Teacher>
 */
class TeacherFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state([
                'role' => 'teacher',
                'status' => fake()->randomElement(['active', 'pending', 'rejected']),
            ]),
            'birth_date' => fake()->date('Y-m-d', '-25 years'),
            'specialty' => fake()->word() . ' ' . fake()->word(),
        ];
    }
}
