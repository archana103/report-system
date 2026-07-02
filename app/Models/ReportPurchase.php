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
    ];
}
