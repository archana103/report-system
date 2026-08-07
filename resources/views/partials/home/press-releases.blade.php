<section class="content-row-section">
  <div class="section-heading row-heading">
    <div>
      <h2>Press Releases</h2>
      <p>Latest announcements, research highlights, and industry updates from our analysts.</p>
    </div>
    <div class="slider-controls">
      <button aria-label="Previous" onclick="document.getElementById('pr-grid').scrollBy({left: -350, behavior: 'smooth'})">
          <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor" stroke-width="1.8" aria-hidden="true" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"></path>
          </svg>
      </button>
      <button class="active" aria-label="Next" onclick="document.getElementById('pr-grid').scrollBy({left: 350, behavior: 'smooth'})">
          <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor" stroke-width="1.8" aria-hidden="true" stroke-linecap="round" stroke-linejoin="round">
            <path d="m9 18 6-6-6-6"></path>
          </svg>
      </button>
    </div>
  </div>
  <div class="story-grid" id="pr-grid" style="display: flex; overflow-x: auto; scroll-snap-type: x mandatory; scrollbar-width: none;">
    @foreach($pressReleases as $item)
      <article class="story-card" style="scroll-snap-align: start; flex: 0 0 calc(33.33% - 15px); min-width: 280px; margin-right: 20px;">
          <a href="{{ url('/press-release/' . ($item->url ?? '')) }}" class="insight-card pr-card" style="text-decoration: none; color: inherit; display: block;">
            <img src="{{ $item->image ?? env('AWS_URL') . '/assets/images/default-report.png' }}" alt="{{ $item->title ?? '' }}" />
            <div class="pr-meta" style="margin: 12px 0 8px; font-size: 13px; color: #6b7280; display: flex; align-items: center; gap: 8px;">
                <span class="pr-date">{{ $item->date ?? ($item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') : '') }}</span>
            </div>
            <h3>{{ $item->title ?? '' }}</h3>
            <p>{{ $item->description ?? '' }}</p>
          </a>
      </article>
    @endforeach
  </div>
  <style>
  #pr-grid::-webkit-scrollbar { display: none; }
  </style>
  <x-center-action href="/press-releases" text="Read More" />
</section>
