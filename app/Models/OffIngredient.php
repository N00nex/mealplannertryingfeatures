<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OffIngredient extends Model
{
    protected $table = 'o_f_f_ingredients';

    protected $fillable = [
        'barcode',
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
