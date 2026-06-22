<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
         'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'start_date' => now()->format('Y-m-d'),
            'deadline' => now()->addMonths(2)->format('Y-m-d'),
            'user_id' => User::factory(),
        ];
    }
}
