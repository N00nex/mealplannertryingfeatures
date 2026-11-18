<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * One row of the ternary relationship: a recipe uses a quantity of a Lebensmittel in a unit.
 */
class LebensmittelRecipeUnit extends Pivot
{
    protected $table = 'lebensmittel_recipes_units';

    public $incrementing = true;

    /**
     * @var list<string>
     */
    protected $fillable = ['recipe_id', 'lebensmittel_id', 'unit_id', 'quantity'];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
        ];
    }

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }

    public function lebensmittel(): BelongsTo
    {
        return $this->belongsTo(Lebensmittel::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
