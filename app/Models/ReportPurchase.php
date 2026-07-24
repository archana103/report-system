<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_detail_id',
        'pricing_id',
        'paypal_order_id',
        'payment_status',
        'full_name',
        'business_email',
        'phone_number',
        'company_name',
        'country',
    ];

    public function reportDetail()
    {
        return $this->belongsTo(ReportDetail::class);
    }

    public function pricing()
    {
        return $this->belongsTo(Pricing::class);
    }
}
