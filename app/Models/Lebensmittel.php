<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lebensmittel extends Model
{
    protected $table = 'lebensmittel_komplett';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $casts = [
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
