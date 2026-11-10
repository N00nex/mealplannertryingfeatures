<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Tags\HasTags;

class Recipe extends Model
{
    use HasFactory, HasTags;

    protected $fillable = [
        'name',
        'description',
        'cooking_time',
        'servings',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cookingSteps(): HasMany
    {
        return $this->hasMany(CookingStep::class);
    }
}
