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
            <svg class="service-connectors" viewBox="0 0 980 610" preserveAspectRatio="none" aria-hidden="true">
              <defs>
                <marker id="service-arrow" viewBox="0 0 10 10" refX="8.5" refY="5" markerWidth="8" markerHeight="8" orient="auto">
                  <path d="M1 1 L9 5 L1 9" />
                </marker>
              </defs>
              <path class="connector-path" marker-end="url(#service-arrow)" d="M 404 190 L 325 210" />
              <path class="connector-path" marker-end="url(#service-arrow)" d="M 576 190 L 655 210" />
              <path class="connector-path" marker-end="url(#service-arrow)" d="M 490 276 V 385" />
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
import { IconBrief, IconTarget, IconBulb } from '../icons'

const services = [
  { title: 'Custom Research Solutions', description: 'Tailored research designed to match your business goals and target markets.', icon: IconTarget, position: 'left' },
  { title: 'Consulting Services', description: 'Expert guidance to help you interpret data and make strategic decisions.', icon: IconBulb, position: 'right' },
  { title: 'Market Research Reports', description: 'Comprehensive reports covering market size, key trends, and future forecasts.', icon: IconBrief, position: 'bottom' }
]
</script>
