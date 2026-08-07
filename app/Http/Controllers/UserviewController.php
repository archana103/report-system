<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportCategory;
use App\Models\ReportList;
use App\Models\PressRelease;
use App\Models\ContactUS;
use App\Models\DiscountRequest;
use App\Models\TopSellingReport;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class UserviewController extends Controller
{
    /**
     * Get categories with their recent active reports.
     */
    public function categoriesWithReports()
    {
        $version = Cache::get('userview_cache_version', 1);
        $key = 'categories_with_reports_v' . $version;
        
        $categories = Cache::remember($key, 60*60*24, function () {
            $cats = ReportCategory::where('status', 'Active')
                ->orderBy('created_at', 'desc')
                ->take(8)
                ->get();

            foreach ($cats as $category) {
                $category->reports = ReportList::where('report_category_id', $category->id)
                    ->has('reportDetail')
                    ->where('status', 'Active')
                    ->orderBy('created_at', 'desc')
                    ->take(3)
                    ->get();
            }
            return $cats;
        });

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
                    'image' => $pr->thumbnail_image ?: ($pr->main_image ?: '/assets/images/default.jpg'),
                    'url' => $pr->url,
                ];
            });

        return response()->json($pressReleases);
    }


    /**
     * Get all reports paginated with filters.
     */
    public function getAllReports(Request $request)
    {
        $search = $request->query('search', '');
        $categoryName = $request->query('category', 'All');
        $page = $request->query('page', 1);
        $sort = $request->query('sort', '');
        
        $version = Cache::get('userview_cache_version', 1);
        $key = sprintf(
            'reports:v%s:p%s:s%s:c%s:o%s',
            $version,
            $page,
            md5($search),
            md5($categoryName),
            $sort
        );

        $paginator = Cache::remember($key, 60*60*24, function () use ($search, $categoryName) {
            $query = ReportList::with(['reportCategory', 'reportDetail'])
                ->has('reportDetail')
                ->where('status', 'Active');

            if ($categoryName !== 'All') {
                $query->whereHas('reportCategory', function ($q) use ($categoryName) {
                    $q->where('slug_url', $categoryName)->orWhere('name', $categoryName);
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

            $paginatorData = $query->orderBy('created_at', 'desc')->paginate(10);
            
            $paginatorData->getCollection()->transform(function ($report) {
                $rawDesc = ($report->reportDetail && !empty($report->reportDetail->detail_description)) ? $report->reportDetail->detail_description : 'No description available.';
                $description = \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($rawDesc)), 250);

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
            
            return $paginatorData;
        });

        return response()->json($paginator);
    }

    /**
     * Predictive search for site header.
     */
    public function predictiveSearch(Request $request)
    {
        $search = $request->query('query');
        
        if (!$search || strlen(trim($search)) < 2) {
            return response()->json([]);
        }

        $query = ReportList::with(['reportDetail'])
            ->has('reportDetail')
            ->where('status', 'Active');

        // Search on title / name using B-Tree index / LIKE matching
        $query->where(function ($q) use ($search) {
            $q->whereHas('reportDetail', function ($q2) use ($search) {
                  $q2->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$search . '*'])
                     ->orWhere('title', 'like', '%' . $search . '%');
              })
              ->orWhere('name', 'like', '%' . $search . '%');
        });

        // The user specifically requested a limit of 6
        $reports = $query->orderBy('created_at', 'desc')
            ->limit(6)
            ->get()
            ->map(function ($report) {
                return [
                    'id' => $report->id,
                    'title' => ($report->reportDetail && $report->reportDetail->title) ? $report->reportDetail->title : $report->name,
                    'slug_url' => ($report->reportDetail && $report->reportDetail->slug_url) ? $report->reportDetail->slug_url : '#'
                ];
            });

        return response()->json($reports);
    }
    
    public function publicTopSellingReports()
    {
        $version = Cache::get('userview_cache_version', 1);
        $key = 'top_selling_reports_v' . $version;
        
        $reports = Cache::remember($key, 60*60*24, function () {
            return TopSellingReport::with('reportDetail:id,title,slug_url')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        });
            
        return response()->json($reports);
    }



    /**
     * Get all blogs paginated for the public blogs page.
     */
  
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
        return response()->json([
            'message' => 'Report not found'
        ], 404);
    }

    $geographies = [
        'Global',
        'North America',
        'Latin America',
        'Europe',
        'Asia Pacific',
        'APAC',
        'Middle East',
        'Africa',
        'MEA',
          'China',
        'Japan',
        'Germany',
        'France',
        'UK',
        'United States',
        'U.S.A',
        'Canada',
        'Brazil',
        'India'
    ];

    $baseTitle = $reportDetail->title ?: optional($reportDetail->reportList)->name;

    // Use regex with word boundaries to avoid accidentally removing substrings (e.g., 'UK' from 'Ukraine')
    $geoRegex = '/\b(' . implode('|', array_map(function($g) { return preg_quote($g, '/'); }, $geographies)) . ')\b/i';
    
    $baseTitleClean = trim(preg_replace('/\s+/', ' ', preg_replace($geoRegex, '', $baseTitle)));
    $searchPrefix = substr($baseTitleClean, 0, 15); // Extract first 15 chars for DB filtering

    $geographyReportsQuery = \App\Models\ReportDetail::with('reportList:id,name')
        ->select('id', 'title', 'slug_url', 'report_list_id')
        ->where('id', '!=', $reportDetail->id);

    // Add a LIKE filter to the DB query so we don't load the entire table into memory
    if (strlen($searchPrefix) > 5) {
        $geographyReportsQuery->where(function($q) use ($searchPrefix) {
            $q->where('title', 'LIKE', '%' . $searchPrefix . '%')
              ->orWhereHas('reportList', function($q2) use ($searchPrefix) {
                  $q2->where('name', 'LIKE', '%' . $searchPrefix . '%');
              });
        });
    }

    $geographyReports = $geographyReportsQuery
        ->get()
        ->filter(function ($item) use ($geoRegex, $baseTitleClean) {
            $itemTitle = $item->title ?: optional($item->reportList)->name;
            if (!$itemTitle) return false;

            $titleClean = trim(preg_replace('/\s+/', ' ', preg_replace($geoRegex, '', $itemTitle)));
            
            // Relaxed matching: Match if first 12 characters are the same
            return strncasecmp($titleClean, $baseTitleClean, 12) === 0;
        })
        ->values()
        ->map(function ($item) use ($geographies) {
            $itemTitle = $item->title ?: optional($item->reportList)->name;
           
            return [
                'id'       => $item->id,
                'title'    => $itemTitle,
                'geo_name' => $itemTitle,
                'slug_url' => $item->slug_url
            ];
        });
  $relatedReports = [];

    if ($reportDetail->reportList && $reportDetail->reportList->reportCategory) {

        $catId = $reportDetail->reportList->report_category_id;

        $relatedReports = \App\Models\ReportList::with([
                'reportCategory',
                'reportDetail'
            ])
            ->where('report_category_id', $catId)
            ->where('id', '!=', $reportDetail->report_list_id)
            ->where('status', 'Active')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($r) {
                return [
                    'id' => $r->id,
                    'title' => optional($r->reportDetail)->title ?: $r->name,
                    'slug' => optional($r->reportDetail)->slug_url ?: '#'
                ];
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Related Industries
    |--------------------------------------------------------------------------
    */

    $relatedCategories = \App\Models\ReportCategory::where('status', 'Active')
        ->orderBy('created_at', 'desc')
        ->take(8)
        ->pluck('name');

    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    return response()->json([

        'id' => $reportDetail->id,

        'title' => $reportDetail->title ?: optional($reportDetail->reportList)->name,

        'description' => $reportDetail->description,
        
        'detail_description' => !empty($reportDetail->detail_description) ? $reportDetail->detail_description : 'No description available.',

        'table_of_contents' => $reportDetail->table_of_contents,

        'single_user_license_cost' => $reportDetail->single_user_license_cost ?: '',

        'team_user_license_cost' => $reportDetail->team_user_license_cost ?: '',

        'enterprise_user_license_cost' => $reportDetail->enterprise_user_license_cost ?: '',

        'download_text' => $reportDetail->download_text,

        'image' => '/assets/images/default-report.png',

        'slug_url' => $reportDetail->slug_url,

        'breadcrumb_title' => $reportDetail->breadcrumb_title ?: optional($reportDetail->reportList)->name,

        'page_main_title' => $reportDetail->page_main_title ?: $reportDetail->title,

        'report_sku' => $reportDetail->report_sku ?: ('REP-' . str_pad($reportDetail->id, 5, '0', STR_PAD_LEFT)),

        'faqs' => $reportDetail->faqs ?: [],

        'category' => optional(optional($reportDetail->reportList)->reportCategory)->name ?: 'Unknown',

        'date' => $reportDetail->created_at
            ? $reportDetail->created_at->format('F Y')
            : date('F Y'),

        'pages' => 120,

        'format' => 'PDF, Excel',

        'related_reports' => $relatedReports,

        'related_industries' => $relatedCategories,

        // Global Methodology
        'report_methodology' => optional(\App\Models\ReportMethodology::first())->content ?: '',

        // Geography dropdown
        'geography_reports' => $geographyReports,

        // SEO
        'meta_title' => $reportDetail->meta_title,
        'meta_description' => $reportDetail->meta_description,
        'meta_keywords' => $reportDetail->meta_keywords,
        'canonical_tag' => $reportDetail->canonical_tag,
        'meta_robots' => $reportDetail->meta_robots,
        'hreflang_tags' => $reportDetail->hreflang_tags ?: [],
        'open_graph_tags' => $reportDetail->open_graph_tags ?: [],
        'twitter_card_tags' => $reportDetail->twitter_card_tags ?: [],
        'schema_tag' => $reportDetail->schema_tag,
        'schema_tag_2' => $reportDetail->schema_tag_2,
        'custom_schema_tags' => $reportDetail->custom_schema_tags ?: [],

    ]);
}

    /**
     * Get a single category by name.
     */
    public function getCategoryDetail($name)
    {
        $category = \App\Models\ReportCategory::where('slug_url', $name)
            ->where('status', 'Active')
            ->first();

        if (!$category) {
            $category = \App\Models\ReportCategory::where('name', $name)
                ->where('status', 'Active')
                ->first();
        }

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json([
            'id' => $category->id,
            'name' => $category->name,
            'slug_url' => $category->slug_url,
            'main_heading' => $category->main_heading,
            'main_subheading' => $category->main_subheading,
            'category_image' => $category->category_image,
            'category_icon' => $category->category_icon,
        ]);
    }

    

    /**
     * Get all active press releases paginated with search filter.
     */
    public function getAllPressReleases(Request $request)
    {
        $search = $request->query('search');
        $query = PressRelease::where('status', 'Active')->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $pressReleases = $query->paginate(12);

        $pressReleases->getCollection()->transform(function ($pr) {
            return [
                'id' => $pr->id,
                'title' => $pr->title,
                'description' => \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($pr->description)), 150),
                'date' => $pr->created_at->format('F d, Y'),
                'image' => $pr->thumbnail_image ?: ($pr->main_image ?: '/assets/images/default-report.png'),
                'url' => $pr->url,
            ];
        });

        return response()->json($pressReleases);
    }

    /**
     * Store a public contact form submission.
     */
    public function storeContactForm(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:45',
            'country' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'specific_research_requirement' => 'required|string',
            'recaptcha_token' => 'nullable|string',
        ]);

        // Verify ReCAPTCHA with Google API
        $recaptchaSecret = config('services.recaptcha.secret');
        if ($recaptchaSecret && $recaptchaSecret !== 'your_secret_key') {
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $recaptchaSecret,
                'response' => $request->input('recaptcha_token'),
                'remoteip' => $request->ip(),
            ]);

            $recaptchaData = $response->json();

            if (!$recaptchaData['success']) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'message' => 'ReCAPTCHA validation failed. Please try again.',
                        'errors' => ['recaptcha_token' => ['The recaptcha token is invalid or expired.']]
                    ], 422);
                }
                return redirect()->back()->withErrors(['recaptcha_token' => 'The recaptcha token is invalid or expired.'])->withInput();
            }
        }

        $contact = \App\Models\ContactUs::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'country' => $validated['country'],
            'company_name' => $validated['company_name'],
            'specific_research_requirement' => $validated['specific_research_requirement'],
        ]);

        try {
            $data = [
                'siteName'     => 'Markspark Solutions',
                'siteUrl'      => url('/'),
                'inquiryType'  => 'New Inquiry Received on Markspark Solutions',
                'name'         => $validated['full_name'],
                'email'        => $validated['email'],
                'phone'        => $validated['phone'],
                'companyName'  => $validated['company_name'],
                'country'      => $validated['country'],
                'messageText'  => $validated['specific_research_requirement'],
                'reportName'   => '',
                'jobTitle'     => '',
            ];

            \App\Jobs\SendInquiryEmailJob::dispatch($data, 'New Inquiry Received on Markspark Solutions');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail sending failed in storeContactForm: ' . $e->getMessage());
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Your message has been sent successfully!',
                'data' => $contact
            ], 201);
        }
        
        return redirect()->to('/thank-you');
    }

    /**
     * Store a public request form submission.
     */
    public function storeRequestForm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:45',
            'subject' => 'required|string|max:255',
            'specific_research_requirement' => 'required|string',
            'report_name' => 'nullable|string|max:1000',
            'recaptcha_token' => 'nullable|string',
        ]);

        // Verify ReCAPTCHA with Google API
        $recaptchaSecret = config('services.recaptcha.secret');
        if ($recaptchaSecret && $recaptchaSecret !== 'your_secret_key') {
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $recaptchaSecret,
                'response' => $request->input('recaptcha_token'),
                'remoteip' => $request->ip(),
            ]);

            $recaptchaData = $response->json();

            if (!$recaptchaData['success']) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'message' => 'ReCAPTCHA validation failed. Please try again.',
                        'errors' => ['recaptcha_token' => ['The recaptcha token is invalid or expired.']]
                    ], 422);
                }
                return redirect()->back()->withErrors(['recaptcha_token' => 'The recaptcha token is invalid or expired.'])->withInput();
            }
        }

        // We create RequestForm from $validated but remove recaptcha_token to avoid SQL error (not in table)
        $dbData = collect($validated)->except('recaptcha_token')->toArray();
        $requestForm = \App\Models\RequestForm::create($dbData);

        try {
            $subjectVal = $validated['subject'] ?: 'Request Sample';
            $reportNameVal = $validated['report_name'] ?: '';
            
            $inquiryTypeLabel = $subjectVal;
            if ($reportNameVal) {
                $inquiryTypeLabel .= ' - ' . $reportNameVal;
            }

            $data = [
                'siteName'     => 'Markspark Solutions',
                'siteUrl'      => url('/'),
                'inquiryType'  => $inquiryTypeLabel,
                'name'         => $validated['name'],
                'email'        => $validated['email'],
                'phone'        => $validated['phone'],
                'messageText'  => $validated['specific_research_requirement'],
                'reportName'   => $reportNameVal,
            ];

            $mailSubject = $subjectVal;
            if ($reportNameVal) {
                $mailSubject .= ' - ' . $reportNameVal;
            }
            \App\Jobs\SendInquiryEmailJob::dispatch($data, 'New Inquiry Received: ' . $mailSubject);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail sending failed in storeRequestForm: ' . $e->getMessage());
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Request submitted successfully!',
                'data' => $requestForm
            ], 201);
        }

        return redirect()->to('/thank-you')->with('success', 'Request submitted successfully!');
    }

    /**
     * Get a single blog by slug (url).
     */
    public function getBlogDetail($slug)
    {
        $blog = \App\Models\Blog::with('blogDetail')
            ->where('url', $slug)
            ->first();

        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        // Fetch related articles (excluding this one)
        $relatedArticles = \App\Models\Blog::where('id', '!=', $blog->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get()
            ->map(function ($b) {
                return [
                    'id' => $b->id,
                    'title' => $b->title,
                    'description' => \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($b->description)), 80),
                    'url' => $b->url,
                ];
            });

        return response()->json([
            'id' => $blog->id,
            'title' => $blog->title,
            'author_name' => $blog->author_name,
            'image' => $blog->image ?: '/assets/images/default-report.png',
            'date' => $blog->created_at->format('F d, Y'),
            'url' => $blog->url,
            'breadcrumb_title' => $blog->blogDetail?->breadcrumb_title ?: $blog->title,
            'detail' => $blog->blogDetail ? [
                'title'       => $blog->blogDetail->title,
                'description' => $blog->blogDetail->description,
                'faqs'        => $blog->blogDetail->faqs ?: [],
            ] : null,
            'related_articles' => $relatedArticles,

            // ── SEO / Meta fields (from blogDetail) ──────────────────────────
            'meta_title'         => $blog->blogDetail?->meta_title,
            'meta_description'   => $blog->blogDetail?->meta_description,
            'meta_keywords'      => $blog->blogDetail?->meta_keywords,
            'canonical_tag'      => $blog->blogDetail?->canonical_tag,
            'meta_robots'        => $blog->blogDetail?->meta_robots,
            'hreflang_tags'      => $blog->blogDetail?->hreflang_tags      ?: [],
            'open_graph_tags'    => $blog->blogDetail?->open_graph_tags    ?: [],
            'twitter_card_tags'  => $blog->blogDetail?->twitter_card_tags  ?: [],
            'schema_tag'         => $blog->blogDetail?->schema_tag,
            'schema_tag_2'       => $blog->blogDetail?->schema_tag_2,
            'schema_tag_3'       => $blog->blogDetail?->schema_tag_3,
        ]);
    }


    /**
     * Store a blog sample request.
     */
    public function storeBlogRequest(Request $request)
    {
        $validated = $request->validate([
            'blog_id' => 'required|integer|exists:blogs,id',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:45',
            'company_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        $blogRequest = \App\Models\BlogRequest::create($validated);

        try {
            $blog = \App\Models\Blog::find($validated['blog_id']);
            $blogTitle = $blog ? $blog->title : 'Blog ID ' . $validated['blog_id'];

            $data = [
                'siteName'     => 'Markspark Solutions',
                'siteUrl'      => url('/'),
                'inquiryType'  => 'Blog Request - ' . $blogTitle,
                'name'         => $validated['full_name'],
                'email'        => $validated['email'],
                'phone'        => $validated['phone'],
                'companyName'  => $validated['company_name'],
                'country'      => $validated['country'],
                'messageText'  => 'Requested blog/sample for blog ID: ' . $validated['blog_id'],
                'reportName'   => $blogTitle,
                'jobTitle'     => '',
            ];

            \App\Jobs\SendInquiryEmailJob::dispatch($data, 'New Inquiry Received: Blog Request - ' . $blogTitle);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail sending failed in storeBlogRequest: ' . $e->getMessage());
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Your request has been submitted successfully!',
                'data' => $blogRequest
            ], 201);
        }
        return redirect()->to('/thank-you')->with('success', 'Your request has been submitted successfully!');
    }

    /**
     * Get a single press release by slug (url).
     */
    public function getPressReleaseDetail($slug)
    {
        $pr = \App\Models\PressRelease::with('pressReleaseDetail')
            ->where('url', $slug)
            ->first();

        if (!$pr) {
            return response()->json(['message' => 'Press release not found'], 404);
        }

        // Fetch related reports
        $relatedReports = \App\Models\ReportList::with(['reportCategory', 'reportDetail'])
            ->has('reportDetail')
            ->where('status', 'Active')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get()
            ->map(function ($r) {
                return [
                    'id' => $r->id,
                    'title' => ($r->reportDetail && $r->reportDetail->title) ? $r->reportDetail->title : $r->name,
                    'slug' => ($r->reportDetail && $r->reportDetail->slug_url) ? $r->reportDetail->slug_url : '#'
                ];
            });

        return response()->json([
            'id' => $pr->id,
            'title' => $pr->title,
            'image' => $pr->thumbnail_image ?: ($pr->main_image ?: '/assets/images/default-report.png'),
            'date' => $pr->created_at->format('F d, Y'),
            'url' => $pr->url,
            'breadcrumb_title' => $pr->pressReleaseDetail?->breadcrumb_title ?: $pr->title,
            'detail' => $pr->pressReleaseDetail ? [
                'content' => $pr->pressReleaseDetail->content,
            ] : null,
            'related_reports' => $relatedReports,

            // ── SEO / Meta fields (from pressReleaseDetail) ──────────────────
            'meta_title'         => $pr->pressReleaseDetail?->meta_title,
            'meta_description'   => $pr->pressReleaseDetail?->meta_description,
            'meta_keywords'      => $pr->pressReleaseDetail?->meta_keywords,
            'canonical_tag'      => $pr->pressReleaseDetail?->canonical_tag,
            'meta_robots'        => $pr->pressReleaseDetail?->meta_robots,
            'hreflang_tags'      => $pr->pressReleaseDetail?->hreflang_tags      ?: [],
            'open_graph_tags'    => $pr->pressReleaseDetail?->open_graph_tags    ?: [],
            'twitter_card_tags'  => $pr->pressReleaseDetail?->twitter_card_tags  ?: [],
            'schema_tag'         => $pr->pressReleaseDetail?->schema_tag,
            'schema_tag_2'       => $pr->pressReleaseDetail?->schema_tag_2,
        ]);
    }

    /**
     * Store a new newsletter subscription.
     */
    public function storeNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletters,email',
        ], [
            'email.unique' => 'You are already subscribed to our newsletter!',
            'email.email' => 'Please enter a valid email address.'
        ]);

        Newsletter::create([
            'email' => $request->input('email')
        ]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Successfully subscribed to the newsletter!']);
        }
        return redirect()->back()->with('newsletter_success', 'Successfully subscribed to the newsletter!');
    }
}
