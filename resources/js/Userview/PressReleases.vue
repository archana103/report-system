<template>
  <div class="press-page">
    <SiteHeader />

    <main class="press-main">
      <!-- Banner Section -->
      <section class="press-banner" :style="{ backgroundImage: `url(${$assetUrl}/assets/images/background-image/press_relasebg.png)`, backgroundSize: 'cover', backgroundPosition: 'center', backgroundRepeat: 'no-repeat' }">
        <div class="press-banner-glow"></div>
        <div class="press-banner-content section-shell">
          <h1>Press Releases</h1>
          <p>
            Stay updated with the latest announcements, research developments, industry insights, and company news from Epignosis Insights.
          </p>
        </div>
      </section>

      <!-- Main Content -->
      <section class="press-content section-shell">
        <div class="press-content-header">
          <h2>Latest Press Releases</h2>
          <div class="press-search-wrapper">
            <input 
              type="search" 
              v-model="searchQuery" 
              placeholder="Search press releases..." 
              class="press-search-input"
            />
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="7"></circle>
              <path d="m20 20-3.5-3.5"></path>
            </svg>
          </div>
        </div>

        <div v-if="loading" class="press-loading">
          <div class="spinner"></div>
          <p>Loading press releases...</p>
        </div>

        <div v-else-if="pressReleases.length === 0" class="press-empty">
          <p>No press releases found. Try searching for something else!</p>
        </div>

        <div v-else class="press-container">
          <div class="press-grid">
            <router-link v-for="pr in pressReleases" :key="pr.id" :to="'/press-release/' + pr.url" class="press-card">
              <div class="press-image-wrapper">
                <img :src="pr.image || $assetUrl + '/assets/images/default-report.png'" :alt="pr.title" class="press-image" />
              </div>
              <div class="press-info">
                <span class="press-date">
                  <span class="dot">•</span>
                  {{ pr.date }}
                </span>
                <h3>{{ pr.title }}</h3>
                <p>{{ pr.description }}</p>
              </div>
            </router-link>
          </div>

          <!-- Pagination -->
          <div class="press-pagination" v-if="totalPages > 1">
            <button 
              class="pagination-arrow" 
              :disabled="currentPage === 1" 
              @click="goToPage(currentPage - 1)"
            >
              <svg class="arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
              </svg>
              Previous
            </button>
            
            <div class="pagination-numbers">
              <template v-for="(page, index) in paginationRange" :key="index">
                <span v-if="page === '...'" class="pagination-dots">
                  <span></span>
                  <span></span>
                  <span></span>
                </span>
                <button 
                  v-else
                  class="pagination-num" 
                  :class="{ active: currentPage === page }"
                  @click="goToPage(page)"
                >
                  {{ page }}
                </button>
              </template>
            </div>

            <button 
              class="pagination-arrow active-arrow" 
              :disabled="currentPage === totalPages" 
              @click="goToPage(currentPage + 1)"
            >
              Next
              <svg class="arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 18 6-6-6-6"/>
              </svg>
            </button>
          </div>
        </div>
      </section>
    </main>

    <SiteFooter />
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import axios from 'axios'
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'

const pressReleases = ref([])
const loading = ref(true)
const currentPage = ref(1)
const totalPages = ref(1)
const searchQuery = ref('')

const paginationRange = computed(() => {
  const current = currentPage.value
  const last = totalPages.value
  const delta = 2
  const left = current - delta
  const right = current + delta + 1
  const range = []
  const rangeWithDots = []
  let l

  for (let i = 1; i <= last; i++) {
    if (i === 1 || i === last || (i >= left && i < right)) {
      range.push(i)
    }
  }

  for (const i of range) {
    if (l) {
      if (i - l === 2) {
        rangeWithDots.push(l + 1)
      } else if (i - l > 2) {
        rangeWithDots.push('...')
      }
    }
    rangeWithDots.push(i)
    l = i
  }

  return rangeWithDots
})

const fetchPressReleases = async (page = 1) => {
  loading.value = true
  try {
    const response = await axios.get('/api/press-releases-list', {
      params: { 
        page,
        search: searchQuery.value
      }
    })
    if (response.data) {
      pressReleases.value = response.data.data || []
      currentPage.value = response.data.current_page || 1
      totalPages.value = response.data.last_page || 1
    }
  } catch (error) {
    console.error('Failed to fetch press releases list:', error)
  } finally {
    loading.value = false
  }
}

const goToPage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    fetchPressReleases(page)
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
}

let searchTimeout
watch(searchQuery, () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    fetchPressReleases(1)
  }, 350)
})

onMounted(() => {
  fetchPressReleases()
})
</script>

<style src="./style.css"></style>
<style src="./pressStyle.css"></style>
