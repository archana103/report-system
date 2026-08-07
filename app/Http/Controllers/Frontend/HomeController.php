<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\UserviewController;
use App\Services\PressreleaseService;
use Illuminate\Http\Request;

use App\Services\CategoryService;
use App\Services\ReportService;
use App\Services\BlogService;

class HomeController extends FrontendController
{
    protected $categoryService;
    protected $reportService;
    protected $blogService;
    protected $pressreleaseService;

    public function __construct(CategoryService $categoryService, ReportService $reportService, BlogService $blogService, PressreleaseService $pressreleaseService)
    {
        $this->categoryService = $categoryService;
        $this->reportService = $reportService;
        $this->blogService = $blogService;
        $this->pressreleaseService = $pressreleaseService;
    }

    public function index(Request $request)
    {
        $seo = $this->seoForPath($request);

        return view('pages.home', [
            'seo' => $seo,
            'initialCategories' => $this->categoryService->getDropdownCategories(),
            'trendingReports' => $this->reportService->getReportsByCategory($request->query('category', 'All')),
            'latestInsights' => $this->blogService->getRecentBlogs(),
            'pressReleases' => $this->pressreleaseService->pressReleases()->getData()
        ]);
    }
}
