<section class="services-section">
  <div class="section-heading centered">
    <h2>Our Services</h2>
    <p>Comprehensive research and analytics solutions designed to help businesses make informed, strategic decisions.</p>
  </div>
  <div class="services-map">
    
    <article class="service-card left">
      <div class="service-icon">
          <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor" stroke-width="1.8" aria-hidden="true" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 21a9 9 0 1 0-9-9 9 9 0 0 0 9 9Z"></path><path d="M12 17a5 5 0 1 0-5-5 5 5 0 0 0 5 5Z"></path><path d="M12 13a1 1 0 1 0-1-1 1 1 0 0 0 1 1Z"></path><path d="M20 4l-5.5 5.5"></path>
          </svg>
      </div>
      <h3>Custom Research Solutions</h3>
      <p>Tailored research designed to match your business goals and target markets.</p>
    </article>
    
    <article class="service-card right">
      <div class="service-icon">
          <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor" stroke-width="1.8" aria-hidden="true" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 18h6"></path><path d="M10 22h4"></path><path d="M8 14a6 6 0 1 1 8 0c-.9.8-1.3 1.7-1.4 3H9.4c-.1-1.3-.5-2.2-1.4-3Z"></path>
          </svg>
      </div>
      <h3>Consulting Services</h3>
      <p>Expert guidance to help you interpret data and make strategic decisions.</p>
    </article>
    
    <article class="service-card bottom">
      <div class="service-icon">
          <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor" stroke-width="1.8" aria-hidden="true" stroke-linecap="round" stroke-linejoin="round">
            <path d="M10 6V5a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v1"></path><path d="M4 7h16v13H4z"></path><path d="M9 12h6"></path>
          </svg>
      </div>
      <h3>Market Research Reports</h3>
      <p>Comprehensive reports covering market size, key trends, and future forecasts.</p>
    </article>
    
    <div class="services-center-overlay">
      <svg class="service-connectors" viewBox="0 0 980 610" preserveAspectRatio="none" aria-hidden="true">
        <defs>
          <marker id="service-arrow" viewBox="0 0 10 10" refX="8.5" refY="5" markerWidth="8" markerHeight="8"
            orient="auto">
            <path d="M1 1 L9 5 L1 9" />
          </marker>
        </defs>
        <path class="connector-path" marker-end="url(#service-arrow)" d="M 404 190 L 325 210" />
        <path class="connector-path" marker-end="url(#service-arrow)" d="M 576 190 L 655 210" />
        <path class="connector-path" marker-end="url(#service-arrow)" d="M 490 276 V 390" />
      </svg>
      <div class="service-center">
        <img src="{{ env('AWS_URL') }}/assets/images/service-center.png" alt="Service Map Center" class="service-center-img" />
      </div>
    </div>
  </div>
  
  <x-center-action href="/services" text="Explore Our Services" />
</section>
