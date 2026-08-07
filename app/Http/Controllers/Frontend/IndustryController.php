<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;

use App\Services\CategoryService;
use App\Services\SeoService;

class IndustryController extends FrontendController
{
    protected $categoryService;
    protected $seoService;

    public function __construct(CategoryService $categoryService, SeoService $seoService)
    {
        $this->categoryService = $categoryService;
        $this->seoService = $seoService;
    }

    public function show(Request $request, $slug)
    {
        $userview = app(\App\Http\Controllers\UserviewController::class);
        $categoryDetailResponse = $userview->getCategoryDetail($slug);

        if ($categoryDetailResponse->getStatusCode() === 404) {
            abort(404);
        }

        $categoryInfo = $categoryDetailResponse->getData();
        $request->query->add(['page' => $request->query('page', 1)]);
        $request->query->add(['category' => $categoryInfo->name]);

        $reportsData = $userview->getAllReports($request)->getData();

        return view('pages.industry.show', [
            'seo' => $this->seoService->getIndustrySeo($slug, $request),
            'categoryInfo' => $categoryInfo,
            'categoryName' => $categoryInfo->name,
            'initialReports' => $reportsData->data ?? [],
            'initialTotalPages' => $reportsData->last_page ?? 1,
            'sidebarCategories' => $this->categoryService->getDropdownCategories(),
        ]);
    }
}
