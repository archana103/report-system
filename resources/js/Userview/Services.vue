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
              :src="'/assets/images/services_chart.png'"
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
          <span class="eyebrow">Engagement detail</span>
          <h2>How Each Service Creates Value</h2>
          <p>Clear scope, senior ownership, and deliverables built for executive decisions.</p>
        </div>

        <div class="service-detail-row">
          <div class="service-detail-info">
            <div class="service-badge">Service 01</div>
            <h2>Custom Research Solutions</h2>
            <p class="service-description">
              We design bespoke research engagements around your specific strategic, operational, or market challenge. Whether you need consumer behavior analysis, market sizing, competitive landscape mapping, product concept testing, or a category deep dive, the study is built from your decision question outward.
            </p>
            <p class="service-description">
              Our approach blends quantitative and qualitative techniques including online surveys, in-depth interviews, focus groups, expert calls, and structured secondary research. A senior research lead remains accountable from brief to final presentation.
            </p>
            <p class="service-description service-note">
              Outputs are concise, board-ready, and focused on what the business should do next.
            </p>
          </div>
          <div class="service-proof-card">
            <h3>Best for</h3>
            <p>Market entry, category validation, audience understanding, opportunity sizing, and competitor mapping.</p>
            <div class="proof-stat">
              <strong>400+</strong>
              <span>Custom studies delivered</span>
            </div>
          </div>
        </div>

        <div class="service-detail-row reverse">
          <div class="service-detail-info">
            <div class="service-badge">Service 02</div>
            <h2>Brand Track Reports</h2>
            <p class="service-description">
              Brand tracking gives you a consistent pulse on awareness, consideration, preference, purchase intent, usage, and brand imagery. Fieldwork can be structured monthly, quarterly, or bi-annually based on your market rhythm.
            </p>
            <p class="service-description">
              Each wave uses consistent methodology so changes are traceable over time. Reporting goes beyond dashboards with a strategic narrative that connects movement in metrics to campaign timing, competitive behavior, and market events.
            </p>
            <p class="service-description service-note">
              Alerts help your team respond before small dips become material brand risks.
            </p>
          </div>
          <div class="service-proof-card">
            <h3>Best for</h3>
            <p>Brand health monitoring, campaign tracking, competitive comparison, and early-warning performance signals.</p>
            <div class="proof-stat">
              <strong>+30%</strong>
              <span>Decision confidence lift</span>
            </div>
          </div>
        </div>

        <div class="service-detail-row">
          <div class="service-detail-info">
            <div class="service-badge">Service 03</div>
            <h2>Consulting Services</h2>
            <p class="service-description">
              Our consulting work bridges the gap between research findings and real business action. We support market entry strategy, portfolio and segmentation strategy, brand positioning, and customer experience optimization.
            </p>
            <p class="service-description">
              Engagements range from focused two-week sprints to longer advisory partnerships. We facilitate workshops, pressure-test assumptions, and create practical frameworks your team can continue using independently.
            </p>
            <p class="service-description service-note">
              When the stakes are high, you need more than data. You need a thinking partner.
            </p>
          </div>
          <div class="service-proof-card">
            <h3>Best for</h3>
            <p>Strategic planning, go-to-market decisions, segmentation, positioning, and board-level recommendations.</p>
            <div class="proof-stat">
              <strong>82%</strong>
              <span>Transformative impact rating</span>
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
