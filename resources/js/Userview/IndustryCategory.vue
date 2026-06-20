<template>
  <div class="industry-category-page">
    <SiteHeader />
    <!-- Dynamic Category Cover Image Banner -->
    <section 
      class="category-hero-banner" 
      :style="categoryInfo && categoryInfo.category_image ? { backgroundImage: `url(${categoryInfo.category_image})` } : {}"
    >
      <div class="banner-overlay"></div>
      <div class="banner-content">
        <div class="breadcrumbs">
          <router-link to="/">Home</router-link> 
          <span class="separator">/</span> 
          <span class="current-crumb">{{ categoryInfo && categoryInfo.name ? categoryInfo.name : categoryName }}</span>
        </div>
        <h1 class="category-banner-title">{{ categoryInfo && categoryInfo.name ? categoryInfo.name : categoryName }}</h1>
      </div>
    </section>

    <!-- Main Content Section -->
    <main class="category-main-content">
      <!-- Category Heading & Description Section -->
      <section class="category-intro-section" v-if="categoryInfo">
        <h2 class="category-main-heading">{{ categoryInfo.main_heading }}</h2>
        <div class="category-subheading-desc" v-if="categoryInfo.main_subheading" v-html="categoryInfo.main_subheading"></div>
       
      </section>

      <!-- Two-Column Layout (Sidebar & Reports) -->
      <div class="category-two-column-layout">
        <!-- Left Sidebar: Reports by Industry -->
        <aside class="category-sidebar">
          <div class="sidebar-card">
            <h3 class="sidebar-title">Reports by Industry</h3>
            <nav class="sidebar-nav">
              <router-link 
                v-for="cat in sidebarCategories" 
                :key="cat" 
                :to="`/industry/${cat}`"
                class="sidebar-nav-item"
                :class="{ 'active-sidebar-item': isCurrentCategory(cat) }"
              >
                <span class="nav-text">{{ cat }}</span>
                <span class="chevron-arrow">›</span>
              </router-link>
            </nav>
          </div>
        </aside>

        <!-- Right Column: Paginated Reports List -->
        <section class="category-reports-list">
          <div v-if="loadingReports" class="loading-state">
            <div class="spinner"></div>
            <p>Loading {{ categoryName }} reports...</p>
          </div>

          <template v-else>
            <div class="report-list-vertical" v-if="reports && reports.length > 0">
              <article v-for="report in reports" :key="report.id" class="report-list-card">
                <!-- Premium Pure CSS 3D Mockup Book Cover -->
                <div class="report-image-wrap">
                  <router-link :to="`/report/${report.slug && report.slug !== '#' ? report.slug : report.id}`" class="cover-link">
                    <div class="mockup-book-cover">
                      <div class="spine-crease"></div>
                      <div class="cover-content">
                        <span class="cover-super-title">MARKET RESEARCH</span>
                        <h4 class="cover-main-title">{{ report.category }}</h4>
                        <span class="cover-sub-title">Premium Insights</span>
                      </div>
                      <div class="cover-badge">REPORT</div>
                    </div>
                  </router-link>
                </div>

                <div class="report-details">
                  <router-link :to="`/report/${report.slug && report.slug !== '#' ? report.slug : report.id}`" class="report-title-link">
                    <h3 class="hover-primary-title">{{ report.title }}</h3>
                  </router-link>
                  <p class="report-description" v-html="report.description"></p>
                  
                  <div class="report-metadata">
                    <span>Pages: <strong>{{ report.pages }}</strong></span>
                    <span class="divider">|</span>
                    <span>Format: <strong>{{ report.format }}</strong></span>
                    <span class="divider">|</span>
                    <span>Publish Date: <strong>{{ report.date }}</strong></span>
                  </div>

                  <div class="report-actions">
                    <button class="secondary-button outlined" @click="openRequestModal('Request Sample', report.title)">Request Sample</button>
                    <button class="secondary-button outlined" @click="openRequestModal('Download Free Sample', report.title)">Download Sample</button>
                    <router-link :to="`/report/${report.slug && report.slug !== '#' ? report.slug : report.id}`" class="primary-button small">Buy Now</router-link>
                  </div>
                </div>
              </article>
            </div>

            <div v-else class="no-results">
              No reports found for this industry category currently.
            </div>

            <!-- Category Report Pagination -->
            <div class="pagination-wrapper" v-if="totalPages > 1">
              <button 
                class="nav-btn prev-btn" 
                :disabled="currentPage === 1" 
                @click="changePage(currentPage - 1)"
              >
                ‹ Previous
              </button>
              
              <div class="page-numbers">
                <button 
                  v-for="page in paginationRange" 
                  :key="page" 
                  class="num-btn" 
                  :class="{ active: page === currentPage }"
                  @click="changePage(page)"
                >
                  {{ page }}
                </button>
              </div>

              <button 
                class="nav-btn next-btn" 
                :disabled="currentPage === totalPages" 
                @click="changePage(currentPage + 1)"
              >
                Next ›
              </button>
            </div>
          </template>
        </section>
      </div>
    </main>

    <!-- Request Form Modal Popup -->
    <RequestFormModal :isOpen="isRequestModalOpen" :subject="requestSubject" :reportName="requestReportName" @close="isRequestModalOpen = false" />

    <!-- Custom Analyst Research CTA Component -->
    <CustomResearchCTA />

    <SiteFooter />
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'
import CustomResearchCTA from './components/CustomResearchCTA.vue'
import RequestFormModal from '../components/RequestFormModal.vue'

const route = useRoute()
const router = useRouter()

const categoryName = computed(() => route.params.name)
const categoryInfo = ref(null)
const sidebarCategories = ref([])
const reports = ref([])
const loadingReports = ref(false)
const currentPage = ref(1)
const totalPages = ref(1)

// Request Form Modal state
const isRequestModalOpen = ref(false)
const requestSubject = ref('Request Sample')
const requestReportName = ref('')

const openRequestModal = (subject = 'Request Sample', reportTitle = '') => {
  requestSubject.value = subject
  requestReportName.value = reportTitle
  isRequestModalOpen.value = true
}

// Fetch all active categories for the left sidebar navigation
const fetchSidebarCategories = async () => {
  try {
    const response = await axios.get('/api/categories-dropdown')
    if (response.data && response.data.length > 0) {
      sidebarCategories.value = response.data.map(cat => cat.name)
    }
  } catch (error) {
    console.error('Failed to fetch sidebar categories:', error)
  }
}

// Fetch single category info (banner image, main heading, subheadings)
const fetchCategoryInfo = async () => {
  try {
    const response = await axios.get(`/api/category/${categoryName.value}`)
    categoryInfo.value = response.data
  } catch (error) {
    console.error('Failed to fetch category details:', error)
    categoryInfo.value = {
      name: categoryName.value,
      main_heading: `${categoryName.value} Market Research and Insights`,
      main_subheading: null,
      category_image: null
    }
  }
}

// Fetch reports belonging to the active category
const fetchCategoryReports = async (page = 1) => {
  loadingReports.value = true
  currentPage.value = page
  try {
    const response = await axios.get('/api/reports-list', {
      params: {
        page: page,
        category: categoryName.value
      }
    })
    reports.value = response.data.data
    totalPages.value = response.data.last_page
  } catch (error) {
    console.error('Failed to fetch category reports:', error)
    reports.value = []
    totalPages.value = 1
  } finally {
    loadingReports.value = false
  }
}

const isCurrentCategory = (cat) => {
  return String(cat).toLowerCase() === String(categoryName.value).toLowerCase()
}

const changePage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    fetchCategoryReports(page)
    window.scrollTo({ top: 400, behavior: 'smooth' })
  }
}

const paginationRange = computed(() => {
  const current = currentPage.value
  const last = totalPages.value
  const range = []

  let start = Math.max(1, current - 1)
  let end = Math.min(last, start + 2)
  
  if (end - start < 2 && start > 1) {
    start = Math.max(1, end - 2)
  }

  for (let i = start; i <= end; i++) {
    range.push(i)
  }

  return range
})

// Initialize Page Data
const loadAllData = () => {
  fetchCategoryInfo()
  fetchCategoryReports(1)
}

onMounted(() => {
  fetchSidebarCategories()
  loadAllData()
})

// Watch for category param route changes to trigger visual updates
watch(categoryName, () => {
  loadAllData()
})
</script>

<style scoped>
.industry-category-page {
  color: #171717;
  background: #ffffff;
  font-family: "Inter", "Instrument Sans", "Segoe UI", sans-serif;
  min-height: 100vh;
}

/* Cover Image Hero Banner styling */
.category-hero-banner {
  position: relative;
  height: 280px;
  background-color: #074d9c; /* fallback color */
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: center;
  padding: 0 48px;
  overflow: hidden;
  box-shadow: inset 0 -4px 10px rgba(0, 0, 0, 0.05);
}

/* Beautiful dark blur overlay for premium contrast and readability */
.banner-overlay {
  position: absolute;
  inset: 0;

  backdrop-filter: blur(1px);
  z-index: 1;
}

.banner-content {
  position: relative;
  z-index: 2;
  color: #ffffff;
  max-width: 1060px;
  width: 100%;
  margin: 0 auto;
}

.breadcrumbs {
  font-size: 13px;
  font-weight: 500;
  color: rgba(255, 255, 255, 0.8);
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.breadcrumbs a {
  color: rgba(255, 255, 255, 0.8);
  text-decoration: none;
  transition: color 0.2s ease;
}

.breadcrumbs a:hover {
  color: #ffffff;
}

.separator {
  opacity: 0.6;
}

.current-crumb {
  color: #ffffff;
  font-weight: 700;
  text-transform: capitalize;
}

.category-banner-title {
  font-size: 38px;
  font-weight: 800;
  margin: 0;
  text-shadow: 0 2px 8px rgba(0,0,0,0.25);
  text-transform: capitalize;
}

/* Main Container Section */
.category-main-content {
  max-width: 1060px;
  margin: 0 auto;
  padding: 56px 24px 80px;
}

/* Category Intro Section */
.category-intro-section {
  margin-bottom: 48px;
}

.category-main-heading {
  font-size: 28px;
  font-weight: 800;
  color: #0d2847;
  margin: 0 0 18px;
  text-align: center;
  text-transform: capitalize;
}

.category-subheading-desc {
  font-size: 15.5px;
  line-height: 1.68;
  color: #4b5361;
  text-align: center;
  max-width: 900px;
  margin: 0 auto;
}

.category-subheading-desc :deep(p) {
  margin: 0 0 14px;
  color: inherit;
  font-size: inherit;
  line-height: inherit;
  text-align: inherit;
}

/* Two Column Layout */
.category-two-column-layout {
  display: grid;
  grid-template-columns: 280px 1fr;
  gap: 36px;
  align-items: start;
}

/* Sidebar Styling: Reports by Industry */
.category-sidebar {
  position: sticky;
  top: 24px;
}

.sidebar-card {
  background: #ffffff;
  border: 1px solid #eef2f7;
  border-radius: 16px;
  padding: 24px 20px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.02);
}

.sidebar-title {
  font-size: 16px;
  font-weight: 800;
  color: #111827;
  margin: 0 0 20px;
  padding-bottom: 10px;
  border-bottom: 1.5px solid #f3f4f6;
  text-align: left;
}

.sidebar-nav {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.sidebar-nav-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 14px;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 500;
  color: #4b5563;
  transition: all 0.2s ease-in-out;
  text-transform: capitalize;
  text-decoration: none;
}

.sidebar-nav-item:hover {
  background: #f4f9ff;
  color: #0783df;
  padding-left: 18px; /* micro shift */
}

/* Highlighted active state */
.active-sidebar-item {
  background: #eef6ff !important;
  color: #0783df !important;
  font-weight: 700;
  box-shadow: inset 3px 0 0 #0783df;
}

.chevron-arrow {
  font-size: 18px;
  font-weight: 300;
  line-height: 1;
  opacity: 0.6;
}

.active-sidebar-item .chevron-arrow {
  opacity: 1;
  transform: translateX(2px);
}

/* Reports Section Right Column */
.category-reports-list {
  display: flex;
  flex-direction: column;
  gap: 28px;
}

.loading-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px;
  color: #4b5563;
}

.spinner {
  border: 3.5px solid #f3f4f6;
  border-top: 3.5px solid #0783df;
  border-radius: 50%;
  width: 44px;
  height: 44px;
  animation: spin 1s linear infinite;
  margin-bottom: 16px;
}

/* Reports vertical cards styling */
.report-list-vertical {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.report-list-card {
  display: flex;
  background: #ffffff;
  border-radius: 18px;
  padding: 24px;
  gap: 28px;
  box-shadow: 0 4px 20px rgba(15, 23, 42, 0.02);
  border: 1px solid #eef2f7;
  align-items: center;
}

/* Premium Pure CSS 3D Mockup Book Cover */
.report-image-wrap {
  width: 140px;
  height: 180px;
  flex-shrink: 0;
}

.cover-link {
  display: block;
  width: 100%;
  height: 100%;
  text-decoration: none;
}

.mockup-book-cover {
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, #077cd1 0%, #004d9c 100%);
  border-radius: 3px 10px 10px 3px;
  box-shadow: 
    -5px 8px 18px rgba(0, 77, 156, 0.22),
    -1px 0 3px rgba(255, 255, 255, 0.3) inset,
    2px 0 5px rgba(0, 0, 0, 0.15);
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 18px 12px;
  color: #ffffff;
  overflow: hidden;
  transition: transform 0.25s ease;
}

.mockup-book-cover:hover {
  transform: translateY(-3px) rotate(-1deg);
}

.spine-crease {
  position: absolute;
  top: 0;
  left: 6px;
  width: 1.5px;
  height: 100%;
  background: rgba(255, 255, 255, 0.15);
  box-shadow: 1px 0 2px rgba(0, 0, 0, 0.25);
}

.cover-content {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.cover-super-title {
  font-size: 7.5px;
  font-weight: 800;
  letter-spacing: 1.5px;
  opacity: 0.75;
}

.cover-main-title {
  font-size: 11px;
  font-weight: 900;
  line-height: 1.35;
  text-transform: uppercase;
  margin: 0;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.cover-sub-title {
  font-size: 7px;
  opacity: 0.7;
}

.cover-badge {
  background: #ffffff;
  color: #004d9c;
  font-size: 7.5px;
  font-weight: 900;
  letter-spacing: 1px;
  padding: 3px 6px;
  border-radius: 4px;
  align-self: flex-start;
}

.report-details {
  flex: 1;
}

.report-title-link {
  text-decoration: none;
  color: #111827;
}

.hover-primary-title {
  font-size: 19px;
  font-weight: 800;
  line-height: 1.4;
  margin: 0 0 10px;
  transition: color 0.2s ease-in-out;
}

.hover-primary-title:hover {
  color: #0783df;
}

.report-description {
  color: #4f535b;
  font-size: 14.5px;
  line-height: 1.55;
  margin: 0 0 16px;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.report-metadata {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 13.5px;
  color: #6b7280;
  margin-bottom: 20px;
  text-transform: capitalize;
}

.report-metadata strong {
  color: #111827;
}

.divider {
  color: #d1d5db;
}

.report-actions {
  display: flex;
  gap: 14px;
}

.secondary-button.outlined {
  background: transparent;
  border: 1px solid #0783df;
  color: #0783df;
  padding: 8px 20px;
  border-radius: 30px;
  font-weight: 600;
  text-decoration: none;
  font-size: 13.5px;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
}

.secondary-button.outlined:hover {
  background: #f4f9ff;
}

.primary-button.small {
  background: #0783df;
  border: 1px solid #0783df;
  color: #ffffff;
  padding: 8px 20px;
  border-radius: 30px;
  font-weight: 600;
  text-decoration: none;
  font-size: 13.5px;
  transition: background 0.2s;
}

.primary-button.small:hover {
  background: #066ebb;
}

.no-results {
  text-align: center;
  padding: 48px;
  color: #6b7280;
  font-size: 15px;
  border: 1px dashed #e5e7eb;
  border-radius: 12px;
  background: #fcfcfc;
}

/* Pagination controls */
.pagination-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 16px;
  margin: 40px 0 10px;
}

.page-numbers {
  display: flex;
  gap: 8px;
  align-items: center;
}

.nav-btn {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 8px 18px;
  border-radius: 30px;
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s;
}

.prev-btn {
  background: #ffffff;
  border: 1px solid #e1e9f0;
  color: #8fa0b3;
}

.prev-btn:not(:disabled):hover {
  background: #f8fbff;
  color: #0783df;
  border-color: #0783df;
}

.next-btn {
  background: #0783df;
  border: 1px solid #0783df;
  color: #ffffff;
}

.next-btn:not(:disabled):hover {
  background: #066ebb;
}

.nav-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.num-btn {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  border: none;
  background: transparent;
  color: #4b5563;
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  display: grid;
  place-items: center;
  transition: all 0.2s;
}

.num-btn:hover {
  background: #f0f6fc;
  color: #0783df;
}

.num-btn.active {
  background: #0783df;
  color: #ffffff;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Responsive Scaling */
@media (max-width: 860px) {
  .category-two-column-layout {
    grid-template-columns: 1fr;
    gap: 30px;
  }
  
  .category-sidebar {
    position: static;
  }

  .report-list-card {
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
  }

  .report-image-wrap {
    align-self: center;
  }
}
</style>
