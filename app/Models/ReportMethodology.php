<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\Base64ImageService;

class ReportMethodology extends Model
{
    use HasFactory;

    protected $fillable = ['content'];

    protected static function booted()
    {
        static::saving(function ($methodology) {
            if ($methodology->content && str_contains($methodology->content, 'data:image')) {
                $methodology->content = Base64ImageService::processHtmlBase64Images($methodology->content, 'Report_Methodology');
            }
        });
    }
}
