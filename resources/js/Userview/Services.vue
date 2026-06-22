<template>
  <div class="services-page">
    <SiteHeader />

    <main class="services-main">
      <section class="services-hero">
        <div class="services-hero-glow"></div>
        <div class="services-hero-content section-shell">
          <!-- <span class="eyebrow">Research and advisory services</span> -->
          <h1>
            Purpose-Built <span class="highlight">Research</span><br />
            for Better Market Decisions
          </h1>
          <p>
            From custom studies and brand tracking to evidence-led consulting, our services help teams turn complex market questions into confident commercial action.
          </p>
          <div class="services-hero-cta">
            <a href="#services" class="primary-button">Explore Services</a>
            <router-link to="/contact" class="secondary-button">Talk to an Analyst</router-link>
          </div>
        </div>
      </section>

      <section class="services-overview section-shell">
        <div class="services-section-header centered">
          <span class="eyebrow">Performance snapshot</span>
          <h2>Proven Research Capability</h2>
          <p>Our operating model is built around speed, rigor, and measurable impact.</p>
        </div>

        <div class="services-metrics-grid">
          <div class="main-image-container">
            <img
              :src="$assetUrl + '/assets/images/services_chart.png'"
              alt="Services performance metrics chart"
              class="main-charts-image"
            />
          </div>

          <div class="impact-grid services-impact">
            <div v-for="metric in metrics" :key="metric.label" class="impact-card">
              <h3>{{ metric.value }}</h3>
              <p>{{ metric.label }}</p>
            </div>
          </div>
        </div>
      </section>

      <!-- <section id="services" class="service-cards-section">
        <div class="section-shell">
          <div class="services-section-header centered">
            <span class="eyebrow">What we deliver</span>
            <h2>Services Designed Around Your Business Question</h2>
            <p>Each engagement is scoped to the decision you need to make, not forced into a generic template.</p>
          </div>

          <div class="services-card-grid">
            <article v-for="service in services" :key="service.title" class="service-card">
              <div class="service-icon">{{ service.number }}</div>
              <h3>{{ service.title }}</h3>
              <p>{{ service.summary }}</p>
              <ul>
                <li v-for="item in service.points" :key="item">{{ item }}</li>
              </ul>
            </article>
          </div>
        </div>
      </section> -->

      <section class="services-detail-section section-shell">
        <div class="services-section-header centered">
          <!-- <span class="eyebrow">Engagement detail</span> -->
          <h2>How Each Service Creates Value</h2>
          <p>Clear scope, senior ownership, and deliverables built for executive decisions.</p>
        </div>

        <div class="service-detail-row">
          <div class="service-detail-info">
            <div class="service-badge">Service 01</div>
            <h2>Custom Research Solutions</h2>
            <p class="service-description">
              In a world flooded with generic data, what businesses truly need is intelligence built around their specific questions. Our Custom Research Solutions service is designed precisely for that delivering bespoke research engagements tailored to the unique strategic, operational, or market challenges your organisations faces. Whether you need consumer behaviour analysis, market sizing, competitive landscape mapping, new product concept testing, or category deep-dives, we design the methodology from scratch to match your objectives rather than shoehorning your needs into a pre-set framework.
            </p>
            <p class="service-description">
              Our approach blends quantitative and qualitative techniques online surveys, in-depth interviews, focus groups, ethnographic studies, and secondary research calibrated to the audience and the depth of insight required. Every study is handled by a senior research lead who stays accountable from brief to final presentation, ensuring nothing gets lost in handoffs.
            </p>
             <p class="service-description">
              Deliverables are crafted for decision-makers: clear, actionable, and structured around the business question rather than the data collection mechanics. We work with clients across FMCG, financial services, healthcare, retail, and technology sectors, covering both urban and emerging markets. With an average study completion time of 3–6 weeks and a track record of over 400 custom studies delivered, we bring rigour, speed, and genuine insight to every research challenge.
            </p>
            <!-- <p class="service-description service-note">
              
            </p> -->
          </div>
          <div class="service-proof-card">
            <h3>Best for</h3>
            <p>Market entry, category validation, audience understanding, opportunity sizing, and competitor mapping.</p>
            <div class="proof-stats-row">
              <div class="proof-stat">
                <strong>400+</strong>
                <span>Custom studies delivered</span>
              </div>
              <div class="proof-stat">
                <strong>3-6 Wks</strong>
                <span>Average turnaround</span>
              </div>
            </div>
          </div>
        </div>

        <div class="service-detail-row reverse">
          <div class="service-detail-info">
            <div class="service-badge">Service 02</div>
            <h2>Brand Track Reports</h2>
            <p class="service-description">
              Your brand is one of your most valuable assets but without consistent, reliable measurement, you're flying blind. Our Brand Track Reports provide a continuous pulse on how your brand is performing in the minds of consumers, tracking the metrics that matter most: awareness (both spontaneous and prompted), consideration, preference, and purchase intent, usage, and brand imagery associations. Fieldwork is conducted at regular intervals monthly, quarterly, or bi-annually depending on your market dynamics ensuring you always have a current, comparable view of your brand's health relative to key competitors.
            </p>
            <p class="service-description">
              The tracker is built on a robust, statistically reliable sample drawn from your defined target audience, with consistent methodology across waves to ensure true trend measurement rather than noise. Our reporting suite goes beyond standard dashboards: each wave culminates in a strategic narrative that contextualizes shifts in metrics against market events, competitive activity, and campaign timing, so you understand not just what changed but why. Alerts are issued when metrics move outside expected ranges, enabling rapid response before small dips become significant problems.
            </p>
            <p class="service-description">
              Clients using our brand trackers report a 30% improvement in marketing decision confidence and significantly faster identification of brand health risks. Whether you're managing an established market leader or building a challenger brand, continuous tracking turns brand management from intuition into evidence.
            </p>
          </div>
          <div class="service-proof-card">
            <h3>Best for</h3>
            <p>Brand health monitoring, campaign tracking, competitive comparison, and early-warning performance signals.</p>
            <div class="proof-stats-row">
              <div class="proof-stat">
                <strong>+30%</strong>
                <span>Decision confidence lift</span>
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
            <div class="service-badge">Service 03</div>
            <h2>Consulting Services</h2>
            <p class="service-description">
              Data without direction is just numbers. Our Consulting Services bridge the gap between research findings and real business action, working alongside leadership teams to translate insights into strategy, sharpen go-to-market plans, and make better-informed decisions under uncertainty. We offer consulting across four core areas: market entry strategy, portfolio and segmentation strategy, brand positioning, and customer experience optimization. Engagements are structured flexibly from focused two-week sprints addressing a specific decision to longer-term advisory partnerships spanning multiple months and business functions.
            </p>
            <p class="service-description">
              Our consultants bring a rare combination of deep research expertise and commercial acumen, having previously worked across both agency and client-side environments in India and internationally. We don't deliver reports and walk away. Instead, we embed ourselves in the problem, facilitate workshops with your internal teams, pressure-test assumptions, and build frameworks your organizations can continue to use independently.
            </p>
            <p class="service-description">
              Our consulting work is always evidence-led grounded in robust data, whether sourced from our own primary research, your internal analytics, or third-party sources. To date, our consulting engagements have supported over 60 strategic decisions across pricing, launch, repositioning, and expansion with 82% of clients rating the commercial impact as significant or transformative. When the stakes are high, you need more than data you need a thinking partner.
            </p>
          </div>
          <div class="service-proof-card">
            <h3>Best for</h3>
            <p>Strategic planning, go-to-market decisions, segmentation, positioning, and board-level recommendations.</p>
            <div class="proof-stats-row">
              <div class="proof-stat">
                <strong>82%</strong>
                <span>Transformative impact</span>
              </div>
              <div class="proof-stat">
                <strong>60+</strong>
                <span>Strategic decisions</span>
              </div>
            </div>
          </div>
        </div>
      </section>

    

      <section class="services-bottom-cta">
        <div class="section-shell cta-container">
          <div class="cta-left">
            <h2>Ready to Commission a Custom Study?</h2>
            <p>Speak to one of our lead analysts to structure a research proposal matched to your objectives.</p>
            <router-link to="/contact" class="white-button">Get in Touch</router-link>
          </div>
          <div class="cta-right">
            <div class="bullet-box">
              <ul>
                <li v-for="item in ctaPoints" :key="item"><span class="dot">•</span> {{ item }}</li>
              </ul>
            </div>
          </div>
        </div>
      </section>
    </main>

    <SiteFooter />
  </div>
</template>

<script setup>
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'

const metrics = [
  { value: '400+', label: 'Custom Studies Delivered' },
  { value: '3-6 wks', label: 'Average Study Turnaround' },
  { value: '+30%', label: 'Decision Confidence Lift' },
  { value: '82%', label: 'Consulting Impact Rating' }
]

const services = [
  {
    number: '01',
    title: 'Custom Research Solutions',
    summary: 'Bespoke research programs designed around your market, customer, or strategic question.',
    points: ['Market sizing and forecasting', 'Customer and buyer research', 'Competitive landscape mapping']
  },
  {
    number: '02',
    title: 'Brand Track Reports',
    summary: 'Repeatable tracking that shows how awareness, consideration, preference, and intent are moving.',
    points: ['Brand health dashboards', 'Competitive benchmarking', 'Metric movement alerts']
  },
  {
    number: '03',
    title: 'Consulting Services',
    summary: 'Evidence-led advisory support that translates research findings into practical next steps.',
    points: ['Market entry strategy', 'Segmentation and positioning', 'Executive decision workshops']
  }
]

const processSteps = [
  { number: '01', side: 'left', title: 'Research Brief', description: 'We clarify the business question, decision context, scope, audience, and success criteria.' },
  { number: '02', side: 'right', title: 'Methodology Design', description: 'We select the right mix of primary, secondary, qualitative, and quantitative research methods.' },
  { number: '03', side: 'left', title: 'Fieldwork and Analysis', description: 'We gather, validate, and analyze the data with senior oversight throughout the engagement.' },
  { number: '04', side: 'right', title: 'Strategic Delivery', description: 'We deliver concise recommendations, supporting evidence, and decision-ready reporting.' }
]

const ctaPoints = [
  'Bespoke Methodologies',
  'Regular Tracking Wave Reports',
  'Evidence-led Advisory',
  'Fast 3-6 Week Completion',
  'Dedicated Senior Leads'
]
</script>

<style src="./style.css"></style>
<style src="./servicesStyle.css"></style>
