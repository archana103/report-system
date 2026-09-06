<section class="hero-section" style="background: url('{{ asset('assets/images/hero-bg-screenshot.png') }}') no-repeat center center; background-size: cover;">
  <img src="{{ env('AWS_URL') }}/assets/images/hero-cards/card5.png" alt="Monthly Market Insights"
    class="hero-img-card hero-card-left-top" />
  <img src="{{ env('AWS_URL') }}/assets/images/hero-cards/card3.png" alt="Global Market Revenue"
    class="hero-img-card hero-card-left-bottom" />
  <img src="{{ env('AWS_URL') }}/assets/images/hero-cards/card4.png" alt="Market Growth Rate" class="hero-img-card hero-card-right-top" />
  <img src="{{ env('AWS_URL') }}/assets/images/hero-cards/card2.png" alt="Increase in Demand" class="hero-img-card hero-card-right-mid" />
  <img src="{{ env('AWS_URL') }}/assets/images/hero-cards/card1.png" alt="Market Activity Trends"
    class="hero-img-card hero-card-right-bottom" />

  <div class="hero-content">
    <h1>Data-Driven <span>Insights</span> for <span>Smarter Business</span> Decisions</h1>
    <p>Access in-depth market research reports, industry analysis, and future forecasts to stay ahead of the
      competition.</p>
    <div class="hero-buttons">
      <a href="/reports" class="primary-button">Explore Reports</a>
      <a href="/press-releases" class="secondary-button">Press Release</a>
    </div>
    <div class="feature-pills">
      <span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="icon" aria-hidden="true"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 19V5"></path>
          <path d="M8 17v-5"></path>
          <path d="M12 17V8"></path>
          <path d="M16 17v-7"></path>
          <path d="M20 17v-3"></path>
        </svg>
        Data-Backed Insights
      </span>
      <span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="icon" aria-hidden="true"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"></path>
          <path d="M9.5 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8"></path>
          <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
          <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
        </svg>
        Expert Analysts
      </span>
      <span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="icon" aria-hidden="true"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 21v-7"></path>
          <path d="M4 10V3"></path>
          <path d="M12 21v-9"></path>
          <path d="M12 8V3"></path>
          <path d="M20 21v-5"></path>
          <path d="M20 12V3"></path>
          <path d="M2 14h4"></path>
          <path d="M10 8h4"></path>
          <path d="M18 16h4"></path>
        </svg>
        Custom Research
      </span>
    </div>
  </div>
</section>