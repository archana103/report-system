<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Base64ImageService;

class PressReleaseDetail extends Model
{
    protected $fillable = [
        'press_release_id',
        'content',
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
        'slug_url',
        'page_main_title',
        'breadcrumb_title',
    ];

    protected $casts = [
        'hreflang_tags' => 'array',
        'open_graph_tags' => 'array',
        'twitter_card_tags' => 'array',
    ];

    public function pressRelease()
    {
        return $this->belongsTo(PressRelease::class, 'press_release_id');
    }

    protected static function booted()
    {
        static::saving(function ($detail) {
            $prefix = $detail->slug_url ?: ($detail->page_main_title ?: 'Press_Release_Image');
            if ($detail->content && str_contains($detail->content, 'data:image')) {
                $detail->content = Base64ImageService::processHtmlBase64Images($detail->content, $prefix);
            }
        });
    }
}
