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
                ->has('reportDetail')
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
            ->has('reportDetail')
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
                    'id' => $report->id,
                    'title' => ($report->reportDetail && $report->reportDetail->title) ? $report->reportDetail->title : $report->name,
                    'description' => $description,
                    'category' => $report->reportCategory ? $report->reportCategory->name : 'Unknown',
                    'date' => $report->created_at->format('F Y'),
                    'image' => '/assets/images/default-report.png',
                    'slug' => ($report->reportDetail && $report->reportDetail->slug_url) ? $report->reportDetail->slug_url : '#'
                ];
            });

        return response()->json($reports);
    }

    /**
     * Get all reports paginated with filters.
     */
    public function getAllReports(Request $request)
    {
        $search = $request->query('search');
        $categoryName = $request->query('category', 'All');

        $query = ReportList::with(['reportCategory', 'reportDetail'])
            ->has('reportDetail')
            ->where('status', 'Active');

        if ($categoryName !== 'All') {
            $query->whereHas('reportCategory', function ($q) use ($categoryName) {
                $q->where('name', $categoryName);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhereHas('reportDetail', function ($q2) use ($search) {
                      $q2->where('title', 'like', '%' . $search . '%')
                         ->orWhere('description', 'like', '%' . $search . '%');
                  });
            });
        }

        $paginator = $query->orderBy('created_at', 'desc')->paginate(10);
        
        $paginator->getCollection()->transform(function ($report) {
            $description = $report->reportDetail ? strip_tags($report->reportDetail->description) : 'No description available.';
            $description = \Illuminate\Support\Str::limit(html_entity_decode($description), 250);

            return [
                'id' => $report->id,
                'title' => ($report->reportDetail && $report->reportDetail->title) ? $report->reportDetail->title : $report->name,
                'description' => $description,
                'category' => $report->reportCategory ? $report->reportCategory->name : 'Unknown',
                'date' => $report->created_at->format('M-Y'),
                'image' => '/assets/images/default-report.png',
                'pages' => 120, // Placeholder
                'format' => 'PDF, Excel', // Placeholder
                'slug' => ($report->reportDetail && $report->reportDetail->slug_url) ? $report->reportDetail->slug_url : '#'
            ];
        });

        return response()->json($paginator);
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

    /**
     * Get a single report by slug.
     */
    public function getReportDetail($slug)
    {
        $query = \App\Models\ReportDetail::with(['reportList.reportCategory']);
        if (is_numeric($slug)) {
            $query->where(function ($q) use ($slug) {
                $q->where('id', $slug)
                  ->orWhere('report_list_id', $slug);
            });
        } else {
            $query->where('slug_url', $slug);
        }
        $reportDetail = $query->first();

        if (!$reportDetail) {
            return response()->json(['message' => 'Report not found'], 404);
        }

        // Fetch related reports in same category
        $relatedReports = [];
        if ($reportDetail->reportList && $reportDetail->reportList->reportCategory) {
            $catId = $reportDetail->reportList->report_category_id;
            $relatedReports = \App\Models\ReportList::with(['reportCategory', 'reportDetail'])
                ->where('report_category_id', $catId)
                ->where('id', '!=', $reportDetail->report_list_id)
                ->where('status', 'Active')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function ($r) {
                    return [
                        'id' => $r->id,
                        'title' => ($r->reportDetail && $r->reportDetail->title) ? $r->reportDetail->title : $r->name,
                        'slug' => ($r->reportDetail && $r->reportDetail->slug_url) ? $r->reportDetail->slug_url : '#'
                    ];
                });
        }

        // Fetch related categories / industries
        $relatedCategories = \App\Models\ReportCategory::where('status', 'Active')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get()
            ->map(function ($cat) {
                return $cat->name;
            });

        return response()->json([
            'id' => $reportDetail->id,
            'title' => $reportDetail->title ?: ($reportDetail->reportList ? $reportDetail->reportList->name : 'No Title'),
            'description' => $reportDetail->description,
            'table_of_contents' => $reportDetail->table_of_contents,
            'single_user_license_cost' => $reportDetail->single_user_license_cost ?: '3500',
            'team_user_license_cost' => $reportDetail->team_user_license_cost ?: '5500',
            'enterprise_user_license_cost' => $reportDetail->enterprise_user_license_cost ?: '7500',
            'download_text' => $reportDetail->download_text,
            'image' => '/assets/images/default-report.png',
            'slug_url' => $reportDetail->slug_url,
            'breadcrumb_title' => $reportDetail->breadcrumb_title ?: ($reportDetail->reportList ? $reportDetail->reportList->name : ''),
            'page_main_title' => $reportDetail->page_main_title ?: $reportDetail->title,
            'report_sku' => $reportDetail->report_sku ?: ('REP-' . str_pad($reportDetail->id, 5, '0', STR_PAD_LEFT)),
            'faqs' => $reportDetail->faqs ?: [],
            'category' => ($reportDetail->reportList && $reportDetail->reportList->reportCategory) ? $reportDetail->reportList->reportCategory->name : 'Unknown',
            'date' => $reportDetail->created_at ? $reportDetail->created_at->format('F Y') : date('F Y'),
            'pages' => 120, // default pages
            'format' => 'PDF, Excel', // default format
            'related_reports' => $relatedReports,
            'related_industries' => $relatedCategories
        ]);
    }

    /**
     * Get a single category by name.
     */
    public function getCategoryDetail($name)
    {
        $category = \App\Models\ReportCategory::where('name', $name)
            ->where('status', 'Active')
            ->first();

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json([
            'id' => $category->id,
            'name' => $category->name,
            'main_heading' => $category->main_heading,
            'main_subheading' => $category->main_subheading,
            'category_image' => $category->category_image ? asset('storage/' . $category->category_image) : null,
            'category_icon' => $category->category_icon ? asset('storage/' . $category->category_icon) : null,
        ]);
    }
}
