<template>
  <div class="checkout-page">
    <SiteHeader />

    <main class="checkout-main">
      <div class="section-shell">
        <div v-if="loading" class="checkout-loading">
          <div class="spinner"></div>
          <p>Loading pricing options...</p>
        </div>

        <div v-else-if="!report" class="checkout-empty">
          <p>Report details not found. Please go back and select a report.</p>
        </div>

        <div v-else class="checkout-content">
          <!-- Page Header -->
          <div class="checkout-header">
            <h1>Explore Our Pricing Plans</h1>
            <p>Access detailed market insights, growth forecasts, competitive analysis, and strategic industry intelligence.</p>
          </div>

          <!-- Report Details Summary Block -->
          <div class="checkout-report-summary">
            <div class="summary-details">
              <h2>{{ report.title }}</h2>
              <div class="summary-meta">
                <span>Report ID: <strong>{{ report.report_sku }}</strong></span>
                <span>Format: <strong>{{ report.format }}</strong></span>
                <span>Publish Date: <strong>{{ report.date }}</strong></span>
              </div>
            </div>
          </div>

          <!-- Pricing Grid -->
          <div class="pricing-grid">
            <div v-for="(plan, index) in pricings" :key="plan.id" class="pricing-card" :class="{ 'selected': selectedLicense === plan.id, 'highlighted': index === 1 }">
              <div class="card-header-info">
                <h3>{{ plan.title }}</h3>
                <div class="price-box">
                  <span class="original-price" v-if="plan.discount_cost">${{ formatPrice(plan.discount_cost) }}</span>
                  <span class="original-price" v-else>${{ formatPrice(getOriginalPrice(plan.cost)) }}</span>
                  <span class="discounted-price">${{ formatPrice(plan.cost) }}</span>
                </div>
              </div>
              <p class="card-features-description">Access targeted market research matching your needs.</p>
              <ul class="features-list">
                <li v-for="(feature, fIndex) in parseDetails(plan.details)" :key="'f'+fIndex"><span class="check-icon-green">✓</span> {{ feature }}</li>
              </ul>
              <button class="pricing-action-btn" @click="selectLicense(plan.id)">
                Buy Now
                <span class="btn-circle-arrow">
                  <svg class="chevron-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <polyline points="9 18 15 12 9 6"/>
                  </svg>
                </span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </main>

    <SiteFooter />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'

const route = useRoute()
const router = useRouter()

const report = ref(null)
const pricings = ref([])
const loading = ref(true)

const selectedLicense = ref(null)

const formatPrice = (val) => {
  if (!val) return '0'
  return String(val).replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}

const getOriginalPrice = (discountedPrice) => {
  return Math.ceil(discountedPrice / 0.8)
}

const parseDetails = (detailsString) => {
  if (!detailsString) return [];
  return detailsString.split('\n').filter(line => line.trim() !== '');
}

const fetchReportDetails = async (slug) => {
  loading.value = true
  try {
    const response = await axios.get(`/api/report/${slug}`)
    if (response.data) {
      report.value = response.data
    }
    const pricingRes = await axios.get('/api/pricings-active')
    pricings.value = pricingRes.data
  } catch (error) {
    console.error('Failed to fetch report or pricings:', error)
    report.value = null
  } finally {
    loading.value = false
  }
}

const selectLicense = (licenseType) => {
  selectedLicense.value = licenseType
  const encryptedId = btoa(licenseType.toString())
  router.push({ path: `/purchase/${route.params.slug}`, query: { ref: encryptedId } })
}

onMounted(() => {
  if (route.params.slug) {
    fetchReportDetails(route.params.slug)
  }
})
</script>

<style src="./style.css"></style>
<style src="./checkoutStyle.css"></style>
