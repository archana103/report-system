<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopSellingReport extends Model
{
    use HasFactory;

    protected $fillable = ['report_detail_id'];

    public function reportDetail()
    {
        return $this->belongsTo(ReportDetail::class);
    }
}
