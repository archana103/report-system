<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PressRelease extends Model
{
    protected $fillable = [
        'title',
        'description',
        'url',
        'status',
        'main_image',
        'thumbnail_image'
    ];

    public function pressReleaseDetail()
    {
        return $this->hasOne(PressReleaseDetail::class, 'press_release_id');
    }

    public function getMainImageAttribute($value)
    {
        return $value ? \Illuminate\Support\Facades\Storage::disk('s3')->url($value) : null;
    }

    public function getThumbnailImageAttribute($value)
    {
        return $value ? \Illuminate\Support\Facades\Storage::disk('s3')->url($value) : null;
    }
}
