<template>
<section id="reports" class="reports-section">
      <div class="section-shell">
        <div class="section-heading centered">
          <h2>Top Trending Market Reports</h2>
          <p>Explore our most in-demand reports featuring the latest industry trends, forecasts, and data-driven insights.</p>
        </div>

        <div class="category-filter">
          <button v-for="category in categories" :key="category" :class="{ active: activeCategory === category }" @click="$emit('update:activeCategory', category)">
            {{ category }}
          </button>
        </div>

        <div class="report-list">
          <article v-for="report in reports" :key="report.title" class="report-card">
            <router-link :to="`/report/${report.slug && report.slug !== '#' ? report.slug : report.id}`" style="color: inherit; text-decoration: none;">
              <h3 class="hover-primary-title">{{ report.title }}</h3>
            </router-link>
            <p v-html="report.description"></p>
            <div class="report-meta">
              <span>Category: <strong>{{ report.category }}</strong></span>
              <span>Publish Date: <strong>{{ report.date }}</strong></span>
              <router-link :to="`/report/${report.slug && report.slug !== '#' ? report.slug : report.id}`" class="view-report-link" style="display: inline-flex; align-items: center; gap: 8px; color: #0079d3; font-weight: 700;">
                View Report <ArrowRight />
              </router-link>
            </div>
          </article>
        </div>

        <div class="center-action">
          <router-link to="/reports" class="primary-button small">View All Reports <CircleArrow /></router-link>
        </div>
      </div>
    </section>
</template>

<script setup>
import { ArrowRight, CircleArrow } from '../icons'

defineProps(['categories', 'activeCategory', 'reports'])
defineEmits(['update:activeCategory'])
</script>

<style scoped>
.hover-primary-title {
  transition: color 0.2s ease-in-out;
}
.hover-primary-title:hover {
  color: #0783df;
}
</style>

