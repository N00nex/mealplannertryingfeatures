<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class ImageUpload extends Model
{
    public mixed $image;
    /**
     * @method static \Illuminate\Database\Eloquent\Builder|ImageUpload create(array $attributes = [])
     */
    protected $fillable = [
        'image',
    ];
}
