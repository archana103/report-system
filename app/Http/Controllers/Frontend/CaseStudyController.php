<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;

use App\Services\SeoService;

class CaseStudyController extends FrontendController
{
    protected $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function index(Request $request)
    {
        $request->query->add(['page' => $request->query('page', 1)]);
        if ($request->has('q')) {
            $request->query->add(['search' => $request->query('q')]);
        }
        
        $userview = app(\App\Http\Controllers\UserviewController::class);
        $csData = $userview->getAllCaseStudies($request)->getData();
        
        return view('pages.case-studies.index', [
            'seo' => $this->seoService->getBaseSeo($request),
            'initialCaseStudies' => $csData->data ?? [],
            'initialTotalPages' => $csData->last_page ?? 1,
        ]);
    }

    public function show(Request $request, $slug)
    {
        $userview = app(\App\Http\Controllers\UserviewController::class);
        $csDetailResponse = $userview->getCaseStudyDetail($slug);
        
        if ($csDetailResponse->getStatusCode() === 404) {
            abort(404);
        }
            
        return view('pages.case-studies.show', [
            // Reusing getPressReleaseSeo works assuming logic is same, 
            // but we might need a getCaseStudySeo in SeoService later if they require dynamic DB SEO.
            // For now passing base SEO or modifying to a generic one.
            'seo' => $this->seoService->getBaseSeo($request),
            'caseStudy' => $csDetailResponse->getData()
        ]);
    }
}
