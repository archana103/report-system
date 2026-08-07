<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;

use App\Services\BlogService;
use App\Services\SeoService;

class ServicesController extends FrontendController
{
    protected $blogService;
    protected $seoService;

    public function __construct(BlogService $blogService, SeoService $seoService)
    {
        $this->blogService = $blogService;
        $this->seoService = $seoService;
    }

    public function index(Request $request)
    {
        $seo = $this->seoService->getBaseSeo($request);
        $latestInsights = $this->blogService->getRecentBlogs();
        return view('pages.services', [
            'seo' => $seo,
            'latestInsights' => $latestInsights
        ]);
    }
}
