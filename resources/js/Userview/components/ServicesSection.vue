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
          <div class="services-center-overlay">
            <svg class="service-connectors" viewBox="0 0 1140 535" preserveAspectRatio="none" aria-hidden="true">
              <defs>
                <marker id="service-arrow-left" viewBox="0 0 10 10" refX="1.5" refY="5" markerWidth="8" markerHeight="8" orient="auto-start-reverse">
                  <path d="M9 1 L1 5 L9 9" />
                </marker>
                <marker id="service-arrow-right" viewBox="0 0 10 10" refX="8.5" refY="5" markerWidth="8" markerHeight="8" orient="auto">
                  <path d="M1 1 L9 5 L1 9" />
                </marker>
              </defs>
              <path class="connector-path" marker-end="url(#service-arrow-left)" d="M 482 206 H 396 V 98 H 336" />
              <path class="connector-path" marker-end="url(#service-arrow-right)" d="M 658 206 H 744 V 98 H 804" />
              <path class="connector-path" marker-end="url(#service-arrow-left)" d="M 482 330 H 420 V 382 H 336" />
              <path class="connector-path" marker-end="url(#service-arrow-right)" d="M 658 330 H 720 V 382 H 804" />
            </svg>
            <div class="service-center">
              <span class="brand-mark large">e</span>
            </div>
          </div>
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
