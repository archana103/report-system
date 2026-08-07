<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;

use App\Services\CategoryService;
use App\Services\SeoService;

class ReportController extends FrontendController
{
    protected $categoryService;
    protected $seoService;

    public function __construct(CategoryService $categoryService, SeoService $seoService)
    {
        $this->categoryService = $categoryService;
        $this->seoService = $seoService;
    }

    public function index(Request $request)
    {
        $request->query->add(['page' => $request->query('page', 1)]);
        if ($request->has('q')) {
            $request->query->add(['search' => $request->query('q')]);
        }
        
        $userview = app(\App\Http\Controllers\UserviewController::class);
        $reportsData = $userview->getAllReports($request)->getData();
        $seo = $this->seoService->getBaseSeo($request);
        
        return view('pages.reports.index', [
            'seo' => $seo,
            'initialReports' => $reportsData->data ?? [],
            'initialTotalPages' => $reportsData->last_page ?? 1,
            'initialCategories' => $this->categoryService->getDropdownCategories(),
            'initialTopSellers' => $userview->publicTopSellingReports()->getData(),
        ]);
    }

    public function show(Request $request, $slug)
    {
        $seo = $this->seoService->getReportSeo($slug, $request);
        $userview = app(\App\Http\Controllers\UserviewController::class);
        if (!isset($seo['report'])) {
            abort(404);
        }

        return view('pages.reports.show', [
            'seo' => $seo,
            'report' => $seo['report'] ?? null,
            'reportData' => $userview->getReportDetail($slug)->getData()
        ]);
    }
}
