<template>
  <div class="press-detail-page">
    <SiteHeader />

    <main class="press-detail-main">
      <div class="section-shell">
        <div v-if="loading" class="press-detail-loading">
          <div class="spinner"></div>
          <p>Loading announcement details...</p>
        </div>

        <div v-else-if="!pressRelease" class="press-detail-empty">
          <p>Press release not found.</p>
        </div>

        <div v-else class="press-detail-content">
          <!-- Breadcrumbs -->
          <div class="press-breadcrumbs" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; font-size: 14px; margin-bottom: 24px; color: #6b7280;">
            <router-link to="/" style="color: #0783df; text-decoration: none;">Home</router-link>
            <span>/</span>
            <router-link to="/press-releases" style="color: #0783df; text-decoration: none;">Press Release</router-link>
            <span>/</span>
            <span style="display: -webkit-box; -webkit-line-clamp: 1; line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; word-break: break-all; color: #4b5563;" :title="pressRelease.title">{{ pressRelease.breadcrumb_title }}</span>
          </div>

          <!-- Main Layout Grid -->
          <div class="press-detail-layout">
            <!-- Left Column Content -->
            <article class="press-post-content">
              <div class="press-pub-date">Published: {{ pressRelease.date }}</div>
              <h1 class="press-post-title">{{ pressRelease.title }}</h1>
              
              <div class="press-main-image-wrapper">
                <img :src="pressRelease.image" :alt="pressRelease.title" class="press-main-image" />
              </div>

              <!-- Main Rich Text Body -->
              <div class="press-body-text" v-html="pressRelease.detail ? pressRelease.detail.content : '<p>No content details available.</p>'"></div>
            </article>

            <!-- Right Column Sidebar -->
            <aside class="press-sidebar">
              <!-- CTA Widget -->
              <div class="sidebar-widget widget-cta">
                <h3>Need Industry-Specific Insights?</h3>
                <p>Explore our latest research reports and market intelligence solutions.</p>
                <router-link to="/reports" class="widget-cta-btn">
                  Explore Reports
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </router-link>
              </div>

              <!-- Related Reports Widget -->
              <div class="sidebar-widget widget-related" v-if="pressRelease.related_reports && pressRelease.related_reports.length > 0">
                <h3>Related Reports</h3>
                <div class="related-reports-list">
                  <div 
                    v-for="item in pressRelease.related_reports" 
                    :key="item.id" 
                    class="related-report-item"
                  >
                    <h4>{{ item.title }}</h4>
                    <router-link :to="'/report/' + item.slug" class="related-report-link">
                      View Report
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="small-icon"><polyline points="9 18 15 12 9 6"/></svg>
                    </router-link>
                  </div>
                </div>
              </div>
            </aside>
          </div>
        </div>
      </div>
    </main>

    <SiteFooter />
  </div>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'

const route = useRoute()

const pressRelease = ref(null)
const loading = ref(true)

// ── Meta Tag Injection ───────────────────────────────────────────────────────
const META_ATTR = 'data-press-meta'

const cleanPressMeta = () => {
  document.querySelectorAll(`[${META_ATTR}]`).forEach(el => el.remove())
}

const injectMetaTags = (p) => {
  cleanPressMeta()
  const head = document.head

  const tag = (type, attrs = {}) => {
    const el = document.createElement(type)
    Object.entries(attrs).forEach(([k, v]) => el.setAttribute(k, v))
    el.setAttribute(META_ATTR, '1')
    head.appendChild(el)
  }

  // Title
  const titleVal = p.meta_title || p.title || ''
  if (titleVal) document.title = titleVal

  // Basic meta
  if (p.meta_description) tag('meta', { name: 'description', content: p.meta_description })
  if (p.meta_keywords)    tag('meta', { name: 'keywords',    content: p.meta_keywords })
  if (p.meta_robots)      tag('meta', { name: 'robots',      content: p.meta_robots })

  // Canonical
  if (p.canonical_tag) tag('link', { rel: 'canonical', href: p.canonical_tag })

  // OG tags (stored as array of raw <meta> strings)
  const ogTags = Array.isArray(p.open_graph_tags) ? p.open_graph_tags : Object.values(p.open_graph_tags || {})
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

  // Twitter tags (same format)
  const twTags = Array.isArray(p.twitter_card_tags) ? p.twitter_card_tags : Object.values(p.twitter_card_tags || {})
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

  // Hreflang links
  const hrefs = Array.isArray(p.hreflang_tags) ? p.hreflang_tags : []
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

  // Schema / JSON-LD scripts
  const schemas = [p.schema_tag, p.schema_tag_2]
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

  // ── Auto-generated NewsArticle schema (injected when no custom schema set) ─────
  if (!hasCustomSchema) {
    const pageUrl = p.canonical_tag || window.location.href
    let dateIso = ''
    try {
      if (p.date) {
        const d = new Date(p.date)
        if (!isNaN(d.getTime())) {
          dateIso = d.toISOString().split('T')[0]
        }
      }
    } catch (e) {}
    if (!dateIso) {
      dateIso = new Date().toISOString().split('T')[0]
    }

    const prSchema = {
      '@context': 'https://schema.org',
      '@type': 'NewsArticle',
      'headline': p.title || '',
      'description': p.meta_description || '',
      'url': pageUrl,
      'image': p.image ? [window.location.origin + p.image] : [],
      'datePublished': dateIso,
      'publisher': {
        '@type': 'Organization',
        'name': 'Report System',
        'logo': {
          '@type': 'ImageObject',
          'url': window.location.origin + '/favicon.png'
        }
      }
    }
    const autoEl = document.createElement('script')
    autoEl.type = 'application/ld+json'
    autoEl.textContent = JSON.stringify(prSchema)
    autoEl.setAttribute(META_ATTR, '1')
    head.appendChild(autoEl)
  }
}
// ─────────────────────────────────────────────────────────────────────────────

const fetchPressReleaseDetails = async (slug) => {
  loading.value = true
  try {
    const response = await axios.get(`/api/press-release/${slug}`)
    if (response.data) {
      pressRelease.value = response.data
      // Inject all SEO meta tags
      injectMetaTags(response.data)
    }
  } catch (error) {
    console.error('Failed to fetch press release details:', error)
    pressRelease.value = null
  } finally {
    loading.value = false
  }
}

watch(
  () => route.params.slug,
  (newSlug) => {
    if (newSlug) {
      fetchPressReleaseDetails(newSlug)
      window.scrollTo({ top: 0, behavior: 'smooth' })
    }
  }
)

onMounted(() => {
  if (route.params.slug) {
    fetchPressReleaseDetails(route.params.slug)
  }
})

onUnmounted(() => {
  cleanPressMeta()
})
</script>

<style src="./style.css"></style>
<style src="./pressDetailStyle.css"></style>
