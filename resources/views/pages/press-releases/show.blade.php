@extends('layouts.public')

@section('content')
<div class="press-detail-page">
    <main class="press-detail-main">
      <div class="section-shell">
        <div class="press-detail-content">
          <!-- Breadcrumbs -->
          <div class="press-breadcrumbs" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; font-size: 14px; margin-bottom: 24px; color: #6b7280;">
            <a href="/" style="color: #0783df; text-decoration: none;">Home</a>
            <span>/</span>
            <a href="/press-releases" style="color: #0783df; text-decoration: none;">Press Release</a>
            <span>/</span>
            <span style="display: -webkit-box; -webkit-line-clamp: 1; line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; word-break: break-all; color: #4b5563;" title="{{ $pressRelease->title }}">{{ $pressRelease->breadcrumb_title ?? $pressRelease->title }}</span>
          </div>

          <!-- Main Layout Grid -->
          <div class="press-detail-layout">
            <!-- Left Column Content -->
            <article class="press-post-content">
              <div class="press-pub-date">Published: {{ $pressRelease->date ?? ($pressRelease->created_at ? \Carbon\Carbon::parse($pressRelease->created_at)->format('Y-m-d') : '') }}</div>
              <h1 class="press-post-title">{{ $pressRelease->title }}</h1>
              
              <div class="press-main-image-wrapper">
                <img src="{{ !empty($pressRelease->image) ? $pressRelease->image : env('AWS_URL') . '/assets/images/default-report.png' }}" alt="{{ $pressRelease->title }}" class="press-main-image" />
              </div>

              <!-- Main Rich Text Body -->
              <div class="press-body-text">
                  {!! optional($pressRelease->detail)->content ?? '<p>No content details available.</p>' !!}
              </div>
            </article>

            <!-- Right Column Sidebar -->
            <aside class="press-sidebar">
              <!-- CTA Widget -->
              <div class="sidebar-widget widget-cta">
                <h3>Need Industry-Specific Insights?</h3>
                <p>Explore our latest research reports and market intelligence solutions.</p>
                <a href="/reports" class="widget-cta-btn" style="text-decoration: none;">
                  Explore Reports
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
              </div>

              <!-- Related Reports Widget -->
              @if(!empty($pressRelease->related_reports) && count($pressRelease->related_reports) > 0)
              <div class="sidebar-widget widget-related">
                <h3>Related Reports</h3>
                <div class="related-reports-list">
                  @foreach($pressRelease->related_reports as $item)
                  <div class="related-report-item">
                    <h4>{{ is_array($item) ? $item['title'] : $item->title }}</h4>
                    <a href="{{ url('/report/' . ($item->slug ?? (is_array($item) ? $item['slug'] : ''))) }}" class="related-report-link" style="text-decoration: none;">
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
