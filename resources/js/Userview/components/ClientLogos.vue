<template>
  <section class="client-logos-section">
    <div class="container">
      <div class="container-header">
        <h2 class="client-logos-title">Trusted by Businesses Worldwide</h2>
      <p class="client-logos-subtitle">
        We work with businesses across industries to deliver reliable market intelligence and data-driven insights.
      </p>
    </div>

    <div class="marquee-container">
      <!-- First Row -->
      <div class="marquee-track">
        <div class="logo-item" v-for="(logo, index) in duplicatedRow1" :key="'r1-'+index">
          <img :src="$assetUrl + '/assets/images/client_logo/' + logo" :alt="logo.replace('.png', '') + ' logo'" />
        </div>
      </div>
      
      <!-- Second Row -->
      <div class="marquee-track reverse">
        <div class="logo-item" v-for="(logo, index) in duplicatedRow2" :key="'r2-'+index">
          <img :src="$assetUrl + '/assets/images/client_logo/' + logo" :alt="logo.replace('.png', '') + ' logo'" />
        </div>
      </div>
    </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'

const logos = [
  'hayes.png',
  'ufg.png',
  'caremedical.png',
  'frankische.png',
  'launch.png',
  'agrolab.png',
  'wilkinson.png',
  'atrix.png',
  'iceland.png',
  'hyundai.png',
  'lex.png',
  'spec.png',
  'hadco_petroleum.png',
  'intran.png',
  'prochaete.png'
]

// Split logos into two rows
const row1Logos = logos.slice(0, 8)
const row2Logos = logos.slice(8)

// Duplicate for continuous seamless marquee effect
const duplicatedRow1 = computed(() => [...row1Logos, ...row1Logos])
const duplicatedRow2 = computed(() => [...row2Logos, ...row2Logos])
</script>

<style scoped>
.client-logos-section {
  padding: 5rem 0; /* no horizontal padding on the section, keeping the marquee full width or bounded */
  background-color: #fcfcfd;
  text-align: center;
  font-family: 'Inter', sans-serif;
  overflow: hidden; /* important for marquee */
}

.container {
  max-width: 1300px;
  margin: 0 auto;
  padding: 0 1rem;
}

.container-header {
  margin-bottom: 2rem;
}

.client-logos-title {
  font-size: 2.25rem;
  font-weight: 700;
  color: #111827;
  margin-bottom: 0.75rem;
}

.client-logos-subtitle {
  font-size: 1rem;
  color: #6b7280;
  max-width: 650px;
  margin: 0 auto 3rem;
  line-height: 1.6;
}

.marquee-container {
  width: 100%;
  position: relative;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  overflow: hidden;
}

/* Pause animation on hover */
.marquee-container:hover .marquee-track {
  animation-play-state: paused;
}

.marquee-track {
  display: flex;
  width: max-content;
  gap: 1.5rem;
  padding: 0 0.75rem;
  animation: scrollLeft 35s linear infinite;
}

.marquee-track.reverse {
  /* For variety, we can scroll the second row in the opposite direction */
  animation: scrollRight 35s linear infinite;
}

.logo-item {
  background: white;
  padding: 1.25rem;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid #e5e7eb;
  border-top: 2px solid #2563eb;
  border-radius: 4px;
  height: 90px;
  width: 180px; /* fixed width for stable marquee */
  flex-shrink: 0;
  transition: all 0.2s ease-in-out;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
  cursor: pointer;
}

.logo-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.08);
}

.logo-item img {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

@keyframes scrollLeft {
  0% { transform: translateX(0); }
  100% { transform: translateX(calc(-50% - 0.75rem)); }
}

@keyframes scrollRight {
  0% { transform: translateX(calc(-50% - 0.75rem)); }
  100% { transform: translateX(0); }
}

@media (max-width: 768px) {
  .logo-item {
    width: 150px;
    height: 80px;
  }
}
</style>
