<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
