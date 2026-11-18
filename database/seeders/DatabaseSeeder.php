<?php

namespace Database\Seeders;

use App\Models\Lebensmittel;
use App\Models\Recipe;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->firstOrCreate(
            ['email' => 'test@example.com'],
            User::factory()->raw(['name' => 'Test User', 'email' => 'test@example.com']),
        );

        $this->call([LebensmittelSeeder::class, UnitSeeder::class]);

        $units = Unit::all();
        $lebensmittel = Lebensmittel::all();

        Recipe::factory()
            ->count(5)
            ->for($user)
            ->create()
            ->each(function (Recipe $recipe) use ($units, $lebensmittel): void {
                $recipe->lebensmittel()->attach(
                    $lebensmittel->random(3)->mapWithKeys(fn (Lebensmittel $item): array => [
                        $item->id => [
                            'unit_id' => $units->random()->id,
                            'quantity' => fake()->randomFloat(2, 1, 500),
                        ],
                    ])->all()
                );
            });
    }
}
