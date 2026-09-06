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
        if (!$value) return null;
        if (str_starts_with($value, 'http')) return $value;
        return rtrim(env('AWS_URL'), '/') . '/' . ltrim($value, '/');
    }

    public function getThumbnailImageAttribute($value)
    {
        if (!$value) return null;
        if (str_starts_with($value, 'http')) return $value;
        return rtrim(env('AWS_URL'), '/') . '/' . ltrim($value, '/');
    }
}
