<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class USDAIngredients extends Model
{
    protected $table = 'u_s_d_a_ingredients';

    protected $fillable = [
        'fdc_id',
        'names',
        'nutriments',
    ];

    protected function casts(): array
    {
        return [
            'names' => 'array',
            'nutriments' => 'array',
        ];
    }
}
