@extends('layouts.public')

@section('content')
  <div class="reports-page">

    <section class="reports-hero">
      <div class="reports-hero-content">
        <h1>Explore Market<br>Research Reports</h1>
        <p>Access in-depth analysis, market trends, and growth forecasts to stay ahead of the curve.</p>
      </div>
    </section>

    <section class="reports-content section-shell reports-two-column-layout">
      <div class="reports-main-column">
        <div class="report-list-vertical">
          @foreach($initialReports as $report)
            <article class="report-list-card">
              <div class="report-image-wrap">
                <a
                  href="{{ url('/report/' . (!empty($report->slug) && $report->slug !== '#' ? $report->slug : $report->id)) }}">
                  <img src="{{ !empty($report->image) ? $report->image : env('AWS_URL') . '/assets/images/default-report.png' }}"
                    alt="{{ $report->title ?? '' }}" />
                </a>
              </div>
              <div class="report-details">
                <a href="{{ url('/report/' . (!empty($report->slug) && $report->slug !== '#' ? $report->slug : $report->id)) }}"
                  style="color: inherit; text-decoration: none;">
                  <h3 class="hover-primary-title">{{ $report->title ?? '' }}</h3>
                </a>
                <p>{!! $report->description ?? '' !!}</p>
                <div class="report-metadata">
                  <span>Pages: <strong>{{ !empty($report->pages) ? $report->pages : 120 }}</strong></span>
                  <span class="divider">|</span>
                  <span>Format: <strong>{{ !empty($report->format) ? $report->format : 'PDF, Excel' }}</strong></span>
                  <span class="divider">|</span>
                  <span>Publish Date: <strong>{{ $report->date ?? now()->format('M-Y') }}</strong></span>
                </div>
                <div class="report-actions">
                  <a href="{{ url('/report/' . (!empty($report->slug) && $report->slug !== '#' ? $report->slug : $report->id) . '?tab=overview') }}"
                    class="secondary-button outlined" style="padding: 10px 24px; min-height: auto; line-height: 1.2;">View
                    Details</a>
                  <a href="javascript:void(0)" onclick="openRequestModal('Request Sample', '{{ addslashes(htmlspecialchars($report->title ?? '', ENT_QUOTES, 'UTF-8')) }}')" class="secondary-button outlined"
                    style="padding: 10px 24px; min-height: auto; line-height: 1.2;">Request Sample</a>
                  <a href="/contact-us" class="primary-button small"
                    style="padding: 10px 24px; min-height: auto; line-height: 1.2;">Buy Now</a>
                </div>
              </div>
            </article>
          @endforeach

          @if(empty($initialReports) || count($initialReports) == 0)
            <div class="no-results">
              No reports found for your search criteria.
            </div>
          @endif
        </div>

        <!-- Pagination -->
        @if($initialTotalPages > 1)
          <div class="pagination-wrapper" style="display: flex;">
            @if(request()->query('page', 1) > 1)
              <a href="?page={{ request()->query('page', 1) - 1 }}{{ request()->query('q') ? '&q=' . request()->query('q') : '' }}{{ request()->query('category', 'All') !== 'All' ? '&category=' . request()->query('category', 'All') : '' }}"
                class="nav-btn prev-btn" style="text-decoration: none;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" class="nav-icon">
                  <path d="m15 18-6-6 6-6"></path>
                </svg>
                Previous
              </a>
            @endif
            <div class="page-numbers">
              @php
                $currentPage = request()->query('page', 1);
                $start = max(1, $currentPage - 2);
                $end = min($initialTotalPages, $start + 4);
                $start = max(1, $end - 4);
              @endphp
              @for ($i = $start; $i <= $end; $i++)
                <a href="?page={{ $i }}{{ request()->query('q') ? '&q=' . request()->query('q') : '' }}{{ request()->query('category', 'All') !== 'All' ? '&category=' . request()->query('category', 'All') : '' }}"
                  class="num-btn {{ $i == $currentPage ? 'active' : '' }}"
                  style="text-decoration: none; display: flex; align-items: center; justify-content: center;">{{ $i }}</a>
              @endfor
            </div>
            @if(request()->query('page', 1) < $initialTotalPages)
              <a href="?page={{ request()->query('page', 1) + 1 }}{{ request()->query('q') ? '&q=' . request()->query('q') : '' }}{{ request()->query('category', 'All') !== 'All' ? '&category=' . request()->query('category', 'All') : '' }}"
                class="nav-btn next-btn" style="text-decoration: none;">
                Next
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" class="nav-icon">
                  <path d="m9 18 6-6-6-6"></path>
                </svg>
              </a>
            @endif
          </div>
        @endif
      </div>

      <aside class="reports-sidebar-column">
        <!-- Filter Bar -->
        <form method="GET" action="{{ url('/reports') }}" class="filter-bar sidebar-search-widget">
          <div class="search-input-group">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search Report by Title or Keyword" />
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="icon input-icon"
              aria-hidden="true">
              <circle cx="11" cy="11" r="8"></circle>
              <path d="m21 21-4.3-4.3" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </div>

          <div class="category-select-group">
            <select name="category">
              <option value="All" {{ request('category', 'All') === 'All' ? 'selected' : '' }}>All</option>
              @foreach($initialCategories as $cat)
                <option value="{{ $cat->name }}" {{ request('category') === $cat->name ? 'selected' : '' }}>{{ $cat->name }}
                </option>
              @endforeach
            </select>
          </div>

          <button type="submit" class="primary-button">Find Report</button>
        </form>

        <!-- Top Selling -->
        <div class="top-seller-widget"
          style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); border: 1px solid #e5e7eb; margin-top: 24px;">
          <h3 class="widget-title" style="font-size: 1.125rem; font-weight: 800; color: #111827;    border-bottom: 1px solid #e5e7eb;
      margin: 0 0 16px;
      padding-bottom: 12px;">Top Seller Reports</h3>

          <div class="widget-reports-list" style="display: flex; flex-direction: column; gap: 24px;">
            @foreach($initialTopSellers as $item)
              <div class="widget-report-item" style="display: flex; flex-direction: column; gap: 8px;">
                <a href="{{ url('/report/' . (!empty($item->report_detail->slug_url) && $item->report_detail->slug_url !== '#' ? $item->report_detail->slug_url : $item->id)) }}"
                  style="text-decoration: none; color: inherit;">
                  <p class="report-title"
                    style="font-size: 14px; font-weight: 500; color: #4b5563; margin: 0; line-height: 1.5;"
                    title="{{ $item->report_detail->title ?? '' }}">{{ $item->report_detail->title ?? '' }}</p>
                </a>
                <a href="{{ url('/report/' . (!empty($item->report_detail->slug_url) && $item->report_detail->slug_url !== '#' ? $item->report_detail->slug_url : $item->id)) }}"
                  class="buy-now-link hover-primary-title"
                  style="font-size: 13px; font-weight: 600; color: #0783df; display: inline-flex; align-items: center; gap: 4px; text-decoration: none;">
                  Buy Now
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="icon"
                    aria-hidden="true" style="width: 12px; height: 12px;">
                    <path d="m9 18 6-6-6-6" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                </a>
              </div>
            @endforeach
          </div>
        </div>
      </aside>
    </section>

    <!-- Custom Research CTA -->
    <section class="custom-research-cta section-shell">
      <div class="cta-inner"
        style="background-image: url('{{ env('AWS_URL') }}/assets/images/background-image/reportpage_cta.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="cta-content">
          <h2>Looking for Custom<br>Market Research?</h2>
          <p>Connect with our analysts for tailored research to answer your specific strategic questions and overcome
            challenges.</p>
          <a href="/contact-us" class="primary-button cta-btn">
            Request Research
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="icon" aria-hidden="true">
              <circle cx="12" cy="12" r="10"></circle>
              <path d="M12 16v-4" stroke-linecap="round" stroke-linejoin="round"></path>
              <path d="M12 8h.01" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </a>
        </div>
      </div>
    </section>

  </div>

  <style>
    .hover-primary-title {
      transition: color 0.2s ease-in-out;
    }

    .hover-primary-title:hover {
      color: #0783df;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }
  </style>
@endsection