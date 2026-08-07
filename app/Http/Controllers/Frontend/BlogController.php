<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Services\BlogService;
use Illuminate\Http\Request;

class BlogController extends FrontendController
{
    protected $blogService;
    public function __construct(BlogService $blogService)
    {

        $this->blogService = $blogService;
    }
    public function index(Request $request)
    {
        $request->query->add(['page' => $request->query('page', 1)]);

        $blogsData = $this->blogService->getAllBlogs($request)->getData();

        return view('pages.blogs.index', [
            'seo' => $this->seoForPath($request),
            'initialBlogs' => $blogsData->data ?? [],
            'initialTotalPages' => $blogsData->last_page ?? 1,
        ]);
    }

    public function show(Request $request, $slug)
    {
        $userview = app(\App\Http\Controllers\UserviewController::class);
        $blogDetailResponse = $userview->getBlogDetail($slug);

        if ($blogDetailResponse->getStatusCode() === 404) {
            abort(404);
        }

        return view('pages.blogs.show', [
            'seo' => $this->seoForPath($request),
            'blog' => $blogDetailResponse->getData()
        ]);
    }
}
