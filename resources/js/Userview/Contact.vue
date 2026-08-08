<template>
  <div class="contact-page">
    <SiteHeader />

    <main class="contact-main">
      <!-- Banner Section -->
      <section class="contact-banner">
        <div class="contact-banner-glow"></div>
        <div class="contact-banner-content section-shell">
          <h1>Get in Touch with Our Research Experts</h1>
          <p>
            Connect with our team for market research inquiries, custom reports, business insights, and strategic
            consulting solutions.
          </p>
        </div>
      </section>

      <!-- Main Layout Columns -->
      <section class="contact-content section-shell">
        <div class="contact-columns-grid">
          <!-- Left Column Form -->
          <div class="contact-form-column">
            <div class="contact-form-card">
              <!-- Success Alert -->
              <Transition name="fade">
                <div v-if="submitSuccess" class="contact-success-alert">
                  <svg class="success-alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="3">
                    <polyline points="20 6 9 17 4 12"></polyline>
                  </svg>
                  <span>Your message has been sent successfully! We will get back to you shortly.</span>
                </div>
              </Transition>

              <form @submit.prevent="handleSubmit" class="contact-form" v-if="!submitSuccess">
                <!-- Full Name -->
                <div class="form-group">
                  <label for="contact_fullName">Full Name <span class="required">*</span></label>
                  <input type="text" id="contact_fullName" v-model="formData.full_name"
                    placeholder="Enter Your Full Name" required />
                </div>

                <!-- Email -->
                <div class="form-group">
                  <label for="contact_email">Email <span class="required">*</span></label>
                  <input type="email" id="contact_email" v-model="formData.email" placeholder="Enter Your Email"
                    required />
                </div>

                <!-- Phone Number -->
                <div class="form-group">
                  <label for="contact_phone">Phone Number <span class="required">*</span></label>
                  <input type="tel" id="contact_phone" ref="phoneInputRef" required />
                </div>

                <!-- Select Country -->
                <div class="form-group">
                  <label for="contact_country">Select Country <span class="required">*</span></label>
                  <select id="contact_country" v-model="formData.country" required>
                    <option value="" disabled selected>Select Country</option>
                    <option v-for="c in countriesList" :key="c" :value="c">{{ c }}</option>
                  </select>
                </div>

                <!-- Company Name -->
                <div class="form-group">
                  <label for="contact_companyName">Company Name <span class="required">*</span></label>
                  <input type="text" id="contact_companyName" v-model="formData.company_name"
                    placeholder="Enter Company Name" required />
                </div>

                <!-- Specific Research Requirement -->
                <div class="form-group">
                  <label for="contact_requirement">Specific Research Requirement <span class="required">*</span></label>
                  <textarea id="contact_requirement" v-model="formData.specific_research_requirement"
                    placeholder="How can we help you?" rows="4" required></textarea>
                </div>

                <!-- Real Google reCAPTCHA Container -->
                <div class="recaptcha-group" style="margin-top: 15px;">
                  <div id="recaptcha-container"></div>
                  <span v-if="recaptchaError" class="recaptcha-error-text"
                    style="color: #dc2626; font-size: 13.5px; margin-top: 5px; display: block;">{{ recaptchaError
                    }}</span>
                </div>

                <!-- Submit Button -->
                <div class="form-submit-row">
                  <button type="submit" class="primary-button contact-submit-btn" :disabled="submitting">
                    <span v-if="submitting">Sending...</span>
                    <span v-else style="display: flex; align-items: center; gap: 6px;">
                      Send Message
                      <CircleArrow style="width: 18px; height: 18px;" />
                    </span>
                  </button>
                </div>
              </form>
            </div>
          </div>

          <!-- Right Column Details -->
          <div class="contact-info-column">
            <!-- Why Choose Us -->
            <div class="info-block">
              <h3>Why Choose Epignosis Insights</h3>
              <ul class="why-list">
                <li>
                  <img :src="$assetUrl + '/assets/images/contact-us/tick.png'"
                    style="width: 24px; height: 24px; flex-shrink: 0;" alt="check" />
                  Reliable Market Intelligence
                </li>
                <li>
                  <img :src="$assetUrl + '/assets/images/contact-us/tick.png'"
                    style="width: 24px; height: 24px; flex-shrink: 0;" alt="check" />
                  Global Industry Coverage
                </li>
                <li>
                  <img :src="$assetUrl + '/assets/images/contact-us/tick.png'"
                    style="width: 24px; height: 24px; flex-shrink: 0;" alt="check" />
                  Customized Research Solutions
                </li>
                <li>
                  <img :src="$assetUrl + '/assets/images/contact-us/tick.png'"
                    style="width: 24px; height: 24px; flex-shrink: 0;" alt="check" />
                  Expert Analyst Support
                </li>
              </ul>
            </div>

            <!-- Contact Information -->
            <div class="info-block contact-details-block">
              <h3>Contact Information</h3>
              <ul class="details-list">
                <li>
                  <img :src="$assetUrl + '/assets/images/contact-us/black_message.png'"
                    style="width: 35px; height: 35px; flex-shrink: 0;" alt="check" />
                  sales@epignosisinsights.com
                </li>
                <li>
                  <img :src="$assetUrl + '/assets/images/contact-us/black_tel.png'"
                    style="width: 35px; height: 35px; flex-shrink: 0;" alt="check" />
                  +91 9370865430
                </li>
                <li>
                  <img :src="$assetUrl + '/assets/images/contact-us/black_location.png'"
                    style="width: 35px; height: 35px; flex-shrink: 0;" alt="check" />
                  703 Kumar Corporate Building, Pune-411028, India
                </li>
              </ul>
            </div>

            <!-- Follow Us -->
            <div class="info-block follow-us-block">
              <h3>Follow Us</h3>
              <div class="contact-social-links">
                <a href="https://www.facebook.com/people/Epignosis-Insights/61591089437924/" target="_blank"
                  rel="noopener noreferrer">
                  <img :src="$assetUrl + '/assets/images/contact-us/black_facebook.png'"
                    style="width: 35px; height: 35px; flex-shrink: 0;" alt="Facebook" />
                </a>
                <a href="https://www.linkedin.com/company/epignosis-insights/" target="_blank"
                  rel="noopener noreferrer">
                  <img :src="$assetUrl + '/assets/images/contact-us/black_linkedin.png'"
                    style="width: 35px; height: 35px; flex-shrink: 0;" alt="LinkedIn" />
                </a>
                <a href="https://x.com/epignosisinsigh" target="_blank" rel="noopener noreferrer">
                  <img :src="$assetUrl + '/assets/images/contact-us/black_x.png'"
                    style="width: 35px; height: 35px; flex-shrink: 0;" alt="X" />
                </a>
                <a href="https://www.instagram.com/epignosisinsights/" target="_blank" rel="noopener noreferrer">
                  <img :src="$assetUrl + '/assets/images/contact-us/black_insta.png'"
                    style="width: 35px; height: 35px; flex-shrink: 0;" alt="Instagram" />
                </a>



              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- FAQ Section Accordion -->
      <section class="contact-faqs section-shell">
        <h2 class="faq-section-title">Frequently Asked Questions</h2>
        <div class="faq-accordion">
          <div v-for="(faq, idx) in faqs" :key="idx" class="faq-item" :class="{ active: faq.isOpen }">
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
    </main>

    <SiteFooter />
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import intlTelInput from 'intl-tel-input/intlTelInputWithUtils'
import 'intl-tel-input/styles'
import SiteHeader from './components/SiteHeader.vue'
import SiteFooter from './components/SiteFooter.vue'
import { CircleArrow } from './icons'
const router = useRouter()

const phoneInputRef = ref(null)
let itiInstance = null

const submitting = ref(false)
const submitSuccess = ref(false)
const recaptchaToken = ref('')
const recaptchaError = ref('')
const recaptchaWidgetId = ref(null)

const formData = ref({
  full_name: '',
  email: '',
  phone: '',
  country: '',
  company_name: '',
  specific_research_requirement: ''
})

const faqs = ref([
  {
    question: 'How can I request a customized market research report?',
    answer: 'Contact our research team with your requirements, including industry, geography, segmentation, and objectives. We will prepare a tailored proposal based on your business needs.',
    isOpen: false
  },
  {
    question: 'Do you offer custom research and consulting services?',
    answer: 'Yes. We provide custom market research, competitive intelligence, primary research, market sizing, forecasting, pricing analysis, feasibility studies, and strategic consulting across multiple industries.',
    isOpen: false
  },
  {
    question: 'How quickly will I receive a response after submitting an inquiry?',
    answer: 'Our team typically responds within 24 business hours to discuss your requirements, provide additional information, or share a quotation.',
    isOpen: false
  },
  {
    question: 'Can I request a sample report before purchasing?',
    answer: 'Yes. We can provide a sample report or table of contents to help you evaluate the report structure, methodology, and level of analysis.',
    isOpen: false
  },
  {
    question: 'Do you provide analyst support after report purchase?',
    answer: 'Yes. Complimentary analyst support is available for a specified period after purchase to help clarify report findings, assumptions, and methodologies.',
    isOpen: false
  }
])

const toggleFaq = (index) => {
  faqs.value[index].isOpen = !faqs.value[index].isOpen
}

// Comprehensive list of countries
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

// Render the captcha explicitly in the target div container
const initRecaptcha = () => {
  if (window.grecaptcha && window.grecaptcha.render) {
    if (recaptchaWidgetId.value === null) {
      try {
        recaptchaWidgetId.value = window.grecaptcha.render('recaptcha-container', {
          sitekey: window.RECAPTCHA_SITE_KEY || '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI',
          callback: (token) => {
            recaptchaToken.value = token
            recaptchaError.value = ''
          },
          'expired-callback': () => {
            recaptchaToken.value = ''
          }
        })
      } catch (e) {
        console.error('reCAPTCHA rendering error:', e)
      }
    }
  } else {
    setTimeout(initRecaptcha, 100)
  }
}

onMounted(() => {
  // Initialize intl-tel-input
  if (phoneInputRef.value) {
    itiInstance = intlTelInput(phoneInputRef.value, {
      initialCountry: 'in',
      preferredCountries: ['in', 'us'],
      separateDialCode: true,
      formatOnDisplay: true,
      autoPlaceholder: 'aggressive',
    })
  }

  // Initialize Google ReCAPTCHA v2
  initRecaptcha()
})

onUnmounted(() => {
  if (itiInstance) {
    itiInstance.destroy()
    itiInstance = null
  }
  if (window.onloadRecaptchaCallback) {
    delete window.onloadRecaptchaCallback
  }
})

const handleSubmit = async () => {
  submitting.value = true
  recaptchaError.value = ''

  // Set the full dialcode-based number
  if (itiInstance) {
    formData.value.phone = itiInstance.getNumber()
  }

  if (!recaptchaToken.value) {
    recaptchaError.value = 'Please verify that you are not a robot.'
    submitting.value = false
    return
  }

  try {
    const response = await axios.post('/api/contact-us', {
      ...formData.value,
      recaptcha_token: recaptchaToken.value
    })

    if (response.data) {
      submitSuccess.value = true
      // Redirect to thank-you page
      router.push('/thank-you')

      // Reset form fields
      formData.value = {
        full_name: '',
        email: '',
        phone: '',
        country: '',
        company_name: '',
        specific_research_requirement: ''
      }
      recaptchaToken.value = ''
      if (window.grecaptcha && recaptchaWidgetId.value !== null) {
        window.grecaptcha.reset(recaptchaWidgetId.value)
      }
    }
  } catch (error) {
    console.error('Failed to save contact us submission:', error)
    if (error.response && error.response.data && error.response.data.message) {
      alert(error.response.data.message)
    } else {
      alert('Failed to submit message. Please check the fields and try again.')
    }
  } finally {
    submitting.value = false
  }
}
</script>

<style src="./style.css"></style>
<style src="./contactStyle.css"></style>
