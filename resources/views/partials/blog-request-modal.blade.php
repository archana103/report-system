<div id="blog-request-modal" class="modal-backdrop" style="display: none;">
  <div class="modal-card" role="dialog" aria-modal="true">
    <!-- Close button (X) -->
    <button type="button" class="close-btn" onclick="closeBlogRequestModal()" aria-label="Close modal">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
    </button>

    <h2 class="modal-title">Request Sample</h2>
    <p class="modal-subtitle">Fill out the form below to receive a summary copy of this document, including key analysis, market scope, and research highlights.</p>

    <!-- Success Notification -->
    <div id="blog-modal-success-alert" class="success-alert" style="display: none;">
      <svg class="success-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
        <polyline points="20 6 9 17 4 12"></polyline>
      </svg>
      <span>Request Submitted Successfully!</span>
    </div>

    <form id="blog-request-form" class="modal-form" onsubmit="submitBlogRequestForm(event)">
      @csrf
      <input type="hidden" id="b_blog_id" name="blog_id">
      
      <div class="form-row-2">
        <!-- Full Name -->
        <div class="form-group">
          <label for="b_fullName">Full Name <span class="required">*</span></label>
          <input type="text" id="b_fullName" name="full_name" placeholder="Enter Your Full Name" required />
        </div>

        <!-- Business Email -->
        <div class="form-group">
          <label for="b_businessEmail">Business Email <span class="required">*</span></label>
          <input type="email" id="b_businessEmail" name="email" placeholder="Enter Business Email" required />
        </div>
      </div>

      <div class="form-row-2">
        <!-- Company Name -->
        <div class="form-group">
          <label for="b_companyName">Company Name <span class="required">*</span></label>
          <input type="text" id="b_companyName" name="company_name" placeholder="Enter Company Name" required />
        </div>

        <!-- Phone Number with intl-tel-input -->
        <div class="form-group">
          <label for="b_phone">Phone Number <span class="required">*</span></label>
          <input type="tel" id="b_phone" placeholder="Enter Phone Number" required />
          <input type="hidden" id="b_full_phone" name="phone">
        </div>
      </div>

      <!-- Select Country -->
      <div class="form-group">
        <label for="b_country">Country <span class="required">*</span></label>
        <select id="b_country" name="country" required>
          <option value="" disabled selected>Select Your Country</option>
          <option value="United States">United States</option>
          <option value="United Kingdom">United Kingdom</option>
          <option value="Canada">Canada</option>
          <option value="Australia">Australia</option>
          <option value="Germany">Germany</option>
          <option value="France">France</option>
          <option value="India">India</option>
          <option value="China">China</option>
          <option value="Japan">Japan</option>
          <option value="South Korea">South Korea</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <!-- Modal Action Buttons -->
      <div class="modal-actions-row" style="margin-top: 15px;">
        <button type="button" class="cancel-btn" style="flex: 1; border-color: #e2e8f0; color: #4b5563;" onclick="closeBlogRequestModal()">Cancel</button>
        <button type="submit" id="b-submit-btn" class="submit-btn" style="flex: 2; border-radius: 12px; height: 48px;">
          <span>Request Sample</span>
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  let blogItiInstance = null;

  window.openBlogRequestModal = function(blogId) {
    const formEl = document.getElementById('blog-request-form');
    if(formEl) formEl.reset();

    document.getElementById('b_blog_id').value = blogId;
    
    if (!document.getElementById('modal-iti-css')) {
        const link = document.createElement('link');
        link.id = 'modal-iti-css';
        link.rel = 'stylesheet';
        link.href = 'https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/css/intlTelInput.css';
        document.head.appendChild(link);
    }

    const initPhone = () => {
        const phoneInput = document.querySelector("#b_phone");
        if (!blogItiInstance && phoneInput) {
            blogItiInstance = window.intlTelInput(phoneInput, {
                initialCountry: "in",
                preferredCountries: ["in", "us", "uk"],
                separateDialCode: true,
                countrySearch: true,
                fixDropdownWidth: true,
                autoPlaceholder: "aggressive",
                formatOnDisplay: true,
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/js/utils.js",
            });
            
            const hiddenPhone = document.getElementById('b_full_phone');
            const updatePhone = () => { hiddenPhone.value = blogItiInstance.getNumber(); };
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

    document.getElementById('blog-request-modal').style.display = 'flex';
    document.getElementById('blog-request-form').style.display = 'flex';
    document.getElementById('blog-modal-success-alert').style.display = 'none';

    if (blogItiInstance) {
        blogItiInstance.setNumber('');
        document.getElementById('b_full_phone').value = '';
    }
  };

  window.closeBlogRequestModal = function() {
    document.getElementById('blog-request-modal').style.display = 'none';
  };

  window.submitBlogRequestForm = function(event) {
    event.preventDefault();
    
    const submitBtn = document.getElementById('b-submit-btn');
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span>Submitting...</span>';
    submitBtn.disabled = true;

    const formEl = document.getElementById('blog-request-form');
    const formData = new FormData(formEl);
    
    const jsonPayload = {};
    formData.forEach((value, key) => jsonPayload[key] = value);

    fetch('/blog-request', {
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
            document.getElementById('blog-request-form').style.display = 'none';
            document.getElementById('blog-modal-success-alert').style.display = 'flex';
            setTimeout(() => {
                closeBlogRequestModal();
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
  
  document.addEventListener('click', function(event) {
    const backdrop = document.getElementById('blog-request-modal');
    if (event.target === backdrop) {
        closeBlogRequestModal();
    }
  });
</script>
