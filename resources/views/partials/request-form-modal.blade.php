<div id="request-form-modal" class="modal-backdrop" style="display: none;">
  <div class="modal-card" role="dialog" aria-modal="true">
    <!-- Close button (X) -->
    <button type="button" class="close-btn" onclick="closeRequestModal()" aria-label="Close modal">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
    </button>

    <h2 class="modal-title">Request a Sample Report</h2>
    <p class="modal-subtitle">Fill out the form below to receive a sample copy of this report and connect with our research experts.</p>

    <!-- Success Notification -->
    <div id="modal-success-alert" class="success-alert" style="display: none;">
      <svg class="success-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
      <span>Request Submitted Successfully!</span>
    </div>

    <form id="modal-request-form" class="modal-form" onsubmit="submitRequestForm(event)">
      @csrf
      <input type="hidden" id="modal_report_name" name="report_name">
      
      <div class="form-row-2">
        <!-- Full Name -->
        <div class="form-group">
          <label for="rfm_fullName">Full Name <span class="required">*</span></label>
          <input type="text" id="rfm_fullName" name="name" placeholder="Enter Your Full Name" required />
        </div>

        <!-- Business Email -->
        <div class="form-group">
          <label for="rfm_businessEmail">Business Email <span class="required">*</span></label>
          <input type="email" id="rfm_businessEmail" name="email" placeholder="Enter Your Business Email" required />
        </div>
      </div>

      <div class="form-row-2">
        <!-- Phone Number with intl-tel-input -->
        <div class="form-group">
          <label for="rfm_phone">Phone Number <span class="required">*</span></label>
          <input type="tel" id="rfm_phone" placeholder="Enter Phone Number" required />
          <input type="hidden" id="rfm_full_phone" name="phone">
        </div>

        <!-- Select Subject -->
        <div class="form-group">
          <label for="rfm_subject">Select Subject <span class="required">*</span></label>
          <select id="rfm_subject" name="subject" required>
            <option value="Request Sample">Request Sample</option>
            <option value="Ask for discount">Ask for discount</option>
            <option value="Request customized report">Request customized report</option>
            <option value="Download Free Sample">Download Free Sample</option>
          </select>
        </div>
      </div>

      <!-- Specific Research Requirement -->
      <div class="form-group" style="margin-top: 15px;">
        <label for="rfm_requirement">Specific Research Requirement <span class="required">*</span></label>
        <textarea id="rfm_requirement" name="specific_research_requirement" placeholder="Enter your specific requirement" rows="3" required></textarea>
      </div>

      <!-- Real Google reCAPTCHA Container -->
      <div class="recaptcha-wrapper" style="margin-top: 10px;">
        <div id="modal-recaptcha-container"></div>
        <span id="modal-recaptcha-error" class="recaptcha-error-text" style="color: #dc2626; font-size: 13.5px; margin-top: 5px; display: none;">Please verify that you are not a robot.</span>
      </div>

      <!-- Modal Action Buttons -->
      <div class="modal-actions-row">
        <button type="submit" id="modal-submit-btn" class="primary-button submit-btn">
          <span>Request Sample <span class="btn-arrow">→</span></span>
        </button>
        <button type="button" class="secondary-button cancel-btn" onclick="closeRequestModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>

<style>
/* Backdrop overlay */
.modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(8, 20, 36, 0.45);
  backdrop-filter: blur(12px);
  align-items: center;
  justify-content: center;
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
.form-group .iti {
  width: 100%;
  display: block;
}

.form-group .iti__input {
  width: 100% !important;
  padding: 12px 18px 12px 82px !important;
  border: 1.5px solid #e2e8f0;
  border-radius: 12px;
  font-size: 14px;
  outline: none;
  background: #fcfdfe;
  color: #1f2937;
  transition: all 0.2s ease-in-out;
  height: auto;
  box-sizing: border-box;
}

.form-group .iti__input:focus {
  border-color: #0783df;
  background: #ffffff;
  box-shadow: 0 0 0 4px rgba(7, 131, 223, 0.08);
}

.form-group .iti__selected-dial-code {
  font-size: 13.5px;
  font-weight: 600;
  color: #4b5563;
}

.form-group .iti__country-container {
  border-radius: 12px 0 0 12px;
}

.form-group .iti__selected-country-primary {
  border-radius: 11px 0 0 11px;
  padding: 0 8px;
}

.form-group .iti__arrow {
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-top: 5px solid #9ca3af;
  margin-left: 4px;
}

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

<script>
  let modalRecaptchaWidgetId = null;
  let modalItiInstance = null;
  let modalRecaptchaToken = '';

  document.addEventListener('DOMContentLoaded', function () {
    // We already load intl-tel-input CSS & JS in public.blade.php if we want, OR we can depend on contact-us injecting it,
    // BUT since it's global, we should check if window.intlTelInput is available when opening.
  });

  function initModalRecaptcha() {
    if (window.grecaptcha && window.grecaptcha.render && document.getElementById('modal-recaptcha-container')) {
      if (modalRecaptchaWidgetId === null) {
        try {
          modalRecaptchaWidgetId = window.grecaptcha.render('modal-recaptcha-container', {
            sitekey: window.RECAPTCHA_SITE_KEY || '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI', // Fallback local test key
            callback: (token) => {
              modalRecaptchaToken = token;
              document.getElementById('modal-recaptcha-error').style.display = 'none';
            },
            'expired-callback': () => {
              modalRecaptchaToken = '';
            }
          });
        } catch (e) {
          console.error('Modal reCAPTCHA rendering error:', e);
        }
      } else {
        window.grecaptcha.reset(modalRecaptchaWidgetId);
        modalRecaptchaToken = '';
      }
    } else {
      setTimeout(initModalRecaptcha, 300);
    }
  }

  window.openRequestModal = function(subject, reportName = '') {
    // Set Subject Dropdown
    const subjectEl = document.getElementById('rfm_subject');
    if (subjectEl) {
        // Fallback if subject value doesn't strictly match case
        const options = Array.from(subjectEl.options);
        const match = options.find(opt => opt.value.toLowerCase() === subject.toLowerCase());
        if(match) subjectEl.value = match.value;
        else subjectEl.value = 'Request Sample';
    }

    // Set internal report name reference
    document.getElementById('modal_report_name').value = reportName;
    
    // Inject dependencies on demand if they aren't loaded (like intl-tel-input)
    if (!document.getElementById('modal-iti-css')) {
        const link = document.createElement('link');
        link.id = 'modal-iti-css';
        link.rel = 'stylesheet';
        link.href = 'https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/css/intlTelInput.css';
        document.head.appendChild(link);
    }

    const initPhone = () => {
        const phoneInput = document.querySelector("#rfm_phone");
        if (!modalItiInstance && phoneInput) {
            modalItiInstance = window.intlTelInput(phoneInput, {
                initialCountry: "in",
                preferredCountries: ["in", "us", "uk"],
                separateDialCode: true,
                countrySearch: true,
                fixDropdownWidth: true,
                autoPlaceholder: "aggressive",
                formatOnDisplay: true,
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/js/utils.js",
            });
            
            const hiddenPhone = document.getElementById('rfm_full_phone');
            const updatePhone = () => { hiddenPhone.value = modalItiInstance.getNumber(); };
            phoneInput.addEventListener('change', updatePhone);
            phoneInput.addEventListener('keyup', updatePhone);
        }
    };

    if (typeof window.intlTelInput === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/js/intlTelInput.min.js';
        script.onload = initPhone;
        document.head.appendChild(script);
    } else {
        initPhone();
    }

    // Show Modal
    document.getElementById('request-form-modal').style.display = 'flex';
    document.getElementById('modal-request-form').style.display = 'flex';
    document.getElementById('modal-success-alert').style.display = 'none';

    // Reset Form
    document.getElementById('modal-request-form').reset();
    if (modalItiInstance) {
        modalItiInstance.setNumber('');
        document.getElementById('rfm_full_phone').value = '';
    }
    
    // Init ReCAPTCHA
    initModalRecaptcha();
  };

  window.closeRequestModal = function() {
    document.getElementById('request-form-modal').style.display = 'none';
  };

  window.submitRequestForm = function(event) {
    event.preventDefault();
    
    if (!modalRecaptchaToken) {
       document.getElementById('modal-recaptcha-error').style.display = 'block';
       return;
    }

    const submitBtn = document.getElementById('modal-submit-btn');
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span>Submitting...</span>';
    submitBtn.disabled = true;

    // Use FormData for serialization
    const formEl = document.getElementById('modal-request-form');
    const formData = new FormData(formEl);
    
    // Set recaptcha token
    formData.append('g-recaptcha-response', modalRecaptchaToken);
    
    // Create equivalent JSON for endpoint compatibility
    const jsonPayload = {};
    formData.forEach((value, key) => jsonPayload[key] = value);

    fetch('/request-form', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(jsonPayload)
    })
    .then(async response => {
        const data = await response.json().catch(() => null);
        if (response.ok) {
            document.getElementById('modal-request-form').style.display = 'none';
            document.getElementById('modal-success-alert').style.display = 'flex';
            setTimeout(() => {
                closeRequestModal();
            }, 3000);
        } else {
            alert(data?.message || 'Validation failed. Please check the fields and try again.');
        }
    })
    .catch(error => {
        console.error('Submission error:', error);
        alert('Failed to submit form. Please try again later.');
    })
    .finally(() => {
        submitBtn.innerHTML = originalBtnText;
        submitBtn.disabled = false;
    });
  };
  
  // Close modal when clicking outside of it
  document.addEventListener('click', function(event) {
    const backdrop = document.getElementById('request-form-modal');
    if (event.target === backdrop) {
        closeRequestModal();
    }
  });
</script>
