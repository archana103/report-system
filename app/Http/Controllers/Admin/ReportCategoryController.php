<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReportCategory;
use Illuminate\Support\Facades\Storage;

class ReportCategoryController extends Controller
{
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
}
