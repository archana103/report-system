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
        'slug_url',
        'status',
        'main_heading',
        'main_subheading',
        'category_image',
        'category_icon',
    ];

    public function getCategoryImageAttribute($value)
    {
        if (!$value) return null;
        if (str_starts_with($value, 'http')) return $value;
        return rtrim(env('AWS_URL'), '/') . '/' . ltrim($value, '/');
    }

    public function getCategoryIconAttribute($value)
    {
        if (!$value) return null;
        if (str_starts_with($value, 'http')) return $value;
        return rtrim(env('AWS_URL'), '/') . '/' . ltrim($value, '/');
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
