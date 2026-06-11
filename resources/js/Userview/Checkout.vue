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
            <!-- Card 1: Single User -->
            <div class="pricing-card" :class="{ 'selected': selectedLicense === 'single' }">
              <span class="discount-badge">Get 20% OFF</span>
              <div class="card-header-info">
                <h3>Single User License</h3>
                <div class="price-box">
                  <span class="original-price">${{ formatPrice(getOriginalPrice(report.single_user_license_cost || 1999)) }}</span>
                  <span class="discounted-price">${{ formatPrice(report.single_user_license_cost || 1999) }}</span>
                </div>
              </div>
              <p class="card-features-description">Access for one user within a single organization.</p>
              <ul class="features-list">
                <li><span class="check-icon-green">✓</span> PDF Report</li>
                <li><span class="check-icon-green">✓</span> Excel Data Pack</li>
                <li><span class="check-icon-green">✓</span> Instant Download</li>
                <li><span class="check-icon-green">✓</span> Analyst Support</li>
              </ul>
              <button class="pricing-action-btn" @click="selectLicense('single', report.single_user_license_cost || 1999)">
                Buy Now
                <span class="btn-circle-arrow">
                  <svg class="chevron-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <polyline points="9 18 15 12 9 6"/>
                  </svg>
                </span>
              </button>
            </div>

            <!-- Card 2: Team User (Highlighted middle card) -->
            <div class="pricing-card highlighted" :class="{ 'selected': selectedLicense === 'team' }">
              <span class="discount-badge">Get 20% OFF</span>
              <div class="card-header-info">
                <h3>Team User License</h3>
                <div class="price-box">
                  <span class="original-price">${{ formatPrice(getOriginalPrice(report.team_user_license_cost || 3999)) }}</span>
                  <span class="discounted-price">${{ formatPrice(report.team_user_license_cost || 3999) }}</span>
                </div>
              </div>
              <p class="card-features-description">Access for up to 5 users within a single organization.</p>
              <ul class="features-list">
                <li><span class="check-icon-green">✓</span> PDF Report</li>
                <li><span class="check-icon-green">✓</span> Excel Data Pack</li>
                <li><span class="check-icon-green">✓</span> Instant Download</li>
                <li><span class="check-icon-green">✓</span> Analyst Support</li>
              </ul>
              <button class="pricing-action-btn" @click="selectLicense('team', report.team_user_license_cost || 3999)">
                Buy Now
                <span class="btn-circle-arrow">
                  <svg class="chevron-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <polyline points="9 18 15 12 9 6"/>
                  </svg>
                </span>
              </button>
            </div>

            <!-- Card 3: Enterprise User -->
            <div class="pricing-card" :class="{ 'selected': selectedLicense === 'enterprise' }">
              <span class="discount-badge">Get 20% OFF</span>
              <div class="card-header-info">
                <h3>Enterprise License</h3>
                <div class="price-box">
                  <span class="original-price">${{ formatPrice(getOriginalPrice(report.enterprise_user_license_cost || 5999)) }}</span>
                  <span class="discounted-price">${{ formatPrice(report.enterprise_user_license_cost || 5999) }}</span>
                </div>
              </div>
              <p class="card-features-description">Unlimited access for all users within the global organization.</p>
              <ul class="features-list">
                <li><span class="check-icon-green">✓</span> PDF Report</li>
                <li><span class="check-icon-green">✓</span> Excel Data Pack</li>
                <li><span class="check-icon-green">✓</span> Instant Download</li>
                <li><span class="check-icon-green">✓</span> Analyst Support</li>
              </ul>
              <button class="pricing-action-btn" @click="selectLicense('enterprise', report.enterprise_user_license_cost || 5999)">
                Buy Now
                <span class="btn-circle-arrow">
                  <svg class="chevron-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <polyline points="9 18 15 12 9 6"/>
                  </svg>
                </span>
              </button>
            </div>
          </div>

          <!-- Checkout & PayPal Container -->
          <div class="payment-section-drawer" v-show="selectedLicense">
            <div class="payment-header">
              <h3>Complete Your Secure Purchase</h3>
              <p>You have selected: <strong>{{ getSelectedLicenseLabel() }}</strong> for <strong>${{ formatPrice(selectedPrice) }}</strong></p>
            </div>

            <!-- PayPal buttons container -->
            <div class="paypal-buttons-container-wrapper">
              <div id="paypal-button-container"></div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <SiteFooter />
  </div>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'

const route = useRoute()
const router = useRouter()

const report = ref(null)
const loading = ref(true)

const selectedLicense = ref(null)
const selectedPrice = ref(0)

const formatPrice = (val) => {
  if (!val) return '0'
  return String(val).replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}

const getOriginalPrice = (discountedPrice) => {
  return Math.ceil(discountedPrice / 0.8)
}

const getSelectedLicenseLabel = () => {
  if (selectedLicense.value === 'single') return 'Single User License'
  if (selectedLicense.value === 'team') return 'Team User License'
  if (selectedLicense.value === 'enterprise') return 'Enterprise License'
  return ''
}

const fetchReportDetails = async (slug) => {
  loading.value = true
  try {
    const response = await axios.get(`/api/report/${slug}`)
    if (response.data) {
      report.value = response.data
    }
  } catch (error) {
    console.error('Failed to fetch report details for checkout:', error)
    report.value = null
  } finally {
    loading.value = false
  }
}

const selectLicense = (licenseType, price) => {
  selectedLicense.value = licenseType
  selectedPrice.value = price

  nextTick(() => {
    // Scroll to payment panel
    const paymentDrawer = document.querySelector('.payment-section-drawer')
    if (paymentDrawer) {
      paymentDrawer.scrollIntoView({ behavior: 'smooth', block: 'start' })
    }
    // Load and render PayPal buttons
    initPaypalButtons(price)
  })
}

// PayPal integration
const initPaypalButtons = (priceValue) => {
  const container = document.getElementById('paypal-button-container')
  if (container) {
    container.innerHTML = ''
  }

  if (window.paypal) {
    try {
      window.paypal.Buttons({
        style: {
          layout: 'vertical',
          color:  'gold',
          shape:  'rect',
          label:  'paypal'
        },
        createOrder: async (data, actions) => {
          try {
            const response = await axios.post('/paypal/create-order', {
              amount: priceValue
            })
            // return order ID
            return response.data.id
          } catch (err) {
            console.error('Failed to create order:', err)
            alert('Unable to initiate transaction. Please try again.')
            throw err
          }
        },
        onApprove: async (data, actions) => {
          try {
            const response = await axios.post(`/paypal/capture-order/${data.orderID}`)
            if (response.data.status === 'COMPLETED') {
              router.push('/thank-you')
            } else {
              alert('Transaction was not completed. Status: ' + response.data.status)
            }
          } catch (err) {
            console.error('Payment capture failed:', err)
            alert('Payment capturing failed. Please contact support.')
          }
        },
        onError: (err) => {
          console.error('PayPal button error:', err)
          alert('An error occurred during payment processing. Please try again.')
        }
      }).render('#paypal-button-container')
    } catch (e) {
      console.error('Error rendering PayPal buttons:', e)
    }
  } else {
    console.error('PayPal SDK not loaded yet.')
  }
}

const loadPaypalScript = () => {
  if (!document.getElementById('paypal-sdk-script')) {
    const script = document.createElement('script')
    script.id = 'paypal-sdk-script'
    script.src = 'https://www.paypal.com/sdk/js?client-id=ARkkAvbBwbuoyR0QCKhM3dX3wKQsxKNHn00aHGq5agif3JFjpwqsWsKhfGP-gRSfPFpjMynEBxbnSaov&currency=USD'
    script.async = true
    script.defer = true
    document.head.appendChild(script)
  }
}

onMounted(() => {
  if (route.params.slug) {
    fetchReportDetails(route.params.slug)
  }
  loadPaypalScript()
})
</script>

<style src="./style.css"></style>
<style src="./checkoutStyle.css"></style>
