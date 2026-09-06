<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Services\SeoService;

class ContactUsController extends FrontendController
{
    protected $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function index(Request $request)
    {
        $seo = $this->seoService->getBaseSeo($request);
        return view('pages.contact-us', ['seo' => $seo]);
    }
}
