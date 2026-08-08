@extends('layouts.public')

@section('content')
<div class="checkout-page" style="background: white;">
    <!-- Hero Banner for Checkout Form -->
    <header class="checkout-hero-banner">
        <div class="breadcrumb-nav">
            <a href="/" class="breadcrumb-link home-link">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                Home
            </a> 
            <span class="sep"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></span> 
            <a href="/reports" class="breadcrumb-link">Reports</a> 
            
            @if($report && $report->category)
                <span class="sep"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></span> 
                <a href="/industry/{{ Str::slug(is_string($report->category) ? $report->category : $report->category->name) }}" class="breadcrumb-link">{{ is_string($report->category) ? $report->category : $report->category->name }}</a>
            @endif

            @if($report)
                <span class="sep"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></span> 
                <a href="/report/{{ $report->slug_url ?? request()->route('slug') }}" class="breadcrumb-link truncate-title" title="{{ $report->title }}">
                {{ $report->breadcrumb_title ?? $report->title }}
                </a>
            @endif

            <span class="sep"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></span> 
            <span class="current-page">Purchase Report</span>
        </div>
        <div class="checkout-hero-content">
            <h1><span class="text-blue">Purchase</span> Market Research Report</h1>
            <p>Complete the form below to purchase your selected market research report. Choose the license that best fits your business needs and enjoy secure payment, instant confirmation, and dedicated analyst support.</p>
        </div>
    </header>

    <main class="checkout-main pt-0" style="padding: 40px 0;">
        <div class="section-shell">
            <div class="checkout-two-columns">
                <!-- Left Column (Form) -->
                <div class="checkout-form-column">
                    <div class="form-header">
                        <h2>Complete Your Purchase</h2>
                        <p>Provide your business details to securely purchase the report. Our team will process your order and deliver your report promptly.</p>
                    </div>

                    <form id="purchase-form" class="purchase-form" onsubmit="submitPurchase(event)">
                        @csrf
                        <div class="form-grid-2">
                            <div class="input-group">
                                <label>Full Name <span class="text-red-600" style="color: #dc2626;">*</span></label>
                                <input type="text" id="full_name" placeholder="Enter Your Full Name" required />
                            </div>
                            <div class="input-group">
                                <label>Business Email <span class="text-red-600" style="color: #dc2626;">*</span></label>
                                <input type="email" id="business_email" placeholder="Enter Your Business Email" required />
                            </div>
                            <div class="input-group">
                                <label>Phone Number <span class="text-red-600" style="color: #dc2626;">*</span></label>
                                <input type="tel" id="phone_input" placeholder="Enter Phone Number" required />
                            </div>
                            <div class="input-group">
                                <label>Company Name <span class="text-red-600" style="color: #dc2626;">*</span></label>
                                <input type="text" id="company_name" placeholder="Enter Company Name" required />
                            </div>
                            <div class="input-group">
                                <label>Country <span class="text-red-600" style="color: #dc2626;">*</span></label>
                                <select id="country" required>
                                    <option value="" disabled selected>Select Your Country</option>
                                    @php
                                        $countriesList = ['Afghanistan', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Antarctica', 'Argentina', 'Armenia', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina', 'Botswana', 'Brazil', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China', 'Colombia', 'Comoros', 'Congo', 'Costa Rica', 'Croatia', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Dominica', 'Dominican Republic', 'Ecuador', 'Egypt', 'El Salvador', 'Estonia', 'Ethiopia', 'Fiji', 'Finland', 'France', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Greece', 'Guatemala', 'Guinea', 'Haiti', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kuwait', 'Kyrgyzstan', 'Latvia', 'Lebanon', 'Liberia', 'Libya', 'Lithuania', 'Luxembourg', 'Madagascar', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Mexico', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Morocco', 'Myanmar', 'Namibia', 'Nepal', 'Netherlands', 'New Zealand', 'Nicaragua', 'Nigeria', 'Norway', 'Oman', 'Pakistan', 'Palestine', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Poland', 'Portugal', 'Qatar', 'Romania', 'Russia', 'Rwanda', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Singapore', 'Slovakia', 'Slovenia', 'Somalia', 'South Africa', 'South Korea', 'Spain', 'Sri Lanka', 'Sudan', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 'Tunisia', 'Turkey', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City', 'Venezuela', 'Vietnam', 'Yemen', 'Zambia', 'Zimbabwe'];
                                    @endphp
                                    @foreach($countriesList as $country)
                                        <option value="{{ $country }}">{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group">
                                <label>License Type <span class="text-red-600" style="color: #dc2626;">*</span></label>
                                <select id="pricing_id" required>
                                    <option value="" disabled>Select License Type</option>
                                    @foreach($pricings as $plan)
                                        <option value="{{ $plan->id }}" data-features="{{ $plan->details }}" {{ $plan->id == $initialPricingId ? 'selected' : '' }}>
                                            {{ $plan->title }} - ${{ number_format($plan->cost) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Payment Options -->
                        <div class="secure-payment-section">
                            <h4>Secure Payment Options:</h4>
                            <p>We support secure online payments through trusted global payment providers.</p>
                            <div class="payment-methods-grid">
                                <label class="payment-method-card active" onclick="setPaymentMethod('visa', this)">
                                    <input type="radio" value="visa" name="payment" checked />
                                    <div class="payment-method-header">
                                        <span class="radio-custom"></span>
                                        <span class="payment-name">Visa</span>
                                    </div>
                                    <img src="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/payment_images/visa.png" alt="Visa" class="w-12 mt-auto" />
                                </label>
                                <label class="payment-method-card" onclick="setPaymentMethod('amex', this)">
                                    <input type="radio" value="amex" name="payment" />
                                    <div class="payment-method-header">
                                        <span class="radio-custom"></span>
                                        <span class="payment-name">American Express</span>
                                    </div>
                                    <img src="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/payment_images/american_express.png" alt="AMEX" class="mt-auto" style="width: 51%;height: 19px;" />
                                </label>
                                <label class="payment-method-card" onclick="setPaymentMethod('paypal', this)">
                                    <input type="radio" value="paypal" name="payment" />
                                    <div class="payment-method-header">
                                        <span class="radio-custom"></span>
                                        <span class="payment-name">PayPal</span>
                                    </div>
                                    <img src="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/payment_images/paypal.png" alt="PayPal" class=" mt-auto" style="width: 51%;height: 19px;" />
                                </label>
                                <label class="payment-method-card" onclick="setPaymentMethod('mastercard', this)">
                                    <input type="radio" value="mastercard" name="payment" />
                                    <div class="payment-method-header">
                                        <span class="radio-custom"></span>
                                        <span class="payment-name">Mastercard</span>
                                    </div>
                                    <img src="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/payment_images/mastercard.png" alt="Mastercard" class="mt-auto" style="width: 51%;height: 19px;" />
                                </label>
                            </div>
                        </div>

                        <div class="submit-actions-wrapper">
                            <button id="standard-submit-btn" type="submit" class="buy-now-submit-btn">
                                BUY NOW
                            </button>
                            <div id="paypal-button-container" class="mt-4" style="text-align: center; display: none;"></div>
                        </div>
                    </form>
                </div>

                <!-- Right Column (Info) -->
                <aside class="checkout-sidebar">
                    <div class="included-card">
                        <h3>What's Included</h3>
                        <p>See What's Included with Your Purchase</p>
                        <ul class="included-list" id="features-list">
                            <!-- Populated dynamically via JS -->
                        </ul>
                    </div>

                    <div class="help-card">
                        <h3>Need Help Choosing<br />the Right License?</h3>
                        <p>Need guidance before buying? We're here for you.</p>
                        <div class="help-contact">
                            <span><strong>Email:</strong> sales@epignosisinsights.com</span>
                            <span><strong>Phone:</strong> +91 9370941234</span>
                        </div>
                        <a href="/contact-us" class="contact-support-btn">Contact Support</a>
                    </div>
                </aside>
            </div>
        </div>
    </main>
</div>

<!-- Add intl-tel-input -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/css/intlTelInput.css" />
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/js/intlTelInput.min.js"></script>
<!-- PayPal SDK integration using the Sandbox ID for testing. You should use config() for production -->
<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID', 'test') }}&currency=USD"></script>

<style>
/* Hero Banner */
.checkout-hero-banner {
  background: url('https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/background-image/pricing_pagebanner.png') center center;
  background-size: cover;
  padding: 40px 24px 66px;
  text-align: center;
  position: relative;
  overflow: hidden;
  border-bottom: 1px solid #e2e8f0;
}
.breadcrumb-nav { max-width: 1285px; margin: 0 auto 50px; text-align: left; font-size: 14.5px; color: #64748b; display: flex; align-items: center; flex-wrap: wrap; }
.breadcrumb-nav .breadcrumb-link { color: #475569; text-decoration: none; transition: color 0.2s; display: inline-flex; align-items: center; }
.breadcrumb-nav .breadcrumb-link.home-link { gap: 4px; }
.breadcrumb-nav .breadcrumb-link.truncate-title { display: block; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.breadcrumb-nav .breadcrumb-link:hover { color: #0ea5e9; }
.breadcrumb-nav .sep { color: #94a3b8; display: inline-flex; align-items: center; margin: 0 8px; }
.breadcrumb-nav span.current-page { color: #0ea5e9; font-weight: 500; }
.checkout-hero-content { max-width: 700px; margin: 0 auto; }
.checkout-hero-content h1 { font-size: 51px; font-weight: 600; color: #0f172a; margin: 0 0 16px; }
.text-blue { color: #0284c7; }
.checkout-hero-content p { color: #475569; font-size: 18px; line-height: 1.6; }

/* Main layout */
.checkout-two-columns { display: grid; grid-template-columns: 1fr 320px; gap: 68px; align-items: start; max-width: 1100px; margin: 0 auto; }
.checkout-form-column { background: #ffffff; border-radius: 16px; padding: 40px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03); border: 1px solid #f1f5f9; }
.form-header { text-align: center; margin-bottom: 32px; }
.form-header h2 { font-size: 32px; font-weight: 600; color: #0f172a; margin: 0 0 12px; }
.form-header p { font-size: 16px; color: #64748b; line-height: 1.5; }
.form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 32px; }
.input-group { display: flex; flex-direction: column; }
.input-group label { font-size: 13.5px; font-weight: 600; color: #334155; margin-bottom: 8px; }
.input-group input, .input-group select { width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; color: #0f172a; background: #ffffff; outline: none; transition: all 0.2s; }
.input-group input:focus, .input-group select:focus { border-color: #0284c7; box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1); }

/* intl-tel-input integration */
.iti { width: 100%; display: block; }
.iti__input { width: 100% !important; padding: 12px 16px 12px 82px !important; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; background: #ffffff; color: #1f2937; transition: all 0.2s ease-in-out; height: auto; box-sizing: border-box; }
.iti__input:focus { border-color: #0284c7; box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1); }
.iti__selected-dial-code { font-size: 13.5px; font-weight: 600; color: #4b5563; }
.iti__country-container { border-radius: 8px 0 0 8px; }
.iti__arrow { border-left: 4px solid transparent; border-right: 4px solid transparent; border-top: 5px solid #9ca3af; margin-left: 4px; }

/* Payment Options */
.secure-payment-section { margin-bottom: 32px; }
.secure-payment-section h4 { font-size: 16px; font-weight: 600; color: #0f172a; margin: 0 0 8px; }
.secure-payment-section p { font-size: 13px; color: #64748b; margin: 0 0 20px; }
.payment-methods-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
.payment-method-card { border: 1px solid #c2ccd8; border-radius: 12px; padding: 16px; display: flex; flex-direction: column; position: relative; cursor: pointer; transition: all 0.2s; }
.payment-method-card:hover, .payment-method-card.active { border-color: #0284c74f; box-shadow: 0 1px 7px rgb(7 131 223 / 21%); }
.payment-method-card input { display: none; }
.radio-custom { width: 16px; height: 16px; border: 2px solid #cbd5e1; border-radius: 50%; position: relative; flex-shrink: 0; }
.payment-method-card.active .radio-custom { border: 2px solid #0284c7; }
.payment-method-card.active .radio-custom::after { content: ''; position: absolute; top: 2px; left: 2px; width: 8px; height: 8px; background: #0284c7; border-radius: 50%; }
.payment-method-header { display: flex; align-items: center; gap: 10px; margin-bottom: 24px; }
.payment-name { font-size: 13.5px; font-weight: 600; color: #0f172a; }

/* Action Button */
.buy-now-submit-btn { width: 43%; padding: 16px; background: #0284c7; color: white; border: none; border-radius: 37px; font-size: 16px; font-weight: 700; cursor: pointer; transition: background 0.2s; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.2); margin: 0 auto; display: block; }
.buy-now-submit-btn:hover:not(:disabled) { background: #0369a1; }
.buy-now-submit-btn:disabled { opacity: 0.7; cursor: not-allowed; }

/* Right Sidebar */
.checkout-sidebar { display: flex; flex-direction: column; gap: 24px; text-align: center; }
.included-card { background: #ffffff; border: 1px solid #aeb7bf; border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03); }
.included-card h3 { font-size: 20px; font-weight: 600; color: #0f172a; margin: 0 0 8px; }
.included-card p { font-size: 13px; color: #64748b; margin: 0 0 20px; }
.included-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 12px; }
.included-list li { font-size: 13px; color: #334155; display: flex; align-items: flex-start; gap: 8px; font-weight: 500; text-align: left; }
.green-check { color: #10b981; font-weight: 800; }
.help-card { background: #0783df; border-radius: 16px; padding: 28px 24px; color: white; text-align: center; box-shadow: 0 10px 30px rgba(14, 165, 233, 0.2); }
.help-card h3 { font-size: 22px; font-weight: 600; margin: 0 0 12px; line-height: 1.3; }
.help-card p { font-size: 14px; opacity: 0.9; margin: 0 0 24px; }
.help-contact { display: flex; flex-direction: column; gap: 8px; font-size: 13px; margin-bottom: 24px; background: rgba(255,255,255,0.1); padding: 16px; border-radius: 8px; }
.contact-support-btn { display: inline-block; background: #ffffff; color: #0ea5e9; padding: 12px 24px; border-radius: 30px; font-weight: 700; font-size: 14px; text-decoration: none; transition: all 0.2s; }
.contact-support-btn:hover { background: #f8fafc; transform: translateY(-2px); }

@media (max-width: 900px) {
  .checkout-two-columns { grid-template-columns: 1fr; }
  .form-grid-2 { grid-template-columns: 1fr; }
  .payment-methods-grid { grid-template-columns: 1fr 1fr; }
}
</style>

<script>
    let itiInstance = null;
    let paymentMethod = 'visa';
    let paypalRendered = false;

    document.addEventListener("DOMContentLoaded", function () {
        const phoneInput = document.querySelector("#phone_input");

        // Init intl-tel-input
        itiInstance = window.intlTelInput(phoneInput, {
            initialCountry: "in",
            preferredCountries: ["in", "us", "uk"],
            separateDialCode: true,
            formatOnDisplay: true,
            autoPlaceholder: "aggressive",
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/js/utils.js",
        });

        const selectPricing = document.getElementById('pricing_id');
        selectPricing.addEventListener('change', updateFeaturesList);
        updateFeaturesList(); // Init on load
    });

    function updateFeaturesList() {
        const selectPlan = document.getElementById('pricing_id');
        const listDiv = document.getElementById('features-list');
        listDiv.innerHTML = '';
        
        if (selectPlan.selectedIndex >= 0) {
            const option = selectPlan.options[selectPlan.selectedIndex];
            const featuresStr = option.getAttribute('data-features') || '';
            const rawFeatures = featuresStr.split('\n');
            rawFeatures.forEach(feature => {
                if (feature.trim() !== '') {
                    const li = document.createElement('li');
                    li.innerHTML = '<span class="green-check">✓</span> ' + feature.trim();
                    listDiv.appendChild(li);
                }
            });
        }
    }

    function setPaymentMethod(method, el) {
        paymentMethod = method;
        document.querySelectorAll('.payment-method-card').forEach(card => card.classList.remove('active'));
        el.classList.add('active');
        el.querySelector('input').checked = true;

        if (method === 'paypal') {
            document.getElementById('standard-submit-btn').style.display = 'none';
            document.getElementById('paypal-button-container').style.display = 'block';
            renderPayPal();
        } else {
            document.getElementById('standard-submit-btn').style.display = 'block';
            document.getElementById('paypal-button-container').style.display = 'none';
        }
    }

    function getFormData() {
        return {
            full_name: document.getElementById('full_name').value,
            business_email: document.getElementById('business_email').value,
            phone_number: itiInstance ? itiInstance.getNumber() : document.getElementById('phone_input').value,
            company_name: document.getElementById('company_name').value,
            country: document.getElementById('country').value,
            pricing_id: document.getElementById('pricing_id').value,
            report_detail_id: {{ $report->id ?? 'null' }}
        };
    }

    function validateForm(data) {
        if (!data.full_name || !data.business_email || !data.company_name || !data.country || !data.pricing_id) {
            alert('Please fill out all required fields (Name, Email, Company, Country, License).');
            return false;
        }
        if (!data.phone_number) {
            alert('Please enter a valid phone number.');
            return false;
        }
        return true;
    }

    function submitPurchase(event) {
        event.preventDefault();
        
        if (paymentMethod === 'paypal') {
            alert("Please click the yellow PayPal button to securely process your payment.");
            return;
        }

        const data = getFormData();
        if (!validateForm(data)) return;

        const btn = document.getElementById('standard-submit-btn');
        btn.innerHTML = 'Processing...';
        btn.disabled = true;

        fetch('/api/checkout/purchase', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (response.ok) {
                alert("Purchase request received! A representative will contact you shortly to complete payment processing.");
                window.location.href = '/thank-you';
            } else {
                throw new Error('Server error');
            }
        })
        .catch(err => {
            console.error(err);
            alert("Failed to submit purchase details. Please check your information and try again.");
            btn.innerHTML = 'BUY NOW';
            btn.disabled = false;
        });
    }

    function renderPayPal() {
        if (paypalRendered || !window.paypal) return;
        paypalRendered = true;

        window.paypal.Buttons({
            onClick: (data, actions) => {
                const formData = getFormData();
                if (!validateForm(formData)) {
                    return actions.reject();
                }
                return actions.resolve();
            },
            createOrder: (data, actions) => {
                const formData = getFormData();
                return fetch('/api/paypal/create-order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ pricing_id: formData.pricing_id })
                }).then(res => res.json()).then(resData => {
                    if (resData.id) {
                        return resData.id;
                    } else {
                        alert('Unable to create PayPal order. Please try again later.');
                        throw new Error('Invalid PayPal order response');
                    }
                });
            },
            onApprove: (data, actions) => {
                const formData = getFormData();
                return fetch('/api/paypal/capture-order/' + data.orderID, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(formData)
                }).then(res => res.json()).then(resData => {
                    if (resData.status === 'COMPLETED' || resData.status === 'success') {
                        alert('Payment successful! Your order has been placed.');
                        window.location.href = '/thank-you';
                    } else {
                        alert('Payment was processed, but status is pending/unverified. Contact support.');
                    }
                }).catch(err => {
                    console.error('Failed to capture PayPal payment', err);
                    alert('Failed to capture your payment. If issues persist, please contact support.');
                });
            },
            onError: (err) => {
                console.error('PayPal checkout error:', err);
            }
        }).render('#paypal-button-container');
    }
</script>
@endsection
