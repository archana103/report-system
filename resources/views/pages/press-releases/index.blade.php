@extends('layouts.public')

@section('content')
<div class="press-page">

    <main class="press-main">
      <!-- Banner Section -->
      <section class="press-banner" style="background-image: url('{{ env('AWS_URL') }}/assets/images/background-image/press_relasebg.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="press-banner-content section-shell">
          <h1>Press Releases</h1>
          <p>
            Stay updated with the latest announcements, research developments, industry insights, and company news from Epignosis Insights.
          </p>
        </div>
      </section>

      <!-- Main Content -->
      <section class="press-content section-shell">
        <div class="press-content-header">
          <h2>Latest Press Releases</h2>
          <form method="GET" action="{{ url('/press-releases') }}" class="press-search-wrapper">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search press releases..." class="press-search-input" />
            <button type="submit" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 0 10px; color: #64748b; position: absolute; right: 0; top: 0; height: 100%;">
                <svg class="search-icon" style="position: static; margin: 0; transform: none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="11" cy="11" r="7"></circle>
                  <path d="m20 20-3.5-3.5"></path>
                </svg>
            </button>
          </form>
        </div>

        <div class="press-container">
            <div class="press-grid">
                @foreach($initialPressReleases as $pr)
                <a href="{{ url('/press-release/' . ($pr->url ?? $pr->id)) }}" class="press-card" style="display: block; text-decoration: none; color: inherit;">
                  <div class="press-image-wrapper">
                    <img src="{{ !empty($pr->image) ? $pr->image : env('AWS_URL') . '/assets/images/default-report.png' }}" alt="{{ $pr->title ?? '' }}" class="press-image" />
                  </div>
                  <div class="press-info">
                    <span class="press-date">
                      <span class="dot">•</span>
                      {{ $pr->date ?? ($pr->created_at ? \Carbon\Carbon::parse($pr->created_at)->format('Y-m-d') : '') }}
                    </span>
                    <h3>{{ $pr->title ?? '' }}</h3>
                    <p>{{ $pr->description ?? '' }}</p>
                  </div>
                </a>
                @endforeach
            </div>

            @if(empty($initialPressReleases))
            <div class="press-empty">
              <p>No press releases found. Try searching for something else!</p>
            </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($initialTotalPages > 1)
        <div class="press-pagination" style="display: flex;">
            @if(request()->query('page', 1) > 1)
            <a href="?page={{ request()->query('page', 1) - 1 }}{{ request()->query('q') ? '&q='.request()->query('q') : '' }}" class="pagination-arrow prev-btn">
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
                    <a href="?page={{ $i }}{{ request()->query('q') ? '&q='.request()->query('q') : '' }}" class="pagination-num {{ $i == $currentPage ? 'active' : '' }}" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">{{ $i }}</a>
                @endfor
            </div>

            @if(request()->query('page', 1) < $initialTotalPages)
            <a href="?page={{ request()->query('page', 1) + 1 }}{{ request()->query('q') ? '&q='.request()->query('q') : '' }}" class="pagination-arrow next-btn active-arrow">
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
