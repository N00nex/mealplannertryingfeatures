<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Tags\Tag;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $tags = collect([
            'vegetarian',
            'vegan',
            'quick',
            'family-friendly',
            'high-protein',
        ])->map(function (string $name): Tag {
            return Tag::query()->where('name->en', $name)->first()
                ?? Tag::create([
                    'name' => ['en' => $name],
                    'slug' => ['en' => Str::slug($name)],
                ]);
        });

        Recipe::factory()
            ->count(20)
            ->for($user)
            ->create()
            ->each(function (Recipe $recipe, int $index) use ($tags): void {
                $recipe->syncTags([
                    $tags[$index % $tags->count()],
                    $tags[($index + 1) % $tags->count()],
                ]);
            });

        $this->call(NoteSeeder::class);
    }
}
