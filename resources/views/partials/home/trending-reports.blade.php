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

    <x-center-action href="/reports" text="View All Reports" />
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