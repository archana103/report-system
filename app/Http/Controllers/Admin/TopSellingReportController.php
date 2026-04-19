<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TopSellingReport;
use App\Models\ReportDetail;

class TopSellingReportController extends Controller
{
    /**
     * Display a listing of the top selling reports.
     */
    public function index()
    {
        $reports = TopSellingReport::with('reportDetail:id,title')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return response()->json($reports);
    }

    /**
     * Store a newly created top selling report.
     */
    public function store(Request $request)
    {
        $request->validate([
            'report_detail_id' => 'required|exists:report_details,id|unique:top_selling_reports,report_detail_id',
        ]);

        $topSelling = TopSellingReport::create([
            'report_detail_id' => $request->report_detail_id,
        ]);

        return response()->json([
            'message' => 'Report added to top selling list successfully!',
            'data' => $topSelling->load('reportDetail:id,title'),
        ]);
    }

    /**
     * Search for reports to add to the top selling list.
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        $reports = ReportDetail::whereNotIn('id', TopSellingReport::pluck('report_detail_id'));

        if (!empty($query)) {
            $reports->where('title', 'like', "%{$query}%");
        }
            
        return response()->json($reports->get(['id', 'title']));
    }

    /**
     * Remove the specified top selling report.
     */
    public function destroy($id)
    {
        $topSelling = TopSellingReport::findOrFail($id);
        $topSelling->delete();

        return response()->json([
            'message' => 'Report removed from top selling list successfully!',
        ]);
    }
}
