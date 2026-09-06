<header class="site-header">
  <a class="brand" href="/" aria-label="Epignosis Insights home">
    <img src="{{ env('AWS_URL') }}/assets/images/logo.png" alt="Epignosis Insights Logo" class="brand-logo" />
  </a>

  <nav class="main-nav" aria-label="Main navigation">
    <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
    <a href="/reports" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">Reports</a>
    <div class="dropdown-menu-container">
      <a href="/reports" class="dropdown-trigger">
        Industry
        <svg class="chevron-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="m6 9 6 6 6-6"></path></svg>
      </a>
      <div class="dropdown-menu dropdown-left-align">
        @foreach($headerCategories as $category)
          <a href="{{ url('/industry/' . ($category->slug_url ?: $category->name)) }}">{{ $category->name }}</a>
        @endforeach
      </div>
    </div>
    <a href="/qualitative-services" class="{{ request()->routeIs('qualitative.services') ? 'active' : '' }}">Qualitative Services</a>
    <a href="/press-releases" class="{{ request()->routeIs('press-releases.*') ? 'active' : '' }}">PR</a>
    <a href="/blogs" class="{{ request()->routeIs('blogs.*') ? 'active' : '' }}">Blog</a>
  </nav>

  <div class="header-actions">
    <div class="top-banner">
      <a href="/about-us">About Us</a>
      <div class="dropdown-menu-container">
        <a href="/services" class="dropdown-trigger">Service</a>
      </div>
      <a href="/contact-us">Contact</a>
    </div>

    <div class="bottom-actions">
      <form class="header-search-container" action="{{ url('/reports') }}" method="GET">
        <label class="header-search">
          <input type="search" name="q" value="{{ request('q') }}" placeholder="Search Report" />
          <button type="submit" class="header-search-submit" aria-label="Search reports"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><path d="m20 20-3.5-3.5"></path></svg></button>
        </label>
      </form>
      <a class="call-button" href="tel:+919370941234">
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.35 1.9.66 2.8a2 2 0 0 1-.45 2.11L8.05 9.9a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.31 1.84.53 2.8.66A2 2 0 0 1 22 16.92Z"></path>
        </svg>
        Call Now
      </a>
    </div>
  </div>
</header>
<style>
.header-search-container { position: relative; max-width: 300px; width: 100%; }
.header-search-submit { border: 0; background: transparent; padding: 0; cursor: pointer; display: flex; }
.header-search.search-active { border-color: #3b82f6; box-shadow: 0 0 0 1px #3b82f6; border-bottom-left-radius: 0; border-bottom-right-radius: 0; }
.search-dropdown-menu { position: absolute; top: 100%; right: 0; width: 130%; background: #ffffff; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 12px 12px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); z-index: 100; overflow: hidden; animation: slideDown 0.2s ease-out; }
.search-status { padding: 16px; text-align: center; color: #6b7280; font-size: 14px; background: #f9fafb; }
.search-results-list { display: flex; flex-direction: column; }
.search-result-item { display: flex; align-items: flex-start; gap: 12px; padding: 12px 16px; border-bottom: 1px solid #f3f4f6; color: inherit; text-decoration: none; transition: background-color 0.15s ease; }
.search-result-item:hover { background-color: #f8fafc; }
.search-icon { flex-shrink: 0; width: 36px; height: 42px; background: #eff6ff; color: #3b82f6; border-radius: 6px; display: flex; align-items: center; justify-content: center; }
.search-content h4 { margin: 0; font-size: 13px; font-weight: 500; color: #1f2937; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-align: left; }
.view-all-link { display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px; background: #f8fafc; color: #2563eb; font-weight: 600; font-size: 13px; text-decoration: none; transition: all 0.2s; }
.view-all-link:hover { background: #eff6ff; color: #1d4ed8; }
.view-all-link svg { width: 16px; height: 16px; }
@keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
</style>
