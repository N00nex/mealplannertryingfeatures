<?php

namespace Database\Factories;

use App\Models\Lebensmittel;
use Illuminate\Database\Eloquent\Factories\Factory;

class LebensmittelFactory extends Factory
{
    protected $model = Lebensmittel::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->numberBetween(10000, 99999), // Manuelle ID für lebensmittel_komplett
            'name' => $this->faker->randomElement(['Tomate', 'Mehl', 'Milch', 'Zucker', 'Salz', 'Butter', 'Ei']),
            'kategorie' => 'Allgemein',
            'energie_kilokalorien_kcal' => $this->faker->randomFloat(2, 20, 500),
            'protein_g' => $this->faker->randomFloat(2, 0, 30),
            'fett_total_g' => $this->faker->randomFloat(2, 0, 50),
            'kohlenhydrate_verfuegbar_g' => $this->faker->randomFloat(2, 0, 80),
        ];
    }
}
