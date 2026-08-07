<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;

class ContactUsController extends FrontendController
{
    public function index(Request $request)
    {
        $seo = $this->seoForPath($request);
        return view('pages.contact-us', ['seo' => $seo]);
    }
}
