<template>
  <header class="site-header">
    <router-link class="brand" to="/" aria-label="Epignosis Insights home">
      <img :src="$assetUrl + '/assets/images/logo.png'" alt="Epignosis Insights Logo" class="brand-logo" />
    </router-link>

    <nav class="main-nav" aria-label="Main navigation">
      <router-link to="/">Home</router-link>
      <router-link to="/reports">Reports</router-link>
      <div class="dropdown-menu-container">
        <a href="#" class="dropdown-trigger" @click.prevent>
          Industry
          <svg class="chevron-icon" viewBox="0 0 24 24" aria-hidden="true">
            <path d="m6 9 6 6 6-6"></path>
          </svg>
        </a>
        <div class="dropdown-menu dropdown-left-align">
          <router-link v-for="cat in industryCategories" :key="cat.slug_url" :to="`/industry/${cat.slug_url}`">
            {{ cat.name }}
          </router-link>
        </div>
      </div>
      <router-link to="/blogs">Blog</router-link>
      <router-link to="/press-releases">Press Release</router-link>
    </nav>

    <div class="header-actions">
      <div class="top-banner">
        <router-link to="/about-us">About Us</router-link>
        <div class="dropdown-menu-container">
          <router-link to="/services" class="dropdown-trigger">
            Service

          </router-link>

        </div>
        <router-link to="/contact-us">Contact</router-link>
      </div>

      <div class="bottom-actions">
        <div class="header-search-container">
          <label class="header-search" :class="{ 'search-active': isDropdownOpen }">
            <input type="search" placeholder="Search Report" v-model="searchQuery" @input="handleSearch"
              @focus="showDropdown" @blur="hideDropdownDelayed" @keydown.enter="submitSearch" />
            <svg viewBox="0 0 24 24" aria-hidden="true" @click="submitSearch" class="cursor-pointer">
              <circle cx="11" cy="11" r="7"></circle>
              <path d="m20 20-3.5-3.5"></path>
            </svg>
          </label>

          <div
            v-if="isDropdownOpen && (searchResults.length > 0 || isSearching || (searchQuery && searchQuery.length > 1))"
            class="search-dropdown-menu">
            <div v-if="isSearching" class="search-status">Searching for results...</div>
            <div v-else-if="searchResults.length === 0 && searchQuery.length > 1" class="search-status">No reports found
              for "{{ searchQuery }}".</div>
            <div v-else class="search-results-list">
              <router-link v-for="report in searchResults" :key="report.id" :to="'/report/' + report.slug_url"
                class="search-result-item" @mousedown="forceNavigate('/report/' + report.slug_url)">
                <div class="search-icon">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                  </svg>
                </div>
                <div class="search-content">
                  <h4>{{ report.title }}</h4>
                </div>
              </router-link>
              <router-link :to="'/reports?search=' + encodeURIComponent(searchQuery)" class="view-all-link"
                @mousedown="forceNavigate('/reports?search=' + encodeURIComponent(searchQuery))">
                View all results
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
              </router-link>
            </div>
          </div>
        </div>
        <a class="call-button" href="tel:+919370941234">
          <svg viewBox="0 0 24 24" aria-hidden="true">
            <path
              d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.35 1.9.66 2.8a2 2 0 0 1-.45 2.11L8.05 9.9a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.31 1.84.53 2.8.66A2 2 0 0 1 22 16.92Z">
            </path>
          </svg>
          Call Now
        </a>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const industryCategories = ref([])
const searchQuery = ref('')
const searchResults = ref([])
const isSearching = ref(false)
const isDropdownOpen = ref(false)
let searchTimeout = null

const submitSearch = () => {
  if (searchQuery.value && searchQuery.value.trim().length > 1) {
    isDropdownOpen.value = false;
    router.push('/reports?search=' + encodeURIComponent(searchQuery.value.trim()))
  }
}

const showDropdown = () => {
  if (searchQuery.value && searchQuery.value.trim().length > 1) {
    isDropdownOpen.value = true;
  }
}

const hideDropdownDelayed = () => {
  // Delay hiding so clicks on dropdown items can register
  setTimeout(() => {
    isDropdownOpen.value = false;
  }, 200);
}

const forceNavigate = (url) => {
  isDropdownOpen.value = false;
  router.push(url);
}

const handleSearch = () => {
  if (!searchQuery.value || searchQuery.value.trim().length < 2) {
    searchResults.value = [];
    isDropdownOpen.value = false;
    isSearching.value = false;
    return;
  }

  isDropdownOpen.value = true;
  isSearching.value = true;

  if (searchTimeout) {
    clearTimeout(searchTimeout);
  }

  searchTimeout = setTimeout(async () => {
    try {
      const response = await axios.get('/api/search-predictive', {
        params: { query: searchQuery.value.trim() }
      });
      searchResults.value = response.data || [];
    } catch (error) {
      console.error('Predictive search failed', error);
      searchResults.value = [];
    } finally {
      isSearching.value = false;
    }
  }, 300); // 300ms debounce
}

onMounted(async () => {
  try {
    const response = await axios.get('/api/categories-dropdown')
    if (response.data && response.data.length > 0) {
      industryCategories.value = response.data.map(cat => ({
        name: cat.name,
        slug_url: cat.slug_url || cat.name
      }))
    }
  } catch (error) {
    console.error('Failed to fetch categories for header dropdown', error)
  }
})
</script>

<style scoped>
.header-search-container {
  position: relative;
  max-width: 300px;
  width: 100%;
}

.header-search.search-active {
  border-color: #3b82f6;
  box-shadow: 0 0 0 1px #3b82f6;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}

.search-dropdown-menu {
  position: absolute;
  top: 100%;
  right: 0;
  width: 130%;
  background: #ffffff;
  border: 1px solid #e5e7eb;
  border-top: none;
  border-radius: 0 0 12px 12px;
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
  z-index: 100;
  overflow: hidden;
  animation: slideDown 0.2s ease-out;
}

.search-status {
  padding: 16px;
  text-align: center;
  color: #6b7280;
  font-size: 14px;
  background: #f9fafb;
}

.search-results-list {
  display: flex;
  flex-direction: column;
}

.search-result-item {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  padding: 12px 16px;
  border-bottom: 1px solid #f3f4f6;
  color: inherit;
  text-decoration: none;
  transition: background-color 0.15s ease;
}

.search-result-item:hover {
  background-color: #f8fafc;
}

.search-icon {
  flex-shrink: 0;
  width: 36px;
  height: 42px;
  background: #eff6ff;
  color: #3b82f6;
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.search-content h4 {
  margin: 0;
  font-size: 13px;
  font-weight: 500;
  color: #1f2937;
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-align: left;
}

.view-all-link {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 12px;
  background: #f8fafc;
  color: #2563eb;
  font-weight: 600;
  font-size: 13px;
  text-decoration: none;
  transition: all 0.2s;
}

.view-all-link:hover {
  background: #eff6ff;
  color: #1d4ed8;
}

.view-all-link svg {
  width: 16px;
  height: 16px;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
