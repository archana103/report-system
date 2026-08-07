<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\UserviewController;
use App\Models\Newsletter;
use App\Services\PressreleaseService;
use Illuminate\Http\Request;

use App\Services\CategoryService;
use App\Services\ReportService;
use App\Services\BlogService;
use App\Services\SeoService;

class HomeController extends FrontendController
{
    protected $categoryService;
    protected $reportService;
    protected $blogService;
    protected $pressreleaseService;
    protected $seoService;

    public function __construct(CategoryService $categoryService, ReportService $reportService, BlogService $blogService, PressreleaseService $pressreleaseService, SeoService $seoService)
    {
        $this->categoryService = $categoryService;
        $this->reportService = $reportService;
        $this->blogService = $blogService;
        $this->pressreleaseService = $pressreleaseService;
        $this->seoService = $seoService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return view('partials.home.trending-report-cards', [
                'trendingReports' => $this->reportService->getReportsByCategory($request->query('category', 'All'))
            ]);
        }

        $seo = $this->seoService->getBaseSeo($request);

        return view('pages.home', [
            'seo' => $seo,
            'initialCategories' => $this->categoryService->getDropdownCategories(),
            'trendingReports' => $this->reportService->getReportsByCategory($request->query('category', 'All')),
            'latestInsights' => $this->blogService->getRecentBlogs(),
            'pressReleases' => $this->pressreleaseService->pressReleases()->getData()
        ]);
    }
    public function storeNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletters,email',
        ], [
            'email.unique' => 'You are already subscribed to our newsletter!',
            'email.email' => 'Please enter a valid email address.'
        ]);
        Newsletter::create([
            'email' => $request->input('email')
        ]);
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Successfully subscribed to the newsletter!']);
        }
        return redirect()->back()->with('newsletter_success', 'Successfully subscribed to the newsletter!');
    }
}
