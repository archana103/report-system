<template>
  <div class="blogs-page">
    <SiteHeader />

    <main class="blogs-main">
      <!-- Banner Section -->
      <section class="blogs-banner" :style="{ backgroundImage: `url(${$assetUrl}/assets/images/background-image/blogbg.png)`, backgroundSize: 'cover', backgroundPosition: 'center', backgroundRepeat: 'no-repeat' }">
        <div class="blogs-banner-glow"></div>
        <div class="blogs-banner-content section-shell">
          <h1>Market Insights & Industry Trends</h1>
          <p>
            Explore expert articles, market trends, industry analysis, and business insights across global sectors.
          </p>
        </div>
      </section>

      <!-- Blogs Grid -->
      <section class="blogs-content section-shell">
        <div v-if="loading" class="blogs-loading">
          <div class="spinner"></div>
          <p>Loading insights...</p>
        </div>

        <div v-else-if="blogs.length === 0" class="blogs-empty">
          <p>No blog posts found. Please check back later!</p>
        </div>

        <div v-else class="blogs-container">
          <div class="blogs-grid">
            <router-link v-for="blog in blogs" :key="blog.id" :to="'/blog/' + blog.url" class="blog-card">
              <div class="blog-image-wrapper">
                <img :src="blog.image || $assetUrl + '/assets/images/default-report.png'" :alt="blog.title" class="blog-image" />
              </div>
              <div class="blog-info">
                <h3>{{ blog.title }}</h3>
                <p>{{ blog.description }}</p>
              </div>
            </router-link>
          </div>

          <!-- Pagination -->
          <div class="blog-pagination" v-if="totalPages > 1">
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
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'

const blogs = ref([])
const loading = ref(true)
const currentPage = ref(1)
const totalPages = ref(1)

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

const fetchBlogs = async (page = 1) => {
  loading.value = true
  try {
    const response = await axios.get('/api/blogs-list', {
      params: { page }
    })
    if (response.data) {
      blogs.value = response.data.data || []
      currentPage.value = response.data.current_page || 1
      totalPages.value = response.data.last_page || 1
    }
  } catch (error) {
    console.error('Failed to fetch blogs list:', error)
  } finally {
    loading.value = false
  }
}

const goToPage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    fetchBlogs(page)
    window.scrollTo({ top: 0, behavior: 'smooth' })
  }
}

onMounted(() => {
  fetchBlogs()
})
</script>

<style src="./style.css"></style>
<style src="./blogsStyle.css"></style>
