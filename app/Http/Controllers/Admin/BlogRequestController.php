<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogRequest;

class BlogRequestController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->expectsJson()) {
            return view('welcome');
        }

        $query = BlogRequest::with('blog');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('company_name', 'like', '%' . $search . '%')
                  ->orWhere('country', 'like', '%' . $search . '%')
                  ->orWhereHas('blog', function($q2) use ($search) {
                      $q2->where('title', 'like', '%' . $search . '%');
                  });
            });
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');

        // Check if sorting by blog title
        if ($sortBy === 'blog') {
            $query->join('blogs', 'blog_requests.blog_id', '=', 'blogs.id')
                  ->select('blog_requests.*')
                  ->orderBy('blogs.title', $sortDir);
        } else {
            $query->orderBy('blog_requests.' . $sortBy, $sortDir);
        }

        if ($request->has('export') && $request->export == 'true') {
            return response()->json($query->get());
        }

        $limit = $request->get('limit', 20);
        $data = $query->paginate($limit);

        return response()->json($data);
    }

    public function destroy($id)
    {
        $blogRequest = BlogRequest::findOrFail($id);
        $blogRequest->delete();

        return response()->json(['message' => 'Record deleted successfully!']);
    }
}
