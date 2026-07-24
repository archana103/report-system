<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportPurchase;
use App\Models\ReportDetail;
use App\Models\Pricing;

class CheckoutController extends Controller
{
    /**
     * Store a newly created purchase record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_detail_id' => 'required|exists:report_details,id',
            'pricing_id' => 'required|exists:pricings,id',
            'full_name' => 'required|string|max:255',
            'business_email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:50',
            'company_name' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        $purchase = ReportPurchase::create([
            'report_detail_id' => $validated['report_detail_id'],
            'pricing_id' => $validated['pricing_id'],
            'full_name' => $validated['full_name'],
            'business_email' => $validated['business_email'],
            'phone_number' => $validated['phone_number'],
            'company_name' => $validated['company_name'],
            'country' => $validated['country'],
            'payment_status' => 'PENDING',
        ]);

        return response()->json([
            'message' => 'Purchase details submitted successfully.',
            'purchase' => $purchase
        ], 201);
    }
}
