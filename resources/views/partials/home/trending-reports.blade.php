<section id="reports" class="reports-section">
  <div class="section-shell">
    <div class="section-heading centered">
      <h2>Top Trending Market Reports</h2>
      <p>Explore our most in-demand reports featuring the latest industry trends, forecasts, and data-driven insights.
      </p>
    </div>

    <div class="category-filter">
      @php $activeCategory = request('category', 'All'); @endphp
      <a href="{{ url('/') }}" class="{{ $activeCategory === 'All' ? 'active' : '' }}"
        style="text-decoration: none;">All</a>
      @foreach($initialCategories as $cat)
        <a href="{{ url('/?category=' . urlencode($cat->name)) }}#reports"
          class="{{ $activeCategory === $cat->name ? 'active' : '' }}" style="text-decoration: none;">{{ $cat->name }}</a>
      @endforeach
    </div>

    <div class="report-list">
      @foreach($trendingReports as $report)
        <article class="report-list-card">
          <div class="report-image-wrap">
            <a
              href="{{ url('/report/' . (!empty($report->slug) && $report->slug !== '#' ? $report->slug : $report->id)) }}">
              <img src="{{ !empty($report->image) ? $report->image : '/assets/images/default-report.png' }}"
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
              <a href="/contact-us" class="secondary-button outlined"
                style="padding: 10px 24px; min-height: auto; line-height: 1.2;">Request Sample</a>
              <a href="/contact-us" class="primary-button small"
                style="padding: 10px 24px; min-height: auto; line-height: 1.2;">Buy Now</a>
            </div>
          </div>
        </article>
      @endforeach
    </div>

    <div class="center-action">
      <a href="/reports" class="primary-button small">
        View All Reports
        <svg viewBox="0 0 512 512" class="small-icon"
          style="fill: currentColor; stroke: none; width: 18px; height: 18px;" aria-hidden="true">
          <path
            d="M165.013,288.946h75.034c6.953,0,12.609,5.656,12.609,12.608v26.424c0,7.065,3.659,9.585,7.082,9.585 c2.106,0,4.451-0.936,6.78-2.702l90.964-69.014c3.416-2.589,5.297-6.087,5.297-9.844c0-3.762-1.881-7.259-5.297-9.849 l-90.964-69.014c-2.329-1.766-4.674-2.702-6.78-2.702c-3.424,0-7.082,2.519-7.082,9.584v26.425c0,6.952-5.656,12.608-12.609,12.608 h-75.034c-8.707,0-15.79,7.085-15.79,15.788v34.313C149.223,281.862,156.305,288.946,165.013,288.946z">
          </path>
          <path
            d="M256,0C114.842,0,0.002,114.84,0.002,256S114.842,512,256,512c141.158,0,255.998-114.84,255.998-256 S397.158,0,256,0z M256,66.785c104.334,0,189.216,84.879,189.216,189.215S360.334,445.215,256,445.215S66.783,360.336,66.783,256 S151.667,66.785,256,66.785z">
          </path>
        </svg>
      </a>
    </div>
  </div>
</section>
<style>
  .hover-primary-title {
    transition: color 0.2s ease-in-out;
  }

  .hover-primary-title:hover {
    color: #0783df;
  }
</style>