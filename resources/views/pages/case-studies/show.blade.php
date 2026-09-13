@extends('layouts.public')

@section('content')
<div class="press-detail-page">
    <main class="press-detail-main">
      <div class="section-shell">
        <div class="press-detail-content">
          <div class="press-breadcrumbs" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; font-size: 14px; margin-bottom: 24px; color: #6b7280;">
            <a href="/" style="color: #0783df; text-decoration: none;">Home</a>
            <span>/</span>
            <a href="/case-studies" style="color: #0783df; text-decoration: none;">Case Study</a>
            <span>/</span>
            <span style="display: -webkit-box; -webkit-line-clamp: 1; line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; word-break: break-all; color: #4b5563;" title="{{ $caseStudy->title }}">{{ $caseStudy->breadcrumb_title ?? $caseStudy->title }}</span>
          </div>

          <!-- Main Layout Grid -->
          <div class="press-detail-layout">
            <!-- Left Column Content -->
            <article class="press-post-content">
              <div class="press-pub-date">Published: {{ $caseStudy->date ?? ($caseStudy->created_at ? \Carbon\Carbon::parse($caseStudy->created_at)->format('Y-m-d') : '') }}</div>
              <h1 class="press-post-title">{{ $caseStudy->title }}</h1>
              
              <div class="press-main-image-wrapper">
                <img src="{{ !empty($caseStudy->image) ? $caseStudy->image : env('AWS_URL') . '/assets/images/default-report.png' }}" alt="{{ $caseStudy->title }}" class="press-main-image" />
              </div>

              <!-- Main Rich Text Body -->
              <div class="press-body-text">
                  {!! optional($caseStudy->detail)->content ?? '<p>No content details available.</p>' !!}
              </div>
            </article>

            <!-- Right Column Sidebar -->
            <aside class="press-sidebar">
              <!-- CTA Widget -->
              <div class="sidebar-widget widget-cta" style="background-color: #0066FF; border-radius: 16px; padding: 32px 24px; text-align: center; color: white; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgba(0, 102, 255, 0.1), 0 2px 4px -1px rgba(0, 102, 255, 0.06);">
                <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 12px; line-height: 1.3; font-family: 'Inter', sans-serif;">Need Insights for<br>Your Business?</h3>
                <p style="font-size: 14px; line-height: 1.5; margin-bottom: 24px; opacity: 0.9; max-width: 240px;">Get customized market research tailored to your industry, market, and business objectives.</p>
                <a href="/reports" style="display: flex; align-items: center; justify-content: center; gap: 8px; background: white; color: #0066FF; border-radius: 30px; font-size: 14px; font-weight: 600; padding: 12px 24px; text-decoration: none; width: 100%; max-width: 260px; transition: transform 0.2s ease;">
                  Explore Reports
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 16l4-4-4-4"></path>
                    <path d="M8 12h8"></path>
                  </svg>
                </a>
              </div>

              <!-- Related Reports Widget -->
              @if(!empty($caseStudy->related_reports) && count((array)$caseStudy->related_reports) > 0)
              <div class="sidebar-widget widget-related">
                <h3>Related Reports</h3>
                <div class="related-reports-list">
                  @foreach($caseStudy->related_reports as $item)
                  <div class="related-report-item">
                    <h4>{{ is_array($item) ? $item['title'] : $item->title }}</h4>
                    <a href="{{ url('/reports/' . ($item->slug ?? (is_array($item) ? $item['slug'] : ''))) }}" class="related-report-link" style="text-decoration: none;">
                      View Report
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="small-icon"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                  </div>
                  @endforeach
                </div>
              </div>
              @endif
            </aside>
          </div>
        </div>
      </div>
    </main>
</div>
@endsection
