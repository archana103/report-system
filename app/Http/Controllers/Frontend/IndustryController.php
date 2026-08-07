<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;

class IndustryController extends FrontendController
{
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
            'seo' => $this->seoForPath($request),
            'categoryInfo' => $categoryInfo,
            'categoryName' => $categoryInfo->name,
            'initialReports' => $reportsData->data ?? [],
            'initialTotalPages' => $reportsData->last_page ?? 1,
            'sidebarCategories' => $userview->categoriesDropdown()->getData(),
        ]);
    }
}
