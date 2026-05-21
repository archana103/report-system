<template>
<section class="services-section">
        <div class="section-heading centered">
          <h2>Our Services</h2>
          <p>Comprehensive research and analytics solutions designed to help businesses make informed, strategic decisions.</p>
        </div>
        <div class="services-map">
          <article v-for="service in services" :key="service.title" :class="['service-card', service.position]">
            <div class="service-icon"><component :is="service.icon" /></div>
            <h3>{{ service.title }}</h3>
            <p>{{ service.description }}</p>
          </article>
          <div class="service-center">
            <span class="brand-mark large">e</span>
          </div>
          <span class="connector c1"></span>
          <span class="connector c2"></span>
          <span class="connector c3"></span>
          <span class="connector c4"></span>
        </div>
        <div class="center-action">
          <a href="#" class="primary-button small">Learn More</a>
        </div>
      </section>
</template>

<script setup>
import { IconBrief, IconTarget, IconTrend, IconBulb } from '../icons'

const services = [
  { title: 'Market Research Reports', description: 'Comprehensive reports covering market size, key trends, and future forecasts.', icon: IconBrief, position: 'top-left' },
  { title: 'Custom Research Solutions', description: 'Tailored research designed to match your business goals and target markets.', icon: IconTarget, position: 'top-right' },
  { title: 'Industry Analysis', description: 'Detailed insights into industry trends, growth drivers, and opportunities.', icon: IconTrend, position: 'bottom-left' },
  { title: 'Consulting Services', description: 'Expert guidance to help you interpret data and make strategic decisions.', icon: IconBulb, position: 'bottom-right' }
]
</script>

