<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        return [
            'unit' => $this->faker->randomElement(['Gramm', 'Milliliter', 'Stück', 'Esslöffel', 'Teelöffel']),
            'symbol' => $this->faker->randomElement(['g', 'ml', 'Stk.', 'EL', 'TL']),
        ];
    }
}
