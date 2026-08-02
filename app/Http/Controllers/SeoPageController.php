<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\PressRelease;
use App\Models\ReportDetail;
use App\Models\PageSeo;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SeoPageController extends Controller
{
    public function show(Request $request)
    {
        $seo = $this->seoForPath($request);
        $path = trim($request->path(), '/');
        $segments = $request->segments();

        if ($path === '') {
            $userview = app(\App\Http\Controllers\UserviewController::class);
            $categoriesData = $userview->categoriesDropdown()->getData();
            $trendingReportsData = $userview->reportsByCategory($request)->getData();
            $latestInsightsData = $userview->blogs()->getData();
            $pressReleasesData = $userview->pressReleases()->getData();

            return view('pages.home', [
                'seo' => $seo,
                'initialCategories' => $categoriesData,
                'trendingReports' => $trendingReportsData,
                'latestInsights' => $latestInsightsData,
                'pressReleases' => $pressReleasesData
            ]);
        }

        if (($segments[0] ?? '') === 'reports' && empty($segments[1])) {
            $userview = app(\App\Http\Controllers\UserviewController::class);

            $request->query->add(['page' => $request->query('page', 1)]);
            if ($request->has('q')) {
                $request->query->add(['search' => $request->query('q')]);
            }

            $reportsResponse = $userview->getAllReports($request);
            $reportsData = $reportsResponse->getData();

            $categoriesResponse = $userview->categoriesDropdown();
            $categoriesData = $categoriesResponse->getData();

            $topSellersResponse = $userview->publicTopSellingReports();
            $topSellersData = $topSellersResponse->getData();

            return view('pages.reports.index', [
                'seo' => $seo,
                'initialReports' => $reportsData->data ?? [],
                'initialTotalPages' => $reportsData->last_page ?? 1,
                'initialCategories' => $categoriesData,
                'initialTopSellers' => $topSellersData,
            ]);
        }

        if (($segments[0] ?? '') === 'report' && !empty($segments[1]) && !empty($seo['report'])) {
            $userview = app(\App\Http\Controllers\UserviewController::class);
            $reportDataResponse = $userview->getReportDetail($segments[1]);
            $reportData = $reportDataResponse->getData();
            return view('pages.reports.show', [
                'seo' => $seo,
                'report' => $seo['report'],
                'reportData' => $reportData
            ]);
        }

        if (($segments[0] ?? '') === 'blogs' && empty($segments[1])) {
            $userview = app(\App\Http\Controllers\UserviewController::class);
            $request->query->add(['page' => $request->query('page', 1)]);
            $blogsResponse = $userview->getAllBlogs($request);
            $blogsData = $blogsResponse->getData();
            return view('pages.blogs.index', [
                'seo' => $seo,
                'initialBlogs' => $blogsData->data ?? [],
                'initialTotalPages' => $blogsData->last_page ?? 1,
            ]);
        }

        if (($segments[0] ?? '') === 'blog' && !empty($segments[1])) {
            $userview = app(\App\Http\Controllers\UserviewController::class);
            $blogDetailResponse = $userview->getBlogDetail($segments[1]);
            if ($blogDetailResponse->getStatusCode() === 404)
                return abort(404);
            return view('pages.blogs.show', [
                'seo' => $seo,
                'blog' => $blogDetailResponse->getData()
            ]);
        }

        if (($segments[0] ?? '') === 'press-releases' && empty($segments[1])) {
            $userview = app(\App\Http\Controllers\UserviewController::class);
            $request->query->add(['page' => $request->query('page', 1)]);
            if ($request->has('q'))
                $request->query->add(['search' => $request->query('q')]);

            $prResponse = $userview->getAllPressReleases($request);
            $prData = $prResponse->getData();
            return view('pages.press-releases.index', [
                'seo' => $seo,
                'initialPressReleases' => $prData->data ?? [],
                'initialTotalPages' => $prData->last_page ?? 1,
            ]);
        }

        if (($segments[0] ?? '') === 'press-release' && !empty($segments[1])) {
            $userview = app(\App\Http\Controllers\UserviewController::class);
            $prDetailResponse = $userview->getPressReleaseDetail($segments[1]);
            if ($prDetailResponse->getStatusCode() === 404)
                return abort(404);
            return view('pages.press-releases.show', [
                'seo' => $seo,
                'pressRelease' => $prDetailResponse->getData()
            ]);
        }

        if (($segments[0] ?? '') === 'industry' && !empty($segments[1])) {
            $userview = app(\App\Http\Controllers\UserviewController::class);
            $categoryDetailResponse = $userview->getCategoryDetail($segments[1]);

            if ($categoryDetailResponse->getStatusCode() === 404)
                return abort(404);

            $categoryInfo = $categoryDetailResponse->getData();

            $request->query->add(['page' => $request->query('page', 1)]);
            $request->query->add(['category' => $categoryInfo->name]);

            $reportsResponse = $userview->getAllReports($request);
            $reportsData = $reportsResponse->getData();

            $categoriesResponse = $userview->categoriesDropdown();
            $categoriesData = $categoriesResponse->getData();

            return view('pages.industry.show', [
                'seo' => $seo,
                'categoryInfo' => $categoryInfo,
                'categoryName' => $categoryInfo->name,
                'initialReports' => $reportsData->data ?? [],
                'initialTotalPages' => $reportsData->last_page ?? 1,
                'sidebarCategories' => $categoriesData ?? [],
            ]);
        }

        $staticPages = [
            'about-us' => 'pages.about-us',
            'contact-us' => 'pages.contact-us',
            'services' => 'pages.services',
            'privacy-policy' => 'pages.privacy',
            'terms-and-conditions' => 'pages.terms',
            'thank-you' => 'pages.thank-you'
        ];

        if (array_key_exists($path, $staticPages)) {
            $viewData = ['seo' => $seo];
            if (in_array($path, ['about-us', 'services'])) {
                $viewData['latestInsights'] = app(\App\Http\Controllers\UserviewController::class)->blogs()->getData();
            }
            return view($staticPages[$path], $viewData);
        }

        if (([0] ?? '') === 'admin') {
            return view('welcome', [
                'seo' => $seo,
            ]);
        }

        abort(404);
    }

    private function seoForPath(Request $request): array
    {
        $path = trim($request->path(), '/');
        $segments = $path === '' ? [] : explode('/', $path);

        if (($segments[0] ?? '') === 'report' && !empty($segments[1])) {
            return $this->reportSeo($segments[1], $request);
        }

        if (($segments[0] ?? '') === 'blog' && !empty($segments[1])) {
            return $this->blogSeo($segments[1], $request);
        }

        if (($segments[0] ?? '') === 'press-release' && !empty($segments[1])) {
            return $this->pressReleaseSeo($segments[1], $request);
        }

        if (($segments[0] ?? '') === 'industry' && !empty($segments[1])) {
            return $this->industrySeo($segments[1], $request);
        }

        return $this->baseSeo($request);
    }

    private function industrySeo(string $slug, Request $request): array
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
            return $this->baseSeo($request);
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

    private function reportSeo(string $slug, Request $request): array
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
            return $this->baseSeo($request);
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
            'prerendered_html' => $this->generateReportHtml($report),
            'report' => $report,
        ], $request);
    }

    private function blogSeo(string $slug, Request $request): array
    {
        $blog = Blog::with('blogDetail')
            ->where('url', $slug)
            ->first();

        if (!$blog) {
            return $this->baseSeo($request);
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
            'prerendered_html' => $this->generateBlogHtml($blog, $detail),
        ], $request);
    }

    private function pressReleaseSeo(string $slug, Request $request): array
    {
        $pressRelease = PressRelease::with('pressReleaseDetail')
            ->where('url', $slug)
            ->first();

        if (!$pressRelease) {
            return $this->baseSeo($request);
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
            'prerendered_html' => $this->generatePressReleaseHtml($pressRelease, $detail),
        ], $request);
    }

    private function baseSeo(Request $request): array
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

    private function buildSeo(array $data, Request $request): array
    {
        $title = trim((string) Arr::get($data, 'title', '')) ?: 'Epignosis Insights';

        return [
            'title' => $title,
            'description' => $this->cleanText(Arr::get($data, 'description')),
            'keywords' => $this->cleanText(Arr::get($data, 'keywords')),
            'robots' => $this->cleanText(Arr::get($data, 'robots')),
            'canonical' => $this->cleanUrl(Arr::get($data, 'canonical')) ?: $request->url(),
            'raw_head' => implode("\n    ", array_filter([
                $this->renderSchemaTags(Arr::get($data, 'schemas', [])),
                Arr::get($data, 'raw_tags', ''),
            ])),
            'prerendered_html' => Arr::get($data, 'prerendered_html', ''),
            'report' => Arr::get($data, 'report', null),
        ];
    }

    private function reportSchema(Request $request, ReportDetail $report, string $title, ?string $description, ?string $category): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $title,
            'description' => $description ?: $title,
            'url' => $request->url(),
            'brand' => $this->organizationReference(),
            'category' => $category ?: 'Market Research Report',
            'sku' => $report->report_sku ?: ('REP-' . str_pad((string) $report->id, 5, '0', STR_PAD_LEFT)),
            'productID' => (string) $report->id,
        ];

        $image = $this->absoluteImage($report->image ?: '/assets/images/default-report.png');
        if ($image) {
            $schema['image'] = $image;
        }

        $price = $report->single_user_license_cost ?: $report->team_user_license_cost ?: $report->enterprise_user_license_cost;
        if ($price) {
            $schema['offers'] = [
                '@type' => 'Offer',
                'url' => $request->url(),
                'priceCurrency' => 'USD',
                'price' => (string) $price,
                'availability' => 'https://schema.org/InStock',
            ];
        }

        return $schema;
    }

    private function generateReportHtml(ReportDetail $report): string
    {
        return view('seo.report', compact('report'))->render();
    }

    private function generateBlogHtml(Blog $blog, $detail): string
    {
        return view('seo.blog', compact('blog', 'detail'))->render();
    }

    private function generatePressReleaseHtml(PressRelease $pressRelease, $detail): string
    {
        return view('seo.press-release', compact('pressRelease', 'detail'))->render();
    }

    private function blogSchema(Request $request, Blog $blog, string $title, ?string $description): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $title,
            'description' => $description ?: $title,
            'url' => $request->url(),
            'image' => array_filter([$this->absoluteImage($blog->image ?: '/favicon.png')]),
            'datePublished' => optional($blog->created_at)->toAtomString(),
            'dateModified' => optional($blog->updated_at)->toAtomString(),
            'author' => [
                '@type' => 'Person',
                'name' => $blog->author_name ?: 'Epignosis Insights',
            ],
            'publisher' => $this->organizationReference(true),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $request->url(),
            ],
        ];
    }

    private function pressReleaseSchema(Request $request, PressRelease $pressRelease, string $title, ?string $description): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => $title,
            'description' => $description ?: $title,
            'url' => $request->url(),
            'image' => array_filter([$this->absoluteImage($pressRelease->thumbnail_image ?: ($pressRelease->main_image ?: '/favicon.png'))]),
            'datePublished' => optional($pressRelease->created_at)->toAtomString(),
            'dateModified' => optional($pressRelease->updated_at)->toAtomString(),
            'publisher' => $this->organizationReference(true),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $request->url(),
            ],
        ];
    }

    private function organizationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => url('/#organization'),
            'name' => 'Epignosis Insights',
            'url' => url('/'),
            'logo' => $this->absoluteImage('/favicon.png'),
            'sameAs' => [],
        ];
    }

    private function websiteSchema(Request $request): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => url('/#website'),
            'name' => 'Epignosis Insights',
            'url' => url('/'),
            'publisher' => $this->organizationReference(),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => url('/reports') . '?search={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    private function breadcrumbSchema(Request $request, array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array_values(array_map(function (array $item, int $index) {
                return [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $item['name'],
                    'item' => $item['url'],
                ];
            }, $items, array_keys($items))),
        ];
    }

    private function organizationReference(bool $withLogo = false): array
    {
        $organization = [
            '@type' => 'Organization',
            '@id' => url('/#organization'),
            'name' => 'Epignosis Insights',
            'url' => url('/'),
        ];

        if ($withLogo) {
            $organization['logo'] = [
                '@type' => 'ImageObject',
                'url' => $this->absoluteImage('/favicon.png'),
            ];
        }

        return $organization;
    }

    private function customSchemas(array $items): array
    {
        return array_values($items);
    }

    private function renderRawTags($items, string $tagName): string
    {
        $tags = [];

        foreach ($this->normalizeList($items) as $raw) {
            if (!is_string($raw) || trim($raw) === '') {
                continue;
            }

            if (preg_match_all('/<' . $tagName . '\b[^>]*>/i', $raw, $matches)) {
                foreach ($matches[0] as $tag) {
                    $tags[] = $this->sanitizeStandaloneTag($tag, $tagName);
                }
            }
        }

        return implode("\n    ", array_filter($tags));
    }

    private function renderSchemaTags($items): string
    {
        $scripts = [];

        foreach ($this->normalizeSchemaList($items) as $raw) {
            if (is_array($raw)) {
                $scripts[] = $this->schemaScript(json_encode($raw, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
                continue;
            }

            if (!is_string($raw) || trim($raw) === '') {
                continue;
            }

            if (preg_match_all('/<script\b[^>]*>(.*?)<\/script>/is', $raw, $matches)) {
                foreach ($matches[1] as $json) {
                    $json = trim($json);
                    if ($json !== '') {
                        $scripts[] = $this->schemaScript($json);
                    }
                }
                continue;
            }

            $json = trim($raw);
            if (Str::startsWith($json, ['{', '['])) {
                $scripts[] = $this->schemaScript($json);
            }
        }

        return implode("\n    ", array_filter($scripts));
    }

    private function schemaScript(?string $json): string
    {
        if (!$json) {
            return '';
        }

        return '<script type="application/ld+json">' . $this->escapeJsonLd($json) . '</script>';
    }

    private function sanitizeStandaloneTag(string $tag, string $tagName): string
    {
        $allowed = $tagName === 'meta'
            ? ['name', 'content', 'property', 'charset', 'http-equiv']
            : ['rel', 'href', 'hreflang', 'media', 'type', 'sizes'];

        preg_match_all('/([a-zA-Z_:][-a-zA-Z0-9_:.]*)\s*=\s*("[^"]*"|\'[^\']*\'|[^\s"\'>]+)/', $tag, $matches, PREG_SET_ORDER);

        $attrs = [];
        foreach ($matches as $match) {
            $name = strtolower($match[1]);
            if (!in_array($name, $allowed, true)) {
                continue;
            }

            $value = trim($match[2], " \t\n\r\0\x0B\"'");
            if ($name === 'href' && !$this->cleanUrl($value)) {
                continue;
            }

            $attrs[] = $name . '="' . e($value) . '"';
        }

        return $attrs ? '<' . $tagName . ' ' . implode(' ', $attrs) . '>' : '';
    }

    private function escapeJsonLd(string $json): string
    {
        return str_ireplace('</script', '<\/script', $json);
    }

    private function normalizeSchemaList($items): array
    {
        if (!$items) {
            return [];
        }

        if (!is_array($items)) {
            return [$items];
        }

        if (array_key_exists('@type', $items) || array_key_exists('@context', $items)) {
            return [$items];
        }

        return array_values($items);
    }
    private function normalizeList($items): array
    {
        if (!$items) {
            return [];
        }

        if (is_array($items)) {
            return Arr::flatten($items, 1);
        }

        return [$items];
    }

    private function cleanText($value): ?string
    {
        $value = trim(strip_tags(html_entity_decode((string) $value)));

        return $value !== '' ? $value : null;
    }

    private function cleanUrl($value): ?string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        return preg_match('/^https?:\/\//i', $value) ? $value : null;
    }

    private function absoluteImage(?string $path): ?string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return null;
        }

        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }

        return url('/' . ltrim($path, '/'));
    }
}


