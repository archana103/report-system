@extends('layouts.public')

@section('content')
<link rel="stylesheet" href="{{ asset('frontend/css/checkoutStyle.css') }}">

<div class="checkout-page">
    <main class="checkout-main" style="padding-top: 80px;">
        <div class="section-shell">
            @if(!$report)
            <div class="checkout-empty" style="text-align: center; padding: 100px 0;">
                <p>Report details not found. Please go back and select a report.</p>
            </div>
            @else
            <div class="checkout-content">
                <!-- Page Header -->
                <div class="checkout-header" style="text-align: center; margin-bottom: 40px;">
                    <h1 style="font-size: 36px; font-weight: 700; color: #0f172a; margin-bottom: 16px;">Explore Our Pricing Plans</h1>
                    <p style="font-size: 16px; color: #64748b; max-width: 600px; margin: 0 auto;">Access detailed market insights, growth forecasts, competitive analysis, and strategic industry intelligence.</p>
                </div>

                <!-- Report Details Summary Block -->
                <div class="checkout-report-summary" style="background: #f8fafc; border-radius: 12px; padding: 24px; margin-bottom: 40px; border: 1px solid #e2e8f0; text-align: center;">
                    <div class="summary-details">
                        <h2 style="font-size: 20px; font-weight: 600; color: #1e293b; margin: 0 0 16px 0;">{{ $report->title }}</h2>
                        <div class="summary-meta" style="display: flex; gap: 24px; justify-content: center; font-size: 14px; color: #475569;">
                            <span>Report ID: <strong>{{ $report->report_sku ?? $report->id }}</strong></span>
                            <span>Format: <strong>{{ collect(explode(',', $report->format))->first() ?? 'PDF' }}</strong></span>
                            <span>Publish Date: <strong>{{ \Carbon\Carbon::parse($report->date)->format('M Y') }}</strong></span>
                        </div>
                    </div>
                </div>

                <!-- Pricing Grid -->
                <div class="pricing-grid">
                    @foreach($pricings as $index => $plan)
                    <div class="pricing-card {{ $index === 1 ? 'highlighted' : '' }}" id="pricing-card-{{ $plan->id }}">
                        <div class="card-header-info">
                            <h3>{{ $plan->title }}</h3>
                            <div class="price-box">
                                @if($plan->discount_cost)
                                <span class="original-price">${{ number_format($plan->discount_cost) }}</span>
                                @else
                                <span class="original-price">${{ number_format(ceil($plan->cost / 0.8)) }}</span>
                                @endif
                                <span class="discounted-price">${{ number_format($plan->cost) }}</span>
                            </div>
                        </div>
                        <p class="card-features-description">Access targeted market research matching your needs.</p>
                        <ul class="features-list">
                            @php
                                $features = explode("\n", $plan->details);
                            @endphp
                            @foreach($features as $feature)
                                @if(trim($feature) !== '')
                                    <li><span class="check-icon-green">✓</span> {{ trim($feature) }}</li>
                                @endif
                            @endforeach
                        </ul>
                        <button class="pricing-action-btn" onclick="selectLicense({{ $plan->id }})">
                            Buy Now
                            <span class="btn-circle-arrow">
                                <svg class="chevron-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <polyline points="9 18 15 12 9 6"/>
                                </svg>
                            </span>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </main>
</div>

<script>
    function selectLicense(licenseType) {
        var encryptedId = btoa(licenseType.toString());
        var slug = "{{ $report ? $report->slug_url ?? request()->route('slug') : request()->route('slug') }}";
        window.location.href = "/purchase/" + slug + "?ref=" + encryptedId;
    }
</script>
@endsection
