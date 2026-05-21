const fs = require('fs');
const path = require('path');

const srcDir = path.join(__dirname, 'resources', 'js', 'Userview');
const componentsDir = path.join(srcDir, 'components');

if (!fs.existsSync(componentsDir)) {
    fs.mkdirSync(componentsDir, { recursive: true });
}

const reportsPath = path.join(srcDir, 'Reports.vue');
const content = fs.readFileSync(reportsPath, 'utf8');

// 1. Extract CSS
const styleMatch = content.match(/<style scoped>([\s\S]*)<\/style>/);
if (styleMatch) {
    fs.writeFileSync(path.join(srcDir, 'reportsStyle.css'), styleMatch[1].trim());
}

// 2. Extract JS Logic to useReportsData.js
const jsLogic = `import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

export function useReportsData() {
  const categories = ref(['All'])
  const selectedCategory = ref('All')
  const searchQuery = ref('')
  const reports = ref([])
  const loading = ref(false)
  const currentPage = ref(1)
  const totalPages = ref(1)

  const fetchCategories = async () => {
    try {
      const response = await axios.get('/admin/report-categories-dropdown')
      if (response.data && response.data.length > 0) {
        categories.value = ['All', ...response.data.map(cat => cat.name)]
      }
    } catch (error) {
      console.error('Failed to fetch categories', error)
    }
  }

  const fetchReports = async (page) => {
    loading.value = true
    currentPage.value = page
    try {
      const response = await axios.get('/api/reports-list', {
        params: {
          page: page,
          category: selectedCategory.value,
          search: searchQuery.value
        }
      })
      
      reports.value = response.data.data
      totalPages.value = response.data.last_page
    } catch (error) {
      console.error('Failed to fetch reports', error)
    } finally {
      loading.value = false
    }
  }

  onMounted(() => {
    fetchCategories()
    fetchReports(1)
  })

  const paginationRange = computed(() => {
    const current = currentPage.value;
    const last = totalPages.value;
    const range = [];

    let start = Math.max(1, current - 1);
    let end = Math.min(last, start + 2);
    
    if (end - start < 2 && start > 1) {
      start = Math.max(1, end - 2);
    }

    for (let i = start; i <= end; i++) {
      range.push(i);
    }

    return range;
  });

  return {
    categories,
    selectedCategory,
    searchQuery,
    reports,
    loading,
    currentPage,
    totalPages,
    fetchReports,
    paginationRange
  }
}`;
fs.writeFileSync(path.join(srcDir, 'useReportsData.js'), jsLogic);

// 3. Components
const templates = {
    ReportsHeroSection: `
<template>
  <section class="reports-hero">
    <div class="hero-content">
      <h1>Explore Market<br>Research Reports</h1>
      <p>Access in-depth analysis, market trends, and growth forecasts to stay ahead of the curve.</p>
    </div>
  </section>
</template>
`,
    ReportsFilterBar: `
<template>
  <div class="filter-bar">
    <div class="search-input-group">
      <input type="text" :value="searchQuery" @input="$emit('update:searchQuery', $event.target.value)" placeholder="Search Report by Title or Keyword" @keyup.enter="$emit('search')" />
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="icon input-icon" aria-hidden="true">
        <circle cx="11" cy="11" r="8"></circle>
        <path d="m21 21-4.3-4.3" stroke-linecap="round" stroke-linejoin="round"></path>
      </svg>
    </div>
    
    <div class="category-select-group">
      <select :value="selectedCategory" @change="$emit('update:selectedCategory', $event.target.value); $emit('search')">
        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
      </select>
    </div>
    
    <button class="primary-button" @click="$emit('search')">Find Report</button>
  </div>
</template>

<script setup>
defineProps({
  searchQuery: String,
  selectedCategory: String,
  categories: Array
})
defineEmits(['update:searchQuery', 'update:selectedCategory', 'search'])
</script>
`,
    ReportList: `
<template>
  <div v-if="loading" class="loading-state">
    Loading reports...
  </div>
  <div v-else class="report-list-vertical">
    <article v-for="report in reports" :key="report.id" class="report-list-card">
      <div class="report-image-wrap">
        <img :src="report.image" :alt="report.title" />
      </div>
      <div class="report-details">
        <h3>{{ report.title }}</h3>
        <p>{{ report.description }}</p>
        <div class="report-metadata">
          <span>Pages: <strong>{{ report.pages }}</strong></span>
          <span class="divider">|</span>
          <span>Format: <strong>{{ report.format }}</strong></span>
          <span class="divider">|</span>
          <span>Publish Date: <strong>{{ report.date }}</strong></span>
        </div>
        <div class="report-actions">
          <a :href="\`/request-sample/\${report.slug}\`" class="secondary-button outlined">Request Sample</a>
          <a :href="\`/buy/\${report.slug}\`" class="primary-button small">Buy Now</a>
        </div>
      </div>
    </article>
    
    <div v-if="reports.length === 0" class="no-results">
      No reports found for your search criteria.
    </div>
  </div>
</template>

<script setup>
defineProps({
  reports: Array,
  loading: Boolean
})
</script>
`,
    ReportPagination: `
<template>
  <div v-if="totalPages > 0" class="pagination-wrapper">
    <button class="nav-btn prev-btn" :disabled="currentPage === 1" @click="$emit('page-change', currentPage - 1)">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="nav-icon"><path d="m15 18-6-6 6-6"/></svg>
      Previous
    </button>
    
    <div class="page-numbers">
      <template v-for="(page, index) in paginationRange" :key="index">
        <span v-if="page === '...'" class="pagination-dots">...</span>
        <button 
          v-else
          class="num-btn"
          :class="{ active: currentPage === page }"
          @click="$emit('page-change', page)"
        >
          {{ page }}
        </button>
      </template>
    </div>

    <button class="nav-btn next-btn" :disabled="currentPage === totalPages" @click="$emit('page-change', currentPage + 1)">
      Next
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="nav-icon"><path d="m9 18 6-6-6-6"/></svg>
    </button>
  </div>
</template>

<script setup>
defineProps({
  currentPage: Number,
  totalPages: Number,
  paginationRange: Array
})
defineEmits(['page-change'])
</script>
`,
    CustomResearchCTA: `
<template>
  <section class="custom-research-cta section-shell">
    <div class="cta-inner">
      <div class="cta-bg-shapes">
        <div class="arc left-arc"></div>
        <div class="arc right-arc"></div>
      </div>
      <div class="cta-content">
        <h2>Looking for Custom<br>Market Research?</h2>
        <p>Connect with our analysts for tailored research to answer your specific strategic questions and overcome challenges.</p>
        <a href="#contact" class="primary-button cta-btn">
          Request Custom Research
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="icon" aria-hidden="true">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M12 16v-4" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M12 8h.01" stroke-linecap="round" stroke-linejoin="round"></path>
          </svg>
        </a>
      </div>
    </div>
  </section>
</template>
`
}

for (const [name, tmpl] of Object.entries(templates)) {
    fs.writeFileSync(path.join(componentsDir, name + '.vue'), tmpl.trim() + '\\n');
}

// 4. Reconstruct Reports.vue
const mainVue = `
<template>
  <div class="reports-page">
    <SiteHeader />

    <main class="reports-main">
      <ReportsHeroSection />

      <section class="reports-content section-shell">
        <ReportsFilterBar 
          v-model:searchQuery="searchQuery" 
          v-model:selectedCategory="selectedCategory" 
          :categories="categories"
          @search="fetchReports(1)"
        />

        <ReportList :reports="reports" :loading="loading" />

        <ReportPagination 
          :currentPage="currentPage" 
          :totalPages="totalPages" 
          :paginationRange="paginationRange"
          @page-change="fetchReports"
        />
      </section>

      <CustomResearchCTA />
    </main>

    <SiteFooter />
  </div>
</template>

<script setup>
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'
import ReportsHeroSection from './components/ReportsHeroSection.vue'
import ReportsFilterBar from './components/ReportsFilterBar.vue'
import ReportList from './components/ReportList.vue'
import ReportPagination from './components/ReportPagination.vue'
import CustomResearchCTA from './components/CustomResearchCTA.vue'
import { useReportsData } from './useReportsData'

const {
  categories,
  selectedCategory,
  searchQuery,
  reports,
  loading,
  currentPage,
  totalPages,
  fetchReports,
  paginationRange
} = useReportsData()
</script>

<style src="./style.css"></style>
<style src="./reportsStyle.css"></style>
`.trim();

fs.writeFileSync(reportsPath, mainVue + '\\n');

console.log("Refactoring complete");
