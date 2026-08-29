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
        rel="noopener noreferrer">
        <img src="{{ env('AWS_URL') }}/assets/images/footer_icons/facebook.png" alt="Facebook"
          class="social-icon-img" />
      </a>
      <a href="https://www.linkedin.com/company/epignosis-insights/" target="_blank" rel="noopener noreferrer">
        <img src="{{ env('AWS_URL') }}/assets/images/footer_icons/linkedin.png" alt="LinkedIn"
          class="social-icon-img" />
      </a>
      <a href="https://x.com/epignosisinsigh" target="_blank" rel="noopener noreferrer">
        <img src="{{ env('AWS_URL') }}/assets/images/footer_icons/x.png" alt="X" class="social-icon-img" />
      </a>
      <a href="https://www.instagram.com/epignosisinsights/" target="_blank" rel="noopener noreferrer">
        <img src="{{ env('AWS_URL') }}/assets/images/footer_icons/instagram.png" alt="Instagram"
          class="social-icon-img" />
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

@vite(['resources/css/app.css', 'resources/js/public.js'])