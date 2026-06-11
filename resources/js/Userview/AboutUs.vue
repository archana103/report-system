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
            We are a leading market research and consulting firm dedicated to delivering accurate, data-driven insights that empower businesses to make informed decisions. Our expertise spans across multiple industries, helping organizations understand evolving market dynamics, emerging trends, and competitive landscapes.
          </p>
          <p>
            Our research combines advanced analytics, industry expertise, and reliable data sources to provide actionable intelligence that drives growth and innovation. From comprehensive market reports to fully customized research solutions, we ensure every insight is tailored to meet specific business objectives.
          </p>
          <p>
            With a strong focus on quality, transparency, and precision, our team of experienced analysts works closely with clients to uncover opportunities, mitigate risks, and support long-term strategic planning.
          </p>
        </div>
        <div class="who-image-container">
          <img class="who-image" :src="'/assets/images/aboutus.png'" alt="Analysts reviewing a market report" />
        </div>
      </section>

      <!-- Our Mission & Vision -->
      <section class="about-mission-vision section-shell">
        <!-- Mission Section -->
        <div class="mission-section">
          <div class="mission-list-card">
            <ul class="checkmark-list">
              <li>
                <span class="check-icon">✓</span>
                Quality Reports
              </li>
              <li>
                <span class="check-icon">✓</span>
                Custom Research
              </li>
              <li>
                <span class="check-icon">✓</span>
                24/7 Support
              </li>
              <li>
                <span class="check-icon">✓</span>
                Global Insights
              </li>
              <li>
                <span class="check-icon">✓</span>
                Experienced Analysts
              </li>
              <li>
                <span class="check-icon">✓</span>
                Client Satisfaction
              </li>
            </ul>
          </div>
          <div class="mission-copy">
            <h3>Our Mission</h3>
            <p>
              To empower organizations worldwide with high-quality, actionable market intelligence that facilitates growth, fosters innovation, and supports strategic decision-making. We strive to be the trusted partner that businesses rely on to navigate complex market environments and achieve sustainable success.
            </p>
            <div class="watermark">MISSION</div>
          </div>
        </div>

        <!-- Vision Section -->
        <div class="vision-section">
          <div class="vision-copy">
            <h3>Our Vision</h3>
            <p>
              To be a global leader in market research and advisory services, recognized for our commitment to excellence, integrity, and client success. We aim to shape the future of market intelligence by leveraging advanced technology and human expertise to deliver unparalleled value to our clients.
            </p>
            <ul class="bullet-list">
              <li>Cutting-edge Analytics</li>
              <li>Innovative Methods</li>
              <li>Client-Centric Approach</li>
              <li>Integrity & Excellence</li>
            </ul>
          </div>
          <div class="vision-image-container">
            <img class="vision-image" :src="'/assets/images/vision_map.png'" alt="Digital World Map and Analyst silhouette" />
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
        <div class="methodology-timeline">
          <div class="timeline-line"></div>
          
          <div class="timeline-step step-1">
            <div class="step-num">01</div>
            <div class="step-content">
              <h4>Primary Research</h4>
              <p>Conducting interviews with industry experts, key opinion leaders, and key stakeholders.</p>
            </div>
          </div>

          <div class="timeline-step step-2">
            <div class="step-num">02</div>
            <div class="step-content">
              <h4>Secondary Research</h4>
              <p>Analyzing industry publications, annual reports, paid databases, and government stats.</p>
            </div>
          </div>

          <div class="timeline-step step-3">
            <div class="step-num">03</div>
            <div class="step-content">
              <h4>Data Synthesis</h4>
              <p>Aggregating the findings, identifying patterns, and validating data accuracy.</p>
            </div>
          </div>

          <div class="timeline-step step-4">
            <div class="step-num">04</div>
            <div class="step-content">
              <h4>Data Analysis & Insights</h4>
              <p>Analyzing trends, building forecasting models, and deriving actionable insights.</p>
            </div>
          </div>

          <div class="timeline-step step-5">
            <div class="step-num">05</div>
            <div class="step-content">
              <h4>Report Formulation</h4>
              <p>Compiling the report, thorough quality checks, and delivering final recommendations.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Why Choose Us -->
      <section class="about-why-choose section-shell">
        <div class="about-section-header centered">
          <h2>Why Choose Us</h2>
          <p>Why leading organizations trust us for their market research needs.</p>
        </div>
        <div class="why-grid">
          <div class="why-card">
            <h4>Deep Domain Expertise</h4>
            <p>Our analysts possess deep domain knowledge across multiple industry verticals.</p>
          </div>
          <div class="why-card">
            <h4>Custom Research Solutions</h4>
            <p>Tailored research designed specifically for your organization's unique needs.</p>
          </div>
          <div class="why-card">
            <h4>Robust Methodology</h4>
            <p>Rigorous data gathering and validation methods ensuring highly reliable data points.</p>
          </div>
          <div class="why-card">
            <h4>Actionable Insights</h4>
            <p>We go beyond just raw data to provide actionable intelligence that drives results.</p>
          </div>
          <div class="why-card">
            <h4>24/7 Customer Support</h4>
            <p>Continuous post-purchase support and quick turnaround time for query resolutions.</p>
          </div>
          <div class="why-card why-cta-card">
            <h4>Looking for Dynamic Market Insights?</h4>
            <router-link to="/contact" class="why-cta-btn">
              Contact Us
              <span class="arrow">→</span>
            </router-link>
          </div>
        </div>
      </section>

      <!-- Latest Insights -->
      <section class="about-insights section-shell" v-if="insights && insights.length > 0">
        <div class="about-section-header">
          <h2>Latest Insights</h2>
          <p>Explore expert perspectives, industry trends, and data-driven stories shaping global markets.</p>
        </div>
        <div class="insights-grid">
          <article v-for="item in insights.slice(0, 2)" :key="item.title" class="insight-article-card">
            <div class="insight-image-wrapper">
              <img :src="item.image || '/assets/images/default-report.png'" :alt="item.title" />
            </div>
            <div class="insight-info">
              <h3>{{ item.title }}</h3>
              <p>{{ item.description }}</p>
              <router-link :to="`/blog/${item.slug || ''}`" class="read-more-link">Read More →</router-link>
            </div>
          </article>
        </div>
      </section>

      <!-- Footer CTA Section -->
      <section class="about-bottom-cta">
        <div class="section-shell cta-container">
          <div class="cta-left">
            <h2>Ready to Unlock Market Insights?</h2>
            <p>Get access to our premium reports and advisory services.</p>
            <router-link to="/reports" class="white-button">Get Started</router-link>
          </div>
          <div class="cta-right">
            <div class="bullet-box">
              <ul>
                <li><span class="dot">•</span> 500+ Reports</li>
                <li><span class="dot">•</span> 100+ Clients</li>
                <li><span class="dot">•</span> 20+ Industries</li>
                <li><span class="dot">•</span> 50+ Countries</li>
                <li><span class="dot">•</span> 24/7 Support</li>
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
import { ref, onMounted } from 'vue'
import axios from 'axios'
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'

const insights = ref([])

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
</script>

<style src="./style.css"></style>
<style src="./aboutStyle.css"></style>
