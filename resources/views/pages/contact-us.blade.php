@extends('layouts.public')

@section('content')




  <div class="contact-page">

    <main class="contact-main">
      <!-- Banner Section -->
      <section class="contact-banner">
        <div class="contact-banner-glow"></div>
        <div class="contact-banner-content section-shell">
          <h1>Get in Touch with Our Research Experts</h1>
          <p>
            Connect with our team for market research inquiries, custom reports, business insights, and strategic
            consulting solutions.
          </p>
        </div>
      </section>

      <!-- Main Layout Columns -->
      <section class="contact-content section-shell">
        <div class="contact-columns-grid">
          <!-- Left Column Form -->
          <div class="contact-form-column">
            <div class="contact-form-card">
              <!-- Success Alert -->
              @if(session('success'))
                <div class="contact-success-alert" style="margin-bottom: 20px;">
                  <svg class="success-alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <polyline points="20 6 9 17 4 12"></polyline>
                  </svg>
                  <span>{{ session('success') }}</span>
                </div>
              @endif

              @if($errors->any())
                <div class="contact-error-alert"
                  style="margin-bottom: 20px; color: #ef4444; font-size: 14px; padding: 12px; background: #fee2e2; border-radius: 6px;">
                  <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $err)
                      <li>{{ $err }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <form class="contact-form" method="POST" action="/contact-us">
                @csrf



                <!-- Full Name -->
                <div class="form-group">
                  <label for="contact_fullName">Full Name <span class="required">*</span></label>
                  <input type="text" id="contact_fullName" name="full_name" placeholder="Enter Your Full Name" required />
                </div>

                <!-- Email -->
                <div class="form-group">
                  <label for="contact_email">Email <span class="required">*</span></label>
                  <input type="email" id="contact_email" name="email" placeholder="Enter Your Email" required />
                </div>

                <!-- Phone Number -->
                <div class="form-group" wire:ignore>
                  <label for="contact_phone">Phone Number <span class="required">*</span></label>
                  <input type="tel" id="contact_phone" name="phone" required />
                </div>

                <!-- Select Country -->
                <div class="form-group">
                  <label for="contact_country">Select Country <span class="required">*</span></label>
                  <select id="contact_country" name="country" required>
                    <option value="" disabled selected>Select Country</option>
                    @foreach([
                        'Afghanistan',
                        'Albania',
                        'Algeria',
                        'American Samoa',
                        'Andorra',
                        'Angola',
                        'Anguilla',
                        'Antarctica',
                        'Antigua and Barbuda',
                        'Argentina',
                        'Armenia',
                        'Aruba',
                        'Australia',
                        'Austria',
                        'Azerbaijan',
                        'Bahamas',
                        'Bahrain',
                        'Bangladesh',
                        'Barbados',
                        'Belarus',
                        'Belgium',
                        'Belize',
                        'Benin',
                        'Bermuda',
                        'Bhutan',
                        'Bolivia',
                        'Bosnia and Herzegovina',
                        'Botswana',
                        'Brazil',
                        'Brunei',
                        'Bulgaria',
                        'Burkina Faso',
                        'Burundi',
                        'Cambodia',
                        'Cameroon',
                        'Canada',
                        'Cape Verde',
                        'Cayman Islands',
                        'Central African Republic',
                        'Chad',
                        'Chile',
                        'China',
                        'Colombia',
                        'Comoros',
                        'Congo',
                        'Costa Rica',
                        'Croatia',
                        'Cuba',
                        'Cyprus',
                        'Czech Republic',
                        'Denmark',
                        'Djibouti',
                        'Dominica',
                        'Dominican Republic',
                        'Ecuador',
                        'Egypt',
                        'El Salvador',
                        'Equatorial Guinea',
                        'Eritrea',
                        'Estonia',
                        'Ethiopia',
                        'Fiji',
                        'Finland',
                        'France',
                        'Gabon',
                        'Gambia',
                        'Georgia',
                        'Germany',
                        'Ghana',
                        'Greece',
                        'Grenada',
                        'Guatemala',
                        'Guinea',
                        'Guinea-Bissau',
                        'Guyana',
                        'Haiti',
                        'Honduras',
                        'Hong Kong',
                        'Hungary',
                        'Iceland',
                        'India',
                        'Indonesia',
                        'Iran',
                        'Iraq',
                        'Ireland',
                        'Israel',
                        'Italy',
                        'Jamaica',
                        'Japan',
                        'Jordan',
                        'Kazakhstan',
                        'Kenya',
                        'Kiribati',
                        'Kosovo',
                        'Kuwait',
                        'Kyrgyzstan',
                        'Laos',
                        'Latvia',
                        'Lebanon',
                        'Lesotho',
                        'Liberia',
                        'Libya',
                        'Liechtenstein',
                        'Lithuania',
                        'Luxembourg',
                        'Macedonia',
                        'Madagascar',
                        'Malawi',
                        'Malaysia',
                        'Maldives',
                        'Mali',
                        'Malta',
                        'Marshall Islands',
                        'Mauritania',
                        'Mauritius',
                        'Mexico',
                        'Micronesia',
                        'Moldova',
                        'Monaco',
                        'Mongolia',
                        'Montenegro',
                        'Morocco',
                        'Mozambique',
                        'Myanmar',
                        'Namibia',
                        'Nauru',
                        'Nepal',
                        'Netherlands',
                        'New Zealand',
                        'Nicaragua',
                        'Niger',
                        'Nigeria',
                        'North Korea',
                        'Norway',
                        'Oman',
                        'Pakistan',
                        'Palau',
                        'Palestine',
                        'Panama',
                        'Papua New Guinea',
                        'Paraguay',
                        'Peru',
                        'Philippines',
                        'Poland',
                        'Portugal',
                        'Qatar',
                        'Romania',
                        'Russia',
                        'Rwanda',
                        'Saint Kitts and Nevis',
                        'Saint Lucia',
                        'Samoa',
                        'San Marino',
                        'Saudi Arabia',
                        'Senegal',
                        'Serbia',
                        'Seychelles',
                        'Sierra Leone',
                        'Singapore',
                        'Slovakia',
                        'Slovenia',
                        'Solomon Islands',
                        'Somalia',
                        'South Africa',
                        'South Korea',
                        'South Sudan',
                        'Spain',
                        'Sri Lanka',
                        'Sudan',
                        'Suriname',
                        'Sweden',
                        'Switzerland',
                        'Syria',
                        'Taiwan',
                        'Tajikistan',
                        'Tanzania',
                        'Thailand',
                        'Togo',
                        'Tonga',
                        'Trinidad and Tobago',
                        'Tunisia',
                        'Turkey',
                        'Turkmenistan',
                        'Tuvalu',
                        'Uganda',
                        'Ukraine',
                        'United Arab Emirates',
                        'United Kingdom',
                        'United States',
                        'Uruguay',
                        'Uzbekistan',
                        'Vanuatu',
                        'Vatican City',
                        'Venezuela',
                        'Vietnam',
                        'Yemen',
                        'Zambia',
                        'Zimbabwe'
                      ] as $c)
                      <option value="{{ $c }}">{{ $c }}</option>
                    @endforeach
                  </select>
                </div>

                <!-- Company Name -->
                <div class="form-group">
                  <label for="contact_companyName">Company Name <span class="required">*</span></label>
                  <input type="text" id="contact_companyName" name="company_name" placeholder="Enter Company Name"
                    required />
                </div>

                <!-- Specific Research Requirement -->
                <div class="form-group">
                  <label for="contact_requirement">Specific Research Requirement <span class="required">*</span></label>
                  <textarea id="contact_requirement" name="specific_research_requirement"
                    placeholder="How can we help you?" rows="4" required></textarea>
                </div>`n <!-- Submit Button -->
                <div class="form-submit-row">
                  <button type="submit" class="primary-button contact-submit-btn">

                    <span style="display: flex; align-items: center; gap: 6px;">
                      Send Message
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 16l4-4-4-4M8 12h8"></path>
                      </svg>
                    </span>
                  </button>
                </div>
              </form>
            </div>
          </div>

          <!-- Right Column Details -->
          <div class="contact-info-column">
            <!-- Why Choose Us -->
            <div class="info-block">
              <h3>Why Choose Epignosis Insights</h3>
              <ul class="why-list">
                <li>
                  <img src="{{ env('AWS_URL') }}/assets/images/contact-us/tick.png"
                    style="width: 24px; height: 24px; flex-shrink: 0;" alt="check" />
                  Reliable Market Intelligence
                </li>
                <li>
                  <img src="{{ env('AWS_URL') }}/assets/images/contact-us/tick.png"
                    style="width: 24px; height: 24px; flex-shrink: 0;" alt="check" />
                  Global Industry Coverage
                </li>
                <li>
                  <img src="{{ env('AWS_URL') }}/assets/images/contact-us/tick.png"
                    style="width: 24px; height: 24px; flex-shrink: 0;" alt="check" />
                  Customized Research Solutions
                </li>
                <li>
                  <img src="{{ env('AWS_URL') }}/assets/images/contact-us/tick.png"
                    style="width: 24px; height: 24px; flex-shrink: 0;" alt="check" />
                  Expert Analyst Support
                </li>
              </ul>
            </div>

            <!-- Contact Information -->
            <div class="info-block contact-details-block">
              <h3>Contact Information</h3>
              <ul class="details-list">
                <li>
                  <img src="{{ env('AWS_URL') }}/assets/images/contact-us/black_message.png"
                    style="width: 35px; height: 35px; flex-shrink: 0;" alt="email" />
                  sales@epignosisinsights.com
                </li>
                <li>
                  <img src="{{ env('AWS_URL') }}/assets/images/contact-us/black_tel.png"
                    style="width: 35px; height: 35px; flex-shrink: 0;" alt="phone" />
                  +91 9370865430
                </li>
                <li>
                  <img src="{{ env('AWS_URL') }}/assets/images/contact-us/black_location.png"
                    style="width: 35px; height: 35px; flex-shrink: 0;" alt="location" />
                  703 Kumar Corporate Building, Pune-411028, India
                </li>
              </ul>
            </div>

            <!-- Follow Us -->
            <div class="info-block follow-us-block">
              <h3>Follow Us</h3>
              <div class="contact-social-links">
                <a href="https://www.facebook.com/people/Epignosis-Insights/61591089437924/" target="_blank"
                  rel="noopener noreferrer" class="social-icon" aria-label="Facebook">
                  <svg fill="currentColor" viewBox="0 0 24 24"
                    style="width:35px; height:35px; flex-shrink:0; color:#111827;">
                    <path
                      d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                  </svg>
                </a>
                <a href="https://www.linkedin.com/company/epignosis-insights/" target="_blank" rel="noopener noreferrer"
                  class="social-icon" aria-label="LinkedIn">
                  <svg fill="currentColor" viewBox="0 0 24 24"
                    style="width:35px; height:35px; flex-shrink:0; color:#111827;">
                    <path
                      d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
                  </svg>
                </a>
                <a href="https://x.com/epignosisinsigh" target="_blank" rel="noopener noreferrer" class="social-icon"
                  aria-label="X (Twitter)">
                  <svg fill="currentColor" viewBox="0 0 24 24"
                    style="width:35px; height:35px; flex-shrink:0; color:#111827;">
                    <path
                      d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L5.26 21.75H1.95l7.73-8.835L1.484 2.25h6.81l4.71 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                  </svg>
                </a>
                <a href="https://www.instagram.com/epignosisinsights/" target="_blank" rel="noopener noreferrer"
                  class="social-icon" aria-label="Instagram">
                  <svg fill="currentColor" viewBox="0 0 24 24"
                    style="width:35px; height:35px; flex-shrink:0; color:#111827;">
                    <path
                      d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>`n
    </main>
  </div>
@endsection