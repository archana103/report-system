<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;

class ReportController extends FrontendController
{
    public function index(Request $request)
    {
        $request->query->add(['page' => $request->query('page', 1)]);
        if ($request->has('q')) {
            $request->query->add(['search' => $request->query('q')]);
        }
        
        $userview = app(\App\Http\Controllers\UserviewController::class);
        $reportsData = $userview->getAllReports($request)->getData();
        $seo = $this->seoForPath($request);
        
        return view('pages.reports.index', [
            'seo' => $seo,
            'initialReports' => $reportsData->data ?? [],
            'initialTotalPages' => $reportsData->last_page ?? 1,
            'initialCategories' => $userview->categoriesDropdown()->getData(),
            'initialTopSellers' => $userview->publicTopSellingReports()->getData(),
        ]);
    }

    public function show(Request $request, $slug)
    {
        $seo = $this->seoForPath($request);
        $userview = app(\App\Http\Controllers\UserviewController::class);
        
        return view('pages.reports.show', [
            'seo' => $seo,
            'report' => $seo['report'] ?? null,
            'reportData' => $userview->getReportDetail($slug)->getData()
        ]);
    }
}
