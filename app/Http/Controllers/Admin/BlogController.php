<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the blogs.
     */
    public function index(Request $request)
    {
        $query = Blog::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author_name', 'like', '%' . $request->search . '%');
        }

        $blogs = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created blog.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'url' => 'nullable|string',
            'author_name' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 's3');
            $data['image'] = $imagePath;
        }

        $blog = Blog::create($data);

        // Auto-create associated blog detail
        \App\Models\BlogDetail::create([
            'blog_id' => $blog->id,
            'title' => $blog->title,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog added successfully!');
    }

    /**
     * Show the form for editing the specified blog.
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified blog.
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'url' => 'nullable|string',
            'author_name' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except(['image', '_method']);

        if ($request->hasFile('image')) {
            if ($blog->getRawOriginal('image')) {
                Storage::disk('s3')->delete($blog->getRawOriginal('image'));
            }
            $imagePath = $request->file('image')->store('blogs', 's3');
            $data['image'] = $imagePath;
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully!');
    }

    /**
     * Remove the specified blog.
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->getRawOriginal('image')) {
            Storage::disk('s3')->delete($blog->getRawOriginal('image'));
        }

        $blog->delete();

        return redirect()->back()->with('success', 'Blog deleted successfully!');
    }
}
