<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportCategory;
use App\Models\ReportList;
use App\Models\PressRelease;

class UserviewController extends Controller
{
    /**
     * Get categories with their recent active reports.
     */
    public function categoriesWithReports()
    {
        $categories = ReportCategory::where('status', 'Active')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        foreach ($categories as $category) {
            $category->reports = ReportList::where('report_category_id', $category->id)
                ->where('status', 'Active')
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
        }

        return response()->json($categories);
    }

    /**
     * Get recent press releases.
     */
    public function pressReleases()
    {
        $pressReleases = PressRelease::where('status', 'Active')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($pr) {
                return [
                    'title' => $pr->title,
                    'description' => \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($pr->description)), 120),
                    'date' => $pr->created_at->format('F d, Y'),
                    'image' => $pr->thumbnail_image ? asset('storage/' . $pr->thumbnail_image) : ($pr->main_image ? asset('storage/' . $pr->main_image) : '/assets/images/default.jpg'),
                ];
            });

        return response()->json($pressReleases);
    }
    /**
     * Get reports by category.
     */
    public function reportsByCategory(Request $request)
    {
        $categoryName = $request->query('category', 'All');

        $query = ReportList::with(['reportCategory', 'reportDetail'])
            ->where('status', 'Active');

        if ($categoryName !== 'All') {
            $query->whereHas('reportCategory', function ($q) use ($categoryName) {
                $q->where('name', $categoryName);
            });
        }

        $reports = $query->orderBy('created_at', 'desc')
            ->take(4)
            ->get()
            ->map(function ($report) {
                $description = $report->reportDetail ? strip_tags($report->reportDetail->description) : 'No description available.';
                $description = \Illuminate\Support\Str::limit(html_entity_decode($description), 150);

                return [
                    'title' => ($report->reportDetail && $report->reportDetail->title) ? $report->reportDetail->title : $report->name,
                    'description' => $description,
                    'category' => $report->reportCategory ? $report->reportCategory->name : 'Unknown',
                    'date' => $report->created_at->format('F Y')
                ];
            });

        return response()->json($reports);
    }

    /**
     * Get recent blogs.
     */
    public function blogs()
    {
        $blogs = \App\Models\Blog::orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($blog) {
                return [
                    'title' => $blog->title,
                    'description' => \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($blog->description)), 120),
                    'date' => $blog->created_at->format('F d, Y'),
                    'image' => $blog->image ? asset('storage/' . $blog->image) : '/assets/images/default.jpg',
                ];
            });

        return response()->json($blogs);
    }
}
