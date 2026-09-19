<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Services\Base64ImageService;

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
        if (!$value) return null;
        if (str_starts_with($value, 'http')) return $value;
        return rtrim(env('AWS_URL'), '/') . '/' . ltrim($value, '/');
    }

    protected static function booted()
    {
        static::saving(function ($reportDetail) {
            $prefix = $reportDetail->slug_url ?: ($reportDetail->title ?: 'Report_Image');
            
            if ($reportDetail->description && str_contains($reportDetail->description, 'data:image')) {
                $reportDetail->description = Base64ImageService::processHtmlBase64Images($reportDetail->description, $prefix);
            }
            if ($reportDetail->detail_description && str_contains($reportDetail->detail_description, 'data:image')) {
                $reportDetail->detail_description = Base64ImageService::processHtmlBase64Images($reportDetail->detail_description, $prefix);
            }
            if ($reportDetail->table_of_contents && str_contains($reportDetail->table_of_contents, 'data:image')) {
                $reportDetail->table_of_contents = Base64ImageService::processHtmlBase64Images($reportDetail->table_of_contents, $prefix);
            }
        });

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

