<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_list_id',
        'title',
        'description',
        'category_list_download',
        'single_user_license_cost',
        'team_user_license_cost',
        'enterprise_user_license_cost',
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
}
