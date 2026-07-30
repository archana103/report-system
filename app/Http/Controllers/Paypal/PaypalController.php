<?php

namespace App\Http\Controllers\Paypal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReportPurchase;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
class PaypalController extends Controller
{
    public function createOrder(Request $request)
    {
        try {
            $request->validate([
                'pricing_id' => 'required|exists:pricings,id'
            ]);

            $pricing = \App\Models\Pricing::findOrFail($request->pricing_id);
            $formatted_cost = number_format((float) $pricing->cost, 2, '.', '');

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $token = $provider->getAccessToken();
            $provider->setAccessToken($token);

            $order = $provider->createOrder([
                "intent" => "CAPTURE",
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $formatted_cost
                        ]
                    ]
                ]
            ]);

            return response()->json($order);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function captureOrder($orderId, Request $request)
    {
        $request->validate([
            'report_detail_id' => 'required|exists:report_details,id',
            'pricing_id' => 'required|exists:pricings,id',
            'full_name' => 'required|string|max:255',
            'business_email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        $provider = new PayPalClient;

        $provider->setApiCredentials(config('paypal'));

        $token = $provider->getAccessToken();

        $provider->setAccessToken($token);

        $response = $provider->capturePaymentOrder($orderId);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            ReportPurchase::create([
                'paypal_order_id' => $orderId,
                'report_detail_id' => $request->report_detail_id,
                'pricing_id' => $request->pricing_id,
                'payment_status' => $response['status'],
                'full_name' => $request->full_name,
                'business_email' => $request->business_email,
                'phone_number' => $request->phone_number,
                'company_name' => $request->company_name,
                'country' => $request->country,
            ]);
        }

        return response()->json($response);
    }
}
