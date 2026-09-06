<section class="client-logos-section bg-gray-50 overflow-hidden font-sans text-center">
    <div class="client-logos-wrapper">
        <div class="section-heading centered" style="margin-bottom: 3.5rem;">
            <h2>Trusted by Businesses Worldwide</h2>
            <p>
                We work with businesses across industries to deliver reliable market intelligence and data-driven insights.
            </p>
        </div>

    @php
        $awsUrl = config('filesystems.disks.s3.url');
        
        $logos = [
            'hayes.png', 'ufg.png', 'caremedical.png', 'frankische.png',
            'launch.png', 'agrolab.png', 'wilkinson.png', 'atrix.png',
            'iceland.png', 'hyundai.png', 'lex.png', 'spec.png',
            'hadco_petroleum.png', 'intran.png', 'prochaete.png'
        ];

        // Split exactly as the original code did
        $row1Logos = array_slice($logos, 0, 8);
        $row2Logos = array_slice($logos, 8);

        // Duplicate for seamless marquee
        $duplicatedRow1 = array_merge($row1Logos, $row1Logos);
        $duplicatedRow2 = array_merge($row2Logos, $row2Logos);
    @endphp

    <div class="client-marquee-container w-full relative flex flex-col gap-6 overflow-hidden">
        
        <!-- First Row -->
        <div class="client-marquee-track">
            @foreach($duplicatedRow1 as $logo)
                <div class="client-logo-item group">
                    <img src="{{ $awsUrl ? rtrim($awsUrl, '/') . '/assets/images/client_logo/' . $logo : asset('assets/images/client_logo/' . $logo) }}" 
                         onerror="this.src='https://placehold.co/180x90/ffffff/565f6c?text={{ str_replace('.png', '', $logo) }}'" 
                         alt="{{ str_replace('.png', '', $logo) }} logo" />
                </div>
            @endforeach
        </div>
        
        <!-- Second Row (Reverse) -->
        <div class="client-marquee-track client-reverse">
            @foreach($duplicatedRow2 as $logo)
                <div class="client-logo-item group">
                    <img src="{{ $awsUrl ? rtrim($awsUrl, '/') . '/assets/images/client_logo/' . $logo : asset('assets/images/client_logo/' . $logo) }}" 
                         onerror="this.src='https://placehold.co/180x90/ffffff/565f6c?text={{ str_replace('.png', '', $logo) }}'" 
                         alt="{{ str_replace('.png', '', $logo) }} logo" />
                </div>
            @endforeach
        </div>
        
    </div>
    </div>
</section>

<style>
/* Scoped Custom Marquee CSS restoring the exact Main Branch animation */
.client-logos-wrapper {
    max-width: 1300px;
    margin: 0 auto;
    padding: 0 1rem;
}
.client-logos-section {
    padding-top: 5rem;
    padding-bottom: 5rem;
}
.client-logos-header {
    margin-bottom: 3.5rem;
}

.client-marquee-container:hover .client-marquee-track {
    animation-play-state: paused;
}

.client-marquee-track {
    display: flex;
    width: max-content;
    gap: 1.5rem;
    padding: 0 0.75rem;
    animation: clientScrollLeft 35s linear infinite;
}

.client-marquee-track.client-reverse {
    animation: clientScrollRight 35s linear infinite;
}

.client-logo-item {
    background: white;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e5e7eb;
    border-top: 2px solid #2563eb;
    border-radius: 4px;
    height: 90px;
    width: 180px;
    flex-shrink: 0;
    transition: all 0.2s ease-in-out;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    cursor: pointer;
}

.client-logo-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.08);
}

.client-logo-item img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

@keyframes clientScrollLeft {
    0% { transform: translateX(0); }
    100% { transform: translateX(calc(-50% - 0.75rem)); }
}

@keyframes clientScrollRight {
    0% { transform: translateX(calc(-50% - 0.75rem)); }
    100% { transform: translateX(0); }
}

@media (max-width: 768px) {
    .client-logo-item {
        width: 150px;
        height: 80px;
    }
}
</style>
