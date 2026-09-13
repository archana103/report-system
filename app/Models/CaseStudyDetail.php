<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseStudyDetail extends Model
{
    protected $fillable = [
        'case_study_id',
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

    public function caseStudy()
    {
        return $this->belongsTo(CaseStudy::class, 'case_study_id');
    }
}
