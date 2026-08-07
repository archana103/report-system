<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;

class ServicesController extends FrontendController
{
    public function index(Request $request)
    {
        $seo = $this->seoForPath($request);
        $latestInsights = app(\App\Http\Controllers\UserviewController::class)->blogs()->getData();
        return view('pages.services', [
            'seo' => $seo,
            'latestInsights' => $latestInsights
        ]);
    }
}
