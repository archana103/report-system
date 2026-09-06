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
      <div class="contact-info">
        <p><span><img src="{{ env('AWS_URL') }}/assets/images/footer_icons/icon_mail.png" alt="Location"
              class="footer-icon-img" /></span>703 Kumar Corporate Building, Pune-411028, India</p>
        <p><span><img src="{{ env('AWS_URL') }}/assets/images/footer_icons/Icon.png" alt="Email"
              class="footer-icon-img" /></span>sales@epignosisinsights.com</p>
        <p><span><img src="{{ env('AWS_URL') }}/assets/images/footer_icons/icon_phone.png" alt="Phone"
              class="footer-icon-img" /></span>+91 9370865430</p>
      </div>

      <div class="payment-partners">
        <h4>Payment Partner</h4>
        <div class="payment-logos">
          <img src="{{ env('AWS_URL') }}/assets/images/bank_images/visa.png" alt="Visa" />
          <img src="{{ env('AWS_URL') }}/assets/images/bank_images/paypal.png" alt="PayPal" />
          <img src="{{ env('AWS_URL') }}/assets/images/bank_images/mastercard.png" alt="Mastercard" />
          <img src="{{ env('AWS_URL') }}/assets/images/bank_images/discover.png" alt="Discover" />
          <img src="{{ env('AWS_URL') }}/assets/images/bank_images/wire_transfer.png" alt="Wire Transfer" />
          <img src="{{ env('AWS_URL') }}/assets/images/bank_images/american.png" alt="American Express" />
        </div>
      </div>
    </div>
  </div>

  <div class="footer-links">
    <nav>
      <a href="/">Home</a>
      <a href="/about-us">About Us</a>
      <a href="/reports">Reports</a>
      <a href="/blogs">Blogs</a>
      <a href="/qualitative-services">Qualitative Services</a>
      <a href="/press-releases">PR</a>
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

<script src="{{ asset('js/public.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var upscrollBtn = document.getElementById("scrollToTopBtn");
    if (upscrollBtn) {
        window.addEventListener("scroll", function() {
            if (window.scrollY > 300) {
                upscrollBtn.style.display = "flex";
            } else {
                upscrollBtn.style.display = "none";
            }
        });
        upscrollBtn.addEventListener("click", function() {
            window.scrollTo({ top: 0, behavior: "smooth" });
        });
    }
});
</script>
<style>
.footer-contact {
  display: flex;
  flex-direction: column;
}
.payment-partners {
  margin-top: auto;
}
.payment-partners h4 {
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

.upscroll-button {
  position: fixed;
  bottom: 40px;
  right: 40px;
  width: 50px;
  height: 50px;
  border: none;
  border-radius: 50%;
  background-color: #0783df;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  cursor: pointer;
  z-index: 9999;
  transition: transform 0.2s ease, background-color 0.2s ease, opacity 0.2s ease;
}

.upscroll-button:hover {
  background-color: #0566b0;
  transform: translateY(-3px);
}

@media (max-width: 560px) {
  .upscroll-button {
    bottom: 20px;
    right: 20px;
    width: 44px;
    height: 44px;
  }
}
</style>