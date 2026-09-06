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
                  <input type="text" id="contact_fullName" name="full_name" placeholder="Enter Your Full Name"
                    value="{{ old('full_name') }}" required />
                </div>

                <!-- Email -->
                <div class="form-group">
                  <label for="contact_email">Email <span class="required">*</span></label>
                  <input type="email" id="contact_email" name="email" placeholder="Enter Your Email"
                    value="{{ old('email') }}" required />
                </div>

                <!-- Phone Number -->
                <div class="form-group">
                  <label for="contact_phone">Phone Number <span class="required">*</span></label>
                  <!-- The visible input for user typing -->
                  <input type="tel" id="contact_phone" value="{{ old('phone') }}" required />
                  <!-- Hidden input to store full international number -->
                  <input type="hidden" id="full_contact_phone" name="phone" value="{{ old('phone') }}" />
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
                      <option value="{{ $c }}" {{ old('country') == $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                  </select>
                </div>

                <!-- Company Name -->
                <div class="form-group">
                  <label for="contact_companyName">Company Name <span class="required">*</span></label>
                  <input type="text" id="contact_companyName" name="company_name" placeholder="Enter Company Name"
                    value="{{ old('company_name') }}" required />
                </div>

                <!-- Specific Research Requirement -->
                <div class="form-group">
                  <label for="contact_requirement">Specific Research Requirement <span class="required">*</span></label>
                  <textarea id="contact_requirement" name="specific_research_requirement"
                    placeholder="How can we help you?" rows="4"
                    required>{{ old('specific_research_requirement') }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 24px;">
                  <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                  @error('g-recaptcha-response')
                    <div style="color: #ef4444; font-size: 13px; margin-top: 4px;">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Submit Button -->
                <div class="form-submit-row" style="margin-top: 15px;">
                  <button type="submit" class="primary-button contact-submit-btn">
                    <span style="display: flex; align-items: center; gap: 6px;">
                      Send Message
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" style="width: 18px; height: 18px;">
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
                  <img src="{{ env('AWS_URL') }}/assets/images/contact-us/black_facebook.png"
                    style="width: 35px; height: 35px; flex-shrink: 0;" alt="Facebook" />
                </a>
                <a href="https://www.linkedin.com/company/epignosis-insights/" target="_blank" rel="noopener noreferrer"
                  class="social-icon" aria-label="LinkedIn">
                   <img src="{{ env('AWS_URL') }}/assets/images/contact-us/black_linkedin.png"
                    style="width: 35px; height: 35px; flex-shrink: 0;" alt="LinkedIn" />
                </a>
                <a href="https://x.com/epignosisinsigh" target="_blank" rel="noopener noreferrer" class="social-icon"
                  aria-label="X (Twitter)">
                    <img src="{{ env('AWS_URL') }}/assets/images/contact-us/black_x.png"
                    style="width: 35px; height: 35px; flex-shrink: 0;" alt="X" />
                </a>
                <a href="https://www.instagram.com/epignosisinsights/" target="_blank" rel="noopener noreferrer"
                  class="social-icon" aria-label="Instagram">
                 <img src="{{ env('AWS_URL') }}/assets/images/contact-us/black_insta.png"
                    style="width: 35px; height: 35px; flex-shrink: 0;" alt="Instagram" />
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      @php
      $faqs = [
          [
              'question' => 'How can I request a customized market research report?',
              'answer' => 'Contact our research team with your requirements, including industry, geography, segmentation, and objectives. We will prepare a tailored proposal based on your business needs.'
          ],
          [
              'question' => 'Do you offer custom research and consulting services?',
              'answer' => 'Yes. We provide custom market research, competitive intelligence, primary research, market sizing, forecasting, pricing analysis, feasibility studies, and strategic consulting across multiple industries.'
          ],
          [
              'question' => 'How quickly will I receive a response after submitting an inquiry?',
              'answer' => 'Our team typically responds within 24 business hours to discuss your requirements, provide additional information, or share a quotation.'
          ],
          [
              'question' => 'Can I request a sample report before purchasing?',
              'answer' => 'Yes. We can provide a sample report or table of contents to help you evaluate the report structure, methodology, and level of analysis.'
          ],
          [
              'question' => 'Do you provide analyst support after report purchase?',
              'answer' => 'Yes. Complimentary analyst support is available for a specified period after purchase to help clarify report findings, assumptions, and methodologies.'
          ]
      ];
      @endphp

      <!-- FAQ Section Accordion -->
      <section class="contact-faqs section-shell">
        <h2 class="faq-section-title">Frequently Asked Questions</h2>
        <div class="faq-accordion">
          @foreach($faqs as $idx => $faq)
          <div class="faq-item" id="faq-item-{{ $idx }}">
            <button class="faq-header" type="button" onclick="toggleFaq({{ $idx }})">
              <span>{{ $faq['question'] }}</span>
              <span class="faq-toggle-icon" id="faq-icon-{{ $idx }}">+</span>
            </button>
            <div class="faq-body" id="faq-body-{{ $idx }}" style="max-height: 0px;">
              <div class="faq-content">
                {{ $faq['answer'] }}
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </section>
    </main>
  </div>

  <!-- intl-tel-input styles -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/css/intlTelInput.css" />
  <style>
    /* intl-tel-input overrides to match form design */
    .iti {
      width: 100%;
      display: block;
    }

    .iti__input {
      width: 100% !important;
      padding: 12px 18px 12px 82px !important;
      /* Extra padding for dropdown */
      border: 1.5px solid #e2e8f0;
      border-radius: 12px;
      font-size: 14px;
      outline: none;
      background: #fcfdfe;
      color: #1f2937;
      transition: all 0.2s ease-in-out;
      height: auto;
      box-sizing: border-box;
    }

    .iti__input:focus {
      border-color: #0783df;
      background: #ffffff;
      box-shadow: 0 0 0 4px rgba(7, 131, 223, 0.08);
    }

    .iti__selected-dial-code {
      font-size: 13.5px;
      font-weight: 600;
      color: #4b5563;
    }

    .iti__country-container {
      border-radius: 12px 0 0 12px;
    }

    .iti__selected-country-primary {
      border-radius: 11px 0 0 11px;
      padding: 0 8px;
    }

    .iti__arrow {
      border-left: 4px solid transparent;
      border-right: 4px solid transparent;
      border-top: 5px solid #9ca3af;
      margin-left: 4px;
    }
  </style>

  <!-- intl-tel-input scripts & initialization -->
  <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/js/intlTelInput.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const phoneInput = document.querySelector("#contact_phone");
      const hiddenPhoneInput = document.querySelector("#full_contact_phone");
      const form = phoneInput.closest("form");

      const iti = window.intlTelInput(phoneInput, {
        initialCountry: "in",
        preferredCountries: ["in", "us", "uk"],
        separateDialCode: true,
        countrySearch: true,
        fixDropdownWidth: true,
        autoPlaceholder: "aggressive",
        formatOnDisplay: true,
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/js/utils.js",
      });

      // Handle old value on validation error
      if (hiddenPhoneInput.value) {
        iti.setNumber(hiddenPhoneInput.value);
      }

      // Update hidden input on change and submit
      const updateHiddenInput = () => {
        hiddenPhoneInput.value = iti.getNumber();
      };

      phoneInput.addEventListener('change', updateHiddenInput);
      phoneInput.addEventListener('keyup', updateHiddenInput);

      form.addEventListener("submit", function () {
        updateHiddenInput();
      });
    });

    function toggleFaq(index) {
      const item = document.getElementById('faq-item-' + index);
      const icon = document.getElementById('faq-icon-' + index);
      const body = document.getElementById('faq-body-' + index);

      const isActive = item.classList.contains('active');

      if (isActive) {
        item.classList.remove('active');
        icon.textContent = '+';
        body.style.maxHeight = '0px';
      } else {
        item.classList.add('active');
        icon.textContent = '−';
        body.style.maxHeight = body.scrollHeight + 'px';
      }
    }
  </script>

  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection