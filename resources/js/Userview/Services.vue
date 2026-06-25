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
      
          <h2>Proven Research Capability</h2>
          <p>Our operating model is built around speed, rigor, and measurable impact.</p>
        </div>

        <div class="services-metrics-grid">
          <div class="main-image-container">
            <img
              :src="$assetUrl + '/assets/images/performance_metrics.gif'"
              alt="Services performance metrics chart"
              class="main-charts-image"
            />
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
            <div class="service-header-inline">
              <div class="service-number-circle">1</div>
              <h2>Custom Research Solutions</h2>
            </div>
            <div class="service-feature-list">
              <div class="service-feature-item">
                <h4>Tailored to Your Questions</h4>
                <p>Custom built research designed around your strategic and market challenges, covering consumer behaviour, market sizing, competitive mapping, and concept testing.</p>
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
              <h2>Brand Track Reports</h2>
            </div>
            <div class="service-feature-list">
              <div class="service-feature-item">
                <h4>Continuous Pulse on Brand Health</h4>
                <p>Track the metrics that matter most awareness, consideration, preference, purchase intent, usage, and brand imagery with regular monthly, quarterly, or bi annual fieldwork.</p>
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
              <h2>Consulting Services</h2>
            </div>
            <div class="service-feature-list">
              <div class="service-feature-item">
                <h4>From Insights to Action</h4>
                <p>We bridge the gap between research and strategy across market entry, portfolio and segmentation, brand positioning, and customer experience, with flexible engagements from two week sprints to long term advisory.</p>
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

    

      <LatestInsights 
        v-if="insights && insights.length > 0"
        :insights="visibleInsights" 
        @next="nextInsight" 
        @prev="prevInsight" 
      />

      <section class="services-bottom-cta section-shell">
        <div class="custom-cta-card">
          <div class="cta-left">
            <h2>Ready to<br />Commission a<br />Custom Study?</h2>
            <p>Speak to one of our lead analysts to structure a research proposal matched to your objectives.</p>
            <router-link to="/contact" class="cta-button-blue">
              Get in Touch <span class="arrow-circle">→</span>
            </router-link>
          </div>
          <div class="cta-right">
            <div class="pill-box">
              <div v-for="item in ctaPoints" :key="item" class="cta-pill">{{ item }}</div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <SiteFooter />
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'
import LatestInsights from './components/LatestInsights.vue'

const insights = ref([])

onMounted(async () => {
  try {
    const response = await axios.get('/api/blogs-public')
    if (response.data) {
      insights.value = response.data
    }
  } catch (error) {
    console.error('Failed to fetch blogs', error)
  }
})

const visibleInsights = computed(() => insights.value.slice(0, 3))
const nextInsight = () => {
  if (insights.value.length > 0) {
    const first = insights.value.shift()
    insights.value.push(first)
  }
}
const prevInsight = () => {
  if (insights.value.length > 0) {
    const last = insights.value.pop()
    insights.value.unshift(last)
  }
}

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
