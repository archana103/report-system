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
            'detail_description' => 'nullable|string',
            'category_list_download' => 'nullable|string',
            'single_user_license_cost' => 'nullable|string',
            'team_user_license_cost' => 'nullable|string',
            'enterprise_user_license_cost' => 'nullable|string',
            'download_text' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string|in:Active,Inactive',
            'slug_url' => 'nullable|string|unique:report_details,slug_url',
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
            $imagePath = $request->file('image')->store('report_details', 's3');
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
            'detail_description' => 'nullable|string',
            'category_list_download' => 'nullable|string',
            'single_user_license_cost' => 'nullable|string',
            'team_user_license_cost' => 'nullable|string',
            'enterprise_user_license_cost' => 'nullable|string',
            'download_text' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string|in:Active,Inactive',
            'slug_url' => 'nullable|string|unique:report_details,slug_url,' . $id,
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
            if ($detail->getRawOriginal('image')) {
                Storage::disk('s3')->delete($detail->getRawOriginal('image'));
            }
            $imagePath = $request->file('image')->store('report_details', 's3');
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

        if ($detail->getRawOriginal('image')) {
            Storage::disk('s3')->delete($detail->getRawOriginal('image'));
        }

        $detail->delete();

        return response()->json([
            'message' => 'Report Detail deleted successfully!',
        ]);
    }

    /**
     * Upload an image from the text editor directly to S3.
     */
    public function uploadEditorImage(Request $request)
    {
        $fileInput = $request->hasFile('file') ? 'file' : ($request->hasFile('blob') ? 'blob' : null);

        \Illuminate\Support\Facades\Log::info('uploadEditorImage request received', [
            'has_file' => $request->hasFile('file'),
            'has_blob' => $request->hasFile('blob'),
            'all_keys' => array_keys($request->all()),
        ]);

        try {
            $request->validate([
                $fileInput ?: 'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240',
            ]);

            if ($fileInput) {
                $file = $request->file($fileInput);
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $sanitizedName = trim(preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName), '_');
                $filename = ($sanitizedName ?: 'editor_image') . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $extension;

                $path = $file->storeAs('uploads/reports', $filename, 'editor');
                $url = Storage::disk('editor')->url($path);

                \Illuminate\Support\Facades\Log::info('uploadEditorImage success', ['url' => $url]);

                return response()->json([
                    'location' => $url,
                ]);
            }

            \Illuminate\Support\Facades\Log::warning('uploadEditorImage: No file found in request keys: ' . implode(', ', array_keys($request->all())));
            return response()->json(['error' => 'No file uploaded'], 400);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => $e->validator->errors()->first(),
            ], 422);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('uploadEditorImage error', [
                'message' => $e->getMessage(),
                'trace' => substr($e->getTraceAsString(), 0, 1000),
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

