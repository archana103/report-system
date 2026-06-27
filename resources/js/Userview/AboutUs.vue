<template>
  <div class="about-page">
    <SiteHeader />

    <main class="about-main">
      <!-- Hero Section -->
      <section class="about-hero">
        <div class="about-hero-glow"></div>
        <div class="about-hero-content section-shell">
          <h1>
            Driving Smarter <span class="highlight">Decisions</span><br />
            <span class="highlight">Through</span> Market Intelligence
          </h1>
          <p>
            We provide comprehensive market research reports and customized consulting services to help organizations navigate complex business challenges and achieve sustainable growth.
          </p>
          <div class="about-hero-cta">
            <a href="#who-we-are" class="primary-button">Read More</a>
          </div>
        </div>
      </section>

      <!-- Who We Are -->
      <section id="who-we-are" class="about-who-we-are section-shell">
        <div class="who-copy">
          <h2>Who We Are</h2>
          <p>
            Epignosis Insights is a next-generation market research and intelligence firm founded on a singular belief: that the best business decisions are built on the deepest understanding. The name Epignosis drawn from the Greek for precise, full knowledge reflects the intellectual standard we hold ourselves to in every research engagement we undertake.

              Operating across 13 high-growth global industry verticals, we serve a diverse client base spanning Fortune 500 corporations, growth-stage businesses, private equity firms, and government bodies seeking reliable intelligence to guide critical investment and strategic decisions. Our team of domain specialists combines rigorous primary and secondary research methodologies with cutting-edge analytical tools to produce insights that are not only data-rich, but genuinely actionable.

              At Epignosis Insights, we understand that in today's volatile, data-saturated markets, the challenge is rarely a shortage of information it is the ability to extract signal from noise. Our research frameworks are built around your strategic questions, not generic templates, ensuring every deliverable directly informs the decisions that matter most to your organization. We are not just a data provider  we are your strategic intelligence partner, committed to translating knowledge into measurable competitive advantage.
            </p>


        </div>
        <div class="why-choose-image-container">
          <img class="who-image" :src="$assetUrl + '/assets/images/business_model_infographic.gif'" alt="Epignosis Insights Business Overview" />
        </div>
      </section>

      <!-- Our Mission & Vision -->
      <section class="about-mission-vision section-shell">
        <!-- Mission Section -->
        <div class="mission-section">
          <div class="why-choose-image-container">
            <img class="mission-image" :src="$assetUrl + '/assets/images/client_value_journey_animation.gif'" alt="Client collaboration and mission commitment" />
          </div>
          <div class="mission-copy">
            <h3>Our Mission</h3>

            <blockquote class="mission-quote">
             Empowering decisions that shape industries and create lasting growth.
            </blockquote>
            <p>
                At Epignosis Insights, our mission is to democratize access to institutional-quality market intelligence by delivering research that is accurate, timely, and genuinely useful. We exist to ensure that the organizations we partner with never have to make a critical strategic decision in the dark, whether entering a new market, launching a product, or defending a competitive position. We pursue this with an uncompromising commitment to research integrity, blending the precision of academic research with the commercial relevance of management consulting. Beyond the report, we build long-term intelligence partnerships where our analysts become extensions of your strategy team, helping clients move faster, invest smarter, and compete with conviction in a world that rewards the well-informed.
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
              <p>We never publish a single-source finding. Every claim is cross-validated across primary research, verified secondary data, and expert review so you can cite our work with complete confidence.</p>
            </div>
            <div class="commitment-card">
              <div class="commitment-num">02</div>
              <h4>Timely delivery</h4>
              <span class="commitment-sub">(Intelligence that arrives when it matters)</span>
              <p>Market windows open and close fast. Our streamlined operations and pre-built industry data infrastructure mean you receive high-quality intelligence on timelines calibrated to your decision cycles not ours.</p>
            </div>
            <div class="commitment-card">
              <div class="commitment-num">03</div>
              <h4>Strategic relevance</h4>
              <span class="commitment-sub">(Every insight tied to a decision)</span>
              <p>We design every research engagement around your specific strategic questions not generic market templates. If a data point doesn't inform a decision you need to make, it doesn't belong in your report.</p>
            </div>
            <div class="commitment-card">
              <div class="commitment-num">04</div>
              <h4>Client-first partnership</h4>
              <span class="commitment-sub">(Your goals drive everything we do)</span>
              <p>From scoping to delivery, our analysts remain engaged and accountable to your outcomes. We measure our success by the quality of the decisions our clients make not the volume of reports we ship.</p>
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
              At Epignosis Insights, we envision a future where deep, reliable, and actionable market intelligence is available to every ambitious organization, not just the largest corporations with the deepest pockets. In a world shaped by rapid change, rising complexity, and higher decision-making risks, we aim to move market research from a periodic, reactive exercise to a continuous intelligence capability embedded in our clients' strategy.
            </p>

              <p>
               We strive to bridge the gap between data and direction, ensuring every boardroom conversation, investment decision, and product launch is built on rigorously validated intelligence rather than assumptions or gut feel. Our goal is to be a globally trusted name synonymous with credibility, depth, and strategic relevance, helping clients grow with confidence in a world that never stops changing.
              </p>



          </div>
          <div class="why-choose-image-container">
            <img class="vision-image" :src="$assetUrl + '/assets/images/growth_horizon_animation.gif'" alt="Epignosis Insights Vision and Growth" />
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
          <p>A robust, data-backed and multi-step research framework ensuring the highest standard of accuracy and reliable insights.</p>
        </div>

        <div class="methodology-waterfall">
          <div class="waterfall-step step-right">
            <div class="step-icon-wrapper"><IconDatabase /></div>
            <div class="step-copy">
              <h4>Data Collection</h4>
              <p>Gathering verified information from trusted primary and secondary research sources.</p>
            </div>
            <div class="path-r-to-l"></div>
          </div>

          <div class="waterfall-step step-left">
            <div class="step-icon-wrapper"><IconSearch /></div>
            <div class="step-copy">
              <h4>Market Analysis</h4>
              <p>Examining market trends, competitive landscapes, and overall industry performance.</p>
            </div>
            <div class="path-l-to-r"></div>
          </div>

          <div class="waterfall-step step-right">
            <div class="step-icon-wrapper"><IconShieldCheck /></div>
            <div class="step-copy">
              <h4>Data Validation</h4>
              <p>Cross-checking and refining data to ensure accuracy, reliability, and consistency.</p>
            </div>
            <div class="path-r-to-l"></div>
          </div>

          <div class="waterfall-step step-left">
            <div class="step-icon-wrapper"><IconChartUp /></div>
            <div class="step-copy">
              <h4>Forecasting & Insights</h4>
              <p>Building growth forecasts, identifying future trends, and uncovering strategic Insights.</p>
            </div>
            <div class="path-l-to-r"></div>
          </div>

          <div class="waterfall-step step-right">
            <div class="step-icon-wrapper"><IconFileText /></div>
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
            <p>Every finding is built on verified data, multi-source validation, and rigorous analysis you can act on with confidence.</p>
          </div>

          <div class="why-choose-image-container">
            <img class="performance-image" :src="$assetUrl + '/assets/images/performance_metrics_animation.gif'" alt="Performance Metrics Chart" />
          </div>

          <div class="why-choose-card">
            <h4>Global Market<br>Coverage</h4>
            <p>Research spanning 20+ industries and 50+ countries gives you a clear view of regional, global, and emerging markets.</p>
          </div>

          <div class="why-choose-card">
            <h4>Customized<br>Solutions</h4>
            <p>We design every engagement around your strategic questions no templates, no generic deliverables.</p>
          </div>

          <div class="why-choose-card">
            <h4>Experienced<br>Analysts</h4>
            <p>Our specialists bring 12+ years of average industry experience and 850+ delivered projects across diverse sectors.</p>
          </div>

          <div class="why-choose-card">
            <h4>Reliable Research<br>Methodology</h4>
            <p>A structured five-step process built on primary research, validation, and quality control at every stage.</p>
          </div>
        </div>
      </section>


      <!-- Latest Insights -->
      <LatestInsights
        v-if="insights && insights.length > 0"
        :insights="visibleInsights"
        @next="nextInsight"
        @prev="prevInsight"
      />

      <!-- Footer CTA Section -->
      <section class="about-bottom-cta">
        <div class="section-shell cta-container">
          <div class="cta-left">
            <h2>Ready to Unlock Market Insights?</h2>
            <p>Get reliable research and data-driven insights tailored to your business goals.</p>
            <router-link to="/reports" class="white-button">
              Get Research
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="arrow-icon"><circle cx="12" cy="12" r="10"/><path d="M12 16l4-4-4-4M8 12h8"/></svg>
            </router-link>
          </div>
          <div class="cta-right">
            <div class="industry-card">
              <ul class="industry-list">
                <li class="ind-item healthcare">
                  <div class="ind-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4.3 6.3a4.5 4.5 0 016.4 0L12 7.6l1.3-1.3a4.5 4.5 0 116.4 6.4L12 20.4l-7.7-7.7a4.5 4.5 0 010-6.4z"/></svg></div>
                  Healthcare
                </li>
                <li class="ind-item technology">
                  <div class="ind-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg></div>
                  Technology
                </li>
                <li class="ind-item energy">
                  <div class="ind-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div>
                  Energy
                </li>
                <li class="ind-item semiconductors active">
                  <div class="ind-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"/><rect x="9" y="9" width="6" height="6"/><line x1="9" y1="1" x2="9" y2="4"/><line x1="15" y1="1" x2="15" y2="4"/><line x1="9" y1="20" x2="9" y2="23"/><line x1="15" y1="20" x2="15" y2="23"/><line x1="20" y1="9" x2="23" y2="9"/><line x1="20" y1="14" x2="23" y2="14"/><line x1="1" y1="9" x2="4" y2="9"/><line x1="1" y1="14" x2="4" y2="14"/></svg></div>
                  Semiconductors
                </li>
                <li class="ind-item retail">
                  <div class="ind-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg></div>
                  Retail & E-commerce
                </li>
                <li class="ind-item bfsi">
                  <div class="ind-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="10" width="16" height="10"/><polygon points="12 2 20 6 4 6 12 2"/><line x1="8" y1="10" x2="8" y2="20"/><line x1="16" y1="10" x2="16" y2="20"/></svg></div>
                  BFSI
                </li>
                <li class="ind-item automotive">
                  <div class="ind-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 16H9m10 0h3v-3.15a1 1 0 00-.84-.99L16 11l-2.7-3.6a2 2 0 00-1.6-.8H8.3a2 2 0 00-1.6.8L4 11l-5.16.86a1 1 0 00-.84.99V16h3"/><circle cx="6.5" cy="16.5" r="2.5"/><circle cx="16.5" cy="16.5" r="2.5"/></svg></div>
                  Automotive
                </li>
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
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'
import LatestInsights from './components/LatestInsights.vue'
import { IconDatabase, IconSearch, IconShieldCheck, IconChartUp, IconFileText } from './icons'

const insights = ref([])
const showFullWhoWeAre = ref(false)
const showFullMission = ref(false)
const showFullVision = ref(false)


onMounted(async () => {
  try {
    const response = await axios.get('/api/blogs-public')
    if (response.data) {
      insights.value = response.data
    }
  } catch (error) {
    console.error('Failed to fetch blogs for About page', error)
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
</script>

<style src="./style.css"></style>
<style src="./aboutStyle.css"></style>
