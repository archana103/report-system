@extends('layouts.public')

@section('content')
<style>
/* Case Studies UI Styling */
.cs-page {
    font-family: 'Inter', sans-serif;
    background-color: #FAFAFA;
}

.cs-banner {
    position: relative;
    padding: 100px 20px;
    text-align: center;
    background-position: center bottom;
    background-size: cover;
    background-repeat: no-repeat;
    min-height: 380px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.cs-banner-content {
    max-width: 800px;
    margin: 0 auto;
}

.cs-banner h1 {
    font-size: 42px;
    font-weight: 700;
    color: #1A1A1A;
    line-height: 1.2;
    margin-bottom: 24px;
}

.cs-banner h1 .text-blue {
    color: #0066cc;
}

.cs-banner p {
    font-size: 16px;
    color: #4A5568;
    line-height: 1.6;
    max-width: 600px;
    margin: 0 auto;
}

.cs-content {
    max-width: 1200px;
    margin: 60px auto 80px;
    padding: 0 20px;
    position: relative;
    z-index: 10;
}

.cs-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 32px;
}

@media (max-width: 768px) {
    .cs-grid {
        grid-template-columns: 1fr;
    }
}

.cs-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    text-decoration: none;
    padding: 20px;
}

.cs-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.05);
}

.cs-image-wrapper {
    width: 100%;
    aspect-ratio: 16/9;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 20px;
}

.cs-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.cs-card:hover .cs-image {
    transform: scale(1.05);
}

.cs-info h3 {
    font-size: 20px;
    font-weight: 700;
    color: #1A202C;
    margin-bottom: 12px;
    line-height: 1.4;
}

.cs-info p {
    font-size: 14px;
    color: #718096;
    line-height: 1.6;
    margin: 0;
}

/* Pagination styles */
.cs-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin-top: 60px;
}

.cs-pagination a, .cs-pagination span {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    border-radius: 50%;
    font-size: 14px;
    font-weight: 600;
    color: #4A5568;
    text-decoration: none;
    transition: all 0.2s ease;
}

.cs-pagination a:hover {
    background-color: #F1F5F9;
}

.cs-pagination .active {
    background-color: #0066FF;
    color: #FFFFFF;
}

.cs-pagination-arrow {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #4A5568;
    font-weight: 500;
    padding: 0 16px;
    border-radius: 20px !important;
}

.cs-pagination-arrow.active-btn {
    background-color: #0066FF;
    color: #FFFFFF;
}
</style>

<div class="cs-page">
    <main>
      <!-- Banner Section -->
      <section class="cs-banner" style="background-image: url('https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/case_study/case_study_cta.png');">
        <div class="cs-banner-content">
          <h1>Market Research <span class="text-blue">Case<br>Studies & Success Stories</span></h1>
          <p>Stay updated with the latest announcements, research developments, industry insights, and company news from Epignosis Insights.</p>
        </div>
      </section>

      <!-- Main Content -->
      <section class="cs-content">
        <div class="cs-grid">
            @forelse($initialCaseStudies as $cs)
            <a href="{{ url('/case-study/' . ($cs->url ?? $cs->id)) }}" class="cs-card">
              <div class="cs-image-wrapper">
                <img src="{{ !empty($cs->image) ? $cs->image : env('AWS_URL') . '/assets/images/default-report.png' }}" alt="{{ $cs->title ?? '' }}" class="cs-image" />
              </div>
              <div class="cs-info">
                <h3>{{ $cs->title ?? '' }}</h3>
                <p>{{ collect(explode(' ', strip_tags(html_entity_decode($cs->description))))->take(25)->implode(' ') }}...</p>
              </div>
            </a>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px; color: #718096;">
              <p>No Case Studies found.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($initialTotalPages > 1)
        <div class="cs-pagination">
            @if(request()->query('page', 1) > 1)
            <a href="?page={{ request()->query('page', 1) - 1 }}{{ request()->query('q') ? '&q='.request()->query('q') : '' }}" class="cs-pagination-arrow">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                Previous
            </a>
            @endif

            @php
                $currentPage = request()->query('page', 1);
                $start = max(1, $currentPage - 2);
                $end = min($initialTotalPages, $start + 4);
                $start = max(1, $end - 4);
            @endphp
            
            @for ($i = $start; $i <= $end; $i++)
                <a href="?page={{ $i }}{{ request()->query('q') ? '&q='.request()->query('q') : '' }}" class="{{ $i == $currentPage ? 'active' : '' }}">{{ $i }}</a>
            @endfor
            
            @if(request()->query('page', 1) < $initialTotalPages)
                <span style="color: #0066FF; letter-spacing: 2px;">...</span>
            @endif

            @if(request()->query('page', 1) < $initialTotalPages)
            <a href="?page={{ request()->query('page', 1) + 1 }}{{ request()->query('q') ? '&q='.request()->query('q') : '' }}" class="cs-pagination-arrow active-btn">
                Next
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
