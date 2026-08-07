<?php

namespace App\Traits;

use App\Models\Blog;
use App\Models\PressRelease;
use App\Models\ReportDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait SeoBuilderTrait
{
    private const SCHEMA = 'https://schema.org';
    private const ORGANIZATION = 'Epignosis Insights';
    private const DEFAULT_IMAGE = '/favicon.png';

    // -------------------------------------------------------------------------
    // Public / Entry SEO Builder
    // -------------------------------------------------------------------------

    protected function buildSeo(array $data, Request $request): array
    {
        $title = trim((string) Arr::get($data, 'title', '')) ?: self::ORGANIZATION;

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
            'report' => Arr::get($data, 'report', null),
        ];
    }

    // -------------------------------------------------------------------------
    // Schema Builders
    // -------------------------------------------------------------------------

    protected function reportSchema(Request $request, ReportDetail $report, string $title, ?string $description, ?string $category): array
    {
        $schema = array_merge(
            $this->baseSchema('Product', $request, $title, $description),
            [
                'name' => $title,
                'brand' => $this->organizationReference(),
                'category' => $category ?: 'Market Research Report',
                'sku' => $report->report_sku ?: ('REP-' . str_pad((string) $report->id, 5, '0', STR_PAD_LEFT)),
                'productID' => (string) $report->id,
            ]
        );

        $image = $this->image($report->image, '/assets/images/default-report.png');
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
                'availability' => self::SCHEMA . '/InStock',
            ];
        }

        return $schema;
    }

    protected function blogSchema(Request $request, Blog $blog, string $title, ?string $description): array
    {
        return array_merge(
            $this->baseSchema('BlogPosting', $request, $title, $description),
            [
                'headline' => $title,
                'image' => array_filter([$this->image($blog->image, self::DEFAULT_IMAGE)]),
                'datePublished' => optional($blog->created_at)->toAtomString(),
                'dateModified' => optional($blog->updated_at)->toAtomString(),
                'author' => [
                    '@type' => 'Person',
                    'name' => $blog->author_name ?: self::ORGANIZATION,
                ],
                'publisher' => $this->organizationReference(true),
                'mainEntityOfPage' => [
                    '@type' => 'WebPage',
                    '@id' => $request->url(),
                ],
            ]
        );
    }

    protected function pressReleaseSchema(Request $request, PressRelease $pressRelease, string $title, ?string $description): array
    {
        return array_merge(
            $this->baseSchema('NewsArticle', $request, $title, $description),
            [
                'headline' => $title,
                'image' => array_filter([$this->image($pressRelease->thumbnail_image, $pressRelease->main_image, self::DEFAULT_IMAGE)]),
                'datePublished' => optional($pressRelease->created_at)->toAtomString(),
                'dateModified' => optional($pressRelease->updated_at)->toAtomString(),
                'publisher' => $this->organizationReference(true),
                'mainEntityOfPage' => [
                    '@type' => 'WebPage',
                    '@id' => $request->url(),
                ],
            ]
        );
    }

    protected function organizationSchema(): array
    {
        return [
            '@context' => self::SCHEMA,
            '@type' => 'Organization',
            '@id' => url('/#organization'),
            'name' => self::ORGANIZATION,
            'url' => url('/'),
            'logo' => $this->absoluteImage(self::DEFAULT_IMAGE),
            'sameAs' => [],
        ];
    }

    protected function websiteSchema(Request $request): array
    {
        return [
            '@context' => self::SCHEMA,
            '@type' => 'WebSite',
            '@id' => url('/#website'),
            'name' => self::ORGANIZATION,
            'url' => url('/'),
            'publisher' => $this->organizationReference(),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => url('/reports') . '?search={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    protected function breadcrumbSchema(Request $request, array $items): array
    {
        return [
            '@context' => self::SCHEMA,
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

    // -------------------------------------------------------------------------
    // Shared Schema Helpers
    // -------------------------------------------------------------------------

    protected function baseSchema(string $type, Request $request, string $title, ?string $description): array
    {
        return [
            '@context' => self::SCHEMA,
            '@type' => $type,
            'url' => $request->url(),
            'description' => $description ?: $title,
        ];
    }

    protected function organizationReference(bool $withLogo = false): array
    {
        $organization = [
            '@type' => 'Organization',
            '@id' => url('/#organization'),
            'name' => self::ORGANIZATION,
            'url' => url('/'),
        ];

        if ($withLogo) {
            $organization['logo'] = [
                '@type' => 'ImageObject',
                'url' => $this->absoluteImage(self::DEFAULT_IMAGE),
            ];
        }

        return $organization;
    }

    protected function image(...$images): ?string
    {
        foreach ($images as $image) {
            if (!empty($image)) {
                return $this->absoluteImage($image);
            }
        }

        return null;
    }

    protected function schemaScript(?string $json): string
    {
        if (!$json) {
            return '';
        }

        return '<script type="application/ld+json">' . $this->escapeJsonLd($json) . '</script>';
    }

    // -------------------------------------------------------------------------
    // Rendering Helpers
    // -------------------------------------------------------------------------

    protected function customSchemas(array $items): array
    {
        return array_values($items);
    }

    protected function renderSchemaTags($items): string
    {
        $scripts = [];

        foreach ($this->normalizeSchemaList($items) as $raw) {
            $scripts = array_merge($scripts, $this->extractSchemaScripts($raw));
        }

        return implode("\n    ", array_filter($scripts));
    }

    protected function extractSchemaScripts($raw): array
    {
        $scripts = [];

        if (is_array($raw)) {
            $scripts[] = $this->schemaScript(json_encode($raw, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            return $scripts;
        }

        if (!is_string($raw) || trim($raw) === '') {
            return $scripts;
        }

        if (preg_match_all('/<script\b[^>]*>(.*?)<\/script>/is', $raw, $matches)) {
            foreach ($matches[1] as $json) {
                $json = trim($json);
                if ($json !== '') {
                    $scripts[] = $this->schemaScript($json);
                }
            }
            return $scripts;
        }

        $json = trim($raw);
        if (Str::startsWith($json, ['{', '['])) {
            $scripts[] = $this->schemaScript($json);
        }

        return $scripts;
    }

    protected function renderRawTags($items, string $tagName): string
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

    protected function sanitizeStandaloneTag(string $tag, string $tagName): string
    {
        $attrs = $this->extractAttributes($tag, $this->allowedAttributes($tagName));

        return $attrs ? '<' . $tagName . ' ' . implode(' ', $attrs) . '>' : '';
    }

    protected function allowedAttributes(string $tagName): array
    {
        return $tagName === 'meta'
            ? ['name', 'content', 'property', 'charset', 'http-equiv']
            : ['rel', 'href', 'hreflang', 'media', 'type', 'sizes'];
    }

    protected function extractAttributes(string $tag, array $allowed): array
    {
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

        return $attrs;
    }

    // -------------------------------------------------------------------------
    // Utility Helpers
    // -------------------------------------------------------------------------

    protected function normalizeSchemaList($items): array
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

    protected function normalizeList($items): array
    {
        if (!$items) {
            return [];
        }

        if (is_array($items)) {
            return Arr::flatten($items, 1);
        }

        return [$items];
    }

    protected function emptyToNull($value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    protected function cleanText($value): ?string
    {
        return $this->emptyToNull(strip_tags(html_entity_decode((string) $value)));
    }

    protected function cleanUrl($value): ?string
    {
        $value = $this->emptyToNull($value);

        if ($value === null) {
            return null;
        }

        return preg_match('/^https?:\/\//i', $value) ? $value : null;
    }

    protected function absoluteImage(?string $path): ?string
    {
        $path = $this->emptyToNull($path);

        if ($path === null) {
            return null;
        }

        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }

        return url('/' . ltrim($path, '/'));
    }

    protected function escapeJsonLd(string $json): string
    {
        return str_ireplace('</script', '<\/script', $json);
    }
}
