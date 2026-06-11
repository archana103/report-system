<template>
  <div class="blog-detail-page">
    <SiteHeader />

    <main class="blog-detail-main">
      <div class="section-shell">
        <div v-if="loading" class="blog-detail-loading">
          <div class="spinner"></div>
          <p>Loading article details...</p>
        </div>

        <div v-else-if="!blog" class="blog-detail-empty">
          <p>Article not found.</p>
        </div>

        <div v-else class="blog-detail-content">
          <!-- Breadcrumbs -->
          <div class="blog-breadcrumbs">
            <router-link to="/">Home</router-link>
            <span>/</span>
            <router-link to="/blogs">Blog</router-link>
            <span>/</span>
            <span>{{ blog.title }}</span>
          </div>

          <!-- Main Layout Grid -->
          <div class="blog-detail-layout">
            <!-- Left Column Content -->
            <article class="blog-post-content">
              <div class="blog-pub-date">Published: {{ blog.date }}</div>
              <h1 class="blog-post-title">{{ blog.title }}</h1>
              
              <div class="blog-main-image-wrapper">
                <img :src="blog.image" :alt="blog.title" class="blog-main-image" />
              </div>

              <!-- Main Rich Text Body -->
              <div class="blog-body-text" v-html="blog.detail ? blog.detail.description : '<p>No content details available.</p>'"></div>

              <!-- FAQs Section -->
              <section class="blog-faqs" v-if="blog.detail && blog.detail.faqs && blog.detail.faqs.length > 0">
                <h2 class="faq-title">Frequently Asked Questions</h2>
                <div class="faq-accordion">
                  <div 
                    v-for="(faq, idx) in faqs" 
                    :key="idx" 
                    class="faq-item" 
                    :class="{ active: faq.isOpen }"
                  >
                    <button class="faq-header" @click="toggleFaq(idx)">
                      <span>{{ faq.question }}</span>
                      <span class="faq-toggle-icon">{{ faq.isOpen ? '−' : '+' }}</span>
                    </button>
                    <div class="faq-body" :style="{ maxHeight: faq.isOpen ? '200px' : '0px' }">
                      <div class="faq-content">
                        {{ faq.answer }}
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            </article>

            <!-- Right Column Sidebar -->
            <aside class="blog-sidebar">
              <!-- CTA Widget -->
              <div class="sidebar-widget widget-cta">
                <h3>Unlock Premium Market Insights</h3>
                <p>Connect with our industry analysts to receive custom research and sector highlights.</p>
                <button class="widget-cta-btn" @click="openModal">
                  Request Sample
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </button>
              </div>

              <!-- Related Articles Widget -->
              <div class="sidebar-widget widget-related" v-if="blog.related_articles && blog.related_articles.length > 0">
                <h3>Related Articles</h3>
                <div class="related-articles-list">
                  <router-link 
                    v-for="item in blog.related_articles" 
                    :key="item.id" 
                    :to="'/blog/' + item.url" 
                    class="related-article-item"
                  >
                    <h4>{{ item.title }}</h4>
                    <p>{{ item.description }}...</p>
                  </router-link>
                </div>
              </div>
            </aside>
          </div>
        </div>
      </div>
    </main>

    <!-- Request Sample Modal Overlay -->
    <div class="modal-overlay" v-if="showModal" @click.self="closeModal">
      <div class="modal-card">
        <button class="modal-close-btn" @click="closeModal">&times;</button>
        <h2>Request Sample</h2>
        <p class="modal-subtitle">Fill out the form below to receive a summary copy of this document, including key analysis, market scope, and research highlights.</p>
        
        <form @submit.prevent="handleFormSubmit" class="modal-form">
          <!-- Full Name -->
          <div class="form-group-full">
            <label for="req_fullName">Full Name *</label>
            <input type="text" id="req_fullName" v-model="formData.full_name" placeholder="Enter Your Full Name" required />
          </div>

          <!-- Business Email -->
          <div>
            <label for="req_email">Business Email *</label>
            <input type="email" id="req_email" v-model="formData.email" placeholder="Enter Business Email" required />
          </div>

          <!-- Phone Number -->
          <div>
            <label for="req_phone">Phone Number *</label>
            <input type="tel" id="req_phone" v-model="formData.phone" placeholder="Enter Phone Number" required />
          </div>

          <!-- Company Name -->
          <div>
            <label for="req_company">Company Name *</label>
            <input type="text" id="req_company" v-model="formData.company_name" placeholder="Enter Company Name" required />
          </div>

          <!-- Country Selection -->
          <div>
            <label for="req_country">Country *</label>
            <select id="req_country" v-model="formData.country" required>
              <option value="" disabled selected>Select Your Country</option>
              <option v-for="c in countriesList" :key="c" :value="c">{{ c }}</option>
            </select>
          </div>

          <!-- Modal Actions -->
          <div class="modal-actions">
            <button type="button" class="btn-cancel" @click="closeModal">Cancel</button>
            <button type="submit" class="btn-submit" :disabled="submitting">
              {{ submitting ? 'Submitting...' : 'Request Sample' }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <SiteFooter />
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'

const route = useRoute()
const router = useRouter()

const blog = ref(null)
const loading = ref(true)
const faqs = ref([])

// Form & Modal States
const showModal = ref(false)
const submitting = ref(false)
const formData = ref({
  full_name: '',
  email: '',
  phone: '',
  company_name: '',
  country: ''
})

const openModal = () => {
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  // Reset form
  formData.value = {
    full_name: '',
    email: '',
    phone: '',
    company_name: '',
    country: ''
  }
}

const toggleFaq = (index) => {
  faqs.value[index].isOpen = !faqs.value[index].isOpen
}

const fetchBlogDetails = async (slug) => {
  loading.value = true
  try {
    const response = await axios.get(`/api/blog/${slug}`)
    if (response.data) {
      blog.value = response.data
      if (response.data.detail && response.data.detail.faqs) {
        faqs.value = response.data.detail.faqs.map(item => ({
          ...item,
          isOpen: false
        }))
      } else {
        faqs.value = []
      }
    }
  } catch (error) {
    console.error('Failed to fetch blog details:', error)
    blog.value = null
  } finally {
    loading.value = false
  }
}

const handleFormSubmit = async () => {
  if (!blog.value) return
  submitting.value = true
  try {
    const response = await axios.post('/api/blog-request', {
      ...formData.value,
      blog_id: blog.value.id
    })
    if (response.data) {
      closeModal()
      router.push('/thank-you')
    }
  } catch (error) {
    console.error('Failed to submit blog request:', error)
    alert('Failed to submit request. Please try again.')
  } finally {
    submitting.value = false
  }
}

watch(
  () => route.params.slug,
  (newSlug) => {
    if (newSlug) {
      fetchBlogDetails(newSlug)
      window.scrollTo({ top: 0, behavior: 'smooth' })
    }
  }
)

onMounted(() => {
  if (route.params.slug) {
    fetchBlogDetails(route.params.slug)
  }
})

// Comprehensive Country List
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
</script>

<style src="./style.css"></style>
<style src="./blogDetailStyle.css"></style>
