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
            ->take(6)
            ->get();

        return response()->json($pressReleases);
    }
}
