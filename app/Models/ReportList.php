<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
class ReportList extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_category_id',
        'name',
        'status',
    ];

    public function reportCategory()
    {
        return $this->belongsTo(ReportCategory::class, 'report_category_id');
    }

    public function reportDetail()
    {
        return $this->hasOne(ReportDetail::class, 'report_list_id');
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
