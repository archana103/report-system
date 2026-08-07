<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;

class AboutUsController extends FrontendController
{
    public function index(Request $request)
    {
        $seo = $this->seoForPath($request);
        $latestInsights = app(\App\Http\Controllers\UserviewController::class)->blogs()->getData();
        return view('pages.about-us', [
            'seo' => $seo,
            'latestInsights' => $latestInsights
        ]);
    }
}
