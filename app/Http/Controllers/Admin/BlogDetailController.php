<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogDetail;
use App\Models\Blog;

class BlogDetailController extends Controller
{
    /**
     * Display a listing of the blog details.
     */
    public function index(Request $request)
    {
        $query = BlogDetail::with('blog:id,title');

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhereHas('blog', function($q) use ($request) {
                      $q->where('title', 'like', '%' . $request->search . '%');
                  });
        }

        $details = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($details);
    }

    /**
     * Store a newly created blog detail.
     */
    public function store(Request $request)
    {
        $request->validate([
            'blog_id' => 'required|exists:blogs,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        $detail = BlogDetail::create($request->all());

        return response()->json([
            'message' => 'Blog detail saved successfully!',
            'data'    => $detail->load('blog:id,title'),
        ], 201);
    }

    /**
     * Update the specified blog detail.
     */
    public function update(Request $request, $id)
    {
        $detail = BlogDetail::findOrFail($id);

        $request->validate([
            'blog_id' => 'required|exists:blogs,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        $detail->update($request->all());

        return response()->json([
            'message' => 'Blog detail updated successfully!',
            'data'    => $detail->load('blog:id,title'),
        ]);
    }

    /**
     * Remove the specified blog detail.
     */
    public function destroy($id)
    {
        $detail = BlogDetail::findOrFail($id);
        $detail->delete();

        return response()->json([
            'message' => 'Blog detail deleted successfully!',
        ]);
    }

    /**
     * Get a simple list of blogs for dropdown.
     */
    public function getBlogsList()
    {
        $blogs = Blog::select('id', 'title')->orderBy('title', 'asc')->get();
        return response()->json($blogs);
    }
}
