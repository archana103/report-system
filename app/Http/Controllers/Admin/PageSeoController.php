<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSeo;
use Illuminate\Http\Request;

class PageSeoController extends Controller
{
    public function index(Request $request)
    {
        $query = PageSeo::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('url_path', 'like', '%' . $request->search . '%');
        }

        $pageSeos = $query->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.page_seo.index', compact('pageSeos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'url_path' => 'required|string|unique:page_seos,url_path',
            'raw_tags' => 'nullable|string',
        ]);

        $pageSeo = PageSeo::create($request->only([
            'url_path', 'schema_tag', 'raw_tags'
        ]));

        return redirect()->back()->with('success', 'Page SEO created successfully');
    }

    public function update(Request $request, $id)
    {
        $pageSeo = PageSeo::findOrFail($id);

        $request->validate([
            'url_path' => 'required|string|unique:page_seos,url_path,' . $id,
            'raw_tags' => 'nullable|string',
        ]);

        $pageSeo->update($request->only([
            'url_path', 'schema_tag', 'raw_tags'
        ]));

        return redirect()->back()->with('success', 'Page SEO updated successfully');
    }

    public function destroy($id)
    {
        $pageSeo = PageSeo::findOrFail($id);
        $pageSeo->delete();

        return redirect()->back()->with('success', 'Page SEO deleted successfully');
    }
}
