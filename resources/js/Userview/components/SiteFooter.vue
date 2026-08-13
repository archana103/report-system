<template>
  <footer class="footer-section">
    <div class="footer-top">
      <div class="footer-left">
        <div class="brand-info">
          <a class="brand footer-brand" href="#">
            <img :src="$assetUrl + '/assets/images/logo.png'" alt="Epignosis Insights Logo" class="brand-logo" />
          </a>
          <p>Delivering data-driven insights to support smarter business decisions.</p>
        </div>
        <div class="newsletter-section">
          <h2>Stay Ahead with Market Insights</h2>
          <form class="footer-form" @submit.prevent="subscribeNewsletter">
            <input type="email" placeholder="Email Address" v-model="emailAddress" required :disabled="isSubscribing" />
            <button type="submit" :disabled="isSubscribing" :style="{ opacity: isSubscribing ? 0.7 : 1 }">{{ isSubscribing
              ? 'Submitting...' : 'Show Now!' }}</button>
          </form>
          <p v-if="subscriptionMessage"
            :style="{ color: messageType === 'success' ? '#10b981' : '#ef4444', fontSize: '13px', marginTop: '8px', fontWeight: '500' }">
            {{ subscriptionMessage }}</p>
        </div>
      </div>
      <div class="footer-contact">
        <div class="contact-info">
          <p><span>
              <img :src="$assetUrl + '/assets/images/footer_icons/icon_mail.png'" alt="Location"
                class="footer-icon-img" />
            </span>703 Kumar Corporate Building, Pune-411028, India</p>
          <p><span>
              <img :src="$assetUrl + '/assets/images/footer_icons/Icon.png'" alt="Email" class="footer-icon-img" />
            </span>sales@epignosisinsights.com</p>
          <p><span>
              <img :src="$assetUrl + '/assets/images/footer_icons/icon_phone.png'" alt="Phone" class="footer-icon-img" />
            </span>+91 9370865430</p>
        </div>
        
        <div class="payment-partners">
          <h4>Payment Partner</h4>
          <div class="payment-logos">
            <img :src="$assetUrl + '/assets/images/bank_images/visa.png'" alt="Visa" />
            <img :src="$assetUrl + '/assets/images/bank_images/paypal.png'" alt="PayPal" />
            <img :src="$assetUrl + '/assets/images/bank_images/mastercard.png'" alt="Mastercard" />
            <img :src="$assetUrl + '/assets/images/bank_images/discover.png'" alt="Discover" />
            <img :src="$assetUrl + '/assets/images/bank_images/wire_transfer.png'" alt="Wire Transfer" />
            <img :src="$assetUrl + '/assets/images/bank_images/american.png'" alt="American Express" />
          </div>
        </div>
      </div>
    </div>
    <div class="footer-links">
      <nav>
        <router-link to="/">Home</router-link>
        <router-link to="/about-us">About Us</router-link>
        <router-link to="/reports">Reports</router-link>
        <router-link to="/blogs">Blogs</router-link>
        <router-link to="/press-releases">Press Release</router-link>
        <router-link to="/contact-us">Contact</router-link>
      </nav>
      <div class="social-links">
        <a href="https://www.facebook.com/people/Epignosis-Insights/61591089437924/" target="_blank"
          rel="noopener noreferrer">
          <img :src="$assetUrl + '/assets/images/footer_icons/facebook.png'" alt="Facebook" class="social-icon-img" />
        </a>
        <a href="https://www.linkedin.com/company/epignosis-insights/" target="_blank" rel="noopener noreferrer">
          <img :src="$assetUrl + '/assets/images/footer_icons/linkedin.png'" alt="LinkedIn" class="social-icon-img" />
        </a>
        <a href="https://x.com/epignosisinsigh" target="_blank" rel="noopener noreferrer">
          <img :src="$assetUrl + '/assets/images/footer_icons/x.png'" alt="X" class="social-icon-img" />
        </a>
        <a href="https://www.instagram.com/epignosisinsights/" target="_blank" rel="noopener noreferrer">
          <img :src="$assetUrl + '/assets/images/footer_icons/instagram.png'" alt="Instagram" class="social-icon-img" />
        </a>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2026 epignosisinsights. All rights reserved.</p>
      <div>
        <router-link to="/terms-and-conditions">Terms & Conditions</router-link>
        <router-link to="/privacy-policy">Privacy Policy</router-link>
      </div>
    </div>
  </footer>
  <button v-if="showUpscroll" class="upscroll-button" @click="scrollToTop" aria-label="Scroll to top">
    <IconArrowUp />
  </button>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import axios from 'axios'
import { IconPin, IconMail, PhoneMini, IconArrowUp } from '../icons'

const showUpscroll = ref(false)
const emailAddress = ref('')
const isSubscribing = ref(false)
const subscriptionMessage = ref('')
const messageType = ref('')

const subscribeNewsletter = async () => {
  if (!emailAddress.value) return
  isSubscribing.value = true
  subscriptionMessage.value = ''

  try {
    const response = await axios.post('/api/newsletter', { email: emailAddress.value })
    subscriptionMessage.value = response.data.message
    messageType.value = 'success'
    emailAddress.value = ''
  } catch (error) {
    if (error.response && error.response.data && error.response.data.errors) {
      subscriptionMessage.value = Object.values(error.response.data.errors)[0][0]
    } else if (error.response && error.response.data && error.response.data.message) {
      subscriptionMessage.value = error.response.data.message
    } else {
      subscriptionMessage.value = 'Something went wrong. Please try again later.'
    }
    messageType.value = 'error'
  } finally {
    isSubscribing.value = false
    setTimeout(() => {
      subscriptionMessage.value = ''
    }, 5000)
  }
}

const handleScroll = () => {
  showUpscroll.value = window.scrollY > 300
}

const scrollToTop = () => {
  window.scrollTo({ top: 0, behavior: 'smooth' })
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
.footer-left, .footer-contact {
  display: flex;
  flex-direction: column;
}
.newsletter-section, .payment-partners {
  margin-top: auto;
  /* padding-top: 1rem; */
}
.newsletter-section h2, .payment-partners h4 {
  font-size: 23px;
  font-weight: 400;
  margin-bottom: 1rem;
  color: #ffffff;
}
.payment-logos {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 0.75rem;
  max-width: 340px;
}
.payment-logos img {
  width: 100%;
  height: 48px;
  background-color: #ffffff;
  padding: 8px 12px;
  border-radius: 8px;
  object-fit: contain;
  box-sizing: border-box;
}
</style>
