@foreach($trendingReports as $report)
  <article class="report-list-card simple-card">
    <div class="report-details">
      <a href="{{ url('/report/' . (!empty($report->slug) && $report->slug !== '#' ? $report->slug : $report->id)) }}"
        style="color: inherit; text-decoration: none;">
        <h3 class="hover-primary-title">{{ $report->title ?? '' }}</h3>
      </a>
      <p>{!! \Illuminate\Support\Str::limit(strip_tags($report->description ?? ''), 150) !!}</p>
      <div class="report-metadata-simple">
        <span class="meta-item">Category: <strong>{{ $report->category ?? 'All' }}</strong></span>
        <span class="meta-item">Publish Date: <strong>{{ $report->date ?? now()->format('F Y') }}</strong></span>
        <a href="{{ url('/report/' . (!empty($report->slug) && $report->slug !== '#' ? $report->slug : $report->id)) }}" class="view-report-link hover-primary-title">View Report ></a>
      </div>
    </div>
  </article>
@endforeach

@if(empty($trendingReports) || count($trendingReports) == 0)
  <div class="no-results" style="grid-column: 1 / -1; padding: 40px; text-align: center; color: #6b7280; font-size: 16px;">
    No top trending reports found for this category.
  </div>
@endif
