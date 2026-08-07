<footer class="footer-section">
  <div class="footer-top">
    <div>
      <a class="brand footer-brand" href="/">
        <img src="{{ env('AWS_URL') }}/assets/images/logo.png" alt="Epignosis Insights Logo" class="brand-logo" />
      </a>
      <p>Delivering data-driven insights to support smarter business decisions.</p>
      <form id="newsletter-form" class="footer-form" method="POST" action="/newsletter">
        @csrf
        <input type="email" name="email" placeholder="Email Address" required />
        <button type="submit">Show Now!</button>
      </form>
      <p id="newsletter-message" style="font-size: 13px; margin-top: 8px; font-weight: 500; display: none;"></p>
    </div>

    <div class="footer-contact">
      <p><span><img src="{{ env('AWS_URL') }}/assets/images/footer_icons/icon_mail.png" alt="Location"
            class="footer-icon-img" /></span>703 Kumar Corporate Building, Pune-411028, India</p>
      <p><span><img src="{{ env('AWS_URL') }}/assets/images/footer_icons/Icon.png" alt="Email"
            class="footer-icon-img" /></span>sales@epignosisinsights.com</p>
      <p><span><img src="{{ env('AWS_URL') }}/assets/images/footer_icons/icon_phone.png" alt="Phone"
            class="footer-icon-img" /></span>+91 9370865430</p>
    </div>
  </div>

  <div class="footer-links">
    <nav>
      <a href="/">Home</a>
      <a href="/about-us">About Us</a>
      <a href="/reports">Reports</a>
      <a href="/blogs">Blogs</a>
      <a href="/press-releases">Press Release</a>
      <a href="/contact-us">Contact</a>
    </nav>
    <div class="social-links">
      <a href="https://www.facebook.com/people/Epignosis-Insights/61591089437924/" target="_blank"
        rel="noopener noreferrer" class="social-icon" aria-label="Facebook">
        <svg fill="currentColor" viewBox="0 0 24 24" class="social-icon-img"
          style="width:24px; height:24px; color:white;">
          <path
            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
        </svg>
      </a>
      <a href="https://www.linkedin.com/company/epignosis-insights/" target="_blank" rel="noopener noreferrer"
        class="social-icon" aria-label="LinkedIn">
        <svg fill="currentColor" viewBox="0 0 24 24" class="social-icon-img"
          style="width:24px; height:24px; color:white;">
          <path
            d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
        </svg>
      </a>
      <a href="https://x.com/epignosisinsigh" target="_blank" rel="noopener noreferrer" class="social-icon"
        aria-label="X (Twitter)">
        <svg fill="currentColor" viewBox="0 0 24 24" class="social-icon-img"
          style="width:24px; height:24px; color:white;">
          <path
            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L5.26 21.75H1.95l7.73-8.835L1.484 2.25h6.81l4.71 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
        </svg>
      </a>
      <a href="https://www.instagram.com/epignosisinsights/" target="_blank" rel="noopener noreferrer"
        class="social-icon" aria-label="Instagram">
        <svg fill="currentColor" viewBox="0 0 24 24" class="social-icon-img"
          style="width:24px; height:24px; color:white;">
          <path
            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
        </svg>
      </a>
    </div>
  </div>

  <div class="footer-bottom">
    <p>© 2026 epignosisinsights. All rights reserved.</p>
    <div>
      <a href="/terms-and-conditions">Terms & Conditions</a>
      <a href="/privacy-policy">Privacy Policy</a>
    </div>
  </div>
</footer>

<button id="scrollToTopBtn" class="upscroll-button" aria-label="Scroll to top" style="display: none;">
  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px" stroke-width="2">
     <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
  </svg>
</button>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('newsletter-form');
    const messageEl = document.getElementById('newsletter-message');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            
            messageEl.style.display = 'none';
            messageEl.textContent = '';
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': formData.get('_token') 
                }
            })
            .then(async response => {
                const data = await response.json().catch(() => ({}));
                messageEl.style.display = 'block';
                
                if (!response.ok) {
                    messageEl.style.color = '#fca5a5';
                    messageEl.textContent = data.errors && data.errors.email ? data.errors.email[0] : (data.message || 'Error subscribing.');
                } else {
                    messageEl.style.color = '#93e0c0';
                    messageEl.textContent = data.message || 'Successfully subscribed!';
                    form.reset();
                }
            })
            .catch(error => {
                messageEl.style.display = 'block';
                messageEl.style.color = '#fca5a5';
                messageEl.textContent = 'An error occurred. Please try again.';
            });
        });
    }

    const scrollBtn = document.getElementById('scrollToTopBtn');
    if (scrollBtn) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                scrollBtn.style.display = 'flex';
            } else {
                scrollBtn.style.display = 'none';
            }
        });
        
        scrollBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
</script>