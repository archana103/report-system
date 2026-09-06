<section class="content-row-section insights-section">
  <div class="section-heading row-heading">
    <div>
      <h2>Latest Insights</h2>
      <p>Explore expert perspectives, industry trends, and data-driven stories shaping global markets.</p>
    </div>
    <div class="slider-controls">
      <button aria-label="Previous" onclick="document.getElementById('insights-grid').scrollBy({left: -350, behavior: 'smooth'})">
          <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor" stroke-width="1.8" aria-hidden="true" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"></path>
          </svg>
      </button>
      <button class="active" aria-label="Next" onclick="document.getElementById('insights-grid').scrollBy({left: 350, behavior: 'smooth'})">
          <svg viewBox="0 0 24 24" fill="none" class="icon" stroke="currentColor" stroke-width="1.8" aria-hidden="true" stroke-linecap="round" stroke-linejoin="round">
            <path d="m9 18 6-6-6-6"></path>
          </svg>
      </button>
    </div>
  </div>
  <div class="insight-strip" id="insights-grid" style="display: flex; overflow-x: auto; scroll-snap-type: x mandatory; scrollbar-width: none;">
    @foreach($latestInsights as $item)
      <article class="insight-card" style="scroll-snap-align: start; flex: 0 0 calc(33.33% - 15px); min-width: 280px; margin-right: 20px;">
          <a href="{{ url('/blog/' . ($item->url ?? '')) }}" class="insight-card" style="text-decoration: none; color: inherit; display: block;">
            <img src="{{ $item->image ?? env('AWS_URL') . '/assets/images/default-report.png' }}" alt="{{ $item->title ?? '' }}" />
            <h3>{{ $item->title ?? '' }}</h3>
            <p>{{ $item->description ?? '' }}</p>
          </a>
      </article>
    @endforeach
  </div>
  <style>
  #insights-grid::-webkit-scrollbar { display: none; }
  </style>
  <x-center-action href="/blogs" text="Read More" />
</section>
