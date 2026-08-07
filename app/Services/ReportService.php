<?php

namespace App\Services;

use App\Models\ReportList;
use App\Traits\CacheKeyTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ReportService
{
    use CacheKeyTrait;

    public function getReportsByCategory(string $categoryName = 'All')
    {
        $key = $this->generateCacheKey('reports_by_category', $categoryName);

        return Cache::remember($key, 86400, fn() => $this->fetchReports($categoryName));
    }

    private function fetchReports(string $categoryName)
    {
        return $this->buildQuery($categoryName)
            ->latest()
            ->take(4)
            ->get()
            ->map(fn($report) => $this->formatReport($report));
    }

    private function buildQuery(string $categoryName)
    {
        return ReportList::with(['reportCategory', 'reportDetail'])
            ->has('reportDetail')
            ->where('status', 'Active')
            ->when($categoryName !== 'All', function ($query) use ($categoryName) {
                $query->whereHas('reportCategory', function ($q) use ($categoryName) {
                    $q->where('slug_url', $categoryName)
                        ->orWhere('name', $categoryName);
                });
            });
    }

    private function formatReport($report)
    {
        $detail = $report->reportDetail;

        return (object) [
            'id' => $report->id,
            'title' => $detail?->title ?? $report->name,
            'description' => $this->getDescription($detail?->detail_description),
            'category' => $report->reportCategory?->name ?? 'Unknown',
            'date' => $report->created_at->format('F Y'),
            'image' => '/assets/images/default-report.png',
            'slug' => $detail?->slug_url ?? '#',
        ];
    }

    private function getDescription(?string $description): string
    {
        return Str::limit(
            html_entity_decode(strip_tags($description ?? 'No description available.')),
            150
        );
    }
}