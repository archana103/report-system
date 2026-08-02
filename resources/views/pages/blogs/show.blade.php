@extends('layouts.public')

@section('content')
<div class="blog-detail-page">
    <main class="blog-detail-main">
      <div class="section-shell">
        <div class="blog-detail-content">
          <!-- Breadcrumbs -->
          <div class="blog-breadcrumbs" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; font-size: 14px; margin-bottom: 24px; color: #6b7280;">
            <a href="/" style="color: #0783df; text-decoration: none;">Home</a>
            <span>/</span>
            <a href="/blogs" style="color: #0783df; text-decoration: none;">Blog</a>
            <span>/</span>
            <span style="display: -webkit-box; -webkit-line-clamp: 1; line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; word-break: break-all; color: #4b5563;" title="{{ $blog->title }}">{{ $blog->breadcrumb_title ?? $blog->title }}</span>
          </div>

          <!-- Main Layout Grid -->
          <div class="blog-detail-layout">
            <!-- Left Column Content -->
            <article class="blog-post-content">
              <div class="blog-pub-date">Published: {{ $blog->date ?? ($blog->created_at ? \Carbon\Carbon::parse($blog->created_at)->format('Y-m-d') : '') }}</div>
              <h1 class="blog-post-title">{{ $blog->title }}</h1>

              <div class="blog-main-image-wrapper">
                <img src="{{ !empty($blog->image) ? $blog->image : '/assets/images/default-report.png' }}" alt="{{ $blog->title }}" class="blog-main-image" />
              </div>

              <!-- Main Rich Text Body -->
              <div class="blog-body-text">
                  {!! optional($blog->detail)->description ?? '<p>No content details available.</p>' !!}
              </div>

              <!-- FAQs Section -->
              @if(!empty($blog->detail) && !empty($blog->detail->faqs) && count($blog->detail->faqs) > 0)
              <section class="blog-faqs">
                <h2 class="faq-title">Frequently Asked Questions</h2>
                <div class="faq-accordion">
                  @foreach($blog->detail->faqs as $idx => $faq)
                  <details class="faq-item"><summary class="faq-header"><span>{{ is_array($faq) ? $faq['question'] : $faq->question }}</span></summary><div class="faq-body"><div class="faq-content">
                        {{ is_array($faq) ? $faq['answer'] : $faq->answer }}
                      </div></div></details>
                  @endforeach
                </div>
              </section>
              @endif
            </article>

            <!-- Right Column Sidebar -->
            <aside class="blog-sidebar">
              <!-- CTA Widget -->
              <div class="sidebar-widget widget-cta">
                <h3>Unlock Premium Market Insights</h3>
                <p>Access detailed industry analysis, market forecasts, and strategic insights tailored to your business needs.</p>
                <a class="widget-cta-btn" href="/contact-us">
                  Request Sample
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                  </svg>
                </a>
              </div>

              <!-- Related Articles Widget -->
              @if(!empty($blog->related_articles) && count($blog->related_articles) > 0)
              <div class="sidebar-widget widget-related">
                <h3>Related Articles</h3>
                <div class="related-articles-list">
                  @foreach($blog->related_articles as $item)
                  <a href="{{ url('/blog/' . ($item->url ?? (is_array($item) ? $item['url'] : ''))) }}" class="related-article-item" style="text-decoration: none; color: inherit;">
                    <h4>{{ is_array($item) ? $item['title'] : $item->title }}</h4>
                    <p>{{ is_array($item) ? $item['description'] : $item->description }}...</p>
                  </a>
                  @endforeach
                </div>
              </div>
              @endif
            </aside>
          </div>
        </div>
      </div>
    </main>
</div>
@endsection
