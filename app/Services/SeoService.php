<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\PressRelease;
use App\Models\ReportDetail;
use App\Models\PageSeo;
use Illuminate\Http\Request;
use App\Traits\SeoBuilderTrait;

class SeoService
{
    use SeoBuilderTrait;

    public function getIndustrySeo(string $slug, Request $request): array
    {
        $category = \App\Models\ReportCategory::where('slug_url', $slug)
            ->where('status', 'Active')
            ->first();

        if (!$category) {
            $category = \App\Models\ReportCategory::where('name', $slug)
                ->where('status', 'Active')
                ->first();
        }

        if (!$category) {
            return $this->getBaseSeo($request);
        }

        $path = ltrim($request->path(), '/');
        $pageSeo = PageSeo::where('url_path', $path)->orWhere('url_path', '/' . $path)->first();

        $title = $category->name . ' Market Research Reports | Epignosis Insights';
        $description = 'Explore ' . strtolower($category->name) . ' market research reports from Epignosis Insights, covering market size, trends, competitive landscape, and forecasts.';

        $data = [
            'title' => $title,
            'description' => $description,
            'canonical' => url('/industry/' . $category->slug_url),
            'schemas' => [
                $this->organizationSchema(),
                $this->websiteSchema($request),
                $this->breadcrumbSchema($request, [
                    ['name' => 'Home', 'url' => url('/')],
                    ['name' => 'Industries', 'url' => url('/industry')],
                    ['name' => $category->name, 'url' => $request->url()],
                ]),
                [
                    '@context' => 'https://schema.org',
                    '@type' => 'CollectionPage',
                    'name' => $title,
                    'description' => $description,
                    'url' => $request->url(),
                ]
            ],
        ];

        if ($pageSeo) {
            if ($pageSeo->meta_title)
                $data['title'] = $pageSeo->meta_title;
            if ($pageSeo->meta_description)
                $data['description'] = $pageSeo->meta_description;
            if ($pageSeo->meta_keywords)
                $data['keywords'] = $pageSeo->meta_keywords;
            if ($pageSeo->schema_tag) {
                $customSchemas = $this->customSchemas(array_filter([$pageSeo->schema_tag]));
                $data['schemas'] = array_merge($customSchemas, $data['schemas']);
            }
            if ($pageSeo->raw_tags)
                $data['raw_tags'] = $pageSeo->raw_tags;
        }

        return $this->buildSeo($data, $request);
    }

    public function getReportSeo(string $slug, Request $request): array
    {
        $query = ReportDetail::with(['reportList:id,name,report_category_id', 'reportList.reportCategory:id,name']);

        if (is_numeric($slug)) {
            $query->where(function ($q) use ($slug) {
                $q->where('id', $slug)
                    ->orWhere('report_list_id', $slug);
            });
        } else {
            $query->where('slug_url', $slug);
        }

        $report = $query->first();

        if (!$report) {
            return $this->getBaseSeo($request);
        }

        $title = $report->meta_title ?: ($report->title ?: optional($report->reportList)->name);
        $description = $this->cleanText($report->meta_description) ?: $this->cleanText($report->detail_description);
        $category = optional(optional($report->reportList)->reportCategory)->name;
        $schemas = $this->customSchemas(array_filter([
            $report->schema_tag,
            $report->schema_tag_2,
            ...($report->custom_schema_tags ?: []),
        ]));

        $schemas[] = $this->reportSchema($request, $report, $title, $description, $category);
        $schemas[] = $this->breadcrumbSchema($request, [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Reports', 'url' => url('/reports')],
            ['name' => $title, 'url' => $request->url()],
        ]);

        return $this->buildSeo([
            'title' => $title,
            'description' => $report->meta_description ?: $description,
            'keywords' => $report->meta_keywords,
            'robots' => $report->meta_robots,
            'canonical' => $report->canonical_tag,
            'hreflang' => $report->hreflang_tags,
            'open_graph' => $report->open_graph_tags,
            'twitter' => $report->twitter_card_tags,
            'schemas' => $schemas,
            'report' => $report,
        ], $request);
    }

    public function getBlogSeo(string $slug, Request $request): array
    {
        $blog = Blog::with('blogDetail')
            ->where('url', $slug)
            ->first();

        if (!$blog) {
            return $this->getBaseSeo($request);
        }

        $detail = $blog->blogDetail;
        $title = optional($detail)->meta_title ?: $blog->title;
        $description = $this->cleanText(optional($detail)->meta_description) ?: $this->cleanText(optional($detail)->description ?: $blog->description);
        $schemas = $this->customSchemas(array_filter([
            optional($detail)->schema_tag,
            optional($detail)->schema_tag_2,
            optional($detail)->schema_tag_3,
        ]));

        $schemas[] = $this->blogSchema($request, $blog, $title, $description);
        $schemas[] = $this->breadcrumbSchema($request, [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Blogs', 'url' => url('/blogs')],
            ['name' => $title, 'url' => $request->url()],
        ]);

        return $this->buildSeo([
            'title' => $title,
            'description' => optional($detail)->meta_description ?: $description,
            'keywords' => optional($detail)->meta_keywords,
            'robots' => optional($detail)->meta_robots,
            'canonical' => optional($detail)->canonical_tag,
            'hreflang' => optional($detail)->hreflang_tags,
            'open_graph' => optional($detail)->open_graph_tags,
            'twitter' => optional($detail)->twitter_card_tags,
            'schemas' => $schemas,
        ], $request);
    }

    public function getPressReleaseSeo(string $slug, Request $request): array
    {
        $pressRelease = PressRelease::with('pressReleaseDetail')
            ->where('url', $slug)
            ->first();

        if (!$pressRelease) {
            return $this->getBaseSeo($request);
        }

        $detail = $pressRelease->pressReleaseDetail;
        $title = optional($detail)->meta_title ?: $pressRelease->title;
        $description = $this->cleanText(optional($detail)->meta_description) ?: $this->cleanText(optional($detail)->content ?: $pressRelease->description);
        $schemas = $this->customSchemas(array_filter([
            optional($detail)->schema_tag,
            optional($detail)->schema_tag_2,
        ]));

        $schemas[] = $this->pressReleaseSchema($request, $pressRelease, $title, $description);
        $schemas[] = $this->breadcrumbSchema($request, [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Press Releases', 'url' => url('/press-releases')],
            ['name' => $title, 'url' => $request->url()],
        ]);

        return $this->buildSeo([
            'title' => $title,
            'description' => optional($detail)->meta_description ?: $description,
            'keywords' => optional($detail)->meta_keywords,
            'robots' => optional($detail)->meta_robots,
            'canonical' => optional($detail)->canonical_tag,
            'hreflang' => optional($detail)->hreflang_tags,
            'open_graph' => optional($detail)->open_graph_tags,
            'twitter' => optional($detail)->twitter_card_tags,
            'schemas' => $schemas,
        ], $request);
    }

    public function getBaseSeo(Request $request): array
    {
        $path = ltrim($request->path(), '/');
        // Handle home route explicitly since path() might return empty or '/'
        if ($path === '') {
            $path = '/';
        }

        $pageSeo = PageSeo::where('url_path', $path)->orWhere('url_path', '/' . $path)->first();

        // Base defaults
        $data = [
            'title' => 'Epignosis Insights - Market Research Reports and Industry Analysis',
            'description' => 'Explore market research reports, industry analysis, trends, forecasts, blogs, and press releases from Epignosis Insights.',
            'canonical' => $request->url(),
            'schemas' => [
                $this->organizationSchema(),
                $this->websiteSchema($request),
            ],
        ];

        if ($pageSeo) {
            $customSchemas = $this->customSchemas(array_filter([
                $pageSeo->schema_tag
            ]));

            $data['schemas'] = array_merge($customSchemas, $data['schemas']);
            $data['raw_tags'] = $pageSeo->raw_tags;
        }

        return $this->buildSeo($data, $request);
    }
}
