@extends('layouts.public')

@section('content')
<div class="thankyou-page">
    <main class="thankyou-main">
      <div class="thankyou-container section-shell">
        <h1 class="thankyou-title">Thank You for Your Request!</h1>
        <p class="thankyou-message">
          We've received your inquiry successfully. Our team will review your request and get back to you shortly with the relevant details and next steps.
        </p>
        <div class="thankyou-actions">
          <a href="/reports" class="primary-button" style="text-decoration: none;">Explore Reports</a>
          <a href="/" class="secondary-button" style="text-decoration: none;">Back to Home</a>
        </div>
      </div>
    </main>
</div>
@endsection
