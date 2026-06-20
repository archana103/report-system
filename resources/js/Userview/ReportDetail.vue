<template>
<div class="report-detail-page">
  <SiteHeader />

  <!-- Loading State -->
  <div v-if="loading" class="loading-state" style="min-height: 60vh; display: grid; place-items: center;">
    <div style="text-align: center;">
      <div class="spinner" style="border: 4px solid #f3f4f6; border-top: 4px solid #0783df; border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite; margin: 0 auto 20px;"></div>
      <p style="font-weight: 600; color: #4b5563;">Loading premium report details...</p>
    </div>
  </div>

  <template v-else-if="report">
    <!-- Banner Hero Section -->
    <header class="detail-hero-banner">
      <div class="detail-hero-shell">
        <div class="book-cover-container">
          <div class="report-book-cover-image-wrapper">
            <div class="spine-crease"></div>
            <img :src="report.image" :alt="report.title" class="report-book-cover-img" />
          </div>
        </div>
        
        <div class="hero-text-content">
          <h1>{{ report.title }}</h1>
          <p class="hero-description-snippet">{{ getHeroSnippet(report.description) }}</p>
          
          <div class="hero-meta-items">
            <span>Report ID: <strong>{{ report.report_sku }}</strong></span>
            <span>|</span>
            <span>Format: <strong>{{ report.format }}</strong></span>
            <span>|</span>
            <span>Publish Date: <strong>{{ report.date }}</strong></span>
            <span>|</span>
            <span>Pages: <strong>{{ report.pages }}</strong></span>
          </div>
          
          <div class="hero-actions-row" style="flex-wrap: wrap; gap: 12px;">
            <button class="secondary-button outlined" @click="openRequestModal('Request Sample')">Request Sample</button>
            <button class="secondary-button outlined" @click="openRequestModal('Ask for discount')">Ask for Discount</button>
            <button class="secondary-button outlined" @click="openRequestModal('Request customized report')">Request Customized Report</button>
            <router-link :to="`/checkout/${report.slug_url}`" class="primary-button">Buy Now</router-link>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Container -->
    <main class="detail-main-layout">
      <!-- Left Main Content Column -->
      <section class="main-content-column">
        <!-- Tabs Nav -->
        <div class="tabs-navigation-wrapper">
          <div class="tabs-btn-group">
            <button 
              class="tab-nav-btn" 
              :class="{ 'active-tab': activeTab === 'overview' }"
              @click="setActiveTab('overview')"
            >
              Overview
            </button>
            <button 
              class="tab-nav-btn" 
              :class="{ 'active-tab': activeTab === 'toc' }"
              @click="setActiveTab('toc')"
            >
              Table of Contents
            </button>
            <button 
              class="tab-nav-btn" 
              :class="{ 'active-tab': activeTab === 'faq' }"
              @click="setActiveTab('faq')"
            >
              FAQ
            </button>
          </div>
          <div class="tabs-right-action">
            <button class="download-sample-btn" @click="openRequestModal('Download Free Sample')">
              <IconSliders style="width:16px; height:16px;" /> Download Sample
            </button>
          </div>
        </div>

        <!-- Tab panes -->
        <div class="tab-pane-content">
          <!-- Overview Tab Pane -->
          <div v-if="activeTab === 'overview'" class="overview-pane">
            <template v-if="report.description && report.description.trim() !== ''">
              <div v-html="report.description" class="dynamic-report-content"></div>
            </template>
            <template v-else>
              <h2 class="section-title">Market Overview</h2>
              <div class="dynamic-report-content"><p>No description available.</p></div>

              <!-- Custom Vector CSS Line Chart -->
              <div class="premium-chart-card">
                <div class="chart-card-header">
                  <h4>Market Growth Projection Analysis</h4>
                  <span>Optical Coatings Market Valuation & Forecast (USD Billions)</span>
                </div>
                <div class="chart-display-container">
                  <div class="chart-background-grids">
                    <div class="grid-line" data-value="12K"></div>
                    <div class="grid-line" data-value="9K"></div>
                    <div class="grid-line" data-value="6K"></div>
                    <div class="grid-line" data-value="3K"></div>
                    <div class="grid-line" data-value="0"></div>
                  </div>
                  <svg class="chart-svg-element" viewBox="0 0 500 200" preserveAspectRatio="none">
                    <defs>
                      <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="#38bdf8" stop-opacity="0.35"/>
                        <stop offset="100%" stop-color="#0783df" stop-opacity="0.0"/>
                      </linearGradient>
                    </defs>
                    <!-- Gradient Area -->
                    <path d="M 0 170 L 100 135 L 200 110 L 300 80 L 400 55 L 500 35 L 500 200 L 0 200 Z" fill="url(#chartGradient)"/>
                    <!-- Main Stroke -->
                    <path d="M 0 170 L 100 135 L 200 110 L 300 80 L 400 55 L 500 35" fill="none" stroke="#0783df" stroke-width="4.5" stroke-linecap="round"/>
                    <!-- Points -->
                    <circle cx="0" cy="170" r="6.5" fill="#ffffff" stroke="#0783df" stroke-width="3"/>
                    <circle cx="100" cy="135" r="6.5" fill="#ffffff" stroke="#0783df" stroke-width="3"/>
                    <circle cx="200" cy="110" r="6.5" fill="#ffffff" stroke="#0783df" stroke-width="3"/>
                    <circle cx="300" cy="80" r="6.5" fill="#ffffff" stroke="#0783df" stroke-width="3"/>
                    <circle cx="400" cy="55" r="6.5" fill="#ffffff" stroke="#0783df" stroke-width="3"/>
                    <circle cx="500" cy="35" r="6.5" fill="#ffffff" stroke="#0783df" stroke-width="3"/>
                  </svg>
                </div>
                <div class="chart-labels-x">
                  <span>2024</span>
                  <span>2025</span>
                  <span>2026</span>
                  <span>2027</span>
                  <span>2028</span>
                  <span>2029</span>
                  <span>2030</span>
                </div>
              </div>

              <p style="margin-top: 25px;">
                The study offers detailed market analysis, including market sizing, growth rates, vendor shares, and technology options, making it essential reading for business strategy execution. The dynamic shift towards advanced automated production methodologies has prompted increased investments from both established conglomerates and emerging startups.
              </p>

              <h2 class="section-title" style="margin-top: 40px;">Regional Analysis</h2>
              <p>
                Geographically, North America dominates the global demand, driven by swift adoption of cutting-edge machinery, presence of major tech giants, and early implementation of commercial applications. However, the Asia Pacific region is expected to witness the highest compound annual growth rate (CAGR) during the forecast period.
              </p>

              <!-- Production Share CSS Bar Chart -->
              <div class="regional-chart-container">
                <div class="chart-card-header">
                  <h4>Production Share by Region (%)</h4>
                  <span>Proportionate Share across Global Manufacturing Locations</span>
                </div>
                <div class="regional-bar-chart">
                  <div class="regional-bar-wrapper">
                    <div class="regional-bar-fill" style="height: 70%;">
                      <span class="regional-bar-value">35%</span>
                    </div>
                    <span class="regional-bar-label">North America</span>
                  </div>
                  <div class="regional-bar-wrapper">
                    <div class="regional-bar-fill" style="height: 56%;">
                      <span class="regional-bar-value">28%</span>
                    </div>
                    <span class="regional-bar-label">Europe</span>
                  </div>
                  <div class="regional-bar-wrapper">
                    <div class="regional-bar-fill" style="height: 48%;">
                      <span class="regional-bar-value">24%</span>
                    </div>
                    <span class="regional-bar-label">Asia Pacific</span>
                  </div>
                  <div class="regional-bar-wrapper">
                    <div class="regional-bar-fill" style="height: 24%;">
                      <span class="regional-bar-value">12%</span>
                    </div>
                    <span class="regional-bar-label">LAMEA</span>
                  </div>
                </div>
              </div>

              <p style="margin-top: 25px;">
                Regulatory frameworks and environmental directives continue to influence regional dynamics. Supply chain integration and localization of manufacturing hubs are emerging as major strategic objectives for market leaders navigating trade barriers and logistical complexities.
              </p>
            </template>
          </div>

          <!-- Table of Contents Tab Pane -->
          <div v-else-if="activeTab === 'toc'" class="toc-pane">
            <h2 class="section-title">Table of Contents</h2>
            <div v-if="report.table_of_contents && report.table_of_contents.trim() !== ''" v-html="report.table_of_contents" class="dynamic-report-content table-of-contents-block"></div>
            <div v-else class="dynamic-report-content">
              <p>No table of contents available</p>
            </div>
          </div>

          <!-- FAQ Tab Pane -->
          <div v-else-if="activeTab === 'faq'" class="faq-pane">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <div v-if="getFaqs() && getFaqs().length > 0" class="faq-accordion-group">
              <div 
                v-for="(faq, index) in getFaqs()" 
                :key="index" 
                class="faq-accordion-item"
                :class="{ 'faq-open': activeFaqIndex === index }"
              >
                <button class="faq-accordion-header" @click="toggleFaq(index)">
                  {{ faq.question }}
                  <span class="faq-toggle-icon">+</span>
                </button>
                <div v-show="activeFaqIndex === index" class="faq-accordion-body">
                  {{ faq.answer }}
                </div>
              </div>
            </div>
            <div v-else class="dynamic-report-content">
              <p>No FAQ available</p>
            </div>
          </div>
        </div>

        <!-- Analyst Support Card -->
        <div class="analyst-support-card">
          <h3>Small Analyst Support Card</h3>
          <p>Need Help Choosing the Right Report? Speak directly with our lead industry expert.</p>
          <button class="talk-analyst-btn" @click="triggerAction('contact')">
            <PhoneMini style="width:18px; height:18px;" /> Talk to Our Analyst
          </button>
        </div>
      </section>

      <!-- Right Sidebar Column -->
      <aside class="sidebar-content-column">
        <!-- Get This Report Card -->
        <div class="sidebar-get-report-card">
          <h3>Get This Report</h3>
          
          <div style="display: flex; flex-direction: column; gap: 16px;">
            <router-link :to="`/checkout/${report.slug_url}`" class="contact-btn-white buy-now-btn">
              Buy Now
              <span class="btn-circle-arrow">
                <svg class="chevron-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                  <polyline points="9 18 15 12 9 6"/>
                </svg>
              </span>
            </router-link>
            
            <button class="contact-btn-white request-sample-btn" @click="openRequestModal('Request Sample')">
              Request Sample
              <span class="btn-circle-arrow">
                <svg class="chevron-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                  <polyline points="9 18 15 12 9 6"/>
                </svg>
              </span>
            </button>
            
            <hr class="card-divider" />
            
            <span class="talk-analyst-title">Talk to Analyst</span>
            
            <a href="tel:+916292226351" class="contact-btn-white call-now-btn">
              Call Now
            </a>
          </div>
        </div>

        <!-- Related Industries -->
        <div class="sidebar-white-info-card">
          <h4>Related Industries</h4>
          <div class="industry-tags-list">
            <span 
              v-for="ind in report.related_industries" 
              :key="ind" 
              class="industry-tag-pill"
              @click="goToCategory(ind)"
            >
              {{ ind }}
            </span>
          </div>
        </div>

        <!-- Related Reports -->
        <div class="sidebar-white-info-card">
          <h4>Related Reports</h4>
          <div class="related-reports-list">
            <div 
              v-for="(rel, idx) in report.related_reports" 
              :key="idx" 
              class="related-report-item"
            >
              <h5>{{ rel.title }}</h5>
              <router-link :to="`/report/${rel.slug && rel.slug !== '#' ? rel.slug : rel.id}`" class="view-link">
                View Report <ArrowRight style="width: 12px; height: 12px;" />
              </router-link>
            </div>
          </div>
        </div>
      </aside>
    </main>

  </template>

  <!-- Error / Not Found State -->
  <div v-else class="no-results" style="min-height: 60vh; display: grid; place-items: center;">
    <div style="text-align: center;">
      <h3 style="font-size: 24px; font-weight: 800; color: #dc2626; margin-bottom: 12px;">Report Not Found</h3>
      <p style="color: #4b5563; margin-bottom: 24px;">The request report details could not be retrieved from the database.</p>
      <router-link to="/reports" class="primary-button">Back to Reports List</router-link>
    </div>
  </div>

  <RequestFormModal :isOpen="isRequestModalOpen" :subject="requestSubject" :reportName="report ? report.title : ''" @close="isRequestModalOpen = false" />
  <SiteFooter />
</div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'
import RequestFormModal from '../components/RequestFormModal.vue'
import { ArrowRight, PhoneMini, IconSliders } from './icons'

const route = useRoute()
const router = useRouter()

const report = ref(null)
const loading = ref(true)
const activeTab = ref('overview')
const activeFaqIndex = ref(0)
const selectedLicense = ref('single')

// Modal Trigger state
const isRequestModalOpen = ref(false)
const requestSubject = ref('Request Sample')

const openRequestModal = (subject = 'Request Sample') => {
  requestSubject.value = subject
  isRequestModalOpen.value = true
}

// Helper to determine the active tab from query parameters
const setTabFromQuery = () => {
  const queryTab = route.query.tab ? String(route.query.tab).toLowerCase() : ''
  if (['faq', 'sample', 'request-sample'].includes(queryTab)) {
    activeTab.value = 'faq'
  } else if (['toc', 'table-of-contents', 'buy'].includes(queryTab)) {
    activeTab.value = 'toc'
  } else {
    activeTab.value = 'overview'
  }
}

// Setter that switches tab and updates the router state using replace
const setActiveTab = (tab) => {
  activeTab.value = tab
  router.replace({ query: { ...route.query, tab } })
}

// ── Meta Tag Injection ──────────────────────────────────────────────────────
const META_ATTR = 'data-report-meta'

const cleanReportMeta = () => {
  document.querySelectorAll(`[${META_ATTR}]`).forEach(el => el.remove())
}

const injectMetaTags = (r) => {
  cleanReportMeta()

  const head = document.head
  const tag = (type, attrs = {}) => {
    const el = document.createElement(type)
    Object.entries(attrs).forEach(([k, v]) => el.setAttribute(k, v))
    el.setAttribute(META_ATTR, '1')
    head.appendChild(el)
    return el
  }

  // ── Title ──────────────────────────────────────────────────────────────────
  const titleVal = r.meta_title || r.title || ''
  if (titleVal) document.title = titleVal

  // ── Basic meta ─────────────────────────────────────────────────────────────
  if (r.meta_description) tag('meta', { name: 'description', content: r.meta_description })
  if (r.meta_keywords)    tag('meta', { name: 'keywords',    content: r.meta_keywords })
  if (r.meta_robots)      tag('meta', { name: 'robots',      content: r.meta_robots })

  // ── Canonical ──────────────────────────────────────────────────────────────
  if (r.canonical_tag) tag('link', { rel: 'canonical', href: r.canonical_tag })

  // ── Open Graph tags (6 raw strings stored as full <meta …> markup) ─────────
  const ogTags = Array.isArray(r.open_graph_tags) ? r.open_graph_tags : []
  ogTags.forEach(raw => {
    if (!raw || !raw.trim()) return
    const tmp = document.createElement('div')
    tmp.innerHTML = raw.trim()
    tmp.querySelectorAll('meta').forEach(m => {
      const el = m.cloneNode(true)
      el.setAttribute(META_ATTR, '1')
      head.appendChild(el)
    })
  })

  // ── Twitter Card tags (same format) ───────────────────────────────────────
  const twTags = Array.isArray(r.twitter_card_tags) ? r.twitter_card_tags : []
  twTags.forEach(raw => {
    if (!raw || !raw.trim()) return
    const tmp = document.createElement('div')
    tmp.innerHTML = raw.trim()
    tmp.querySelectorAll('meta').forEach(m => {
      const el = m.cloneNode(true)
      el.setAttribute(META_ATTR, '1')
      head.appendChild(el)
    })
  })

  // ── Hreflang links ────────────────────────────────────────────────────────
  const hrefs = Array.isArray(r.hreflang_tags) ? r.hreflang_tags : []
  hrefs.forEach(raw => {
    if (!raw || !raw.trim()) return
    const tmp = document.createElement('div')
    tmp.innerHTML = raw.trim()
    tmp.querySelectorAll('link').forEach(l => {
      const el = l.cloneNode(true)
      el.setAttribute(META_ATTR, '1')
      head.appendChild(el)
    })
  })

  // ── Schema / JSON-LD scripts (custom from admin) ─────────────────────────
  const schemas = [
    r.schema_tag,
    r.schema_tag_2,
    ...(Array.isArray(r.custom_schema_tags) ? r.custom_schema_tags : [])
  ]
  const hasCustomSchema = schemas.some(s => s && s.trim())

  schemas.forEach(raw => {
    if (!raw || !raw.trim()) return
    const tmp = document.createElement('div')
    tmp.innerHTML = raw.trim()
    tmp.querySelectorAll('script').forEach(s => {
      const el = document.createElement('script')
      el.type = s.type || 'application/ld+json'
      el.textContent = s.textContent
      el.setAttribute(META_ATTR, '1')
      head.appendChild(el)
    })
  })

  // ── Auto-generated Product schema (injected when no custom schema set) ─────
  if (!hasCustomSchema) {
    const pageUrl = r.canonical_tag || window.location.href
    const productSchema = {
      '@context': 'https://schema.org',
      '@type': 'Product',
      'name': r.title || '',
      'description': r.meta_description || '',
      'url': pageUrl,
      'image': r.image ? [window.location.origin + r.image] : [],
      'sku': r.report_sku || '',
      'category': r.category || '',
      'offers': [
        {
          '@type': 'Offer',
          'name': 'Single User License',
          'price': r.single_user_license_cost || '3500',
          'priceCurrency': 'USD',
          'availability': 'https://schema.org/InStock',
          'url': pageUrl
        },
        {
          '@type': 'Offer',
          'name': 'Team User License',
          'price': r.team_user_license_cost || '5500',
          'priceCurrency': 'USD',
          'availability': 'https://schema.org/InStock',
          'url': pageUrl
        },
        {
          '@type': 'Offer',
          'name': 'Enterprise User License',
          'price': r.enterprise_user_license_cost || '7500',
          'priceCurrency': 'USD',
          'availability': 'https://schema.org/InStock',
          'url': pageUrl
        }
      ]
    }
    const autoEl = document.createElement('script')
    autoEl.type = 'application/ld+json'
    autoEl.textContent = JSON.stringify(productSchema)
    autoEl.setAttribute(META_ATTR, '1')
    head.appendChild(autoEl)
  }
}
// ─────────────────────────────────────────────────────────────────────────────

const loadReportDetails = async (slug) => {
  loading.value = true
  activeFaqIndex.value = 0
  selectedLicense.value = 'single'
  
  try {
    const response = await axios.get(`/api/report/${slug}`)
    report.value = response.data
    // Inject all SEO meta tags from report data
    injectMetaTags(response.data)
    // Set tab correctly once report data is successfully fetched
    setTabFromQuery()
  } catch (error) {
    console.error('Error fetching single report details:', error)
    report.value = null
  } finally {
    loading.value = false
  }
}

const getHeroSnippet = (desc) => {
  if (!desc) return 'Comprehensive market research report containing key industry statistics, growth rates, vendor landscape analysis, and forecast values.'
  // strip tags and truncate
  const plainText = desc.replace(/<[^>]*>/g, '')
  if (plainText.length > 220) {
    return plainText.substring(0, 220) + '...'
  }
  return plainText
}

const getSelectedPrice = () => {
  if (!report.value) return '0'
  if (selectedLicense.value === 'team') return report.value.team_user_license_cost
  if (selectedLicense.value === 'enterprise') return report.value.enterprise_user_license_cost
  return report.value.single_user_license_cost
}

const toggleFaq = (idx) => {
  if (activeFaqIndex.value === idx) {
    activeFaqIndex.value = -1
  } else {
    activeFaqIndex.value = idx
  }
}

const getFaqs = () => {
  if (report.value && report.value.faqs && report.value.faqs.length > 0) {
    return report.value.faqs
  }
  return []
}

// Refactored to smoothly transition tabs and scroll to contents
const triggerAction = (action) => {
  if (!report.value) return
  if (action === 'buy' || action === 'sample' || action === 'toc' || action === 'faq') {
    const targetTab = (action === 'buy' || action === 'toc') ? 'toc' : 'faq'
    setActiveTab(targetTab)
    
    // Smoothly scroll down to the tabs navigation wrapper
    setTimeout(() => {
      const tabsWrapper = document.querySelector('.tabs-navigation-wrapper')
      if (tabsWrapper) {
        tabsWrapper.scrollIntoView({ behavior: 'smooth', block: 'start' })
      }
    }, 50)
  } else if (action === 'contact') {
    router.push('/admin/contact-us') // redirects to contact page
  }
}

const goToCategory = (categoryName) => {
  router.push({ path: '/reports', query: { category: categoryName } })
}

onMounted(() => {
  loadReportDetails(route.params.slug)
})

onUnmounted(() => {
  cleanReportMeta()
})

// Watch for changes in the slug parameters to reload the page data
watch(
  () => route.params.slug,
  (newSlug) => {
    if (newSlug) {
      loadReportDetails(newSlug)
    }
  }
)

// Watch for changes in the tab query parameters to sync tab choices dynamically
watch(
  () => route.query.tab,
  () => {
    setTabFromQuery()
  }
)
</script>

<style src="./style.css"></style>
<style src="./reportDetailStyle.css"></style>

<style scoped>
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
