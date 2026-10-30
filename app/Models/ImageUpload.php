<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\PseudoTypes\True_;

/**
 * @method static create(array $array)
 */
class ImageUpload extends Model
{
    /**
     * @method static \Illuminate\Database\Eloquent\Builder|ImageUpload create(array $attributes = [])
     */
    protected $fillable = [
        'image',
    ];
}
