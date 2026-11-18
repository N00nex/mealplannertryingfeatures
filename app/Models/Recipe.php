<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Tags\HasTags;

class Recipe extends Model
{
    use HasFactory, HasTags;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cookingSteps(): HasMany
    {
        return $this->hasMany(CookingStep::class);
    }

    public function lebensmittel(): BelongsToMany
    {
        return $this->belongsToMany(Lebensmittel::class, 'lebensmittel_recipes_units', 'recipe_id', 'lebensmittel_id')
            ->using(LebensmittelRecipeUnit::class)
            ->withPivot('unit_id', 'quantity');
    }

    /**
     * The ingredient rows (Lebensmittel + Unit + quantity) of this recipe.
     */
    public function ingredients(): HasMany
    {
        return $this->hasMany(LebensmittelRecipeUnit::class);
    }

    public function loadRecipeDetails(): Recipe
    {
        return $this->load([
            'cookingSteps',
            'tags',
            'lebensmittel',
            'ingredients.lebensmittel',
            'ingredients.unit',
        ]);
    }
}
