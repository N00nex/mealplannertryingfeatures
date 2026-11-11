<?php

namespace Database\Factories;

use App\Models\Lebensmittel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lebensmittel>
 */
class LebensmittelFactory extends Factory
{
    protected $model = Lebensmittel::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'synonyme' => fake()->optional()->words(2, true),
            'kategorie' => fake()->randomElement([
                'Früchte/Früchte frisch',
                'Gemüse/Gemüse frisch',
                'Getreideprodukte, Hülsenfrüchte und Kartoffeln',
                'Milch und Milchprodukte',
            ]),
            'energie_kilojoule_kj' => fake()->randomFloat(1, 0, 3000),
            'energie_kilokalorien_kcal' => fake()->randomFloat(1, 0, 700),
            'fett_total_g' => fake()->randomFloat(1, 0, 80),
            'fettsaeuren_gesaettigt_g' => fake()->randomFloat(1, 0, 40),
            'kohlenhydrate_verfuegbar_g' => fake()->randomFloat(1, 0, 100),
            'zucker_g' => fake()->randomFloat(1, 0, 80),
            'nahrungsfasern_g' => fake()->randomFloat(1, 0, 40),
            'protein_g' => fake()->randomFloat(1, 0, 50),
            'salz_nacl_g' => fake()->randomFloat(1, 0, 10),
        ];
    }
}
