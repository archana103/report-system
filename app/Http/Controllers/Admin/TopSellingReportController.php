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
    public function index(Request $request)
    {
        $reports = TopSellingReport::with('reportDetail:id,title')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $availableReports = ReportDetail::whereNotIn('id', TopSellingReport::pluck('report_detail_id'))
            ->orderBy('title')
            ->get(['id', 'title']);

        return view('admin.top_selling_reports.index', compact('reports', 'availableReports'));
    }

    /**
     * Store a newly created top selling report.
     */
    public function store(Request $request)
    {
        $request->validate([
            'report_detail_id' => 'required|exists:report_details,id|unique:top_selling_reports,report_detail_id',
        ]);

        TopSellingReport::create([
            'report_detail_id' => $request->report_detail_id,
        ]);

        return redirect()->route('admin.top_selling_reports.index')->with('success', 'Report added to top selling list successfully!');
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

        return redirect()->back()->with('success', 'Report removed from top selling list successfully!');
    }
}
