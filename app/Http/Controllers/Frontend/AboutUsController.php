<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;

use App\Services\BlogService;

class AboutUsController extends FrontendController
{
    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function index(Request $request)
    {
        $seo = $this->seoForPath($request);
        $latestInsights = $this->blogService->getRecentBlogs();
        return view('pages.about-us', [
            'seo' => $seo,
            'latestInsights' => $latestInsights
        ]);
    }
}
