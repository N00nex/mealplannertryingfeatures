<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Erstellt automatisch einen User, falls keiner übergeben wird
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'cooking_time' => $this->faker->numberBetween(15, 90),
            'servings' => $this->faker->numberBetween(1, 4),
            'difficulty' => $this->faker->randomElement(['simple', 'medium', 'hard']),
        ];
    }
}
