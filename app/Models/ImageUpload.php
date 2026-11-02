<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class ImageUpload extends Model
{
    protected $fillable = [
        'image_path',
    ];

    public function imageArray()
    {
        return $this->hasMany(ImageArray::class);
    }
}
