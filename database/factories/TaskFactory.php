<?php

namespace Database\Factories;

use App\Models\{TaskStatus, User};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->words(2, true),
            'description' => fake()->text(100),
            'status_id' => TaskStatus::factory()->create(),
            'created_by_id' => User::factory()->create()->id,
            'assigned_to_id' => User::factory()->create()->id
        ];
    }
}
