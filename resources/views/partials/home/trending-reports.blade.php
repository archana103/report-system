<section id="reports" class="reports-section">
  <div class="section-shell">
    <div class="section-heading centered">
      <h2>Top Trending Market Reports</h2>
      <p>Explore our most in-demand reports featuring the latest industry trends, forecasts, and data-driven insights.
      </p>
    </div>

    <div class="category-filter">
      @php $activeCategory = request('category', 'All'); @endphp
      <a href="javascript:void(0)" data-url="{{ url('/') }}" class="category-btn {{ $activeCategory === 'All' ? 'active' : '' }}"
        style="text-decoration: none;">All</a>
      @foreach($initialCategories as $cat)
        <a href="javascript:void(0)" data-url="{{ url('/?category=' . urlencode($cat->name)) }}"
          class="category-btn {{ $activeCategory === $cat->name ? 'active' : '' }}" style="text-decoration: none;">{{ $cat->name }}</a>
      @endforeach
    </div>

    <div id="trending-reports-list" class="report-list" style="transition: opacity 0.3s;">
      @include('partials.home.trending-report-cards')
    </div>

    <div class="center-action">
      <a href="/reports" class="primary-button small">
        View All Reports
        <svg viewBox="0 0 512 512" class="small-icon"
          style="fill: currentColor; stroke: none; width: 18px; height: 18px;" aria-hidden="true">
          <path
            d="M165.013,288.946h75.034c6.953,0,12.609,5.656,12.609,12.608v26.424c0,7.065,3.659,9.585,7.082,9.585 c2.106,0,4.451-0.936,6.78-2.702l90.964-69.014c3.416-2.589,5.297-6.087,5.297-9.844c0-3.762-1.881-7.259-5.297-9.849 l-90.964-69.014c-2.329-1.766-4.674-2.702-6.78-2.702c-3.424,0-7.082,2.519-7.082,9.584v26.425c0,6.952-5.656,12.608-12.609,12.608 h-75.034c-8.707,0-15.79,7.085-15.79,15.788v34.313C149.223,281.862,156.305,288.946,165.013,288.946z">
          </path>
          <path
            d="M256,0C114.842,0,0.002,114.84,0.002,256S114.842,512,256,512c141.158,0,255.998-114.84,255.998-256 S397.158,0,256,0z M256,66.785c104.334,0,189.216,84.879,189.216,189.215S360.334,445.215,256,445.215S66.783,360.336,66.783,256 S151.667,66.785,256,66.785z">
          </path>
        </svg>
      </a>
    </div>
  </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const filterLinks = document.querySelectorAll('.category-filter .category-btn');
    const reportsList = document.getElementById('trending-reports-list');

    if (!reportsList) return;

    filterLinks.forEach(link => {
        link.addEventListener("click", function(e) {
            e.preventDefault();
            
            // Remove active classes
            filterLinks.forEach(l => l.classList.remove('active'));
            // Add active class to clicked
            this.classList.add('active');

            const url = this.getAttribute('data-url');
            
            // Visual fade-out effect during load
            reportsList.style.opacity = '0.5';
            reportsList.style.pointerEvents = 'none';

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if(!response.ok) throw new Error("Network error");
                return response.text();
            })
            .then(html => {
                reportsList.innerHTML = html;
                reportsList.style.opacity = '1';
                reportsList.style.pointerEvents = 'auto';
            })
            .catch(error => {
                console.error('Error fetching reports:', error);
                reportsList.style.opacity = '1';
                reportsList.style.pointerEvents = 'auto';
                reportsList.innerHTML = '<div style="text-align:center; padding: 20px; color: red;">Failed to load reports. Please try again.</div>';
            });
        });
    });
});
</script>

<style>
  .hover-primary-title {
    transition: color 0.2s ease-in-out;
  }

  .hover-primary-title:hover {
    color: #0783df;
  }
</style>