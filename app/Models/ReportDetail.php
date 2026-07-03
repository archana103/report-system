<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
class ReportDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_list_id',
        'title',
        'description',
        'detail_description',
        'category_list_download',
        'download_text',
        'image',
        'status',
        'slug_url',
        'breadcrumb_title',
        'page_main_title',
        'report_sku',
        'table_of_contents',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_tag',
        'meta_robots',
        'hreflang_tags',
        'open_graph_tags',
        'twitter_card_tags',
        'schema_tag',
        'schema_tag_2',
        'custom_schema_tags',
        'faqs',
    ];

    protected $casts = [
        'hreflang_tags' => 'array',
        'open_graph_tags' => 'array',
        'twitter_card_tags' => 'array',
        'custom_schema_tags' => 'array',
        'faqs' => 'array',
    ];

    public function reportList()
    {
        return $this->belongsTo(ReportList::class, 'report_list_id');
    }

    public function getImageAttribute($value)
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
