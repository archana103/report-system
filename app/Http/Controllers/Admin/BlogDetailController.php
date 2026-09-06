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

        $details = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.blog_details.index', compact('details'));
    }


    /**
     * Show the form for editing the specified blog detail.
     */
    public function edit($id)
    {
        $detail = BlogDetail::findOrFail($id);
        $blogs = Blog::select('id', 'title')->orderBy('title', 'asc')->get();
        return view('admin.blog_details.edit', compact('detail', 'blogs'));
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
            'breadcrumb_title' => 'nullable|string',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        $detail->update($request->all());

        return redirect()->route('admin.blog_details.index')->with('success', 'Blog detail updated successfully!');
    }

    /**
     * Remove the specified blog detail.
     */
    public function destroy($id)
    {
        $detail = BlogDetail::findOrFail($id);
        $detail->delete();

        return redirect()->back()->with('success', 'Blog detail deleted successfully!');
    }
}
