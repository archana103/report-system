<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogRequest;

class BlogRequestController extends Controller
{
    public function index(Request $request)
    {
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

        $requests = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.blog_requests.index', compact('requests'));
    }

    public function destroy($id)
    {
        $blogRequest = BlogRequest::findOrFail($id);
        $blogRequest->delete();

        return redirect()->back()->with('success', 'Blog Request deleted successfully!');
    }
}
