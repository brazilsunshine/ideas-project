<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class IdeaFactory extends Factory
{
    public function definition()
    {
        // "Let's add some fields here"
        return [
            'user_id' => $this->faker->numberBetween(1, 20),
            'category_id' => $this->faker->numberBetween(1, 4),
            'status_id' => $this->faker->numberBetween(1, 5),
            'title' => ucwords($this->faker->words(4, true)), // Create 4 words text for 'title'. ucwords will make the first letter uppercase
            'description' => $this->faker->paragraph(5),
        ];
    }
}
// laracasts andre first came to ideaFactory, and then database seeder
