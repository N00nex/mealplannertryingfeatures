<?php

namespace Database\Factories;

use App\Models\CookingStep;
use App\Models\Lebensmittel;
use App\Models\Recipe;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Spatie\Tags\Tag;

/**
 * @extends Factory<Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Create cooking steps after the recipe is persisted.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Recipe $recipe): void {
            CookingStep::factory()->count(3)->create([
                'recipe_id' => $recipe->id,
            ]);

            $lebensmittel = Lebensmittel::query()->inRandomOrder()->limit(3)->get();
            $units = Unit::query()->get();

            if ($lebensmittel->isNotEmpty() && $units->isNotEmpty()) {
                $recipe->lebensmittel()->attach(
                    $lebensmittel->mapWithKeys(fn (Lebensmittel $lebensmittel): array => [
                        $lebensmittel->getKey() => [
                            'unit_id' => $units->random()->getKey(),
                            'quantity' => fake()->randomFloat(2, 1, 10),
                        ],
                    ])->all()
                );
            }

            collect([
                fake()->randomElement(['vegetarian', 'vegan', 'quick']),
                fake()->randomElement(['breakfast', 'lunch', 'dinner']),
            ])->map(function (string $name): Tag {
                return Tag::query()->where('name->en', $name)->first()
                    ?? Tag::create([
                        'name' => ['en' => $name],
                        'slug' => ['en' => Str::slug($name)],
                    ]);
            })->each(fn (Tag $tag) => $recipe->attachTag($tag));
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'difficulty' => fake()->randomElement(['simple', 'medium', 'complex']),
            'cooking_time' => fake()->numberBetween(15, 120),
            'servings' => fake()->numberBetween(1, 8),
        ];
    }
}
