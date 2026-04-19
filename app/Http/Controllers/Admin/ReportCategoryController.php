<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReportCategory;
use Illuminate\Support\Facades\Storage;

class ReportCategoryController extends Controller
{
    /**
     * Display a listing of the report categories.
     */
    public function index(Request $request)
    {
        $query = ReportCategory::query();

        // Search by name
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        if ($request->has('export') && $request->export == 'true') {
            return response()->json($query->get());
        }

        // Default pagination 20 per page
        $limit = $request->get('limit', 20);
        $categories = $query->paginate($limit);

        return response()->json($categories);
    }

    /**
     * Store a newly created report category in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:Active,Inactive',
            'main_heading' => 'nullable|string|max:255',
            'main_subheading' => 'nullable|string',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except(['category_image', 'category_icon']);

        if ($request->hasFile('category_image')) {
            $imagePath = $request->file('category_image')->store('report_categories', 'public');
            $data['category_image'] = $imagePath;
        }

        if ($request->hasFile('category_icon')) {
            $iconPath = $request->file('category_icon')->store('report_categories', 'public');
            $data['category_icon'] = $iconPath;
        }

        $category = ReportCategory::create($data);

        return response()->json([
            'message' => 'Report Category saved successfully!',
            'data' => $category,
        ], 201);
    }

    /**
     * Update the specified report category in storage.
     */
    public function update(Request $request, $id)
    {
        $category = ReportCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:Active,Inactive',
            'main_heading' => 'nullable|string|max:255',
            'main_subheading' => 'nullable|string',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except(['category_image', 'category_icon', '_method']);

        if ($request->hasFile('category_image')) {
            if ($category->category_image) {
                Storage::disk('public')->delete($category->category_image);
            }
            $imagePath = $request->file('category_image')->store('report_categories', 'public');
            $data['category_image'] = $imagePath;
        }

        if ($request->hasFile('category_icon')) {
            if ($category->category_icon) {
                Storage::disk('public')->delete($category->category_icon);
            }
            $iconPath = $request->file('category_icon')->store('report_categories', 'public');
            $data['category_icon'] = $iconPath;
        }

        $category->update($data);

        return response()->json([
            'message' => 'Report Category updated successfully!',
            'data' => $category,
        ]);
    }

    /**
     * Remove the specified report category from storage.
     */
    public function destroy($id)
    {
        $category = ReportCategory::findOrFail($id);

        if ($category->category_image) {
            Storage::disk('public')->delete($category->category_image);
        }

        if ($category->category_icon) {
            Storage::disk('public')->delete($category->category_icon);
        }

        $category->delete();

        return response()->json([
            'message' => 'Report Category deleted successfully!',
        ]);
    }
}
