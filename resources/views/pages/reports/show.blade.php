@extends('layouts.public')

@section('content')
<div class="report-detail-page">
  <header class="detail-hero-banner">
    <div class="breadcrumb-container"
      style="max-width: 1120px; margin: 0 auto 20px; display: flex; align-items: center; gap: 8px; font-size: 13px; color: #6b7280; flex-wrap: wrap;">
      <a href="/" style="color: #0783df; text-decoration: none; font-weight: 500;">Home</a>
      <span style="color: #9ca3af;">/</span>
      <a href="/reports" style="color: #0783df; text-decoration: none; font-weight: 500;">Reports</a>
      <span style="color: #9ca3af;">/</span>
      @if(optional($report->reportList)->reportCategory)
        <a href="/industry/{{ optional(optional($report->reportList)->reportCategory)->slug_url ?: optional(optional($report->reportList)->reportCategory)->name }}"
          style="color: #0783df; text-decoration: none; font-weight: 500;">{{ optional(optional($report->reportList)->reportCategory)->name }}</a>
        <span style="color: #9ca3af;">/</span>
      @endif
      <span
        style="color: #4b5563; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 1; line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; word-break: break-all;"
        title="{{ $report->title }}">{{ $report->breadcrumb_title ?: optional($report->reportList)->name }}</span>
    </div>

    <div class="detail-hero-shell">
      <div class="book-cover-container">
        <div class="report-book-cover-image-wrapper">
          <img src="{{ env('AWS_URL') }}/assets/images/default-report.png"
            alt="{{ $report->title ?: optional($report->reportList)->name }}" class="report-book-cover-img" />
        </div>
      </div>

      <div class="hero-text-content">
        <h1>{{ $report->title ?: optional($report->reportList)->name }}</h1>
        <p class="hero-description-snippet">
          {{ $report->detail_description }}
        </p>

        <div class="hero-meta-items">
          <span>Report ID:
            <strong>{{ $report->report_sku ?: ('REP-' . str_pad($report->id, 5, '0', STR_PAD_LEFT)) }}</strong></span>
          <span>|</span>
          <span>Format: <strong>PDF, Excel</strong></span>
          <span>|</span>
          <span>Publish Date:
            <strong>{{ $report->created_at ? $report->created_at->format('F Y') : date('F Y') }}</strong></span>
          <span>|</span>
          <span>Pages: <strong>120</strong></span>
        </div>

        <div class="hero-actions-row" style="flex-wrap: wrap; gap: 12px;">
          <a href="javascript:void(0)" onclick="openRequestModal('Request Sample', '{{ addslashes(htmlspecialchars($report->title ?: optional($report->reportList)->name, ENT_QUOTES, 'UTF-8')) }}')" class="secondary-button outlined">Request Sample</a>
          <a href="javascript:void(0)" onclick="openRequestModal('Ask for discount', '{{ addslashes(htmlspecialchars($report->title ?: optional($report->reportList)->name, ENT_QUOTES, 'UTF-8')) }}')" class="secondary-button outlined">Ask for Discount</a>
          <a href="javascript:void(0)" onclick="openRequestModal('Request customized report', '{{ addslashes(htmlspecialchars($report->title ?: optional($report->reportList)->name, ENT_QUOTES, 'UTF-8')) }}')" class="secondary-button outlined">Request Customized Report</a>
          <a href="/checkout/{{ $report->slug_url ?? $report->id ?? optional($report->reportList)->id }}" class="primary-button">Buy Now</a>
        </div>
      </div>
    </div>
  </header>

  <main class="detail-main-layout">
    <!-- Left Main Content Column -->
    <section class="main-content-column">
      <!-- Tabs Nav -->
      <div class="tabs-navigation-wrapper">
        @php($activeTab = in_array(request('tab'), ['toc', 'methodology']) ? request('tab') : 'overview')
        <div class="tabs-btn-group">
          <a href="?tab=overview" class="tab-nav-btn {{ $activeTab === 'overview' ? 'active-tab' : '' }}">Overview</a>
          <a href="?tab=toc" class="tab-nav-btn {{ $activeTab === 'toc' ? 'active-tab' : '' }}">Table of Contents</a>
          <a href="?tab=methodology" class="tab-nav-btn {{ $activeTab === 'methodology' ? 'active-tab' : '' }}">Report
            Methodology</a>
        </div>
        <div class="tabs-right-action">
          <a href="javascript:void(0)" onclick="openRequestModal('Download Free Sample', '{{ addslashes(htmlspecialchars($report->title ?: optional($report->reportList)->name, ENT_QUOTES, 'UTF-8')) }}')" class="download-sample-btn">
            <svg viewBox="0 0 24 24" fill="none" class="icon" style="width:16px; height:16px;" stroke="currentColor"
              stroke-width="1.8" aria-hidden="true" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 21v-7"></path>
              <path d="M4 10V3"></path>
              <path d="M12 21v-9"></path>
              <path d="M12 8V3"></path>
              <path d="M20 21v-5"></path>
              <path d="M20 12V3"></path>
              <path d="M2 14h4"></path>
              <path d="M10 8h4"></path>
              <path d="M18 16h4"></path>
            </svg> Download Sample
          </a>
        </div>
      </div>
      <div class="tab-pane-content">
        @if($activeTab === 'overview')
          <div class="overview-pane">
            <div class="dynamic-report-content">
              {!! !empty($report->description) && trim(strip_tags($report->description)) !== '' ? $report->description : '<p>No description available.</p>' !!}
            </div>
          </div>
        @elseif($activeTab === 'toc')
          <div class="toc-pane">
            <div class="dynamic-report-content table-of-contents-block">
              {!! !empty($report->table_of_contents) && trim(strip_tags($report->table_of_contents)) !== '' ? $report->table_of_contents : '<p>No table of contents available.</p>' !!}
            </div>
          </div>
        @else
          <div class="toc-pane">
            <div class="dynamic-report-content">
              {!! $reportData->report_methodology ?? '<p>No methodology available.</p>' !!}
            </div>
          </div>
        @endif
      </div>

      <!-- FAQ Section -->
      @if(!empty($reportData->faqs) && count($reportData->faqs) > 0)
        <div class="faq-section" style="margin-top: 40px; margin-bottom: 40px;">
          <h1 class="section-title"
            style="color: #0783df; font-size: 30px; font-weight: 800; margin-top: 32px; margin-bottom: 16px; line-height: 1.3;">
            Frequently Asked Questions</h1>
          <div class="faq-accordion-group">
            @foreach($reportData->faqs as $faq)
              <details class="faq-accordion-item">
                <summary class="faq-accordion-header">{{ $faq->question }}</summary>
                <div class="faq-accordion-body"><span>{{ $faq->answer }}</span></div>
              </details>
            @endforeach
          </div>
        </div>
      @endif
    </section>

    <!-- Right Sidebar Column -->
    <aside class="sidebar-content-column">
      <!-- Geography Dropdown -->
      @if(!empty($reportData->geography_reports) && count($reportData->geography_reports) > 0)
        <div class="geography-dropdown-wrapper" style="margin-bottom: 24px;">
          <p>Select another geography:</p>@foreach($reportData->geography_reports as $geo)<a class="industry-tag-pill"
          href="{{ url('/report/' . ($geo->slug_url ?: ($geo->slug ?? $geo->id))) }}">{{ $geo->geo_name ?? ($geo->title ?? '') }}</a>@endforeach
        </div>
      @endif

      <!-- Jump to Section (Dynamic TOC) -->
      <div class="sidebar-white-info-card" id="jump-to-section-card" style="display: none; margin-bottom: 24px;">
        <h4 style="margin-bottom:16px; font-size: 16px; font-weight: 700; color: #111827;">Jump to Section</h4>
        <nav class="jump-links-container" id="jump-links-container"></nav>
      </div>

      <!-- Get This Report Card -->
      <div class="sidebar-get-report-card">
        <h3>Get This Report</h3>
        <div style="display: flex; flex-direction: column; gap: 16px;">
          <a href="/checkout/{{ $report->slug_url ?? $report->id ?? optional($report->reportList)->id }}" class="contact-btn-white buy-now-btn">
            Buy Now
            <span class="btn-circle-arrow">
              <svg class="chevron-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                <polyline points="9 18 15 12 9 6" />
              </svg>
            </span>
          </a>

          <a href="javascript:void(0)" onclick="openRequestModal('Request Sample', '{{ addslashes(htmlspecialchars($report->title ?: optional($report->reportList)->name, ENT_QUOTES, 'UTF-8')) }}')" class="contact-btn-white request-sample-btn">
            Request Sample
            <span class="btn-circle-arrow">
              <svg class="chevron-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                <polyline points="9 18 15 12 9 6" />
              </svg>
            </span>
          </a>

          <hr class="card-divider" />
          <span class="talk-analyst-title">Talk to Analyst</span>
          <a href="tel:+919370941234" class="contact-btn-white call-now-btn">Call Now</a>
        </div>
      </div>

      <!-- Related Industries -->
      @if(!empty($reportData->related_industries) && count($reportData->related_industries) > 0)
        <div class="sidebar-white-info-card">
          <h4>Related Industries</h4>
          <div class="industry-tags-list">
            @foreach($reportData->related_industries as $ind)
              <a href="/industry/{{ preg_replace('/(^-|-+$)/', '', preg_replace('/[^a-z0-9]+/', '-', strtolower($ind))) }}"
                class="industry-tag-pill" style="text-decoration: none;">{{ $ind }}</a>
            @endforeach
          </div>
        </div>
      @endif

      <!-- Related Reports -->
      @if(!empty($reportData->related_reports) && count($reportData->related_reports) > 0)
        <div class="sidebar-white-info-card">
          <h4>Related Reports</h4>
          <div class="related-reports-list">
            @foreach($reportData->related_reports as $rel)
              <div class="related-report-item">
                <h5>{{ $rel->title ?? '' }}</h5>
                <a href="/report/{{ (!empty($rel->slug) && $rel->slug !== '#') ? $rel->slug : $rel->id }}"
                  class="view-link">
                  View Report
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="icon"
                    aria-hidden="true" stroke-linecap="round" stroke-linejoin="round" style="width: 12px; height: 12px;">
                    <path d="m9 18 6-6-6-6"></path>
                  </svg>
                </a>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </aside>
  </main>

  <div style="max-width: 1300px; margin: 0 auto 60px; padding: 0 24px;">
    <div class="analyst-support-card"
      style="background-image: url(/assets/images/background-image/mainreportpage_cta.png); background-size: cover; background-position: center; background-repeat: no-repeat; margin: 0; padding: 100px 40px; border-radius: 24px;">
      <h3 style="font-size: 40px; font-weight: 600; color: #111827;">Small Analyst Support Card</h3>
      <p style="font-size: 16px; color: #4b5563; margin-bottom: 30px;">Need Help Choosing the Right Report</p>
      <a href="/contact-us" class="talk-analyst-btn">
        Talk to Our Analyst
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          style="width:18px;height:18px;margin-left:4px;">
          <circle cx="12" cy="12" r="10" />
          <path d="M12 16l4-4-4-4M8 12h8" />
        </svg>
      </a>
    </div>
  </div>
</div>

<style>
  .jump-links-container {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .jump-link-item {
    display: block;
    padding: 8px 16px;
    color: #6b7280;
    text-decoration: none;
    font-size: 14px;
    border-radius: 20px;
    transition: all 0.2s;
    line-height: 1.4;
  }

  .jump-link-item:hover {
    background-color: #f3f4f6;
    color: #111827;
  }

  .jump-link-item.active {
    background-color: #f3f4f6;
    color: #0783df;
    font-weight: 600;
  }

  .jump-link-item.sub-heading {
    padding-left: 24px;
    font-size: 13px;
  }

  .geography-select {
    width: 100%;
    padding: 12px 20px;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    border: 1px solid #e5e7eb;
    border-radius: 25px;
    background-color: white;
    font-size: 14px;
    color: #4b5563;
    outline: none;
    cursor: pointer;
    appearance: none;
    background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2212%22%20height%3D%228%22%20viewBox%3D%220%200%2012%208%22%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cpath%20d%3D%22M1%201.5L6%206.5L11%201.5%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22/%3E%3C/svg%3E');
    background-repeat: no-repeat;
    background-position: right 16px center;
    background-size: 12px;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    transition: border-color 0.2s;
  }

  .geography-select:focus {
    border-color: #0783df;
  }
</style>
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contentContainers = document.querySelectorAll('.dynamic-report-content');
    const jumpCard = document.getElementById('jump-to-section-card');
    const jumpLinksContainer = document.getElementById('jump-links-container');
    
    if (contentContainers.length === 0 || !jumpCard || !jumpLinksContainer) return;

    // Find all h2, h3 tags in the active content tab
    let headings = [];
    contentContainers.forEach(container => {
        // Only get headings from the visible pane
        if (container.closest('.tab-pane-content')) {
           const headingElements = container.querySelectorAll('h2, h3, h4');
           headings = [...headings, ...headingElements];
        }
    });
    
    if (headings.length === 0) return;

    jumpCard.style.display = 'block';
    
    headings.forEach((heading, index) => {
        // Add ID if it doesn't have one
        if (!heading.id) {
            const text = heading.textContent.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-');
            heading.id = text ? text + '-' + index : 'section-' + index;
        }

        const link = document.createElement('a');
        link.href = '#' + heading.id;
        const tagName = heading.tagName.toLowerCase();
        link.className = 'jump-link-item' + (tagName === 'h3' || tagName === 'h4' ? ' sub-heading' : '');
        link.textContent = heading.textContent;
        
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.getElementById(heading.id);
            if (target) {
                const yOffset = -120; // adjust based on header height
                const y = target.getBoundingClientRect().top + window.pageYOffset + yOffset;
                window.scrollTo({top: y, behavior: 'smooth'});
            }
        });

        jumpLinksContainer.appendChild(link);
    });

    // Intersection Observer for highlighting active link
    const observerOptions = {
        root: null,
        rootMargin: '-120px 0px -40% 0px',
        threshold: 0
    };

    let activeId = null;

    const observer = new IntersectionObserver(entries => {
        let isIntersectingSomething = false;
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                isIntersectingSomething = true;
                activeId = entry.target.id;
            }
        });

        if (isIntersectingSomething) {
           document.querySelectorAll('.jump-link-item').forEach(link => {
              if (link.getAttribute('href') === '#' + activeId) {
                  link.classList.add('active');
              } else {
                  link.classList.remove('active');
              }
           });
        }
    }, observerOptions);

    headings.forEach(heading => observer.observe(heading));
});
</script>
@endsection