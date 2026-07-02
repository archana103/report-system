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
                        "value" => $request->amount
                    ]
                ]
            ]
        ]);

        return response()->json($order);
    }

    public function captureOrder($orderId, Request $request)
    {
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
            ]);
        }

        return response()->json($response);
    }
}
