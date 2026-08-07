<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;

class PressReleaseController extends FrontendController
{
    public function index(Request $request)
    {
        $request->query->add(['page' => $request->query('page', 1)]);
        if ($request->has('q')) {
            $request->query->add(['search' => $request->query('q')]);
        }
        
        $userview = app(\App\Http\Controllers\UserviewController::class);
        $prData = $userview->getAllPressReleases($request)->getData();
        
        return view('pages.press-releases.index', [
            'seo' => $this->seoForPath($request),
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
            'seo' => $this->seoForPath($request),
            'pressRelease' => $prDetailResponse->getData()
        ]);
    }
}
