@extends('layouts.public')

@section('content')
<div class="blogs-page">

    <main class="blogs-main">
      <!-- Banner Section -->
      <section class="blogs-banner" style="background-image: url('https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/background-image/blogbg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="blogs-banner-content section-shell">
          <h1>Market Insights & Industry Trends</h1>
          <p>
            Explore expert articles, market trends, industry analysis, and business insights across global sectors.
          </p>
        </div>
      </section>

      <!-- Blogs Grid -->
      <section class="blogs-content section-shell">
        <div class="blogs-container">
            <div class="blogs-grid">
                @foreach($initialBlogs as $blog)
                <a href="{{ url('/blog/' . ($blog->url ?? $blog->id)) }}" class="blog-card" style="display: block; text-decoration: none; color: inherit;">
                  <div class="blog-image-wrapper">
                    <img src="{{ !empty($blog->image) ? $blog->image : '/assets/images/default-report.png' }}" alt="{{ $blog->title ?? '' }}" class="blog-image" />
                  </div>
                  <div class="blog-info">
                    <h3>{{ $blog->title ?? '' }}</h3>
                    <p>{{ $blog->description ?? '' }}</p>
                  </div>
                </a>
                @endforeach
            </div>

            @if(empty($initialBlogs))
            <div class="blogs-empty">
              <p>No blog posts found. Please check back later!</p>
            </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($initialTotalPages > 1)
        <div class="blog-pagination" style="display: flex;">
            @if(request()->query('page', 1) > 1)
            <a href="?page={{ request()->query('page', 1) - 1 }}" class="pagination-arrow prev-btn">
                <svg class="arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
                </svg>
                Previous
            </a>
            @endif

            <div class="pagination-numbers">
                @php
                    $currentPage = request()->query('page', 1);
                    $start = max(1, $currentPage - 2);
                    $end = min($initialTotalPages, $start + 4);
                    $start = max(1, $end - 4);
                @endphp
                @for ($i = $start; $i <= $end; $i++)
                    <a href="?page={{ $i }}" class="pagination-num {{ $i == $currentPage ? 'active' : '' }}" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">{{ $i }}</a>
                @endfor
            </div>

            @if(request()->query('page', 1) < $initialTotalPages)
            <a href="?page={{ request()->query('page', 1) + 1 }}" class="pagination-arrow next-btn active-arrow">
                Next
                <svg class="arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 18 6-6-6-6"/>
                </svg>
            </a>
            @endif
        </div>
        @endif
      </section>
    </main>
</div>
@endsection
