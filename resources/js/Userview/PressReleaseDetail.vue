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
          <div class="press-breadcrumbs">
            <router-link to="/">Home</router-link>
            <span>/</span>
            <router-link to="/press-releases">Press Release</router-link>
            <span>/</span>
            <span>{{ pressRelease.title }}</span>
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
import { ref, watch, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'

const route = useRoute()

const pressRelease = ref(null)
const loading = ref(true)

const fetchPressReleaseDetails = async (slug) => {
  loading.value = true
  try {
    const response = await axios.get(`/api/press-release/${slug}`)
    if (response.data) {
      pressRelease.value = response.data
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
</script>

<style src="./style.css"></style>
<style src="./pressDetailStyle.css"></style>
