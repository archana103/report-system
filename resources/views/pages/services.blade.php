@extends('layouts.public')

@section('content')
<div class="services-page">
    <main class="services-main">
      <section class="services-hero" style="background-image: url('https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/background-image/servicepage_banner.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="services-hero-content section-shell">
          <h1>
            Purpose-Built <span class="highlight">Research</span><br />
            for Better Market Decisions
          </h1>
          <p>
            From custom studies and brand tracking to evidence-led consulting, our services help teams turn complex market questions into confident commercial action.
          </p>
          <div class="services-hero-cta">
            <a href="/reports" class="primary-button" style="text-decoration: none;">Explore Reports</a>
            <a href="/contact-us" class="secondary-button" style="text-decoration: none;">Talk to an Analyst</a>
          </div>
        </div>
      </section>

      <section class="services-overview section-shell">
        <div class="services-section-header centered">
          <h2>Proven Research Capability</h2>
          <p>Our operating model is built around speed, rigor, and measurable impact.</p>
        </div>

        <div class="services-metrics-grid">
          <div class="main-image-container">
            <img src="/assets/images/performance_metrics.gif" alt="Services performance metrics chart" class="main-charts-image" />
          </div>
        </div>
      </section>

      <section class="services-detail-section section-shell">
        <div class="services-section-header centered">
          <h2>How Each Service Creates Value</h2>
          <p>Clear scope, senior ownership, and deliverables built for executive decisions.</p>
        </div>

        <div class="service-detail-row">
          <div class="service-detail-info">
            <div class="service-header-inline">
              <div class="service-number-circle">1</div>
              <h3>Custom Research Solutions</h3>
            </div>
            <div class="service-feature-list">
              <div class="service-feature-item">
                <h4>Tailored to Your Questions</h4>
                <p>Custom built research designed around your strategic and market challenges, covering consumer
                  behaviour, market sizing, competitive mapping, and concept testing.</p>
              </div>
              <div class="service-feature-item">
                <h4>Blended Methods, Senior Led</h4>
              </div>
              <div class="service-feature-item">
                <h4>Decision Ready Insights</h4>
              </div>
            </div>
          </div>
          <div class="service-proof-card">
            <h3>Best for</h3>
            <p>Market entry, category validation, audience understanding, opportunity sizing, and competitor mapping.</p>
            <div class="proof-stats-row">
              <div class="proof-stat">
                <strong>400+</strong>
                <span>Custom Studies Delivered</span>
              </div>
              <div class="proof-stat">
                <strong>3-6 Wks</strong>
                <span>Average Turnaround</span>
              </div>
            </div>
          </div>
        </div>

        <div class="service-detail-row reverse">
          <div class="service-detail-info">
            <div class="service-header-inline">
              <div class="service-number-circle">2</div>
              <h3>Brand Track Reports</h3>
            </div>
            <div class="service-feature-list">
              <div class="service-feature-item">
                <h4>Continuous Pulse on Brand Health</h4>
                <p>Track the metrics that matter most awareness, consideration, preference, purchase intent, usage, and
                  brand imagery with regular monthly, quarterly, or bi annual fieldwork.</p>
              </div>
              <div class="service-feature-item">
                <h4>Reliable Data, Strategic Narrative</h4>
              </div>
              <div class="service-feature-item">
                <h4>Confident, Evidence Based Decisions</h4>
              </div>
            </div>
          </div>
          <div class="service-proof-card">
            <h3>Best for</h3>
            <p>Brand health monitoring, campaign tracking, competitive comparison, and early-warning performance signals.</p>
            <div class="proof-stats-row">
              <div class="proof-stat">
                <strong>+30%</strong>
                <span>Decision Confidence Lift</span>
              </div>
              <div class="proof-stat">
                <strong>Real-Time</strong>
                <span>Health risk alerts</span>
              </div>
            </div>
          </div>
        </div>

        <div class="service-detail-row">
          <div class="service-detail-info">
            <div class="service-header-inline">
              <div class="service-number-circle">3</div>
              <h3>Consulting Services</h3>
            </div>
            <div class="service-feature-list">
              <div class="service-feature-item">
                <h4>From Insights to Action</h4>
                <p>We bridge the gap between research and strategy across market entry, portfolio and segmentation,
                  brand positioning, and customer experience, with flexible engagements from two week sprints to long
                  term advisory.</p>
              </div>
              <div class="service-feature-item">
                <h4>Embedded Thinking Partners</h4>
              </div>
              <div class="service-feature-item">
                <h4>Evidence Led, Impact Driven</h4>
              </div>
            </div>
          </div>
          <div class="service-proof-card">
            <h3>Best for</h3>
            <p>Strategic planning, go-to-market decisions, segmentation, positioning, and board-level recommendations.</p>
            <div class="proof-stats-row">
              <div class="proof-stat">
                <strong>82%</strong>
                <span>Transformative Impact</span>
              </div>
              <div class="proof-stat">
                <strong>Real-Time</strong>
                <span>Strategic Decisions</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Latest Insights -->
      <section class="content-row-section insights-section">
        <div>
            <div class="section-heading row-heading">
              <div>
                <h2>Latest Insights</h2>
                <p>Explore expert perspectives, industry trends, and data-driven stories shaping global markets.</p>
              </div>
              <div class="slider-controls">
                <button aria-label="Previous" onclick="document.getElementById('services-insights-grid').scrollBy({left: -350, behavior: 'smooth'})">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"></path></svg>
                </button>
                <button class="active" aria-label="Next" onclick="document.getElementById('services-insights-grid').scrollBy({left: 350, behavior: 'smooth'})">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"></path></svg>
                </button>
              </div>
            </div>
            <div class="insight-strip" id="services-insights-grid" style="display: flex; overflow-x: auto; scroll-snap-type: x mandatory; scrollbar-width: none;">
              @foreach($latestInsights as $item)
                  <article class="insight-card" style="scroll-snap-align: start; flex: 0 0 calc(33.33% - 15px); min-width: 280px; margin-right: 20px;">
                    <a href="{{ url('/blog/' . ($item->url ?? '')) }}" style="color: inherit; text-decoration: none;">
                        <img src="{{ $item->image ?? '/assets/images/default-report.png' }}" alt="{{ $item->title ?? '' }}" />
                        <h3>{{ $item->title ?? '' }}</h3>
                        <p>{{ $item->description ?? '' }}</p>
                    </a>
                  </article>
              @endforeach
            </div>
            <div class="center-action">
              <a href="/blogs" class="primary-button small" style="text-decoration: none;">Read More 
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 16l4-4-4-4M8 12h8"></path></svg>
              </a>
            </div>
        </div>
      </section>

      <section class="services-bottom-cta section-shell">
        <div class="custom-cta-card">
          <div class="cta-left">
            <h3>Ready to<br />Commission a<br />Custom Study?</h3>
            <p>Speak to one of our lead analysts to structure a research proposal matched to your objectives.</p>
            <a href="/contact-us" class="cta-button-blue" style="text-decoration: none;">
              Get in Touch <span class="arrow-circle">→</span>
            </a>
          </div>
          <div class="cta-right">
            <div class="pill-box">
              @foreach([
                  'Bespoke Methodologies',
                  'Regular Tracking Wave Reports',
                  'Evidence-led Advisory',
                  'Fast 3-6 Week Completion',
                  'Dedicated Senior Leads'
              ] as $item)
              <div class="cta-pill">{{ $item }}</div>
              @endforeach
            </div>
          </div>
        </div>
      </section>
    </main>
</div>
@endsection
