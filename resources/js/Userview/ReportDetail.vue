<template>
  <div class="report-detail-page">
    <SiteHeader />

    <!-- Loading State -->
    <div v-if="loading" class="loading-state" style="min-height: 60vh; display: grid; place-items: center;">
      <div style="text-align: center;">
        <div class="spinner"
          style="border: 4px solid #f3f4f6; border-top: 4px solid #0783df; border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite; margin: 0 auto 20px;">
        </div>
        <p style="font-weight: 600; color: #4b5563;">Loading premium report details...</p>
      </div>
    </div>

    <template v-else-if="report">
      <!-- Banner Hero Section -->
      <header class="detail-hero-banner">
        <div class="breadcrumb-container" style="max-width: 1120px; margin: 0 auto 20px; display: flex; align-items: center; gap: 8px; font-size: 13px; color: #6b7280; flex-wrap: wrap;">
          <router-link to="/" style="color: #0783df; text-decoration: none; font-weight: 500;">Home</router-link>
          <span style="color: #9ca3af;">/</span>
          <router-link to="/reports" style="color: #0783df; text-decoration: none; font-weight: 500;">Reports</router-link>
          <span style="color: #9ca3af;">/</span>
          <template v-if="report.category">
            <router-link :to="`/industry/${generateSlug(report.category)}`" style="color: #0783df; text-decoration: none; font-weight: 500;">{{ report.category }}</router-link>
            <span style="color: #9ca3af;">/</span>
          </template>
          <span style="color: #4b5563; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 1; line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; word-break: break-all;" :title="report.title">{{ report.breadcrumb_title }}</span>
        </div>
        
        <div class="detail-hero-shell">
          <div class="book-cover-container">
            <div class="report-book-cover-image-wrapper">
              <!-- <div class="spine-crease"></div> -->
              <img :src="report.image" :alt="report.title" class="report-book-cover-img" />
            </div>
          </div>

          <div class="hero-text-content">
            <h1>{{ report.title }}</h1>
            <p class="hero-description-snippet">{{ report.detail_description }}</p>

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
              <button class="secondary-button outlined" @click="openRequestModal('Request Sample')">Request
                Sample</button>
              <button class="secondary-button outlined" @click="openRequestModal('Ask for discount')">Ask for
                Discount</button>
              <button class="secondary-button outlined" @click="openRequestModal('Request customized report')">Request
                Customized Report</button>
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
              <button class="tab-nav-btn" :class="{ 'active-tab': activeTab === 'overview' }"
                @click="setActiveTab('overview')">
                Overview
              </button>
              <button class="tab-nav-btn" :class="{ 'active-tab': activeTab === 'toc' }" @click="setActiveTab('toc')">
                Table of Contents
              </button>
              <button v-if="report.report_methodology && report.report_methodology.trim() !== ''" class="tab-nav-btn" :class="{ 'active-tab': activeTab === 'methodology' }" @click="setActiveTab('methodology')">
                Report Methodology
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
              <div v-if="report.description && report.description.trim() !== ''" v-html="report.description"
                class="dynamic-report-content"></div>
              <div v-else class="dynamic-report-content">
                <p>No description available.</p>
              </div>
            </div>

            <!-- Table of Contents Tab Pane -->
            <div v-else-if="activeTab === 'toc'" class="toc-pane">
              <h2 class="section-title">Table of Contents</h2>
              <div v-if="report.table_of_contents && report.table_of_contents.trim() !== ''"
                v-html="report.table_of_contents" class="dynamic-report-content table-of-contents-block"></div>
              <div v-else class="dynamic-report-content">
                <p>No table of contents available</p>
              </div>
            </div>

            <!-- Report Methodology Tab Pane -->
            <div v-else-if="activeTab === 'methodology'" class="toc-pane">
              <h2 class="section-title">Report Methodology</h2>
              <div v-if="report.report_methodology && report.report_methodology.trim() !== ''"
                v-html="report.report_methodology" class="dynamic-report-content"></div>
            </div>
          </div>

          <!-- FAQ Section -->
          <div v-if="getFaqs() && getFaqs().length > 0" class="faq-section"
            style="margin-top: 40px; margin-bottom: 40px;">
            <h1 class="section-title" style="    color: #0783df;
    font-size: 30px;
    font-weight: 800;
    margin-top: 32px;
    margin-bottom: 16px;
    line-height: 1.3;">Frequently Asked Questions</h1>
            <div class="faq-accordion-group">
              <div v-for="(faq, index) in getFaqs()" :key="index" class="faq-accordion-item"
                :class="{ 'faq-open': activeFaqIndex === index }">
                <button class="faq-accordion-header" @click="toggleFaq(index)">
                  {{ faq.question }}
                  <span class="faq-toggle-icon">+</span>
                </button>
                <div v-show="activeFaqIndex === index" class="faq-accordion-body">
                  {{ faq.answer }}
                </div>
              </div>
            </div>
          </div>

          <!-- Analyst Support Card -->
          <div class="analyst-support-card">
            <h3>Small Analyst Support Card</h3>
            <p>Need Help Choosing the Right Report? Speak directly with our lead industry expert.</p>
            <router-link to="/contact-us" class="talk-analyst-btn">
              <PhoneMini style="width:18px; height:18px;" /> Talk to Our Analyst
            </router-link>
          </div>
        </section>

        <!-- Right Sidebar Column -->
        <aside class="sidebar-content-column">
          <!-- Geography Dropdown -->
          <div v-if="report.geography_reports && report.geography_reports.length > 0" class="geography-dropdown-wrapper" style="margin-bottom: 24px;">
            <select class="geography-select" @change="handleGeographyChange">
              <option value="" disabled selected>Select Another Geography</option>
              <option v-for="(geo, idx) in report.geography_reports" :key="idx" :value="geo.slug_url || geo.slug || geo.id">
                {{ geo.geo_name || geo.title }}
              </option>
            </select>
          </div>

          <!-- Jump to Section -->
          <div v-if="(activeTab === 'overview' || activeTab === 'methodology') && extractedHeadings.length > 0" class="sidebar-white-info-card jump-to-section-card" style="margin-bottom: 24px;">
            <h4 style="font-size: 16px; font-weight: 700; color: #111827; margin-bottom: 16px;">Jump to Section</h4>
            <div class="jump-links-container">
              <a v-for="(heading, idx) in extractedHeadings" :key="idx"
                 href="#"
                 @click.prevent="scrollToHeading(heading.id)"
                 class="jump-link-item"
                 :class="{ 'active': activeHeadingId === heading.id, 'sub-heading': heading.tagName === 'h3' }">
                {{ heading.text }}
              </a>
            </div>
          </div>

          <!-- Get This Report Card -->
          <div class="sidebar-get-report-card">
            <h3>Get This Report</h3>

            <div style="display: flex; flex-direction: column; gap: 16px;">
              <router-link :to="`/checkout/${report.slug_url}`" class="contact-btn-white buy-now-btn">
                Buy Now
                <span class="btn-circle-arrow">
                  <svg class="chevron-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <polyline points="9 18 15 12 9 6" />
                  </svg>
                </span>
              </router-link>

              <button class="contact-btn-white request-sample-btn" @click="openRequestModal('Request Sample')">
                Request Sample
                <span class="btn-circle-arrow">
                  <svg class="chevron-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <polyline points="9 18 15 12 9 6" />
                  </svg>
                </span>
              </button>

              <hr class="card-divider" />

              <span class="talk-analyst-title">Talk to Analyst</span>

              <a href="tel:+919370940742" class="contact-btn-white call-now-btn">
                Call Now
              </a>
            </div>
          </div>

          <!-- Related Industries -->
          <div class="sidebar-white-info-card">
            <h4>Related Industries</h4>
            <div class="industry-tags-list">
              <span v-for="ind in report.related_industries" :key="ind" class="industry-tag-pill"
                @click="goToCategory(ind)">
                {{ ind }}
              </span>
            </div>
          </div>

          <!-- Related Reports -->
          <div class="sidebar-white-info-card">
            <h4>Related Reports</h4>
            <div class="related-reports-list">
              <div v-for="(rel, idx) in report.related_reports" :key="idx" class="related-report-item">
                <h5>{{ rel.title }}</h5>
                <router-link :to="`/report/${rel.slug && rel.slug !== '#' ? rel.slug : rel.id}`" class="view-link">
                  View Report
                  <ArrowRight style="width: 12px; height: 12px;" />
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
        <p style="color: #4b5563; margin-bottom: 24px;">The request report details could not be retrieved from the
          database.
        </p>
        <router-link to="/reports" class="primary-button">Back to Reports List</router-link>
      </div>
    </div>

    <RequestFormModal :isOpen="isRequestModalOpen" :subject="requestSubject" :reportName="report ? report.title : ''"
      @close="isRequestModalOpen = false" />
    <SiteFooter />
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch, computed } from 'vue'
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
const overviewHeadings = ref([])
const methodologyHeadings = ref([])
const activeHeadingId = ref('')
let headingObserver = null

const extractedHeadings = computed(() => {
  if (activeTab.value === 'overview') return overviewHeadings.value
  if (activeTab.value === 'methodology') return methodologyHeadings.value
  return []
})

// Process HTML string to inject IDs and extract headings
const processContent = (htmlString, prefix) => {
  if (!htmlString) return { html: '', headings: [] }
  const tempDiv = document.createElement('div')
  tempDiv.innerHTML = htmlString
  const headings = tempDiv.querySelectorAll('h2, h3')
  const newHeadings = []

  headings.forEach((heading, index) => {
    const id = heading.id || `${prefix}-heading-${index}`
    heading.id = id
    newHeadings.push({
      id: id,
      text: heading.innerText || heading.textContent,
      tagName: heading.tagName.toLowerCase()
    })
  })

  return { html: tempDiv.innerHTML, headings: newHeadings }
}

const scrollToHeading = (id) => {
  const el = document.getElementById(id)
  if (el) {
    el.scrollIntoView({ behavior: 'smooth', block: 'start' })
  }
}

const setupScrollSpy = () => {
  if (headingObserver) {
    headingObserver.disconnect()
  }

  headingObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        activeHeadingId.value = entry.target.id
      }
    })
  }, {
    rootMargin: '-10% 0px -70% 0px'
  })

  setTimeout(() => {
    extractedHeadings.value.forEach(h => {
      const el = document.getElementById(h.id)
      if (el) headingObserver.observe(el)
    })
  }, 300)
}

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
  if (['sample', 'request-sample'].includes(queryTab)) {
    activeTab.value = 'overview'
  } else if (['toc', 'table-of-contents', 'buy'].includes(queryTab)) {
    activeTab.value = 'toc'
  } else if (['methodology'].includes(queryTab)) {
    activeTab.value = 'methodology'
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
  if (titleVal) {
    document.title = titleVal
    tag('meta', { name: 'title', content: titleVal })
  }

  // ── Basic meta ─────────────────────────────────────────────────────────────
  if (r.meta_description) tag('meta', { name: 'description', content: r.meta_description })
  if (r.meta_keywords) tag('meta', { name: 'keywords', content: r.meta_keywords })
  if (r.meta_robots) tag('meta', { name: 'robots', content: r.meta_robots })

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

}
// ─────────────────────────────────────────────────────────────────────────────

const loadReportDetails = async (slug) => {
  loading.value = true
  activeFaqIndex.value = 0

  try {
    const response = await axios.get(`/api/report/${slug}`)
    const data = response.data

    if (data.description) {
      const { html, headings } = processContent(data.description, 'overview')
      data.description = html
      overviewHeadings.value = headings
    }

    if (data.report_methodology) {
      const { html, headings } = processContent(data.report_methodology, 'methodology')
      data.report_methodology = html
      methodologyHeadings.value = headings
    }

    report.value = data
    // Inject all SEO meta tags from report data
    injectMetaTags(data)
    // Set tab correctly once report data is successfully fetched
    setTabFromQuery()
    // Setup scroll spy
    setupScrollSpy()
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
    const targetTab = (action === 'buy' || action === 'toc') ? 'toc' : 'overview'
    setActiveTab(targetTab)

    // Smoothly scroll down to the target wrapper
    setTimeout(() => {
      let targetElement = document.querySelector('.tabs-navigation-wrapper')
      if (action === 'faq') {
        targetElement = document.querySelector('.faq-section')
      }
      if (targetElement) {
        targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' })
      }
    }, 50)
  } else if (action === 'contact') {
    router.push('/admin/contact-us') // redirects to contact page
  }
}

const handleGeographyChange = (event) => {
  const selectedSlug = event.target.value
  if (selectedSlug) {
    router.push(`/report/${selectedSlug}`)
  }
}

const generateSlug = (text) => {
  if (!text) return ''
  return text.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '')
}

const goToCategory = (categoryName) => {
  if (!categoryName) return
  router.push(`/industry/${generateSlug(categoryName)}`)
}

onMounted(() => {
  loadReportDetails(route.params.slug)
})

onUnmounted(() => {
  if (headingObserver) headingObserver.disconnect()
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

// Watch for tab changes to update the scroll spy bindings for Jump to Section
watch(activeTab, () => {
  activeHeadingId.value = ''
  setTimeout(() => {
    setupScrollSpy()
  }, 300)
})
</script>

<style src="./style.css"></style>
<style src="./reportDetailStyle.css"></style>

<style scoped>
.jump-links-container {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.jump-link-item {
  display: block;
  padding: 8px 16px;
  color: #6b7280;
  text-decoration: none;
  font-size: 14px;
  border-radius: 20px;
  transition: all 0.2s;
  line-height: 1.4;
}

.jump-link-item:hover {
  background-color: #f3f4f6;
  color: #111827;
}

.jump-link-item.active {
  background-color: #f3f4f6;
  color: #0783df;
  font-weight: 600;
}

.jump-link-item.sub-heading {
  padding-left: 24px;
  font-size: 13px;
}

.geography-select {
  width: 100%;
  padding: 12px 20px;
  text-overflow: ellipsis;
  white-space: nowrap;
  overflow: hidden;
  border: 1px solid #e5e7eb;
  border-radius: 25px;
  background-color: white;
  font-size: 14px;
  color: #4b5563;
  outline: none;
  cursor: pointer;
  appearance: none;
  background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2212%22%20height%3D%228%22%20viewBox%3D%220%200%2012%208%22%20fill%3D%22none%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cpath%20d%3D%22M1%201.5L6%206.5L11%201.5%22%20stroke%3D%22%236B7280%22%20stroke-width%3D%221.5%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22/%3E%3C/svg%3E');
  background-repeat: no-repeat;
  background-position: right 16px center;
  background-size: 12px;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  transition: border-color 0.2s;
}

.geography-select:focus {
  border-color: #0783df;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}
</style>
