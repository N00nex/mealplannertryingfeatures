<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            [10, 'Gramm'],
            [25, 'Gramm'],
            [50, 'Gramm'],
            [100, 'Gramm'],
            [200, 'Gramm'],
            [250, 'Gramm'],
            [500, 'Gramm'],
            [1000, 'Gramm'],
            [1, 'Kilogramm'],
            [50, 'Milliliter'],
            [100, 'Milliliter'],
            [200, 'Milliliter'],
            [250, 'Milliliter'],
            [500, 'Milliliter'],
            [1000, 'Milliliter'],
            [1, 'Liter'],
            [1, 'Teelöffel'],
            [1, 'Esslöffel'],
            [1, 'Stück'],
            [1, 'Prise'],
        ];

        foreach ($units as [$quantity, $unit]) {
            Unit::query()->updateOrCreate([
                'quantity' => $quantity,
                'unit' => $unit,
            ]);
        }
    }
}
