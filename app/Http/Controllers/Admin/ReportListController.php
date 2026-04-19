<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReportList;
use App\Models\ReportCategory;

class ReportListController extends Controller
{
    /**
     * Get all active categories for dropdown.
     */
    public function categories()
    {
        $categories = ReportCategory::select('id', 'name')
            ->where('status', 'Active')
            ->orderBy('name')
            ->get();

        return response()->json($categories);
    }

    /**
     * Get all active report lists for dropdown.
     */
    public function dropdown()
    {
        $lists = ReportList::select('id', 'name')
            ->where('status', 'Active')
            ->orderBy('name')
            ->get();

        return response()->json($lists);
    }

    /**
     * Display a listing of the report lists.
     */
    public function index(Request $request)
    {
        $query = ReportList::with('reportCategory:id,name');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('report_category_id', $request->category_id);
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');

        if ($sortBy === 'report_category_id') {
           // We can't easily order by the relationship directly with simple orderBy without a join,
           // so we fallback to latest or we can implement a join.
           // For simplicity, we just sort by the foreign key which roughly correlates to creation order of categories.
           $query->orderBy($sortBy, $sortDir);
        } else {
           $query->orderBy($sortBy, $sortDir);
        }

        if ($request->has('export') && $request->export == 'true') {
            return response()->json($query->get());
        }

        $limit = $request->get('limit', 20);
        $lists = $query->paginate($limit);

        return response()->json($lists);
    }

    /**
     * Store a newly created report list.
     */
    public function store(Request $request)
    {
        $request->validate([
            'report_category_id' => 'required|exists:report_categories,id',
            'name'               => 'required|string|max:255',
            'status'             => 'required|string|in:Active,Inactive',
        ]);

        $reportList = ReportList::create($request->only('report_category_id', 'name', 'status'));
        $reportList->load('reportCategory:id,name');

        return response()->json([
            'message' => 'Report saved successfully!',
            'data'    => $reportList,
        ], 201);
    }

    /**
     * Update the specified report list.
     */
    public function update(Request $request, $id)
    {
        $reportList = ReportList::findOrFail($id);

        $request->validate([
            'report_category_id' => 'required|exists:report_categories,id',
            'name'               => 'required|string|max:255',
            'status'             => 'required|string|in:Active,Inactive',
        ]);

        $reportList->update($request->only('report_category_id', 'name', 'status'));
        $reportList->load('reportCategory:id,name');

        return response()->json([
            'message' => 'Report updated successfully!',
            'data'    => $reportList,
        ]);
    }

    /**
     * Remove the specified report list.
     */
    public function destroy($id)
    {
        $reportList = ReportList::findOrFail($id);
        $reportList->delete();

        return response()->json([
            'message' => 'Report deleted successfully!',
        ]);
    }
}
