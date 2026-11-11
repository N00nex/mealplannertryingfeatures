<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Unit>
 */
class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        return [
            'quantity' => fake()->randomElement([10, 25, 50, 100, 200, 250, 500, 1000]),
            'unit' => fake()->randomElement([
                'Gramm',
                'Kilogramm',
                'Milliliter',
                'Liter',
                'Teelöffel',
                'Esslöffel',
                'Stück',
            ]),
        ];
    }
}
