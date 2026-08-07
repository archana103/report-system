<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;

class HomeController extends FrontendController
{
    public function index(Request $request)
    {
        $userview = app(\App\Http\Controllers\UserviewController::class);
        $seo = $this->seoForPath($request);
        
        return view('pages.home', [
            'seo' => $seo,
            'initialCategories' => $userview->categoriesDropdown()->getData(),
            'trendingReports' => $userview->reportsByCategory($request)->getData(),
            'latestInsights' => $userview->blogs()->getData(),
            'pressReleases' => $userview->pressReleases()->getData()
        ]);
    }
}
