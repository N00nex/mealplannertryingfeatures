<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImageArray extends Model
{
    protected $fillable = [
        'image_upload_id',
        'image_path',
    ];

    public function imageUpload(): BelongsTo
    {
        return $this->belongsTo(ImageUpload::class);
    }
}
