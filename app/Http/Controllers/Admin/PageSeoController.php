<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSeo;
use Illuminate\Http\Request;

class PageSeoController extends Controller
{
    public function index()
    {
        $pageSeos = PageSeo::orderBy('created_at', 'desc')->get();
        return response()->json($pageSeos, 200);
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

        return response()->json([
            'message' => 'Page SEO created successfully',
            'data' => $pageSeo
        ], 201);
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

        return response()->json([
            'message' => 'Page SEO updated successfully',
            'data' => $pageSeo
        ], 200);
    }

    public function destroy($id)
    {
        $pageSeo = PageSeo::findOrFail($id);
        $pageSeo->delete();

        return response()->json([
            'message' => 'Page SEO deleted successfully'
        ], 200);
    }
}
