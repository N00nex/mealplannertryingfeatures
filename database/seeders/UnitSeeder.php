<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['g', 'Gramm'],
            ['kg', 'Kilogramm'],
            ['ml', 'Milliliter'],
            ['l', 'Liter'],
            ['TL', 'Teelöffel'],
            ['EL', 'Esslöffel'],
            ['Stk.', 'Stück'],
            ['Prise', 'Prise'],
        ];

        foreach ($units as [$symbol, $unit]) {
            Unit::query()->updateOrCreate(
                ['unit' => $unit],
                ['symbol' => $symbol],
            );
        }
    }
}
