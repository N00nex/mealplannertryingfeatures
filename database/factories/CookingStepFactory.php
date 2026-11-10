<?php

namespace Database\Factories;

use App\Models\CookingStep;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CookingStep>
 */
class CookingStepFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'recipe_id' => Recipe::factory(),
            'instructions' => fake()->sentence(),
            'preparation_time' => fake()->numberBetween(1, 30),
        ];
    }
}
