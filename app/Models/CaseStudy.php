<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    protected $fillable = [
        'title',
        'description',
        'url',
        'status',
        'main_image',
        'thumbnail_image'
    ];

    public function caseStudyDetail()
    {
        return $this->hasOne(CaseStudyDetail::class, 'case_study_id');
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
