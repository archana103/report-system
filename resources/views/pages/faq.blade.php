@extends('layouts.public')

@section('content')
<style>
/* FAQ Page Styles */
.faq-page-wrapper {
    background-color: #FAFAFA;
    font-family: 'Inter', sans-serif;
    min-height: 100vh;
}

.faq-banner {
    position: relative;
    padding: 100px 20px;
    text-align: center;
    background-position: center center;
    background-size: cover;
    background-repeat: no-repeat;
    min-height: 380px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.faq-banner-content {
    max-width: 800px;
    margin: 0 auto;
    z-index: 2;
}

.faq-banner h1 {
    font-size: 42px;
    font-weight: 700;
    color: #1A1A1A;
    margin-bottom: 16px;
    line-height: 1.2;
}

.faq-banner p {
    font-size: 18px;
    color: #4A5568;
    line-height: 1.6;
    max-width: 600px;
    margin: 0 auto 32px;
}

.faq-search-wrapper {
    position: relative;
    max-width: 500px;
    margin: 0 auto;
    width: 100%;
}

.faq-search-input {
    width: 100%;
    padding: 16px 24px;
    padding-right: 50px;
    border: none;
    border-radius: 30px;
    font-size: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    outline: none;
    transition: box-shadow 0.2s ease;
}

.faq-search-input:focus {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.faq-search-icon {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #A0AEC0;
}

.faq-content {
    max-width: 900px;
    margin: 60px auto 80px;
    padding: 0 20px;
    position: relative;
    z-index: 10;
}

.faq-accordion {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.faq-item {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.faq-item.active {
    border-color: #0066FF;
    box-shadow: 0 4px 6px -1px rgba(0, 102, 255, 0.1);
}

.faq-header {
    width: 100%;
    text-align: left;
    padding: 24px;
    background: transparent;
    border: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    color: #2D3748;
    transition: color 0.2s ease;
}

.faq-item.active .faq-header {
    color: #0066FF;
}

.faq-toggle-icon {
    font-size: 20px;
    color: #A0AEC0;
    transition: transform 0.3s ease, color 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
}

.faq-item.active .faq-toggle-icon {
    color: #0066FF;
    transform: rotate(45deg);
}

.faq-body {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out;
}

.faq-body-content {
    padding: 0 24px 24px;
    color: #718096;
    font-size: 15px;
    line-height: 1.6;
}
</style>

@php
$faqs = [
    [
        'question' => 'What is Epignosis Insights?',
        'answer' => 'Epignosis Insights is a market research and consulting firm delivering data driven insights, industry analysis, market forecasts, and customized research solutions.'
    ],
    [
        'question' => 'What market research services does Epignosis Insights offer?',
        'answer' => 'We offer market research reports, custom research solutions, consulting services, industry analysis, and strategic business insights.'
    ],
    [
        'question' => 'Which industries does Epignosis Insights cover?',
        'answer' => 'Our research covers industries including ICT, semiconductors and electronics, automotive, healthcare, chemicals and materials, consumer goods, energy, and more.'
    ],
    [
        'question' => 'Do you provide customized market research reports?',
        'answer' => 'Yes, we provide customized research solutions tailored to your business objectives, target markets, and specific information requirements.'
    ],
    [
        'question' => 'What information is included in your market research reports?',
        'answer' => 'Our reports cover market size, industry trends, growth drivers, competitive landscapes, and future market forecasts.'
    ],
    [
        'question' => 'Can I request a sample report before purchasing?',
        'answer' => 'Yes, you can request a sample report through our website to explore the research and connect with our research experts.'
    ],
    [
        'question' => 'Do you provide market forecasts and industry trends?',
        'answer' => 'Yes, our research provides future forecasts, emerging trends, and market intelligence to support strategic business planning.'
    ],
    [
        'question' => 'How can Epignosis Insights help my business?',
        'answer' => 'We help businesses understand market dynamics, identify growth opportunities, assess competition, and make informed strategic decisions.'
    ],
    [
        'question' => 'Do you offer consulting services along with market research reports?',
        'answer' => 'Yes, our consulting services help businesses interpret research findings and develop strategies aligned with their business goals.'
    ],
    [
        'question' => 'How can I purchase a market research report?',
        'answer' => 'You can explore our market research reports and contact our team to discuss your requirements, report availability, and purchase options.'
    ],
    [
        'question' => 'How can I contact Epignosis Insights for research requirements?',
        'answer' => 'You can contact our team through the website or email sales@epignosisinsights.com to discuss your research requirements and receive expert assistance.'
    ]
];
@endphp

<div class="faq-page-wrapper">
    <!-- Banner Section -->
    <section class="faq-banner" style="background-image: url('https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/assets/images/faq_page/faq_cta.png');">
        <div class="faq-banner-content">
            <h1>Frequently Asked Questions</h1>
            <p>Find answers to common questions about our market research reports, custom research solutions, purchasing process, and services.</p>
        </div>
    </section>

    <!-- FAQ Accordion List -->
    <section class="faq-content">
        <div class="faq-accordion" id="faqList">
            @foreach($faqs as $idx => $faq)
            <div class="faq-item" id="faq-item-{{ $idx }}" data-question="{{ strtolower($faq['question']) }}">
                <button class="faq-header" type="button" onclick="toggleFaqPage({{ $idx }})">
                    <span>{{ $faq['question'] }}</span>
                    <span class="faq-toggle-icon" id="faq-icon-{{ $idx }}">+</span>
                </button>
                <div class="faq-body" id="faq-body-{{ $idx }}" style="max-height: 0px;">
                    <div class="faq-body-content">
                        {{ $faq['answer'] }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>

<script>
    function toggleFaqPage(index) {
        const item = document.getElementById('faq-item-' + index);
        const icon = document.getElementById('faq-icon-' + index);
        const body = document.getElementById('faq-body-' + index);

        // Close all other FAQs
        const allItems = document.querySelectorAll('.faq-item');
        allItems.forEach((otherItem, i) => {
            if (i !== index && otherItem.classList.contains('active')) {
                otherItem.classList.remove('active');
                document.getElementById('faq-icon-' + i).textContent = '+';
                document.getElementById('faq-icon-' + i).style.transform = 'rotate(0deg)';
                document.getElementById('faq-body-' + i).style.maxHeight = '0px';
            }
        });

        // Toggle current FAQ
        const isActive = item.classList.contains('active');
        if (isActive) {
            item.classList.remove('active');
            icon.textContent = '+';
            icon.style.transform = 'rotate(0deg)';
            body.style.maxHeight = '0px';
        } else {
            item.classList.add('active');
            icon.textContent = '+'; // keep plus visual but we'll rotate it via css
            icon.style.transform = 'rotate(45deg)';
            body.style.maxHeight = body.scrollHeight + 'px';
        }
    }
</script>
@endsection
