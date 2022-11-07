<?php

namespace Database\Factories;

use App\Models\User;
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
        // the keys are the table names and teh values are coming from the faker class (except 'the user_id')
        return [
            'user_id' => User::all()->random()->id, // we're going to get all users then we're going to select a random user and just grab the id
            'name' => $this->faker->unique()->sentence(),
            'description' => $this->faker->text(),
            'priority' => $this->faker->randomElement([
                'low',
                'medium',
                'high'
            ])
        ];
    }
}
