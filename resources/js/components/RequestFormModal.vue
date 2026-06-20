<template>
  <Transition name="modal-fade">
    <div v-if="isOpen" class="modal-backdrop" @click.self="$emit('close')">
      <div class="modal-card" role="dialog" aria-modal="true">
        <!-- Close button (X) -->
        <button class="close-btn" @click="$emit('close')" aria-label="Close modal">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>

        <h2 class="modal-title">Request a Sample Report</h2>
        <p class="modal-subtitle">Fill out the form below to receive a sample copy of this report and connect with our research experts.</p>

        <!-- Success Notification -->
        <Transition name="success-fade">
          <div v-if="submitSuccess" class="success-alert">
            <svg class="success-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
              <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            <span>Request Submitted Successfully!</span>
          </div>
        </Transition>

        <form @submit.prevent="handleSubmit" class="modal-form" v-if="!submitSuccess">
          <div class="form-row-2">
            <!-- Full Name -->
            <div class="form-group">
              <label for="rfm_fullName">Full Name <span class="required">*</span></label>
              <input 
                type="text" 
                id="rfm_fullName" 
                v-model="formData.name" 
                placeholder="Enter Your Full Name" 
                required 
              />
            </div>

            <!-- Business Email -->
            <div class="form-group">
              <label for="rfm_businessEmail">Business Email <span class="required">*</span></label>
              <input 
                type="email" 
                id="rfm_businessEmail" 
                v-model="formData.email" 
                placeholder="Enter Your Business Email" 
                required 
              />
            </div>
          </div>

          <div class="form-row-2">
            <!-- Phone Number with intl-tel-input -->
            <div class="form-group">
              <label for="rfm_phone">Phone Number <span class="required">*</span></label>
              <input 
                type="tel" 
                id="rfm_phone" 
                ref="phoneInputRef"
                placeholder="Enter Phone Number" 
                required 
              />
            </div>

            <!-- Company Name -->
            <div class="form-group">
              <label for="rfm_companyName">Company Name <span class="required">*</span></label>
              <input 
                type="text" 
                id="rfm_companyName" 
                v-model="formData.company_name" 
                placeholder="Enter Company Name" 
                required 
              />
            </div>
          </div>

          <div class="form-row-2">
            <!-- Select Country -->
            <div class="form-group">
              <label for="rfm_country">Country <span class="required">*</span></label>
              <select id="rfm_country" v-model="formData.country" required>
                <option value="" disabled selected>Select Your Country</option>
                <option v-for="c in countriesList" :key="c" :value="c">{{ c }}</option>
              </select>
            </div>

            <!-- Select Subject -->
            <div class="form-group">
              <label for="rfm_subject">Select Subject <span class="required">*</span></label>
              <select id="rfm_subject" v-model="formData.subject" required>
                <option value="Request Sample">Request Sample</option>
                <option value="Ask for discount">Ask for discount</option>
                <option value="Request customized report">Request customized report</option>
                <option value="Download Free Sample">Download Free Sample</option>
              </select>
            </div>
          </div>

          <div class="form-row-2">
            <!-- Job Title -->
            <div class="form-group">
              <label for="rfm_jobTitle">Job Title <span class="required">*</span></label>
              <input 
                type="text" 
                id="rfm_jobTitle" 
                v-model="formData.job_title" 
                placeholder="Enter Job Title" 
                required 
              />
            </div>

            <!-- Specific Research Requirement -->
            <div class="form-group">
              <label for="rfm_requirement">Specific Research Requirement <span class="required">*</span></label>
              <textarea 
                id="rfm_requirement" 
                v-model="formData.specific_research_requirement" 
                placeholder="Enter your specific requirement" 
                rows="2"
                required
              ></textarea>
            </div>
          </div>

          <!-- Real Google reCAPTCHA Container -->
          <div class="recaptcha-wrapper" style="margin-top: 10px;">
            <div id="modal-recaptcha-container"></div>
            <span v-if="recaptchaError" class="recaptcha-error-text" style="color: #dc2626; font-size: 13.5px; margin-top: 5px; display: block;">{{ recaptchaError }}</span>
          </div>

          <!-- Modal Action Buttons -->
          <div class="modal-actions-row">
            <button 
              type="submit" 
              class="primary-button submit-btn" 
              :disabled="submitting"
            >
              <span v-if="submitting">Submitting...</span>
              <span v-else>Request Sample <span class="btn-arrow">→</span></span>
            </button>
            <button type="button" class="secondary-button cancel-btn" @click="$emit('close')">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, watch, onUnmounted, nextTick } from 'vue'
import axios from 'axios'
import intlTelInput from 'intl-tel-input/intlTelInputWithUtils'
import 'intl-tel-input/styles'

const props = defineProps({
  isOpen: Boolean,
  subject: String,
  reportName: String
})

const emit = defineEmits(['close'])

const submitting = ref(false)
const submitSuccess = ref(false)
const recaptchaToken = ref('')
const recaptchaError = ref('')
const recaptchaWidgetId = ref(null)
const phoneInputRef = ref(null)
let itiInstance = null

const formData = ref({
  name: '',
  email: '',
  phone: '',
  country: '',
  subject: 'Request Sample',
  job_title: '',
  company_name: '',
  specific_research_requirement: '',
  report_name: ''
})

// Sync subject parameter when modal opens
watch(() => props.subject, (newSubject) => {
  if (newSubject) {
    formData.value.subject = newSubject
  }
})

// Sync report name when prop updates
watch(() => props.reportName, (newReport) => {
  formData.value.report_name = newReport || ''
})

// Initialize/destroy intl-tel-input when modal opens/closes
watch(() => props.isOpen, async (newVal) => {
  if (newVal) {
    // Reset form data
    formData.value.name = ''
    formData.value.email = ''
    formData.value.phone = ''
    formData.value.country = ''
    formData.value.job_title = ''
    formData.value.company_name = ''
    formData.value.specific_research_requirement = ''
    formData.value.subject = props.subject || 'Request Sample'
    formData.value.report_name = props.reportName || ''
    recaptchaToken.value = ''
    recaptchaError.value = ''
    submitSuccess.value = false

    // Wait for DOM to render the phone input
    await nextTick()

    // Initialize intl-tel-input on the phone input element
    if (phoneInputRef.value) {
      itiInstance = intlTelInput(phoneInputRef.value, {
        initialCountry: 'in',
        preferredCountries: ['in', 'us'],
        separateDialCode: true,
        formatOnDisplay: true,
        autoPlaceholder: 'aggressive',
      })
    }
    
    // Initialize or reset reCAPTCHA
    if (window.grecaptcha && window.grecaptcha.render) {
      if (recaptchaWidgetId.value === null) {
        initRecaptcha()
      } else {
        window.grecaptcha.reset(recaptchaWidgetId.value)
      }
    } else {
      setTimeout(initRecaptcha, 300)
    }
  } else {
    // Destroy instance when closing
    if (itiInstance) {
      itiInstance.destroy()
      itiInstance = null
    }
  }
})

const initRecaptcha = () => {
  if (window.grecaptcha && window.grecaptcha.render && document.getElementById('modal-recaptcha-container')) {
    if (recaptchaWidgetId.value === null) {
      try {
        recaptchaWidgetId.value = window.grecaptcha.render('modal-recaptcha-container', {
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
        console.error('Modal reCAPTCHA rendering error:', e)
      }
    }
  } else if (props.isOpen) {
    setTimeout(initRecaptcha, 100)
  }
}

onUnmounted(() => {
  if (itiInstance) {
    itiInstance.destroy()
    itiInstance = null
  }
})



// Comprehensive Countries List
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

const handleSubmit = async () => {
  if (!recaptchaToken.value) {
    recaptchaError.value = 'Please verify that you are not a robot.'
    return
  }
  
  submitting.value = true
  
  // Get the full phone number with dial code from intl-tel-input
  if (itiInstance) {
    formData.value.phone = itiInstance.getNumber()
  }

  try {
    const response = await axios.post('/api/request-form', {
      ...formData.value,
      recaptcha_token: recaptchaToken.value
    })
    if (response.data) {
      submitSuccess.value = true
      // Auto close modal after success
      setTimeout(() => {
        emit('close')
      }, 2000)
    }
  } catch (error) {
    console.error('Failed to submit request form:', error)
    alert('Failed to submit form. Please check your fields and try again.')
  } finally {
    submitting.value = false
  }
}
</script>

<style scoped>
/* Backdrop overlay */
.modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(8, 20, 36, 0.45);
  backdrop-filter: blur(12px);
  display: grid;
  place-items: center;
  z-index: 10000;
  padding: 24px;
}

/* Modal Card body */
.modal-card {
  background: #ffffff;
  border-radius: 24px;
  max-width: 680px;
  width: 100%;
  padding: 42px 40px;
  box-shadow: 
    0 24px 70px rgba(8, 26, 48, 0.18),
    0 0 1px rgba(0, 0, 0, 0.08);
  position: relative;
  border: 1px solid rgba(225, 233, 240, 0.9);
  max-height: 90vh;
  overflow-y: auto;
}

/* Close button (X) */
.close-btn {
  position: absolute;
  top: 24px;
  right: 24px;
  background: #f4f6f9;
  border: none;
  width: 38px;
  height: 38px;
  border-radius: 50%;
  color: #6b7280;
  cursor: pointer;
  display: grid;
  place-items: center;
  transition: all 0.25s ease;
}

.close-btn:hover {
  background: #eef1f6;
  color: #111827;
  transform: rotate(90deg);
}

.close-btn svg {
  width: 16px;
  height: 16px;
}

.modal-title {
  font-size: 26px;
  font-weight: 800;
  color: #0c243f;
  margin: 0 0 10px;
  text-align: left;
}

.modal-subtitle {
  font-size: 14px;
  color: #5d6778;
  line-height: 1.5;
  margin: 0 0 32px;
  text-align: left;
}

/* Success notification style */
.success-alert {
  display: flex;
  align-items: center;
  gap: 14px;
  background: #eefdf4;
  border: 1px solid #a3e635;
  padding: 20px 24px;
  border-radius: 16px;
  color: #15803d;
  font-weight: 700;
  font-size: 16px;
  margin: 40px 0;
  justify-content: center;
  box-shadow: 0 10px 25px rgba(21, 128, 61, 0.05);
}

.success-icon {
  width: 24px;
  height: 24px;
}

.modal-form {
  display: flex;
  flex-direction: column;
  gap: 22px;
}

.form-row-2 {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
  position: relative;
  text-align: left;
}

.form-group label {
  font-size: 13.5px;
  font-weight: 700;
  color: #1f2937;
}

.required {
  color: #dc2626;
}

/* Inputs styling */
.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  padding: 12px 18px;
  border: 1.5px solid #e2e8f0;
  border-radius: 12px;
  font-size: 14px;
  outline: none;
  background: #fcfdfe;
  color: #1f2937;
  transition: all 0.2s ease-in-out;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  border-color: #0783df;
  background: #ffffff;
  box-shadow: 0 0 0 4px rgba(7, 131, 223, 0.08);
}

.form-group textarea {
  resize: vertical;
}

/* intl-tel-input overrides for the modal context */
.form-group :deep(.iti) {
  width: 100%;
}

.form-group :deep(.iti input) {
  width: 100%;
  padding: 12px 18px 12px 52px;
  border: 1.5px solid #e2e8f0;
  border-radius: 12px;
  font-size: 14px;
  outline: none;
  background: #fcfdfe;
  color: #1f2937;
  transition: all 0.2s ease-in-out;
  height: auto;
}

.form-group :deep(.iti input:focus) {
  border-color: #0783df;
  background: #ffffff;
  box-shadow: 0 0 0 4px rgba(7, 131, 223, 0.08);
}

.form-group :deep(.iti__selected-dial-code) {
  font-size: 13.5px;
  font-weight: 600;
  color: #4b5563;
}

.form-group :deep(.iti__country-container) {
  border-radius: 12px 0 0 12px;
}

.form-group :deep(.iti__selected-country-primary) {
  border-radius: 11px 0 0 11px;
  padding: 0 8px;
}

.form-group :deep(.iti__arrow) {
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-top: 5px solid #9ca3af;
  margin-left: 4px;
}

/* Mockup reCAPTCHA widget style */
.recaptcha-wrapper {
  margin-top: 4px;
  align-self: flex-start;
}

.recaptcha-box {
  background: #f9f9f9;
  border: 1px solid #d3d3d3;
  border-radius: 3px;
  width: 302px;
  height: 76px;
  padding: 0 12px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  user-select: none;
}

.recaptcha-left {
  display: flex;
  align-items: center;
  gap: 12px;
}

.recaptcha-checkbox {
  width: 28px;
  height: 28px;
  border: 2px solid #c1c1c1;
  border-radius: 2px;
  background: #ffffff;
  display: grid;
  place-items: center;
  transition: all 0.2s;
}

.recaptcha-checkbox.checked {
  border-color: #00b050;
}

.recaptcha-checkbox svg {
  width: 18px;
  height: 18px;
}

.recaptcha-label {
  font-size: 14px;
  color: #2b2b2b;
  font-family: Roboto, helvetica, arial, sans-serif;
  font-weight: 400;
}

.recaptcha-right {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.recaptcha-logo {
  width: 32px;
  height: 32px;
  object-fit: contain;
}

.recaptcha-text {
  font-size: 10px;
  color: #555555;
  font-weight: 600;
  margin-top: 2px;
  font-family: Roboto, helvetica, arial, sans-serif;
}

.recaptcha-terms {
  font-size: 8px;
  color: #777777;
  font-weight: 400;
  margin-top: 1px;
}

/* Modal actions row styling */
.modal-actions-row {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-top: 8px;
}

.submit-btn {
  background: #0783df;
  border: 1px solid #0783df;
  color: #ffffff;
  min-height: 44px;
  padding: 0 30px;
  font-size: 14.5px;
  font-weight: 700;
  border-radius: 30px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  cursor: pointer;
  transition: all 0.2s;
}

.submit-btn:hover:not(:disabled) {
  background: #066ebb;
  box-shadow: 0 8px 24px rgba(7, 131, 223, 0.25);
}

.submit-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-arrow {
  font-size: 16px;
  line-height: 1;
}

.cancel-btn {
  background: transparent;
  border: 1.5px solid #dce6ef;
  color: #4b5563;
  min-height: 44px;
  padding: 0 28px;
  font-size: 14.5px;
  font-weight: 700;
  border-radius: 30px;
  cursor: pointer;
  transition: all 0.2s;
}

.cancel-btn:hover {
  background: #f4f6f9;
  border-color: #cbd5e1;
  color: #1f2937;
}

/* Transitions */
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.3s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}

.modal-fade-enter-active .modal-card {
  animation: slide-up 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.modal-fade-leave-active .modal-card {
  animation: slide-down 0.3s cubic-bezier(0.36, 0.07, 0.19, 0.97);
}

@keyframes slide-up {
  from {
    transform: translateY(30px) scale(0.96);
    opacity: 0;
  }
  to {
    transform: translateY(0) scale(1);
    opacity: 1;
  }
}

@keyframes slide-down {
  from {
    transform: translateY(0) scale(1);
    opacity: 1;
  }
  to {
    transform: translateY(20px) scale(0.96);
    opacity: 0;
  }
}

.success-fade-enter-active {
  transition: all 0.3s ease;
}

.success-fade-enter-from {
  transform: scale(0.95);
  opacity: 0;
}

@media (max-width: 640px) {
  .modal-card {
    padding: 30px 24px;
  }
  
  .form-row-2 {
    grid-template-columns: 1fr;
    gap: 16px;
  }
}
</style>
