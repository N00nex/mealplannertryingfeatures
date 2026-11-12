<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lebensmittel extends Model
{
    use HasFactory;

    protected $table = 'lebensmittel_komplett';

    public $timestamps = false;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'energie_kilojoule_kj' => 'float',
            'energie_kilokalorien_kcal' => 'float',
            'fett_total_g' => 'float',
            'fettsaeuren_gesaettigt_g' => 'float',
            'kohlenhydrate_verfuegbar_g' => 'float',
            'zucker_g' => 'float',
            'nahrungsfasern_g' => 'float',
            'protein_g' => 'float',
            'salz_nacl_g' => 'float',
        ];
    }

    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class);
    }

    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'lebensmittel_recipes_units')
            ->withPivot('unit_id');
    }
}
