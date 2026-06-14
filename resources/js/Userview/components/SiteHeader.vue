<template>
<header class="site-header">
      <a class="brand" href="#" aria-label="Epignosis Insights home">
        <img :src="'/assets/images/logo.png'" alt="Epignosis Insights Logo" class="brand-logo" />
      </a>

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
            <router-link 
              v-for="cat in industryCategories" 
              :key="cat" 
              :to="`/industry/${cat}`"
            >
              {{ cat }}
            </router-link>
          </div>
        </div>
        <router-link to="/blogs">Blog</router-link>
        <router-link to="/press-releases">Press Release</router-link>
      </nav>

      <div class="header-actions">
        <div class="top-banner">
          <router-link to="/about">About Us</router-link>
          <div class="dropdown-menu-container">
            <router-link to="/services" class="dropdown-trigger">
              Service
              
            </router-link>
          
          </div>
          <router-link to="/contact">Contact</router-link>
        </div>

        <div class="bottom-actions">
          <label class="header-search">
            <input type="search" placeholder="Search Report" />
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <circle cx="11" cy="11" r="7"></circle>
              <path d="m20 20-3.5-3.5"></path>
            </svg>
          </label>
          <a class="call-button" href="tel:+916292226351">
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.35 1.9.66 2.8a2 2 0 0 1-.45 2.11L8.05 9.9a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.31 1.84.53 2.8.66A2 2 0 0 1 22 16.92Z"></path>
            </svg>
            Call Now
          </a>
        </div>
      </div>
    </header>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const industryCategories = ref([])

onMounted(async () => {
  try {
    const response = await axios.get('/api/categories-dropdown')
    if (response.data && response.data.length > 0) {
      industryCategories.value = response.data.map(cat => cat.name)
    }
  } catch (error) {
    console.error('Failed to fetch categories for header dropdown', error)
  }
})
</script>

