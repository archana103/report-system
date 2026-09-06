<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;

use App\Services\SeoService;

class PressReleaseController extends FrontendController
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
        $prData = $userview->getAllPressReleases($request)->getData();
        
        return view('pages.press-releases.index', [
            'seo' => $this->seoService->getBaseSeo($request),
            'initialPressReleases' => $prData->data ?? [],
            'initialTotalPages' => $prData->last_page ?? 1,
        ]);
    }

    public function show(Request $request, $slug)
    {
        $userview = app(\App\Http\Controllers\UserviewController::class);
        $prDetailResponse = $userview->getPressReleaseDetail($slug);
        
        if ($prDetailResponse->getStatusCode() === 404) {
            abort(404);
        }
            
        return view('pages.press-releases.show', [
            'seo' => $this->seoService->getPressReleaseSeo($slug, $request),
            'pressRelease' => $prDetailResponse->getData()
        ]);
    }
}
