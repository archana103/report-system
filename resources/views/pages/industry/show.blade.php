@extends('layouts.public')

@section('content')
  <div class="industry-category-page">
    <!-- Dynamic Category Cover Image Banner -->
    <section class="category-hero-banner"
      style="{{ !empty($categoryInfo->category_image) ? 'background-image: url(' . $categoryInfo->category_image . ');' : '' }}">
      <div class="banner-overlay"></div>
      <div class="banner-content">
        <div class="breadcrumbs">
          <a href="/">Home</a>
          <span class="separator">/</span>
          <span class="current-crumb">{{ $categoryInfo->name ?? $categoryName }}</span>
        </div>
        <h1 class="category-banner-title">{{ $categoryInfo->name ?? $categoryName }}</h1>
      </div>
    </section>

    <!-- Main Content Section -->
    <main class="category-main-content">
      <!-- Category Heading & Description Section -->
      @if(!empty($categoryInfo))
        <section class="category-intro-section">
          <h2 class="category-main-heading">{{ $categoryInfo->main_heading ?? '' }}</h2>
          @if(!empty($categoryInfo->main_subheading))
            <div class="category-subheading-desc">{!! $categoryInfo->main_subheading !!}</div>
          @endif
        </section>
      @endif

      <!-- Two-Column Layout (Sidebar & Reports) -->
      <div class="category-two-column-layout">
        <!-- Left Sidebar: Reports by Industry -->
        <aside class="category-sidebar">
          <div class="sidebar-card">
            <h3 class="sidebar-title">Reports by Industry</h3>
            <nav class="sidebar-nav">
              @foreach($sidebarCategories as $cat)
                <a href="{{ url('/industry/' . (!empty($cat->slug_url) ? $cat->slug_url : $cat->name)) }}"
                  class="sidebar-nav-item {{ (strtolower(!empty($cat->slug_url) ? $cat->slug_url : $cat->name) === strtolower($categoryName) || strtolower($cat->name) === strtolower($categoryName)) ? 'active-sidebar-item' : '' }}">
                  <span class="nav-text">{{ $cat->name }}</span>
                  <span class="chevron-arrow">›</span>
                </a>
              @endforeach
            </nav>
          </div>
        </aside>

        <!-- Right Column: Paginated Reports List -->
        <section class="category-reports-list">
          @if(!empty($initialReports) && count($initialReports) > 0)
            <div class="report-list-vertical">
              @foreach($initialReports as $report)
                @php $report = (object) $report; @endphp
                <article class="report-list-card">
                  <!-- Premium Pure CSS 3D Mockup Book Cover -->
                  <div class="report-image-wrap">
                    <a href="{{ url('/report/' . (!empty($report->slug) && $report->slug !== '#' ? $report->slug : $report->id)) }}"
                      class="cover-link">
                      <img src="{{ env('AWS_URL') }}/assets/images/default-report.png" alt="{{ $report->title ?? '' }}" />
                    </a>
                  </div>

                  <div class="report-details">
                    <a href="{{ url('/report/' . (!empty($report->slug) && $report->slug !== '#' ? $report->slug : $report->id)) }}"
                      class="report-title-link">
                      <h3 class="hover-primary-title">{{ $report->title ?? '' }}</h3>
                    </a>
                    <p class="report-description">{!! $report->description ?? '' !!}</p>

                    <div class="report-metadata">
                      <span>Pages: <strong>{{ !empty($report->pages) ? $report->pages : 120 }}</strong></span>
                      <span class="divider">|</span>
                      <span>Format: <strong>{{ !empty($report->format) ? $report->format : 'PDF, Excel' }}</strong></span>
                      <span class="divider">|</span>
                      <span>Publish Date: <strong>{{ explode('-', $report->date ?? '')[0] }}
                          {{ explode('-', $report->date ?? '')[1] ?? '' }}</strong></span>
                    </div>

                    <div class="report-actions">
                      <a href="javascript:void(0)"
                        onclick="openRequestModal('Request Sample', '{{ addslashes(htmlspecialchars($report->title ?? '', ENT_QUOTES, 'UTF-8')) }}')"
                        class="secondary-button outlined"
                        style="padding: 10px 24px; min-height: auto; line-height: 1.2;">Request Sample</a>
                      <a href="javascript:void(0)"
                        onclick="openRequestModal('Download Sample', '{{ addslashes(htmlspecialchars($report->title ?? '', ENT_QUOTES, 'UTF-8')) }}')"
                        class="secondary-button outlined"
                        style="padding: 10px 24px; min-height: auto; line-height: 1.2;">Download Sample</a>
                      <a href="{{ url('/checkout/' . $report->id) }}" class="primary-button small"
                        style="padding: 10px 24px; min-height: auto; line-height: 1.2;">Buy Now</a>
                    </div>
                  </div>
                </article>
              @endforeach
            </div>
          @else
            <div class="no-results">
              No reports found for this industry category currently.
            </div>
          @endif

          <!-- Pagination -->
          @if($initialTotalPages > 1)
            <div class="pagination-wrapper" style="display: flex;">
              @if(request()->query('page', 1) > 1)
                <a href="?page={{ request()->query('page', 1) - 1 }}" class="nav-btn prev-btn" style="text-decoration: none;">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="nav-icon" style="width:16px">
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
                  <a href="?page={{ $i }}" class="num-btn {{ $i == $currentPage ? 'active' : '' }}"
                    style="text-decoration: none; display: flex; align-items: center; justify-content: center;">{{ $i }}</a>
                @endfor
              </div>
              @if(request()->query('page', 1) < $initialTotalPages)
                <a href="?page={{ request()->query('page', 1) + 1 }}" class="nav-btn next-btn" style="text-decoration: none;">
                  Next
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="nav-icon" style="width:16px">
                    <path d="m9 18 6-6-6-6"></path>
                  </svg>
                </a>
              @endif
            </div>
          @endif

        </section>
      </div>
    </main>

    <!-- Custom Analyst Research CTA Component -->
    <section class="custom-research-cta section-shell">
      <div class="cta-inner"
        style="background-image: url('{{ env('AWS_URL') }}/assets/images/background-image/reportpage_cta.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="cta-content">
          <h2>Looking for Custom<br>Market Research?</h2>
          <p>Connect with our analysts for tailored research to answer your specific strategic questions and overcome
            challenges.</p>
          <a href="/contact-us" class="primary-button cta-btn">
            Request Research
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="icon" aria-hidden="true"
              style="width:16px">
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
    .industry-category-page {
      color: #171717;
      background: #ffffff;
      font-family: "Inter", "Instrument Sans", "Segoe UI", sans-serif;
      min-height: 100vh;
    }

    /* Cover Image Hero Banner styling */
    .category-hero-banner {
      position: relative;
      height: 280px;
      background-color: #074d9c;
      /* fallback color */
      background-size: cover;
      background-position: center;
      display: flex;
      align-items: center;
      padding: 0 48px;
      overflow: hidden;
      box-shadow: inset 0 -4px 10px rgba(0, 0, 0, 0.05);
    }

    /* Beautiful dark blur overlay for premium contrast and readability */
    .banner-overlay {
      position: absolute;
      inset: 0;
      background: rgba(15, 23, 42, 0.65);
      backdrop-filter: blur(1px);
      z-index: 1;
    }

    .banner-content {
      position: relative;
      z-index: 2;
      color: #ffffff;
      max-width: 1060px;
      width: 100%;
      margin: 0 auto;
    }

    .breadcrumbs {
      font-size: 13px;
      font-weight: 500;
      color: rgba(255, 255, 255, 0.8);
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .breadcrumbs a {
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .breadcrumbs a:hover {
      color: #ffffff;
    }

    .separator {
      opacity: 0.6;
    }

    .current-crumb {
      color: #ffffff;
      font-weight: 700;
      text-transform: capitalize;
    }

    .category-banner-title {
      font-size: 38px;
      font-weight: 800;
      margin: 0;
      text-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
      text-transform: capitalize;
    }

    /* Main Container Section */
    .category-main-content {
      max-width: 1300px;
      margin: 0 auto;
      padding: 56px 24px 80px;
    }

    /* Category Intro Section */
    .category-intro-section {
      margin-bottom: 48px;
    }

    .category-main-heading {
      font-size: 28px;
      font-weight: 800;
      color: #0d2847;
      margin: 0 0 18px;
      text-align: center;
      text-transform: capitalize;
    }

    .category-subheading-desc {
      font-size: 15.5px;
      line-height: 1.68;
      color: #4b5361;
      text-align: center;
      margin: 0 auto;
    }

    .category-subheading-desc p {
      margin: 0 0 14px;
      color: inherit;
      font-size: inherit;
      line-height: inherit;
      text-align: inherit;
    }

    /* Two Column Layout */
    .category-two-column-layout {
      display: grid;
      grid-template-columns: 280px 1fr;
      gap: 36px;
      align-items: start;
    }

    /* Sidebar Styling: Reports by Industry */
    .category-sidebar {
      position: sticky;
      top: 24px;
    }

    .sidebar-card {
      background: #ffffff;
      border: 1px solid #eef2f7;
      border-radius: 16px;
      padding: 24px 20px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.02);
    }

    .sidebar-title {
      font-size: 16px;
      font-weight: 800;
      color: #111827;
      margin: 0 0 20px;
      padding-bottom: 10px;
      border-bottom: 1.5px solid #f3f4f6;
      text-align: left;
    }

    .sidebar-nav {
      display: flex;
      flex-direction: column;
      gap: 1px;
    }

    .sidebar-nav-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 14px;
      font-size: 14px;
      font-weight: 500;
      color: #4b5563;
      transition: all 0.2s ease-in-out;
      text-transform: capitalize;
      text-decoration: none;
    }

    .sidebar-nav-item:hover {
      background: #f4f9ff;
      color: #0783df;
      padding-left: 18px;
      /* micro shift */
    }

    /* Highlighted active state */
    .active-sidebar-item {
      color: #0783df !important;
      font-weight: 700;
      box-shadow: inset 3px 0 0 #0783df;
    }

    .chevron-arrow {
      font-size: 18px;
      font-weight: 300;
      line-height: 1;
      opacity: 0.6;
    }

    .active-sidebar-item .chevron-arrow {
      opacity: 1;
      transform: translateX(2px);
    }

    /* Reports Section Right Column */
    .category-reports-list {
      display: flex;
      flex-direction: column;
      gap: 28px;
    }

    .report-list-vertical {
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    .report-list-card {
      display: flex;
      background: #fafafa;
      border-radius: 18px;
      padding: 10px;
      gap: 28px;
      box-shadow: 0 4px 20px #0f172a05;
      border: 1px solid #eef2f7;
      align-items: center;
    }

    .report-image-wrap {
      width: 140px !important;
      height: 180px !important;
      flex-shrink: 0 !important;
    }

    .cover-link {
      display: block;
      width: 100%;
      height: 100%;
      text-decoration: none;
    }

    .report-image-wrap img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    .report-details {
      flex: 1;
    }

    .report-title-link {
      text-decoration: none;
      color: #111827;
    }

    .hover-primary-title {
      font-size: 15px;
      font-weight: 500;
      line-height: 1.4;
      margin: 0 0 10px;
      transition: color 0.2s ease-in-out;
    }

    .hover-primary-title:hover {
      color: #0783df;
    }

    .report-description {
      color: #4f535b;
      font-size: 14.5px;
      line-height: 1.55;
      margin: 0 0 16px;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .report-metadata {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 13.5px;
      color: #6b7280;
      margin-bottom: 20px;
      text-transform: capitalize;
    }

    .report-metadata strong {
      color: #111827;
    }

    .divider {
      color: #d1d5db;
    }

    .report-actions {
      display: flex;
      gap: 14px;
    }

    .secondary-button.outlined {
      background: transparent;
      border: 1px solid #0783df;
      color: #0783df;
      padding: 8px 12px;
      border-radius: 30px;
      font-weight: 600;
      text-decoration: none;
      font-size: 13.5px;
      transition: all 0.2s;
      display: inline-flex;
      align-items: center;
    }

    .secondary-button.outlined:hover {
      background: #f4f9ff;
    }

    .primary-button.small {
      background: #0783df;
      border: 1px solid #0783df;
      color: #ffffff;
      padding: 8px 20px;
      border-radius: 30px;
      font-weight: 600;
      text-decoration: none;
      font-size: 13.5px;
      transition: background 0.2s;
    }

    .primary-button.small:hover {
      background: #066ebb;
    }

    .no-results {
      text-align: center;
      padding: 48px;
      color: #6b7280;
      font-size: 15px;
      border: 1px dashed #e5e7eb;
      border-radius: 12px;
      background: #fcfcfc;
    }

    /* Pagination controls */
    .pagination-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 16px;
      margin: 40px 0 10px;
    }

    .page-numbers {
      display: flex;
      gap: 8px;
      align-items: center;
    }

    .nav-btn {
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 8px 18px;
      border-radius: 30px;
      font-weight: 600;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.2s;
    }

    .prev-btn {
      background: #ffffff;
      border: 1px solid #e1e9f0;
      color: #8fa0b3;
    }

    .prev-btn:not(:disabled):hover {
      background: #f8fbff;
      color: #0783df;
      border-color: #0783df;
    }

    .next-btn {
      background: #0783df;
      border: 1px solid #0783df;
      color: #ffffff;
    }

    .next-btn:not(:disabled):hover {
      background: #066ebb;
    }

    .num-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      border: none;
      background: transparent;
      color: #4b5563;
      font-weight: 600;
      font-size: 14px;
      cursor: pointer;
      display: grid;
      place-items: center;
      transition: all 0.2s;
    }

    .num-btn:hover {
      background: #f0f6fc;
      color: #0783df;
    }

    .num-btn.active {
      background: #0783df;
      color: #ffffff;
    }

    @media (max-width: 860px) {
      .category-two-column-layout {
        grid-template-columns: 1fr;
        gap: 30px;
      }

      .category-sidebar {
        position: static;
      }

      .report-list-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
      }

      .report-image-wrap {
        align-self: center;
      }
    }
  </style>
@endsection