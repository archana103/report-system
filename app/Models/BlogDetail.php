<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\Base64ImageService;

class BlogDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'title',
        'breadcrumb_title',
        'description',
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
        'schema_tag_3',
        'faqs',
    ];

    protected $casts = [
        'hreflang_tags' => 'array',
        'open_graph_tags' => 'array',
        'twitter_card_tags' => 'array',
        'faqs' => 'array',
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    protected static function booted()
    {
        static::saving(function ($detail) {
            $prefix = $detail->title ?: 'Blog_Image';
            if ($detail->description && str_contains($detail->description, 'data:image')) {
                $detail->description = Base64ImageService::processHtmlBase64Images($detail->description, $prefix);
            }
        });
    }
}
