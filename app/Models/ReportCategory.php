<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ReportCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'main_heading',
        'main_subheading',
        'category_image',
        'category_icon',
    ];

    public function getCategoryImageAttribute($value)
    {
        return $value ? \Illuminate\Support\Facades\Storage::disk('s3')->url($value) : null;
    }

    public function getCategoryIconAttribute($value)
    {
        return $value ? \Illuminate\Support\Facades\Storage::disk('s3')->url($value) : null;
    }

      protected static function booted()
{
    $bumpVersion = function () {
        if (!Cache::has('userview_cache_version')) {
            Cache::forever('userview_cache_version', 1);
        }

        Cache::increment('userview_cache_version');
    };

    static::saved($bumpVersion);
    static::deleted($bumpVersion);
}
}
