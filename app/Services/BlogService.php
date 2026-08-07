<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BlogService
{
    /**
     * Get recent blogs for insights display.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRecentBlogs()
    {
        return Blog::latest()
            ->take(5)
            ->get()
            ->map(fn($blog) => $this->formatBlog($blog));
    }

    private function formatBlog($blog)
    {
        return (object) [
            'title' => $blog->title,
            'description' => Str::limit(strip_tags(html_entity_decode($blog->description)), 120),
            'date' => $blog->created_at->format('F d, Y'),
            'image' => $blog->image ?: '/assets/images/default-blog.png',
            'url' => $blog->url,
        ];
    }

    public function getAllBlogs(Request $request)
    {
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(12);

        $blogs->getCollection()->transform(function ($blog) {
            return [
                'id' => $blog->id,
                'title' => $blog->title,
                'description' => Str::limit(strip_tags(html_entity_decode($blog->description)), 150),
                'date' => $blog->created_at->format('F d, Y'),
                'image' => $blog->image ?: '/assets/images/default-blog.png',
                'url' => $blog->url,
            ];
        });

        return response()->json($blogs);
    }
}
