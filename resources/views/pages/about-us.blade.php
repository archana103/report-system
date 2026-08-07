@extends('layouts.public')

@section('content')
  <div class="about-page">
    <main class="about-main">
      <!-- Hero Section -->
      <section class="about-hero"
        style="background-image: url('{{ env('AWS_URL') }}/assets/images/background-image/aboutpage_banner.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="about-hero-content section-shell">
          <h1>
            Driving Smarter <span class="highlight">Decisions</span><br />
            <span class="highlight">Through</span> Market Intelligence
          </h1>
          <p>
            We deliver reliable market research, industry analysis, and data-driven insights that help businesses identify
            opportunities, understand market trends, and achieve strategic growth.
          </p>
          <div class="about-hero-cta">
            <a href="/reports" class="primary-button" style="text-decoration: none;">Explore Reports</a>
          </div>
        </div>
      </section>

      <!-- Who We Are -->
      <section id="who-we-are" class="about-who-we-are section-shell">
        <div class="who-copy">
          <h2>Who We Are</h2>
          <p>
            Epignosis Insights is a next-generation market research and intelligence firm founded on a singular belief:
            that the best business decisions are built on the deepest understanding. The name Epignosis drawn from the
            Greek for precise, full knowledge reflects the intellectual standard we hold ourselves to in every research
            engagement we undertake.

            Operating across 13 high-growth global industry verticals, we serve a diverse client base spanning Fortune
            500 corporations, growth-stage businesses, private equity firms, and government bodies seeking reliable
            intelligence to guide critical investment and strategic decisions. Our team of domain specialists combines
            rigorous primary and secondary research methodologies with cutting-edge analytical tools to produce insights
            that are not only data-rich, but genuinely actionable.

            At Epignosis Insights, we understand that in today's volatile, data-saturated markets, the challenge is
            rarely a shortage of information it is the ability to extract signal from noise. Our research frameworks are
            built around your strategic questions, not generic templates, ensuring every deliverable directly informs
            the decisions that matter most to your organization. We are not just a data provider we are your strategic
            intelligence partner, committed to translating knowledge into measurable competitive advantage.
          </p>
        </div>
        <div class="why-choose-image-container">
          <img class="who-image" src="{{ env('AWS_URL') }}/assets/images/business_model_infographic.gif"
            alt="Epignosis Insights Business Overview" />
        </div>
      </section>

      <!-- Our Mission & Vision -->
      <section class="about-mission-vision section-shell">
        <!-- Mission Section -->
        <div class="mission-section">
          <div class="why-choose-image-container">
            <img class="mission-image" src="{{ env('AWS_URL') }}/assets/images/client_value_journey_animation.gif"
              alt="Client collaboration and mission commitment" />
          </div>
          <div class="mission-copy">
            <h3>Our Mission</h3>
            <blockquote class="mission-quote">
              Empowering decisions that shape industries and create lasting growth.
            </blockquote>
            <p>
              At Epignosis Insights, our mission is to democratize access to institutional-quality market intelligence
              by delivering research that is accurate, timely, and genuinely useful. We exist to ensure that the
              organizations we partner with never have to make a critical strategic decision in the dark, whether
              entering a new market, launching a product, or defending a competitive position. We pursue this with an
              uncompromising commitment to research integrity, blending the precision of academic research with the
              commercial relevance of management consulting. Beyond the report, we build long-term intelligence
              partnerships where our analysts become extensions of your strategy team, helping clients move faster,
              invest smarter, and compete with conviction in a world that rewards the well-informed.
            </p>
          </div>
        </div>

        <!-- Mission Commitments -->
        <div class="mission-commitments-container">
          <div class="about-section-header centered">
            <h2>Our Four Mission Commitments</h2>
          </div>
          <div class="commitments-grid">
            <div class="commitment-card">
              <div class="commitment-num">01</div>
              <h4>Research integrity</h4>
              <span class="commitment-sub">(Multi-source validation on every study)</span>
              <p>We never publish a single-source finding. Every claim is cross-validated across primary research,
                verified secondary data, and expert review so you can cite our work with complete confidence.</p>
            </div>
            <div class="commitment-card">
              <div class="commitment-num">02</div>
              <h4>Timely delivery</h4>
              <span class="commitment-sub">(Intelligence that arrives when it matters)</span>
              <p>Market windows open and close fast. Our streamlined operations and pre-built industry data infrastructure
                mean you receive high-quality intelligence on timelines calibrated to your decision cycles not ours.</p>
            </div>
            <div class="commitment-card">
              <div class="commitment-num">03</div>
              <h4>Strategic relevance</h4>
              <span class="commitment-sub">(Every insight tied to a decision)</span>
              <p>We design every research engagement around your specific strategic questions not generic market
                templates. If a data point doesn't inform a decision you need to make, it doesn't belong in your report.
              </p>
            </div>
            <div class="commitment-card">
              <div class="commitment-num">04</div>
              <h4>Client-first partnership</h4>
              <span class="commitment-sub">(Your goals drive everything we do)</span>
              <p>From scoping to delivery, our analysts remain engaged and accountable to your outcomes. We measure our
                success by the quality of the decisions our clients make not the volume of reports we ship.</p>
            </div>
          </div>
        </div>

        <!-- Vision Section -->
        <div class="vision-section">
          <div class="vision-copy">
            <h3>Our Vision</h3>
            <blockquote class="vision-quote">
              "To be the world's most trusted intelligence partner for knowledge-driven growth."
            </blockquote>
            <p>
              At Epignosis Insights, we envision a future where deep, reliable, and actionable market intelligence is
              available to every ambitious organization, not just the largest corporations with the deepest pockets. In
              a world shaped by rapid change, rising complexity, and higher decision-making risks, we aim to move market
              research from a periodic, reactive exercise to a continuous intelligence capability embedded in our
              clients' strategy.
            </p>
            <p>
              We strive to bridge the gap between data and direction, ensuring every boardroom conversation, investment
              decision, and product launch is built on rigorously validated intelligence rather than assumptions or gut
              feel. Our goal is to be a globally trusted name synonymous with credibility, depth, and strategic
              relevance, helping clients grow with confidence in a world that never stops changing.
            </p>
          </div>
          <div class="why-choose-image-container">
            <img class="vision-image" src="{{ env('AWS_URL') }}/assets/images/growth_horizon_animation.gif"
              alt="Epignosis Insights Vision and Growth" />
          </div>
        </div>
      </section>

      <!-- Our Impact -->
      <section class="about-impact">
        <div class="section-shell">
          <div class="about-section-header centered">
            <h2>Our Impact</h2>
            <p>A quick snapshot of our achievements and scale of operations globally.</p>
          </div>
          <div class="impact-grid">
            <div class="impact-card">
              <h3>500+</h3>
              <p>Reports Published</p>
            </div>
            <div class="impact-card">
              <h3>100+</h3>
              <p>Global Clients</p>
            </div>
            <div class="impact-card">
              <h3>20+</h3>
              <p>Industries Covered</p>
            </div>
            <div class="impact-card">
              <h3>50+</h3>
              <p>Countries Analyzed</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Research Methodology -->
      <section class="about-methodology section-shell">
        <div class="about-section-header centered">
          <h2>Our Research Methodology</h2>
          <p>A robust, data-backed and multi-step research framework ensuring the highest standard of accuracy and
            reliable insights.</p>
        </div>

        <div class="methodology-waterfall">
          <div class="waterfall-step step-right">
            <div class="step-icon-wrapper">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
              </svg>
            </div>
            <div class="step-copy">
              <h4>Data Collection</h4>
              <p>Gathering verified information from trusted primary and secondary research sources.</p>
            </div>
            <div class="path-r-to-l"></div>
          </div>

          <div class="waterfall-step step-left">
            <div class="step-icon-wrapper">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
              </svg>
            </div>
            <div class="step-copy">
              <h4>Market Analysis</h4>
              <p>Examining market trends, competitive landscapes, and overall industry performance.</p>
            </div>
            <div class="path-l-to-r"></div>
          </div>

          <div class="waterfall-step step-right">
            <div class="step-icon-wrapper">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                <path d="M9 12l2 2 4-4"></path>
              </svg>
            </div>
            <div class="step-copy">
              <h4>Data Validation</h4>
              <p>Cross-checking and refining data to ensure accuracy, reliability, and consistency.</p>
            </div>
            <div class="path-r-to-l"></div>
          </div>

          <div class="waterfall-step step-left">
            <div class="step-icon-wrapper">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="18 20 18 10 12 14 6 10 6 20"></polyline>
                <polyline points="2 22 22 22"></polyline>
                <polyline points="12 4 12 14"></polyline>
              </svg>
            </div>
            <div class="step-copy">
              <h4>Forecasting & Insights</h4>
              <p>Building growth forecasts, identifying future trends, and uncovering strategic Insights.</p>
            </div>
            <div class="path-l-to-r"></div>
          </div>

          <div class="waterfall-step step-right">
            <div class="step-icon-wrapper">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
              </svg>
            </div>
            <div class="step-copy">
              <h4>Final Reporting</h4>
              <p>Delivering comprehensive reports with clear findings and actionable recommendations.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Why Choose Us -->
      <section class="about-why-choose section-shell">
        <div class="about-section-header">
          <h2>Why Choose Us</h2>
          <p>Delivering reliable market intelligence and strategic insights tailored to evolving business needs.</p>
        </div>

        <div class="why-choose-grid">
          <div class="why-choose-card">
            <h4>Data-Driven<br>Insights</h4>
            <p>Every finding is built on verified data, multi-source validation, and rigorous analysis you can act on with
              confidence.</p>
          </div>

          <div class="why-choose-image-container">
            <img class="performance-image" src="{{ env('AWS_URL') }}/assets/images/performance_metrics_animation.gif"
              alt="Performance Metrics Chart" />
          </div>

          <div class="why-choose-card">
            <h4>Global Market<br>Coverage</h4>
            <p>Research spanning 20+ industries and 50+ countries gives you a clear view of regional, global, and emerging
              markets.</p>
          </div>

          <div class="why-choose-card">
            <h4>Customized<br>Solutions</h4>
            <p>We design every engagement around your strategic questions no templates, no generic deliverables.</p>
          </div>

          <div class="why-choose-card">
            <h4>Experienced<br>Analysts</h4>
            <p>Our specialists bring 12+ years of average industry experience and 850+ delivered projects across diverse
              sectors.</p>
          </div>

          <div class="why-choose-card">
            <h4>Reliable Research<br>Methodology</h4>
            <p>A structured five-step process built on primary research, validation, and quality control at every stage.
            </p>
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
              <button aria-label="Previous"
                onclick="document.getElementById('about-insights-grid').scrollBy({left: -350, behavior: 'smooth'})">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M15 18l-6-6 6-6"></path>
                </svg>
              </button>
              <button class="active" aria-label="Next"
                onclick="document.getElementById('about-insights-grid').scrollBy({left: 350, behavior: 'smooth'})">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M9 18l6-6-6-6"></path>
                </svg>
              </button>
            </div>
          </div>
          <div class="insight-strip" id="about-insights-grid"
            style="display: flex; overflow-x: auto; scroll-snap-type: x mandatory; scrollbar-width: none;">
            @foreach($latestInsights as $item)
              <article class="insight-card"
                style="scroll-snap-align: start; flex: 0 0 calc(33.33% - 15px); min-width: 280px; margin-right: 20px;">
                <a href="{{ url('/blog/' . ($item->url ?? '')) }}" style="color: inherit; text-decoration: none;">
                  <img src="{{ $item->image ?? env('AWS_URL') . '/assets/images/default-report.png' }}"
                    alt="{{ $item->title ?? '' }}" />
                  <h3>{{ $item->title ?? '' }}</h3>
                  <p>{{ $item->description ?? '' }}</p>
                </a>
              </article>
            @endforeach
          </div>
          <x-center-action href="/blogs" text="Read More" />
        </div>
      </section>


      <!-- Footer CTA Section -->
      <section class="about-bottom-cta"
        style="background-image: url('{{ env('AWS_URL') }}/assets/images/background-image/aboutus_cta.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="section-shell cta-container">
          <div class="cta-left">
            <h3>Ready to Unlock Market Insights?</h3>
            <p>Get reliable research and data-driven insights tailored to your business goals.</p>
            <a href="/reports" class="white-button" style="text-decoration: none;">
              Get Research
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="arrow-icon">
                <circle cx="12" cy="12" r="10" />
                <path d="M12 16l4-4-4-4M8 12h8" />
              </svg>
            </a>
          </div>
          <div class="cta-right">
            <div class="industry-card"
              style="background-image: url('{{ env('AWS_URL') }}/assets/images/background-image/aboutus_ctaaboveimage.png'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 380px;">
            </div>
          </div>
        </div>
      </section>
    </main>
    <div style="height:150px"></div>
  </div>
@endsection