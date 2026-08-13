<template>
  <div class="home-page">
    <SiteHeader />
    <main>
      <HeroSection />
      <ClientLogos />
      <TrendingReports :categories="categories" :activeCategory="activeCategory" :reports="reports"
        @update:activeCategory="activeCategory = $event" />
      <PressReleases :pressReleases="visiblePressReleases" @next="nextPressRelease" @prev="prevPressRelease" />
      <LatestInsights :insights="visibleInsights" @next="nextInsight" @prev="prevInsight" />
      <ServicesSection />
      <AboutSection />
      <ContactSection />
      <div style="min-height: 150px;"></div>
    </main>
    <SiteFooter />
  </div>
</template>

<script setup>
import { useHomeData } from './useHomeData'
import SiteHeader from './components/SiteHeader.vue'
import HeroSection from './components/HeroSection.vue'
import ClientLogos from './components/ClientLogos.vue'
import TrendingReports from './components/TrendingReports.vue'
import PressReleases from './components/PressReleases.vue'
import LatestInsights from './components/LatestInsights.vue'
import ServicesSection from './components/ServicesSection.vue'
import AboutSection from './components/AboutSection.vue'
import ContactSection from './components/ContactSection.vue'
import SiteFooter from './components/SiteFooter.vue'

const {
  activeCategory,
  categories,
  reports,
  visiblePressReleases,
  nextPressRelease,
  prevPressRelease,
  visibleInsights,
  nextInsight,
  prevInsight
} = useHomeData()
</script>

<style src="./style.css"></style>
