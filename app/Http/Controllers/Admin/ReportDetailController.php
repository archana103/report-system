<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReportDetail;
use Illuminate\Support\Facades\Storage;

class ReportDetailController extends Controller
{
    /**
     * Display a listing of the report details.
     */
    public function index(Request $request)
    {
        $query = ReportDetail::with('reportList:id,name');

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhereHas('reportList', function($q) use($request){
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');

        if ($sortBy === 'report_list_id') {
           $query->orderBy($sortBy, $sortDir);
        } else {
           $query->orderBy($sortBy, $sortDir);
        }

        if ($request->has('export') && $request->export == 'true') {
            return response()->json($query->get());
        }

        $limit = $request->get('limit', 20);
        $details = $query->paginate($limit);

        return response()->json($details);
    }

    /**
     * Store a newly created report detail.
     */
    public function store(Request $request)
    {
        $request->validate([
            'report_list_id' => 'required|exists:report_lists,id',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'category_list_download' => 'nullable|string',
            'single_user_license_cost' => 'nullable|string',
            'team_user_license_cost' => 'nullable|string',
            'enterprise_user_license_cost' => 'nullable|string',
            'download_text' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string|in:Active,Inactive',
            'slug_url' => 'nullable|string',
            'breadcrumb_title' => 'nullable|string',
            'page_main_title' => 'nullable|string',
            'report_sku' => 'nullable|string',
            'table_of_contents' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'canonical_tag' => 'nullable|string',
            'meta_robots' => 'nullable|string',
            'hreflang_tags' => 'nullable',
            'open_graph_tags' => 'nullable',
            'twitter_card_tags' => 'nullable',
            'schema_tag' => 'nullable|string',
            'schema_tag_2' => 'nullable|string',
            'custom_schema_tags' => 'nullable',
            'faqs' => 'nullable',
        ]);

        $data = $request->except(['image']);
        
        $jsonFields = ['hreflang_tags', 'open_graph_tags', 'twitter_card_tags', 'custom_schema_tags', 'faqs'];
        foreach ($jsonFields as $field) {
            if (isset($data[$field]) && is_string($data[$field])) {
                $data[$field] = json_decode($data[$field], true) ?: [];
            }
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('report_details', 'public');
            $data['image'] = $imagePath;
        }

        $detail = ReportDetail::create($data);

        // Synchronize license costs globally across all reports ONLY if they are provided
        $licenseCosts = $request->only([
            'single_user_license_cost',
            'team_user_license_cost',
            'enterprise_user_license_cost'
        ]);

        if (array_filter($licenseCosts)) {
            ReportDetail::query()->update($licenseCosts);
        }

        $detail->load('reportList:id,name');

        return response()->json([
            'message' => 'Report Detail saved successfully!',
            'data'    => $detail,
        ], 201);
    }

    /**
     * Update the specified report detail.
     */
    public function update(Request $request, $id)
    {
        $detail = ReportDetail::findOrFail($id);

        $request->validate([
            'report_list_id' => 'required|exists:report_lists,id',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'category_list_download' => 'nullable|string',
            'single_user_license_cost' => 'nullable|string',
            'team_user_license_cost' => 'nullable|string',
            'enterprise_user_license_cost' => 'nullable|string',
            'download_text' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string|in:Active,Inactive',
            'slug_url' => 'nullable|string',
            'breadcrumb_title' => 'nullable|string',
            'page_main_title' => 'nullable|string',
            'report_sku' => 'nullable|string',
            'table_of_contents' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'canonical_tag' => 'nullable|string',
            'meta_robots' => 'nullable|string',
            'hreflang_tags' => 'nullable',
            'open_graph_tags' => 'nullable',
            'twitter_card_tags' => 'nullable',
            'schema_tag' => 'nullable|string',
            'schema_tag_2' => 'nullable|string',
            'custom_schema_tags' => 'nullable',
            'faqs' => 'nullable',
        ]);

        $data = $request->except(['image', '_method']);
        
        $jsonFields = ['hreflang_tags', 'open_graph_tags', 'twitter_card_tags', 'custom_schema_tags', 'faqs'];
        foreach ($jsonFields as $field) {
            if (isset($data[$field]) && is_string($data[$field])) {
                $data[$field] = json_decode($data[$field], true) ?: [];
            }
        }

        if ($request->hasFile('image')) {
            if ($detail->image) {
                Storage::disk('public')->delete($detail->image);
            }
            $imagePath = $request->file('image')->store('report_details', 'public');
            $data['image'] = $imagePath;
        }

        $detail->update($data);

        // Synchronize license costs globally across all reports ONLY if they are provided
        $licenseCosts = $request->only([
            'single_user_license_cost',
            'team_user_license_cost',
            'enterprise_user_license_cost'
        ]);

        if (array_filter($licenseCosts)) {
            ReportDetail::query()->update($licenseCosts);
        }

        $detail->load('reportList:id,name');

        return response()->json([
            'message' => 'Report Detail updated successfully!',
            'data'    => $detail,
        ]);
    }

    /**
     * Remove the specified report detail.
     */
    public function destroy($id)
    {
        $detail = ReportDetail::findOrFail($id);

        if ($detail->image) {
            Storage::disk('public')->delete($detail->image);
        }

        $detail->delete();

        return response()->json([
            'message' => 'Report Detail deleted successfully!',
        ]);
    }
}
