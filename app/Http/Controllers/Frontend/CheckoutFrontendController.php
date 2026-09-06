<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Services\SeoService;
use App\Models\Pricing;

class CheckoutFrontendController extends FrontendController
{
    protected $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function checkout(Request $request, $slug)
    {
        $seo = $this->seoService->getReportSeo($slug, $request);
        if (!isset($seo['report'])) {
            abort(404);
        }

        $pricings = Pricing::where('status', 'active')->get();

        return view('pages.checkout.checkout', [
            'seo' => $seo,
            'report' => $seo['report'],
            'pricings' => $pricings
        ]);
    }

    public function purchase(Request $request, $slug)
    {
        $seo = $this->seoService->getReportSeo($slug, $request);
        if (!isset($seo['report'])) {
            abort(404);
        }

        $pricings = Pricing::where('status', 'active')->get();
        
        $pricingId = null;
        if ($request->has('ref')) {
            $decoded = base64_decode($request->query('ref'));
            if (is_numeric($decoded)) {
                $pricingId = (int)$decoded;
            }
        } elseif ($request->has('pricing_id')) {
            $pricingId = (int)$request->query('pricing_id');
        }

        return view('pages.checkout.purchase', [
            'seo' => $seo,
            'report' => $seo['report'],
            'pricings' => $pricings,
            'initialPricingId' => $pricingId
        ]);
    }
}
