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
          </p>

            <p>
              Operating across 13 high-growth global industry verticals, we serve a diverse client base spanning Fortune 500 corporations, growth-stage businesses, private equity firms, and government bodies seeking reliable intelligence to guide critical investment and strategic decisions. Our team of domain specialists combines rigorous primary and secondary research methodologies with cutting-edge analytical tools to produce insights that are not only data-rich, but genuinely actionable.
            </p>          <div class="expandable-text" :class="{ expanded: showFullWhoWeAre }">
            <p>
              At Epignosis Insights, we understand that in today's volatile, data-saturated markets, the challenge is rarely a shortage of information it is the ability to extract signal from noise. Our research frameworks are built around your strategic questions, not generic templates, ensuring every deliverable directly informs the decisions that matter most to your organization. We are not just a data provider  we are your strategic intelligence partner, committed to translating knowledge into measurable competitive advantage.
            </p>
          </div>
          <button @click="showFullWhoWeAre = !showFullWhoWeAre" class="read-more-btn">
            {{ showFullWhoWeAre ? 'Read Less' : 'Read More' }}
            <span class="arrow-icon" :class="{ rotated: showFullWhoWeAre }">↓</span>
          </button>
        </div>
        <div class="who-image-container">
          <img class="who-image" :src="$assetUrl + '/assets/images/Business.png'" alt="Epignosis Insights Business Overview" />
        </div>
      </section>

      <!-- Our Mission & Vision -->
      <section class="about-mission-vision section-shell">
        <!-- Mission Section -->
        <div class="mission-section">
          <div class="mission-image-container">
            <img class="mission-image" :src="$assetUrl + '/assets/images/Client.png'" alt="Client collaboration and mission commitment" />
          </div>
          <div class="mission-copy">
            <h3>Our Mission</h3>
            <p class="mission-tagline">Empowering decisions that shape industries and create lasting growth.</p>
            <blockquote class="mission-quote">
              "To deliver precise, timely, and actionable market intelligence that transforms how organizations understand, compete, and grow."
            </blockquote>
            <p>
              The mission of Epignosis Insights is to democratize access to institutional-quality market intelligence by delivering research that is accurate, timely, and above all, genuinely useful. We exist to serve one purpose: to ensure that the organizations we partner with never have to make a critical strategic decision in the dark. Whether it is entering a new market, launching a product, evaluating an acquisition, or defending a competitive position, our mission is to give our clients the clearest possible picture of the terrain before they commit.
            </p>
            <div class="expandable-text" :class="{ expanded: showFullMission }">
              <p>
                We pursue this mission by maintaining an uncompromising commitment to research integrity at every stage of the research process. In an industry where speed often comes at the expense of rigor, we refuse to accept that trade-off. Our methodology combines the precision of academic research with the commercial relevance of management consulting delivering findings that are not just technically sound, but strategically meaningful. We invest deeply in primary data collection, ensuring our reports reflect the real-world dynamics of markets rather than recycled secondary data dressed in new packaging.
              </p>
              <p>
                Our mission extends beyond the report. We are committed to building long-term intelligence partnerships with every client we serve relationships where our analysts become extensions of your strategy team, anticipating your information needs before you know you have them. We believe that the true value of market research is not the document delivered at project close, but the organizational confidence it creates the ability to move faster, invest smarter, and compete with conviction in markets that reward the well-informed and punish the complacent.
              </p>
              <p>
                Ultimately, our mission is measured not by the number of reports we publish, but by the quality of outcomes our clients achieve. Every study we undertake, every insight we surface, and every recommendation we make is held to a single standard: does this make our client meaningfully better positioned to win? That is the Epignosis Insights mission and it is the standard we apply, without exception, to every engagement we accept.
              </p>
            </div>
            <button @click="showFullMission = !showFullMission" class="read-more-btn">
              {{ showFullMission ? 'Read Less' : 'Read More' }}
              <span class="arrow-icon" :class="{ rotated: showFullMission }">↓</span>
            </button>
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
            <p class="vision-tagline">A world where every business decision is grounded in truth.</p>
            <blockquote class="vision-quote">
              "To be the world's most trusted intelligence partner for knowledge-driven growth."
            </blockquote>
            <p>
              At Epignosis Insights, our vision is to fundamentally reshape how organizations across the globe engage with market intelligence. We envision a future where access to deep, reliable, and actionable research is not a privilege reserved for the largest corporations with the deepest pockets, but a standard capability available to every ambitious organization regardless of size, geography, or industry.
            </p>
            <div class="expandable-text" :class="{ expanded: showFullVision }">
              <p>
                We see a global marketplace that is growing more complex by the day. Geopolitical realignments, technological disruptions, shifting consumer values, and climate-driven regulatory pressures are creating a business environment where the cost of a misinformed decision has never been higher. In this environment, market intelligence is no longer a support function it is the core of competitive strategy. Our vision is to lead that shift: to move market research from a periodic, reactive exercise to a continuous, embedded intelligence capability woven into the strategic DNA of the organizations we serve.
              </p>
              <p>
                Epignosis Insights aspires to be the firm that bridges the gap between data and direction where our reports do not merely describe markets but illuminate the paths through them. We are building toward a world where our clients enter every boardroom conversation, every investment committee, and every product launch with the confidence that comes from knowing their decisions rest on rigorously validated intelligence. Not assumptions. Not gut feel. Not yesterday's data repackaged with a new cover.
              </p>
              <p>
                Looking ahead, we envision Epignosis Insights as a globally recognized center of research excellence a firm whose name, when attached to a market study, is synonymous with credibility, depth, and strategic relevance. We will achieve this not by growing for growth's sake, but by deepening our expertise, expanding our methodological capabilities, and staying relentlessly focused on the outcome that matters most: helping our clients grow with confidence in a world that never stops changing.
              </p>
            </div>
            <button @click="showFullVision = !showFullVision" class="read-more-btn">
              {{ showFullVision ? 'Read Less' : 'Read More' }}
              <span class="arrow-icon" :class="{ rotated: showFullVision }">↓</span>
            </button>
          </div>
          <div class="vision-image-container">
            <img class="vision-image" :src="$assetUrl + '/assets/images/Growth.png'" alt="Epignosis Insights Vision and Growth" />
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
        <div class="why-list">
          <article v-for="(item, index) in whyChooseUsItems" :key="item.id" class="why-feature">
            <div class="why-feature-marker">
              <span>{{ String(index + 1).padStart(2, '0') }}</span>
            </div>
            <div class="why-feature-copy">
              <h4>{{ item.title }}</h4>
              <p class="why-summary">{{ item.summary }}</p>
              <div class="why-details" v-html="item.details"></div>
            </div>
          </article>
         
        </div>
      </section>

      <!-- Performance Banner Section -->
      <section class="about-performance section-shell">
        <div class="main-image-container shadow-premium">
          <img class="performance-image" :src="$assetUrl + '/assets/images/Performance.png'" alt="Epignosis Insights Performance Metrics" />
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
              <img :src="item.image || $assetUrl + '/assets/images/default-report.png'" :alt="item.title" />
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
const showFullWhoWeAre = ref(false)
const showFullMission = ref(false)
const showFullVision = ref(false)

const whyChooseUsItems = ref([
  {
    id: 'team',
    title: 'Experienced team',
    summary: `Behind every successful project is a team that has seen it all before. Our professionals bring an average of 12+ years of hands-on industry experience, having collectively delivered over 850 projects across diverse sectors including technology, healthcare, retail, and finance. That depth of exposure means we've navigated complex requirements, tight timelines, shifting client expectations, and unexpected technical hurdles and come out the other side with solutions that hold up.`,
    details: `<p>Our team includes certified specialists, seasoned project managers, and creative problem-solvers who collaborate closely rather than working in silos. Clients frequently tell us that working with us feels different: conversations move faster, fewer things get lost in translation, and the final output reflects genuine understanding rather than a surface-level interpretation of the brief. We also invest in continuous learning team members regularly attend workshops, industry conferences, and certification programs to stay current.</p><p>You're not just hiring a service provider; you're partnering with a team that treats your goals as their own, backed by the kind of experience that only comes from years of real-world delivery.</p>`
  },
  {
    id: 'turnaround',
    title: 'Fast turnaround time',
    summary: `In today's market, speed is a strategic advantage and we're built for it. Our average project delivery time is 40% faster than industry benchmarks, thanks to streamlined workflows, agile sprint methodologies, and a dedicated project coordination layer that eliminates the bottlenecks most teams don't even realize they have. From the moment a project is scoped, parallel workstreams are initiated so that research, design, and execution happen simultaneously rather than sequentially.`,
    details: `<p>Our internal SLA framework guarantees 24-hour responses to all client communications and 48-hour turnarounds on revision requests. For urgent engagements, we offer a dedicated fast-track service that mobilizes a senior team within 6 hours of sign-off. Speed, however, never comes at the cost of quality our QA process runs concurrently with production so nothing slips through.</p><p>Over the past two years, 94% of our projects were delivered on or ahead of schedule. When your deadline is non-negotiable, you need a partner whose entire operating model is designed around delivering and delivering fast.</p>`
  },
  {
    id: 'customization',
    title: 'Customized solutions',
    summary: `No two businesses are alike, and we refuse to treat them as if they are. Rather than offering a menu of fixed packages, we begin every engagement with a deep-discovery phase: understanding your industry context, operational constraints, target audience, competitive landscape, and long-term vision. From that foundation, we architect a solution that fits your situation precisely not a template with your logo dropped in. This approach has led to a 37% higher satisfaction rate on post-project surveys compared to clients who received standardized offerings from other providers.`,
    details: `<p>Whether you're a startup needing to move fast with limited budget, an enterprise navigating legacy system integration, or a mid-sized company scaling rapidly, our methodology adapts. We also build flexibility into deliverables themselves, so as your needs evolve, the solution can grow with you rather than requiring a costly rebuild. Every recommendation we make is grounded in your specific data, goals, and constraints not in what worked for someone else. Customization isn't a premium add-on for us; it's simply the only way we know how to work.</p>`
  },
  {
    id: 'pricing',
    title: 'Competitive pricing',
    summary: `Exceptional quality shouldn't require an exceptional budget. Our pricing model is engineered to deliver maximum value at every tier whether you're engaging us for a focused one-week sprint or a 12-month strategic partnership. We operate lean by design: minimal overhead, no unnecessary layers of account management, and a project resourcing model that scales precisely to scope rather than padding hours. Independent benchmarking has shown our rates sit 18–25% below comparable agencies without any reduction in output quality or senior-level involvement.`,
    details: `<p>We also offer transparent, fixed-fee proposals for clearly scoped work, so there are no surprise invoices mid-project. For ongoing retainers, clients receive priority scheduling, accumulated project history, and loyalty rate adjustments after six months. We're happy to work within budget constraints tell us what you have and we'll tell you honestly what's achievable. Our goal is a long-term relationship, not a single transaction, which means pricing you fairly is in our own interest too. Value isn't about the cheapest price; it's about the best outcome per pound spent.</p>`
  },
  {
    id: 'support',
    title: 'Dedicated support',
    summary: `A project doesn't end at delivery and neither does our commitment. Every client is assigned a named account manager who remains your single point of contact from kickoff through post-launch, ensuring continuity of context and eliminating the frustration of re-explaining your situation every time you reach out. Our support desk operates across three time zones, providing effective coverage from 07:00 to 23:00 GMT, with a guaranteed first-response time of under 2 hours for active clients.`,
    details: `<p>Post-delivery, we offer a 90-day warranty period during which issues are resolved at no additional cost because we stand behind our work. Beyond reactive support, your account manager proactively schedules monthly check-ins to review performance metrics, flag emerging opportunities, and align on evolving priorities. Our client retention rate of 88% over three consecutive years speaks to the quality of these ongoing relationships. Support, for us, means being genuinely accessible, deeply familiar with your setup, and invested in your continued success not just available to log a ticket.</p>`
  }
])
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
