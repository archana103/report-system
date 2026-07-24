<template>
  <div class="checkout-page">
    <SiteHeader />

    <div v-if="loading" style="text-align: center; padding: 100px 0;">
      <div class="spinner"></div>
      <p>Loading your purchase details...</p>
    </div>
    
    <div v-else>
      <!-- Hero Banner for Checkout Form -->
      <header class="checkout-hero-banner">
        <div class="breadcrumb-nav">
          <router-link to="/" class="breadcrumb-link home-link">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            Home
          </router-link> 
          <span class="sep"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></span> 
          <router-link to="/reports" class="breadcrumb-link">Reports</router-link> 
          
          <template v-if="report && report.category">
            <span class="sep"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></span> 
            <router-link :to="`/industry/${generateSlug(report.category)}`" class="breadcrumb-link">{{ report.category.name || report.category }}</router-link>
          </template>

          <template v-if="report">
            <span class="sep"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></span> 
            <router-link :to="`/report/${report.slug_url || route.params.slug}`" class="breadcrumb-link truncate-title" :title="report.title">
              {{ report.breadcrumb_title || report.title }}
            </router-link>
          </template>

          <span class="sep"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></span> 
          <span class="current-page">Purchase Report</span>
        </div>
        <div class="checkout-hero-content">
          <h1><span class="text-blue">Purchase</span> Market Research Report</h1>
          <p>Complete the form below to purchase your selected market research report. Choose the license that best fits your business needs and enjoy secure payment, instant confirmation, and dedicated analyst support.</p>
        </div>
      </header>

    <main class="checkout-main pt-0">
      <div class="section-shell" style="margin-top: 30px;">
        <div class="checkout-two-columns">
          <!-- Left Column (Form) -->
          <div class="">
            <div class="form-header">
              <h2>Complete Your Purchase</h2>
              <p>Provide your business details to securely purchase the report. Our team will process your order and
                deliver your report promptly.</p>
            </div>

            <form @submit.prevent="submitPurchase" class="purchase-form">
              <div class="form-grid-2">
                <div class="input-group">
                  <label>Full Name <span class="text-red-600">*</span></label>
                  <input type="text" v-model="form.full_name" placeholder="Enter Your Full Name" required />
                </div>
                <div class="input-group">
                  <label>Business Email <span class="text-red-600">*</span></label>
                  <input type="email" v-model="form.business_email" placeholder="Enter Your Business Email" required />
                </div>
                <div class="input-group">
                  <label>Phone Number <span class="text-red-600">*</span></label>
                  <input type="tel" ref="phoneInputRef" placeholder="Enter Phone Number" required />
                </div>
                <div class="input-group">
                  <label>Company Name <span class="text-red-600">*</span></label>
                  <input type="text" v-model="form.company_name" placeholder="Enter Company Name" required />
                </div>
                <div class="input-group">
                  <label>Country <span class="text-red-600">*</span></label>
                  <select v-model="form.country" required>
                    <option value="" disabled>Select Your Country</option>
                    <option v-for="country in countriesList" :key="country" :value="country">{{ country }}</option>
                  </select>
                </div>
                <div class="input-group">
                  <label>License Type <span class="text-red-600">*</span></label>
                  <select v-model="form.pricing_id" required>
                    <option value="" disabled>Select License Type</option>
                    <option v-for="plan in pricings" :key="plan.id" :value="plan.id">
                      {{ plan.title }} - ${{ formatPrice(plan.cost) }}
                    </option>
                  </select>
                </div>
              </div>

              <!-- Payment Options -->
              <div class="secure-payment-section">
                <h4>Secure Payment Options:</h4>
                <p>We support secure online payments through trusted global payment providers.</p>
                <div class="payment-methods-grid">
                  <label class="payment-method-card" :class="{ 'active': paymentMethod === 'visa' }">
                    <input type="radio" v-model="paymentMethod" value="visa" name="payment" />
                    <div class="payment-method-header">
                      <span class="radio-custom"></span>
                      <span class="payment-name">Visa</span>
                    </div>
                    <img
                      src="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/payment_images/visa.png"
                      alt="Visa" class="w-12 mt-auto" />
                  </label>
                  <label class="payment-method-card" :class="{ 'active': paymentMethod === 'amex' }">
                    <input type="radio" v-model="paymentMethod" value="amex" name="payment" />
                    <div class="payment-method-header">
                      <span class="radio-custom"></span>
                      <span class="payment-name">American Express</span>
                    </div>
                    <img
                      src="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/payment_images/american_express.png"
                      alt="AMEX" class="mt-auto" style="width: 51%;height: 19px;" />
                  </label>
                  <label class="payment-method-card" :class="{ 'active': paymentMethod === 'paypal' }">
                    <input type="radio" v-model="paymentMethod" value="paypal" name="payment" />
                    <div class="payment-method-header">
                      <span class="radio-custom"></span>
                      <span class="payment-name">PayPal</span>
                    </div>
                    <img
                      src="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/payment_images/paypal.png"
                      alt="PayPal" class=" mt-auto" style="width: 51%;height: 19px;" />
                  </label>
                  <label class="payment-method-card" :class="{ 'active': paymentMethod === 'mastercard' }">
                    <input type="radio" v-model="paymentMethod" value="mastercard" name="payment" />
                    <div class="payment-method-header">
                      <span class="radio-custom"></span>
                      <span class="payment-name">Mastercard</span>
                    </div>
                    <img
                      src="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/payment_images/mastercard.png"
                      alt="Mastercard" class="mt-auto" style="width: 51%;height: 19px;" />
                  </label>
                </div>
              </div>

              <button type="submit" class="buy-now-submit-btn" :disabled="isSubmitting">
                {{ isSubmitting ? 'Processing...' : 'BUY NOW' }}
              </button>
            </form>
          </div>

          <!-- Right Column (Info) -->
          <aside class="checkout-sidebar">
            <div class="included-card">
              <h3>What's Included</h3>
              <p>See What's Included with Your Purchase</p>
              <ul class="included-list">
                <li v-for="(feature, index) in selectedFeatures" :key="'f'+index">
                  <span class="green-check">✔</span> {{ feature }}
                </li>
              </ul>
            </div>

            <div class="help-card">
              <h3>Need Help Choosing<br />the Right License?</h3>
              <p>Need guidance before buying? We're here for you.</p>
              <div class="help-contact">
                <span><strong>Email:</strong> sales@epignosisinsights.co</span>
                <span><strong>Phone:</strong> +91 9370941234</span>
              </div>
              <router-link to="/contact-us" class="contact-support-btn">Contact Support</router-link>
            </div>
          </aside>
        </div>
      </div>
    </main>
    </div>

    <SiteFooter />
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick, watch, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import axios from 'axios'
import intlTelInput from 'intl-tel-input/intlTelInputWithUtils'
import 'intl-tel-input/styles'
import SiteHeader from './SiteHeader.vue'
import SiteFooter from './SiteFooter.vue'

const router = useRouter()
const route = useRoute()

const report = ref(null)
const pricings = ref([])
const loading = ref(true)

const isSubmitting = ref(false)
const paymentMethod = ref('visa')
const phoneInputRef = ref(null)
let itiInstance = null

const getInitialPricingId = () => {
  try {
    if (route.query.ref) return Number(atob(route.query.ref))
    if (route.query.pricing_id) return Number(route.query.pricing_id)
  } catch (e) {
    console.error('Failed to parse pricing ref')
  }
  return ''
}

const form = ref({
  full_name: '',
  business_email: '',
  phone_number: '',
  company_name: '',
  country: '',
  pricing_id: getInitialPricingId()
})

const selectedFeatures = computed(() => {
  const plan = pricings.value.find(p => p.id === form.value.pricing_id)
  if (!plan || !plan.details) return []
  return plan.details.split('\n').filter(line => line.trim() !== '')
})

const countriesList = [
  'Afghanistan', 'Albania', 'Algeria', 'American Samoa', 'Andorra',
  'Angola', 'Anguilla', 'Antarctica', 'Antigua and Barbuda', 'Argentina',
  'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas',
  'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize',
  'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina',
  'Botswana', 'Brazil', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi',
  'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Cayman Islands',
  'Central African Republic', 'Chad', 'Chile', 'China', 'Colombia',
  'Comoros', 'Congo', 'Costa Rica', 'Croatia', 'Cuba', 'Cyprus',
  'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic',
  'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea',
  'Estonia', 'Ethiopia', 'Fiji', 'Finland', 'France', 'Gabon', 'Gambia',
  'Georgia', 'Germany', 'Ghana', 'Greece', 'Grenada', 'Guatemala',
  'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Honduras', 'Hong Kong',
  'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland',
  'Israel', 'Italy', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya',
  'Kiribati', 'Kosovo', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia',
  'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania',
  'Luxembourg', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives',
  'Mali', 'Malta', 'Marshall Islands', 'Mauritania', 'Mauritius', 'Mexico',
  'Micronesia', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Morocco',
  'Mozambique', 'Myanmar', 'Namibia', 'Nauru', 'Nepal', 'Netherlands',
  'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'North Korea', 'Norway',
  'Oman', 'Pakistan', 'Palau', 'Palestine', 'Panama', 'Papua New Guinea',
  'Paraguay', 'Peru', 'Philippines', 'Poland', 'Portugal', 'Qatar',
  'Romania', 'Russia', 'Rwanda', 'Saint Kitts and Nevis', 'Saint Lucia',
  'Samoa', 'San Marino', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles',
  'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands',
  'Somalia', 'South Africa', 'South Korea', 'South Sudan', 'Spain',
  'Sri Lanka', 'Sudan', 'Suriname', 'Sweden', 'Switzerland', 'Syria',
  'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 'Tonga',
  'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Tuvalu',
  'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom',
  'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City',
  'Venezuela', 'Vietnam', 'Yemen', 'Zambia', 'Zimbabwe'
]

const formatPrice = (val) => {
  if (!val) return '0'
  return String(val).replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}

const generateSlug = (category) => {
  if (!category) return ''
  const name = typeof category === 'string' ? category : (category.name || '')
  return name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '')
}

onMounted(async () => {
  loading.value = true
  try {
    const slug = route.params.slug
    const [reportRes, pricingsRes] = await Promise.all([
      axios.get(`/api/report/${slug}`),
      axios.get('/api/pricings-active')
    ])
    if (reportRes.data) {
      report.value = reportRes.data
    }
    if (pricingsRes.data) {
      pricings.value = pricingsRes.data
    }
  } catch (error) {
    console.error('Failed to fetch data', error)
  } finally {
    loading.value = false
  }

  await nextTick()
  if (phoneInputRef.value) {
    itiInstance = intlTelInput(phoneInputRef.value, {
      initialCountry: 'in',
      preferredCountries: ['in', 'us'],
      separateDialCode: true,
      formatOnDisplay: true,
      autoPlaceholder: 'aggressive',
    })
  }
})

onUnmounted(() => {
  if (itiInstance) {
    itiInstance.destroy()
    itiInstance = null
  }
})

watch(() => route.query.ref, (newVal) => {
  if (newVal) {
    try {
      form.value.pricing_id = Number(atob(newVal))
    } catch (e) {}
  }
})

watch(() => route.query.pricing_id, (newVal) => {
  if (newVal) {
    form.value.pricing_id = Number(newVal)
  }
})

const submitPurchase = async () => {
  if (!form.value.pricing_id) {
    alert("Please select a license type.")
    return
  }

  if (itiInstance) {
    form.value.phone_number = itiInstance.getNumber()
  }

  isSubmitting.value = true
  try {
    const payload = {
      ...form.value,
      report_detail_id: report.value ? report.value.id : null
    }

    const res = await axios.post('/api/checkout/purchase', payload)

    alert("Purchase request received! A representative will contact you shortly to complete payment processing.")
    router.push('/thank-you')
  } catch (err) {
    console.error(err)
    alert("Failed to submit purchase details. Please check your information and try again.")
  } finally {
    isSubmitting.value = false
  }
}
</script>

<style scoped>
/* Hero Banner */
.checkout-hero-banner {
  background: url('https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/background-image/pricing_pagebanner.png') center center;
  background-size: cover;
  padding: 40px 24px 66px;
  text-align: center;
  position: relative;
  overflow: hidden;
  border-bottom: 1px solid #e2e8f0;
}

.breadcrumb-nav {
  max-width: 1285px;
  margin: 0 auto 50px;
  text-align: left;
  font-size: 14.5px;
  color: #64748b;
  display: flex;
  align-items: center;
  flex-wrap: wrap;
}

.breadcrumb-nav .breadcrumb-link {
  color: #475569;
  text-decoration: none;
  transition: color 0.2s;
  display: inline-flex;
  align-items: center;
}

.breadcrumb-nav .breadcrumb-link.home-link {
  gap: 4px;
}

.breadcrumb-nav .breadcrumb-link.truncate-title {
  display: block;
  max-width: 250px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.breadcrumb-nav .breadcrumb-link:hover {
  color: #0ea5e9;
}

.breadcrumb-nav .sep {
  color: #94a3b8;
  display: inline-flex;
  align-items: center;
}

.breadcrumb-nav span.current-page {
  color: #0ea5e9;
  font-weight: 500;
}

.checkout-hero-content {
  max-width: 700px;
  margin: 0 auto;
}

.checkout-hero-content h1 {
  font-size: 51px;
  font-weight: 600;
  color: #0f172a;
  margin: 0 0 16px;
}

.text-blue {
  color: #0284c7;
}

.checkout-hero-content p {
  color: #475569;
  font-size: 18px;
  line-height: 1.6;
}

/* Main Content */
.checkout-main {
  padding: 40px 0px;
  background: white;
}

.section-shell {
  max-width: 1100px;
  margin: 0 auto;
  position: relative;
  z-index: 10;
}

.checkout-two-columns {
  display: grid;
  grid-template-columns: 1fr 320px;
  gap: 68px;
  align-items: start;
}

/* Form Container */
.checkout-form-column {
  background: #ffffff;
  border-radius: 16px;
  padding: 40px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
  border: 1px solid #f1f5f9;
}

.form-header {
  text-align: center;
  margin-bottom: 32px;
}

.form-header h2 {
  font-size: 32px;
  font-weight: 600;
  color: #0f172a;
  margin: 0 0 12px;
}

.form-header p {
  font-size: 16px;
  color: #64748b;
  line-height: 1.5;
}

.form-grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-bottom: 32px;
}

.input-group {
  display: flex;
  flex-direction: column;
}

.input-group label {
  font-size: 13.5px;
  font-weight: 600;
  color: #334155;
  margin-bottom: 8px;
}

.input-group input,
.input-group select {
  width: 100%;
  padding: 12px 16px;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  font-size: 14px;
  color: #0f172a;
  background: #ffffff;
  outline: none;
  transition: all 0.2s;
}

.input-group input:focus,
.input-group select:focus {
  border-color: #0284c7;
  box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1);
}

/* intl-tel-input overrides */
.input-group :deep(.iti) {
  width: 100%;
}

.input-group :deep(.iti input) {
  width: 100%;
  padding: 12px 16px 12px 52px;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  font-size: 14px;
  outline: none;
  background: #ffffff;
  color: #1f2937;
  transition: all 0.2s ease-in-out;
  height: auto;
}

.input-group :deep(.iti input:focus) {
  border-color: #0284c7;
  box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1);
}

.input-group :deep(.iti__selected-dial-code) {
  font-size: 13.5px;
  font-weight: 600;
  color: #4b5563;
}

/* Payment Options */
.secure-payment-section {
  margin-bottom: 32px;
}

.secure-payment-section h4 {
  font-size: 16px;
  font-weight: 400;
  color: #0f172a;
  margin: 0 0 8px;
}

.secure-payment-section p {
  font-size: 13px;
  color: #64748b;
  margin: 0 0 20px;
}

.payment-methods-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
}

.payment-method-card {
  border: 1px solid #c2ccd8;
  border-radius: 12px;
  padding: 16px;
  display: flex;
  flex-direction: column;
  position: relative;
  cursor: pointer;
  transition: all 0.2s;
}

.payment-method-card:hover {
  border-color: #0284c74f;
  box-shadow: 0 1px 7px rgb(7 131 223 / 21%);
}

.payment-method-card.active {
  border-color: #0284c74f;
  box-shadow: 0 1px 7px rgb(7 131 223 / 21%);
}

.payment-method-card input {
  display: none;
}

.radio-custom {
  width: 16px;
  height: 16px;
  border: 2px solid #cbd5e1;
  border-radius: 50%;
  position: relative;
  flex-shrink: 0;
}

.payment-method-card.active .radio-custom {
  border: 2px solid #cbd5e1;
}

.payment-method-card.active .radio-custom::after {
  content: '';
  position: absolute;
  top: 1px;
  left: 1px;
  width: 11px;
  height: 11px;
  background: #0284c7;
  border-radius: 50%;
}

.payment-method-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 24px;
}

.payment-name {
  font-size: 13.5px;
  font-weight: 600;
  color: #0f172a;
}

/* Action Button */
.buy-now-submit-btn {
  width: 43%;
  padding: 16px;
  background: #0284c7;
  color: white;
  border: none;
  border-radius: 37px;
  font-size: 16px;
  font-weight: 700;
  cursor: pointer;
  transition: background 0.2s;
  box-shadow: 0 4px 12px rgba(2, 132, 199, 0.2);
  margin: 0 auto;
  display: block;
}

.buy-now-submit-btn:hover:not(:disabled) {
  background: #0369a1;
}

.buy-now-submit-btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

/* Right Sidebar */
.checkout-sidebar {
  display: flex;
  flex-direction: column;
  gap: 24px;
  text-align: center;
}

.included-card {
  background: #ffffff;
  border: 1px solid #aeb7bf;
  border-radius: 16px;
  padding: 24px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
}

.included-card h3 {
  font-size: 20px;
  font-weight: 600;
  color: #0f172a;
  margin: 0 0 8px;
}

.included-card p {
  font-size: 13px;
  color: #64748b;
  margin: 0 0 20px;
}

.included-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.included-list li {
  font-size: 13px;
  color: #334155;
  display: flex;
  align-items: flex-start;
  gap: 8px;
  font-weight: 500;
  text-align: left;
}

.green-check {
  color: #10b981;
  font-weight: 800;
}

.help-card {
  background: #0783df;
  border-radius: 16px;
  padding: 28px 24px;
  color: white;
  text-align: center;
  box-shadow: 0 10px 30px rgba(14, 165, 233, 0.2);
}

.help-card h3 {
  font-size: 22px;
  font-weight: 600;
  margin: 0 0 12px;
  line-height: 1.3;
}

.help-card p {
  font-size: 14px;
  opacity: 0.9;
  margin: 0 0 24px;
}

.help-contact {
  display: flex;
  flex-direction: column;
  gap: 8px;
  font-size: 13px;
  margin-bottom: 24px;

  padding: 16px;
  border-radius: 8px;
}

.contact-support-btn {
  display: inline-block;
  background: #ffffff;
  color: #0ea5e9;
  padding: 12px 24px;
  border-radius: 30px;
  font-weight: 700;
  font-size: 14px;
  text-decoration: none;
  transition: all 0.2s;
}

.contact-support-btn:hover {
  background: #f8fafc;
  transform: translateY(-2px);
}

@media (max-width: 900px) {
  .checkout-two-columns {
    grid-template-columns: 1fr;
  }

  .form-grid-2 {
    grid-template-columns: 1fr;
  }

  .payment-methods-grid {
    grid-template-columns: 1fr 1fr;
  }
}
</style>
