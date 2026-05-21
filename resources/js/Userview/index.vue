<template>
  <div class="home-page">
    <header class="site-header">
      <a class="brand" href="#" aria-label="Epignosis Insights home">
        <img :src="'/assets/images/logo.png'" alt="Epignosis Insights Logo" class="brand-logo" />
      </a>

      <nav class="main-nav" aria-label="Main navigation">
        <a class="active" href="#">Home</a>
        <a href="#">Reports</a>
        <a href="#">Blog</a>
        <a href="#">Press Release</a>
        <a href="#">Contact</a>
      </nav>

      <div class="header-actions">
        <label class="header-search">
          <input type="search" placeholder="Search Report" />
          <svg viewBox="0 0 24 24" aria-hidden="true">
            <circle cx="11" cy="11" r="7"></circle>
            <path d="m20 20-3.5-3.5"></path>
          </svg>
        </label>
        <a class="call-button" href="tel:+916292226351">
          <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.35 1.9.66 2.8a2 2 0 0 1-.45 2.11L8.05 9.9a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.31 1.84.53 2.8.66A2 2 0 0 1 22 16.92Z"></path>
          </svg>
          Call Now
        </a>
      </div>
    </header>

    <main>
      <section class="hero-section">
        <div class="hero-ring" aria-hidden="true"></div>
        <div class="hero-card hero-card-left-top">
          <p>Monthly Market Insights</p>
          <div class="mini-bars tall">
            <span v-for="n in 24" :key="`top-${n}`" :style="{ height: `${20 + ((n * 11) % 64)}px` }"></span>
          </div>
          <small>Global Market Trends - 2025</small>
        </div>
        <div class="hero-card hero-card-left-bottom">
          <small>Industry Analysis</small>
          <h3>Global Market Revenue</h3>
          <div class="mini-bars">
            <span v-for="n in 12" :key="`rev-${n}`" :style="{ height: `${30 + ((n * 17) % 76)}px` }"></span>
          </div>
          <div class="card-metrics">
            <small>Current Growth</small>
            <small>$920B</small>
            <small>$1.4T</small>
          </div>
        </div>
        <div class="hero-card hero-card-right-top">
          <div class="donut"><span>65%</span></div>
          <p>Market Growth Rate</p>
          <small>Projected CAGR 2025-2030</small>
        </div>
        <div class="hero-card hero-card-right-mid">
          <strong>65%</strong>
          <small>Increase in Demand</small>
          <div class="tiny-bars">
            <span v-for="n in 6" :key="`tiny-${n}`" :style="{ height: `${12 + ((n * 13) % 34)}px` }"></span>
          </div>
        </div>
        <div class="hero-card hero-card-right-bottom">
          <p>Market Activity Trends</p>
          <div class="mini-bars short">
            <span v-for="n in 7" :key="`activity-${n}`" :style="{ height: `${28 + ((n * 19) % 75)}px` }"></span>
          </div>
          <small>S M T W T F S</small>
        </div>

        <div class="hero-content">
          <h1>Data-Driven <span>Insights</span> for <span>Smarter Business</span> Decisions</h1>
          <p>Access in-depth market research reports, industry analysis, and future forecasts to stay ahead of the competition.</p>
          <div class="hero-buttons">
            <a href="#reports" class="primary-button">Explore Reports</a>
            <a href="#contact" class="secondary-button">Request Custom Research</a>
          </div>
          <div class="feature-pills">
            <span><IconChart /> Data-Backed Insights</span>
            <span><IconUsers /> Expert Analysts</span>
            <span><IconSliders /> Custom Research</span>
          </div>
        </div>
      </section>

      <section id="reports" class="reports-section section-shell">
        <div class="section-heading centered">
          <h2>Top Trending Market Reports</h2>
          <p>Explore our most in-demand reports featuring the latest industry trends, forecasts, and data-driven insights.</p>
        </div>

        <div class="category-filter">
          <button v-for="category in categories" :key="category" :class="{ active: activeCategory === category }" @click="activeCategory = category">
            {{ category }}
          </button>
        </div>

        <div class="report-list">
          <article v-for="report in filteredReports" :key="report.title" class="report-card">
            <h3>{{ report.title }}</h3>
            <p>{{ report.description }}</p>
            <div class="report-meta">
              <span>Category: <strong>{{ report.category }}</strong></span>
              <span>Publish Date: <strong>{{ report.date }}</strong></span>
              <a href="#">View Report <ArrowRight /></a>
            </div>
          </article>
        </div>

        <div class="center-action">
          <a href="#" class="primary-button small">View All Reports <CircleArrow /></a>
        </div>
      </section>

      <section class="content-row-section">
        <div class="section-heading row-heading">
          <div>
            <h2>Press Releases</h2>
            <p>Latest announcements, research highlights, and industry updates from our analysts.</p>
          </div>
          <div class="slider-controls">
            <button aria-label="Previous"><ArrowLeft /></button>
            <button class="active" aria-label="Next"><ArrowRight /></button>
          </div>
        </div>
        <div class="story-grid">
          <article v-for="item in pressReleases" :key="item.title" class="story-card">
            <img :src="item.image" :alt="item.title" />
            <p class="story-date">{{ item.date }}</p>
            <h3>{{ item.title }}</h3>
            <p>{{ item.description }}</p>
          </article>
        </div>
        <div class="center-action">
          <a href="#" class="primary-button small">Read More <CircleArrow /></a>
        </div>
      </section>

      <section class="content-row-section insights-section">
        <div class="section-heading row-heading">
          <div>
            <h2>Latest Insights</h2>
            <p>Explore expert perspectives, industry trends, and data-driven stories shaping global markets.</p>
          </div>
          <div class="slider-controls">
            <button aria-label="Previous"><ArrowLeft /></button>
            <button class="active" aria-label="Next"><ArrowRight /></button>
          </div>
        </div>
        <div class="insight-strip">
          <article v-for="item in insights" :key="item.title" class="insight-card">
            <img :src="item.image" :alt="item.title" />
            <h3>{{ item.title }}</h3>
            <p>{{ item.description }}</p>
          </article>
        </div>
        <div class="center-action">
          <a href="#" class="primary-button small">Read More <CircleArrow /></a>
        </div>
      </section>

      <section class="services-section">
        <div class="section-heading centered">
          <h2>Our Services</h2>
          <p>Comprehensive research and analytics solutions designed to help businesses make informed, strategic decisions.</p>
        </div>
        <div class="services-map">
          <article v-for="service in services" :key="service.title" :class="['service-card', service.position]">
            <div class="service-icon"><component :is="service.icon" /></div>
            <h3>{{ service.title }}</h3>
            <p>{{ service.description }}</p>
          </article>
          <div class="service-center">
            <span class="brand-mark large">e</span>
          </div>
          <span class="connector c1"></span>
          <span class="connector c2"></span>
          <span class="connector c3"></span>
          <span class="connector c4"></span>
        </div>
        <div class="center-action">
          <a href="#" class="primary-button small">Learn More</a>
        </div>
      </section>

      <section class="about-section section-shell">
        <div class="about-copy">
          <h2>About Us</h2>
          <p>We are a leading market research and consulting firm dedicated to delivering accurate, data-driven insights that empower businesses to make informed decisions. Our expertise spans across multiple industries, helping organizations understand evolving market dynamics, emerging trends, and competitive landscapes.</p>
          <p>Our research combines advanced analytics, industry expertise, and reliable data sources to provide actionable intelligence that drives growth and innovation. From comprehensive market reports to fully customized research solutions, we ensure every insight is tailored to meet specific business objectives.</p>
          <p>With a strong focus on quality, transparency, and precision, our team of experienced analysts works closely with clients to uncover opportunities, mitigate risks, and support long-term strategic planning.</p>
        </div>
        <img class="about-image" :src="'/assets/images/loginpageimage.jpg'" alt="Analysts reviewing a market report" />
        <div class="about-stats">
          <div v-for="stat in aboutStats" :key="stat.label">
            <span><component :is="stat.icon" /></span>
            <strong>{{ stat.value }}</strong>
            <p>{{ stat.label }}</p>
          </div>
        </div>
      </section>

      <section id="contact" class="cta-section">
        <h2>Get the Insights You Need to Stay Ahead</h2>
        <p>Access in-depth market research and tailored insights to make smarter, data-driven decisions.</p>
        <a href="#" class="white-button">Request Custom Research</a>
      </section>
    </main>

    <footer class="footer-section">
      <div class="footer-top">
        <div>
          <a class="brand footer-brand" href="#">
            <img :src="'/assets/images/logo.png'" alt="Epignosis Insights Logo" class="brand-logo" />
          </a>
          <p>Delivering data-driven insights to support smarter business decisions.</p>
          <form class="footer-form">
            <input type="email" placeholder="Email Address" />
            <button type="submit">Show Now!</button>
          </form>
        </div>
        <div class="footer-contact">
          <p><span><IconPin /></span>123 Maple Street, Pune, India</p>
          <p><span><IconMail /></span>info@epignosisinsides.com</p>
          <p><span><PhoneMini /></span>+91 6292226351</p>
        </div>
      </div>
      <div class="footer-links">
        <nav>
          <a href="#">Home</a>
          <a href="#">About Us</a>
          <a href="#">Reports</a>
          <a href="#">Blogs</a>
          <a href="#">Press Release</a>
          <a href="#">Contact</a>
        </nav>
        <div class="social-links">
          <a href="#">f</a>
          <a href="#">in</a>
          <a href="#">x</a>
          <a href="#">ig</a>
        </div>
      </div>
      <div class="footer-bottom">
        <p>© 2025 epignosisinsides. All rights reserved.</p>
        <div>
          <a href="#">Teams & Conditions</a>
          <a href="#">Privacy Policy</a>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { computed, h, ref } from 'vue'

const iconBase = { viewBox: '0 0 24 24', fill: 'none', stroke: 'currentColor', 'stroke-width': '1.8' }
const icon = (paths, className = 'icon') => () => h('svg', { ...iconBase, class: className, 'aria-hidden': 'true' }, paths.map((d) => h('path', { d, 'stroke-linecap': 'round', 'stroke-linejoin': 'round' })))

const ArrowRight = icon(['m9 18 6-6-6-6'])
const ArrowLeft = icon(['m15 18-6-6 6-6'])
const CircleArrow = icon(['M5 12h14', 'm13 6 6-6-6-6'], 'icon small-icon')
const IconChart = icon(['M4 19V5', 'M8 17v-5', 'M12 17V8', 'M16 17v-7', 'M20 17v-3'])
const IconUsers = icon(['M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2', 'M9.5 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8', 'M22 21v-2a4 4 0 0 0-3-3.87', 'M16 3.13a4 4 0 0 1 0 7.75'])
const IconSliders = icon(['M4 21v-7', 'M4 10V3', 'M12 21v-9', 'M12 8V3', 'M20 21v-5', 'M20 12V3', 'M2 14h4', 'M10 8h4', 'M18 16h4'])
const IconTarget = icon(['M12 21a9 9 0 1 0-9-9 9 9 0 0 0 9 9Z', 'M12 17a5 5 0 1 0-5-5 5 5 0 0 0 5 5Z', 'M12 13a1 1 0 1 0-1-1 1 1 0 0 0 1 1Z', 'M20 4l-5.5 5.5'])
const IconBrief = icon(['M10 6V5a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v1', 'M4 7h16v13H4z', 'M9 12h6'])
const IconTrend = icon(['M4 17 10 11l4 4 6-8', 'M14 7h6v6'])
const IconBulb = icon(['M9 18h6', 'M10 22h4', 'M8 14a6 6 0 1 1 8 0c-.9.8-1.3 1.7-1.4 3H9.4c-.1-1.3-.5-2.2-1.4-3Z'])
const IconPin = icon(['M12 21s7-4.5 7-11a7 7 0 1 0-14 0c0 6.5 7 11 7 11Z', 'M12 10.5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z'])
const IconMail = icon(['M4 6h16v12H4z', 'm4 7 8 6 8-6'])
const PhoneMini = icon(['M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.35 1.9.66 2.8a2 2 0 0 1-.45 2.11L8.05 9.9a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.31 1.84.53 2.8.66A2 2 0 0 1 22 16.92Z'])

const activeCategory = ref('All')
const categories = ['All', 'Healthcare', 'Automotive', 'Energy & Power', 'Finance', 'Chemicals & Materials', 'Food & Beverages', 'Semiconductors & Electronics', 'Consumer Goods', 'Technology']

const reports = [
  {
    title: 'Global Artificial Intelligence Market Size, Share & Growth Forecast (2025-2030)',
    description: 'Comprehensive analysis of AI adoption, key industry players, emerging technologies, and revenue projections across global markets.',
    category: 'Technology',
    date: 'March 2025'
  },
  {
    title: 'Electric Vehicle (EV) Market Growth Analysis, Industry Trends & Forecast (2025-2032)',
    description: 'Detailed insights into EV adoption rates, battery innovations, regional demand, and government policies shaping the global automotive transition.',
    category: 'Automotive',
    date: 'February 2025'
  },
  {
    title: 'Healthcare Analytics Market Size, Share, Trends & Forecast (2025-2030)',
    description: 'Explore the rise of data-driven healthcare, including predictive analytics, digital health solutions, and investment opportunities across global markets.',
    category: 'Healthcare',
    date: 'January 2025'
  },
  {
    title: 'Renewable Energy Market Outlook, Growth Trends & Forecast (2025-2035)',
    description: 'In-depth coverage of solar, wind, and clean energy sectors, including market expansion, technological advancements, and sustainability initiatives.',
    category: 'Energy & Power',
    date: 'January 2025'
  }
]

const filteredReports = computed(() => {
  if (activeCategory.value === 'All') return reports
  return reports.filter((report) => report.category === activeCategory.value)
})

const pressReleases = [
  {
    image: '/storage/press_releases/k9YeGo5kQe8fYVZ6tK3BlNrDnfNXkpobWw6Uxtq4.jpg',
    date: 'April 12, 2025',
    title: 'AI Market Expected to Reach $1.5 Trillion by 2030, Driven by Rapid Enterprise Adoption',
    description: 'Our latest research highlights the accelerating demand for AI technologies across healthcare, finance, and retail.'
  },
  {
    image: '/storage/press_releases/thumbnails/J43LNa5gBkMUkdviHVzMMkVSJR4FpRCtbSLpbeDF.png',
    date: 'March 28, 2025',
    title: 'Electric Vehicle Market Sees Surge as Global Adoption Accelerates',
    description: 'New report reveals strong growth in EV sales, supported by government policies and advancements in charging infrastructure.'
  },
  {
    image: '/assets/images/login_bg.png',
    date: 'March 10, 2025',
    title: 'Renewable Energy Sector Set for Significant Expansion Over the Next Decade',
    description: 'Growing investments in solar and wind energy are expected to drive long-term market growth.'
  }
]

const insights = [
  {
    image: '/storage/blogs/0qhm29zHSnmTyb3p4UQV94208ZMIaFlQIxpbhlFS.jpg',
    title: 'Top 5 Emerging Technologies Transforming Global Industries in 2025',
    description: 'From AI to IoT, discover the key technologies reshaping industries and creating new growth opportunities worldwide.'
  },
  {
    image: '/storage/blogs/8dEQl3R9ch6s8meuEwhmGaYYzZQEcm8TWj7jlx7A.png',
    title: 'How Data Analytics is Revolutionizing the Healthcare Industry',
    description: 'Learn how predictive analytics and digital tools are improving patient outcomes and operational efficiency in healthcare.'
  },
  {
    image: '/storage/blogs/kYy73D8dI2YLKua3WzggkK5qiYY3pwevRgknxUZu.png',
    title: 'The Rise of Smart Infrastructure and the Future of Connected Cities',
    description: 'Explore the trends and market forces shaping intelligent transportation, energy, and urban systems.'
  }
]

const services = [
  { title: 'Market Research Reports', description: 'Comprehensive reports covering market size, key trends, and future forecasts.', icon: IconBrief, position: 'top-left' },
  { title: 'Custom Research Solutions', description: 'Tailored research designed to match your business goals and target markets.', icon: IconTarget, position: 'top-right' },
  { title: 'Industry Analysis', description: 'Detailed insights into industry trends, growth drivers, and opportunities.', icon: IconTrend, position: 'bottom-left' },
  { title: 'Consulting Services', description: 'Expert guidance to help you interpret data and make strategic decisions.', icon: IconBulb, position: 'bottom-right' }
]

const aboutStats = [
  { value: '500+', label: 'Reports Published', icon: IconBrief },
  { value: '100+', label: 'Global Clients', icon: IconUsers },
  { value: '20+', label: 'Industries Covered', icon: IconSliders },
  { value: '50+', label: 'Countries Analyzed', icon: IconPin }
]
</script>

<style scoped>
.home-page {
  color: #171717;
  background: #ffffff;
  font-family: "Inter", "Instrument Sans", "Segoe UI", sans-serif;
  letter-spacing: 0;
}

a {
  color: inherit;
  text-decoration: none;
}

button,
input {
  font: inherit;
}

.site-header {
  position: sticky;
  top: 0;
  z-index: 50;
  display: grid;
  grid-template-columns: auto 1fr auto;
  align-items: center;
  gap: 32px;
  width: min(1120px, calc(100% - 48px));
  margin: 0 auto;
  padding: 28px 0 18px;
  background: rgba(255, 255, 255, 0.92);
  backdrop-filter: blur(18px);
}

.brand {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  color: #087bd8;
  font-size: 25px;
  font-weight: 600;
  white-space: nowrap;
}

.brand-mark {
  display: grid;
  width: 33px;
  height: 33px;
  place-items: center;
  border-radius: 11px 11px 11px 4px;
  background: #087bd8;
  color: #ffffff;
  font-size: 25px;
  font-weight: 900;
  line-height: 1;
}

.brand-mark.large {
  width: 74px;
  height: 74px;
  border-radius: 50%;
  font-size: 54px;
}

.brand-logo {
  height: 36px;
  width: auto;
  object-fit: contain;
}

.main-nav {
  display: flex;
  justify-content: center;
  gap: 34px;
  color: #252525;
  font-size: 15px;
}

.main-nav a {
  padding-bottom: 5px;
}

.main-nav .active {
  color: #007fe0;
  border-bottom: 2px solid #007fe0;
}

.header-actions {
  display: flex;
  align-items: center;
  gap: 14px;
}

.header-search {
  display: flex;
  align-items: center;
  gap: 8px;
  width: 196px;
  height: 32px;
  padding: 0 12px;
  border: 1px solid #111827;
  border-radius: 20px;
  background: #fff;
}

.header-search input {
  width: 100%;
  min-width: 0;
  border: 0;
  outline: 0;
  font-size: 12px;
}

.icon,
.header-search svg,
.call-button svg {
  width: 18px;
  height: 18px;
  fill: none;
  stroke: currentColor;
  stroke-width: 2;
}

.small-icon {
  width: 14px;
  height: 14px;
}

.call-button,
.primary-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 9px;
  min-height: 44px;
  padding: 0 24px;
  border-radius: 999px;
  background: #0783df;
  color: #ffffff;
  font-size: 14px;
  font-weight: 600;
  box-shadow: 0 12px 30px rgba(7, 131, 223, 0.2);
}

.call-button {
  min-height: 34px;
  padding: 0 20px;
  font-size: 13px;
}

.primary-button.small {
  min-height: 43px;
  padding: 0 26px;
}

.secondary-button,
.white-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 44px;
  padding: 0 24px;
  border: 1px solid #0783df;
  border-radius: 999px;
  color: #067bd2;
  font-size: 14px;
  font-weight: 600;
}

.white-button {
  min-width: 250px;
  border-color: #ffffff;
  background: #ffffff;
}

.hero-section {
  position: relative;
  min-height: 735px;
  overflow: hidden;
  padding: 170px 24px 90px;
  background: linear-gradient(180deg, #ffffff 0%, #ffffff 68%, #f5fbff 100%);
}

.hero-ring {
  position: absolute;
  inset: -80px 7% auto;
  height: 700px;
  border: 110px solid rgba(231, 243, 255, 0.88);
  border-radius: 50%;
  pointer-events: none;
}

.hero-content {
  position: relative;
  z-index: 4;
  max-width: 760px;
  margin: 0 auto;
  text-align: center;
}

.hero-content h1 {
  margin: 0;
  color: #171717;
  font-size: clamp(42px, 5vw, 62px);
  font-weight: 800;
  line-height: 1.25;
  letter-spacing: 0;
}

.hero-content h1 span {
  color: #0783df;
}

.hero-content p {
  max-width: 580px;
  margin: 22px auto 0;
  color: #36383e;
  font-size: 17px;
  line-height: 1.42;
}

.hero-buttons {
  display: flex;
  justify-content: center;
  gap: 14px;
  margin-top: 32px;
  flex-wrap: wrap;
}

.feature-pills {
  display: flex;
  justify-content: center;
  gap: 24px;
  margin-top: 86px;
  flex-wrap: wrap;
}

.feature-pills span {
  display: inline-flex;
  align-items: center;
  gap: 12px;
  min-height: 48px;
  padding: 0 22px;
  border: 1px solid #ecf0f4;
  border-radius: 999px;
  background: rgba(255, 255, 255, 0.92);
  box-shadow: 0 8px 30px rgba(15, 23, 42, 0.05);
  font-weight: 600;
}

.feature-pills svg {
  color: #0783df;
}

.hero-card {
  position: absolute;
  z-index: 3;
  border: 1px solid rgba(218, 228, 238, 0.88);
  border-radius: 10px;
  background: rgba(255, 255, 255, 0.96);
  box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
}

.hero-card p,
.hero-card h3 {
  margin: 0;
}

.hero-card small {
  color: #696f7a;
}

.hero-card-left-top {
  left: 8%;
  top: 100px;
  width: 166px;
  padding: 18px 18px 16px;
  transform: rotate(-4deg);
}

.hero-card-left-bottom {
  left: 9%;
  top: 430px;
  width: 255px;
  padding: 17px 18px 15px;
}

.hero-card-right-top {
  right: 9%;
  top: 94px;
  width: 145px;
  padding: 28px 20px 20px;
  transform: rotate(8deg);
}

.hero-card-right-mid {
  right: 7.5%;
  top: 390px;
  display: grid;
  grid-template-columns: 60px 1fr;
  align-items: center;
  width: 190px;
  padding: 15px 18px;
  transform: rotate(4deg);
}

.hero-card-right-bottom {
  right: 8.5%;
  top: 500px;
  width: 165px;
  padding: 24px 18px 18px;
  transform: rotate(-5deg);
}

.mini-bars,
.tiny-bars {
  display: flex;
  align-items: end;
  gap: 7px;
  height: 88px;
  margin: 12px 0;
}

.mini-bars span,
.tiny-bars span {
  width: 12px;
  border-radius: 4px 4px 0 0;
  background: linear-gradient(180deg, #b9dcff 0%, #0783df 100%);
}

.mini-bars.tall {
  gap: 3px;
  height: 95px;
}

.mini-bars.tall span {
  width: 3px;
}

.mini-bars.short {
  height: 105px;
}

.tiny-bars {
  grid-row: 1 / span 2;
  grid-column: 2;
  justify-self: end;
  height: 42px;
  margin: 0;
  gap: 5px;
}

.tiny-bars span {
  width: 8px;
}

.card-metrics {
  display: flex;
  justify-content: space-between;
  gap: 10px;
}

.donut {
  display: grid;
  width: 86px;
  height: 86px;
  place-items: center;
  margin: 0 auto 22px;
  border-radius: 50%;
  background: conic-gradient(#0783df 0 65%, #d8ecff 65% 100%);
}

.donut span {
  display: grid;
  width: 65px;
  height: 65px;
  place-items: center;
  border-radius: 50%;
  background: #fff;
  font-size: 20px;
  font-weight: 700;
}

.section-shell {
  width: min(940px, calc(100% - 48px));
  margin: 0 auto;
}

.reports-section {
  padding: 84px 0 142px;
  background:
    radial-gradient(circle at left 28%, rgba(220, 241, 255, 0.78), transparent 23%),
    linear-gradient(180deg, #ffffff 0%, #f8fcff 100%);
}

.section-heading h2 {
  margin: 0;
  color: #171717;
  font-size: clamp(32px, 4vw, 42px);
  font-weight: 800;
  line-height: 1.1;
}

.section-heading p {
  margin: 22px 0 0;
  color: #4f535b;
  font-size: 17px;
  line-height: 1.35;
}

.centered {
  text-align: center;
}

.centered p {
  max-width: 620px;
  margin-left: auto;
  margin-right: auto;
}

.category-filter {
  display: flex;
  justify-content: center;
  gap: 24px;
  flex-wrap: wrap;
  margin-top: 58px;
}

.category-filter button {
  min-width: 96px;
  height: 34px;
  padding: 0 20px;
  border: 1px solid #dce6ef;
  border-radius: 999px;
  background: #ffffff;
  color: #3e4249;
  cursor: pointer;
}

.category-filter .active {
  border-color: #0783df;
  background: #0783df;
  color: #ffffff;
}

.report-list {
  display: grid;
  gap: 32px;
  margin-top: 86px;
}

.report-card {
  padding: 31px 31px 34px;
  border: 1px solid #e1e9f0;
  border-radius: 18px;
  background: rgba(255, 255, 255, 0.96);
  box-shadow: 0 12px 40px rgba(15, 23, 42, 0.035);
}

.report-card h3 {
  margin: 0;
  font-size: 21px;
  line-height: 1.35;
}

.report-card p {
  margin: 15px 0 0;
  max-width: 780px;
  color: #4a4d55;
  font-size: 16px;
  line-height: 1.45;
}

.report-meta {
  display: flex;
  align-items: center;
  gap: 27px;
  flex-wrap: wrap;
  margin-top: 26px;
  font-size: 15px;
}

.report-meta a {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  color: #0079d3;
  font-weight: 700;
}

.center-action {
  display: flex;
  justify-content: center;
  margin-top: 78px;
}

.content-row-section {
  width: min(1060px, calc(100% - 48px));
  margin: 0 auto;
  padding: 72px 0 110px;
}

.row-heading {
  display: flex;
  align-items: end;
  justify-content: space-between;
  gap: 32px;
}

.row-heading p {
  max-width: 440px;
}

.slider-controls {
  display: flex;
  gap: 31px;
}

.slider-controls button {
  display: grid;
  width: 66px;
  height: 66px;
  place-items: center;
  border: 1px solid #e1e9f0;
  border-radius: 50%;
  background: #ffffff;
  color: #111827;
}

.slider-controls .active {
  border-color: #0783df;
  background: #0783df;
  color: #ffffff;
}

.story-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 42px;
  margin-top: 58px;
}

.story-card img,
.insight-card img {
  width: 100%;
  object-fit: cover;
  border-radius: 11px;
}

.story-card img {
  height: 288px;
}

.story-date {
  margin: 20px 0 10px;
  color: #40444c;
  font-size: 14px;
}

.story-date::before {
  content: "";
  display: inline-block;
  width: 6px;
  height: 6px;
  margin-right: 8px;
  border-radius: 50%;
  background: #101010;
  vertical-align: middle;
}

.story-card h3,
.insight-card h3 {
  margin: 0;
  font-size: 21px;
  font-weight: 800;
  line-height: 1.45;
}

.story-card p:last-child,
.insight-card p {
  color: #4f535b;
  font-size: 14px;
  line-height: 1.35;
}

.insights-section {
  padding-top: 82px;
}

.insight-strip {
  display: grid;
  grid-template-columns: minmax(260px, 1fr) minmax(260px, 1fr) minmax(170px, 0.52fr);
  gap: 36px;
  margin-top: 58px;
  overflow: hidden;
}

.insight-card img {
  height: 230px;
}

.insight-card h3 {
  margin-top: 24px;
}

.services-section {
  padding: 94px 24px 108px;
  background:
    radial-gradient(circle at 18% 60%, rgba(221, 242, 255, 0.86), transparent 28%),
    linear-gradient(180deg, #ffffff 0%, #f1f9ff 100%);
}

.services-map {
  position: relative;
  width: min(960px, 100%);
  height: 480px;
  margin: 62px auto 0;
}

.service-card {
  position: absolute;
  width: 295px;
  min-height: 148px;
  padding: 31px 28px;
  border: 1px solid #dce6ef;
  border-radius: 18px;
  background: rgba(255, 255, 255, 0.93);
  box-shadow: 0 18px 45px rgba(15, 23, 42, 0.035);
}

.service-card.top-left {
  left: 0;
  top: 0;
}

.service-card.top-right {
  right: 0;
  top: 22px;
}

.service-card.bottom-left {
  left: 48px;
  bottom: 18px;
}

.service-card.bottom-right {
  right: 48px;
  bottom: 18px;
}

.service-icon {
  display: grid;
  width: 54px;
  height: 54px;
  place-items: center;
  border-radius: 50%;
  background: #e9f5ff;
  color: #0783df;
}

.service-card h3 {
  margin: 25px 0 12px;
  font-size: 18px;
}

.service-card p {
  margin: 0;
  color: #444953;
  font-size: 13px;
  line-height: 1.35;
}

.service-center {
  position: absolute;
  left: 50%;
  top: 50%;
  display: grid;
  width: 176px;
  height: 176px;
  place-items: center;
  border-radius: 50%;
  background: radial-gradient(circle, #acd8fb 0 38%, #dff1ff 39% 62%, rgba(222, 242, 255, 0.45) 63% 100%);
  transform: translate(-50%, -50%);
}

.connector {
  position: absolute;
  border-color: #343941;
  border-style: dashed;
  opacity: 0.72;
}

.c1 {
  left: 305px;
  top: 128px;
  width: 110px;
  height: 70px;
  border-width: 1px 1px 0 0;
}

.c2 {
  right: 305px;
  top: 128px;
  width: 110px;
  height: 70px;
  border-width: 1px 0 0 1px;
}

.c3 {
  left: 350px;
  bottom: 132px;
  width: 78px;
  height: 84px;
  border-width: 0 1px 1px 0;
}

.c4 {
  right: 350px;
  bottom: 132px;
  width: 78px;
  height: 84px;
  border-width: 0 0 1px 1px;
}

.about-section {
  display: grid;
  grid-template-columns: minmax(0, 1fr) 500px;
  gap: 74px;
  align-items: center;
  padding: 170px 0 145px;
}

.about-copy h2 {
  margin: 0 0 32px;
  font-size: 42px;
  line-height: 1;
}

.about-copy p {
  margin: 0 0 21px;
  color: #3e4249;
  font-size: 17px;
  line-height: 1.26;
}

.about-image {
  width: 100%;
  height: 390px;
  object-fit: cover;
  border-radius: 18px;
}

.about-stats {
  grid-column: 1 / -1;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 40px;
  margin-top: 22px;
}

.about-stats div {
  display: grid;
  grid-template-columns: 54px auto;
  align-items: center;
  column-gap: 18px;
}

.about-stats span {
  display: grid;
  grid-row: span 2;
  width: 54px;
  height: 54px;
  place-items: center;
  border-radius: 12px;
  background: #e9f5ff;
  color: #0783df;
}

.about-stats strong {
  font-size: 28px;
}

.about-stats p {
  margin: 0;
  color: #535862;
}

.cta-section {
  position: relative;
  overflow: hidden;
  display: grid;
  min-height: 410px;
  place-items: center;
  padding: 64px 24px;
  text-align: center;
  color: #ffffff;
  background:
    radial-gradient(circle at 14% 112%, rgba(255, 255, 255, 0.12) 0 180px, transparent 182px),
    radial-gradient(circle at 86% 42%, rgba(255, 255, 255, 0.1) 0 54px, transparent 56px),
    linear-gradient(180deg, #1489e6 0%, #005198 100%);
}

.cta-section h2 {
  max-width: 880px;
  margin: 0;
  font-size: clamp(44px, 6vw, 68px);
  font-weight: 800;
  line-height: 1.08;
}

.cta-section p {
  max-width: 640px;
  margin: 28px auto 0;
  color: #e4f4ff;
  font-size: 15px;
}

.cta-section .white-button {
  margin-top: 35px;
}

.footer-section {
  background: #ffffff;
}

.footer-top {
  display: grid;
  grid-template-columns: 1fr 360px;
  gap: 64px;
  width: min(1120px, calc(100% - 48px));
  margin: 0 auto;
  padding: 70px 0 48px;
  border-bottom: 1px solid #d7dce3;
}

.footer-brand {
  font-size: 30px;
}

.footer-top p {
  max-width: 390px;
  margin: 30px 0 0;
  font-size: 16px;
}

.footer-form {
  display: flex;
  width: 360px;
  height: 43px;
  margin-top: 40px;
  border: 1px solid #9fa7b3;
  border-radius: 999px;
  overflow: hidden;
}

.footer-form input {
  min-width: 0;
  flex: 1;
  border: 0;
  padding: 0 18px;
  outline: 0;
}

.footer-form button {
  margin: 3px;
  padding: 0 24px;
  border: 0;
  border-radius: 999px;
  background: #0783df;
  color: #ffffff;
  font-weight: 700;
}

.footer-contact {
  display: grid;
  gap: 24px;
}

.footer-contact p {
  display: flex;
  align-items: center;
  gap: 20px;
  margin: 0;
  max-width: none;
}

.footer-contact span {
  display: grid;
  width: 46px;
  height: 46px;
  place-items: center;
  border-radius: 50%;
  background: #e9f5ff;
  color: #0783df;
}

.footer-links {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: min(1120px, calc(100% - 48px));
  margin: 0 auto;
  padding: 28px 0 56px;
}

.footer-links nav {
  display: flex;
  gap: 58px;
  font-size: 14px;
}

.social-links {
  display: flex;
  gap: 18px;
}

.social-links a {
  display: grid;
  width: 28px;
  height: 28px;
  place-items: center;
  border-radius: 50%;
  background: #e9f5ff;
  color: #0783df;
  font-size: 12px;
  font-weight: 700;
}

.footer-bottom {
  display: flex;
  justify-content: space-between;
  gap: 24px;
  padding: 22px min(8vw, 80px);
  background: #1687df;
  color: #ffffff;
  font-size: 14px;
}

.footer-bottom p {
  margin: 0;
}

.footer-bottom div {
  display: flex;
  gap: 40px;
}

@media (max-width: 1100px) {
  .site-header {
    grid-template-columns: 1fr;
    justify-items: center;
  }

  .hero-card {
    display: none;
  }

  .hero-section {
    min-height: auto;
    padding-top: 96px;
  }

  .about-section,
  .footer-top {
    grid-template-columns: 1fr;
  }

  .about-stats {
    grid-template-columns: repeat(2, 1fr);
  }

  .services-map {
    display: grid;
    height: auto;
    grid-template-columns: repeat(2, 1fr);
    gap: 18px;
  }

  .service-card,
  .service-card.top-left,
  .service-card.top-right,
  .service-card.bottom-left,
  .service-card.bottom-right {
    position: static;
    width: auto;
  }

  .service-center,
  .connector {
    display: none;
  }
}

@media (max-width: 800px) {
  .main-nav,
  .header-actions {
    flex-wrap: wrap;
    justify-content: center;
  }

  .story-grid,
  .insight-strip,
  .services-map,
  .about-stats {
    grid-template-columns: 1fr;
  }

  .row-heading,
  .footer-links,
  .footer-bottom {
    align-items: flex-start;
    flex-direction: column;
  }

  .footer-links nav {
    flex-wrap: wrap;
    gap: 20px;
  }

  .footer-form {
    width: 100%;
  }
}

@media (max-width: 560px) {
  .site-header,
  .section-shell,
  .content-row-section,
  .footer-top,
  .footer-links {
    width: min(100% - 28px, 1120px);
  }

  .brand {
    font-size: 22px;
  }

  .main-nav {
    gap: 16px;
    font-size: 13px;
  }

  .header-search {
    width: min(100%, 260px);
  }

  .hero-content h1 {
    font-size: 38px;
  }

  .feature-pills {
    margin-top: 48px;
  }

  .report-card,
  .service-card {
    padding: 24px;
  }

  .report-meta {
    align-items: flex-start;
    flex-direction: column;
  }

  .about-section {
    padding: 90px 0;
  }
}
</style>
