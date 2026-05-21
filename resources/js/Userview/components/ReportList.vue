<template>
  <div v-if="loading" class="loading-state">
    Loading reports...
  </div>
  <div v-else class="report-list-vertical">
    <article v-for="report in reports" :key="report.id" class="report-list-card">
      <div class="report-image-wrap">
        <router-link :to="`/report/${report.slug && report.slug !== '#' ? report.slug : report.id}`">
          <img :src="report.image" :alt="report.title" />
        </router-link>
      </div>
      <div class="report-details">
        <router-link :to="`/report/${report.slug && report.slug !== '#' ? report.slug : report.id}`" style="color: inherit; text-decoration: none;">
          <h3 class="hover-primary-title">{{ report.title }}</h3>
        </router-link>
        <p>{{ report.description }}</p>
        <div class="report-metadata">
          <span>Pages: <strong>{{ report.pages }}</strong></span>
          <span class="divider">|</span>
          <span>Format: <strong>{{ report.format }}</strong></span>
          <span class="divider">|</span>
          <span>Publish Date: <strong>{{ report.date }}</strong></span>
        </div>
        <div class="report-actions">
          <router-link :to="`/report/${report.slug && report.slug !== '#' ? report.slug : report.id}?tab=overview`" class="secondary-button outlined" style="padding: 10px 24px; min-height: auto; line-height: 1.2;">View Details</router-link>
          <router-link :to="`/report/${report.slug && report.slug !== '#' ? report.slug : report.id}?tab=faq`" class="secondary-button outlined" style="padding: 10px 24px; min-height: auto; line-height: 1.2;">Request Sample</router-link>
          <router-link :to="`/report/${report.slug && report.slug !== '#' ? report.slug : report.id}?tab=toc`" class="primary-button small" style="padding: 10px 24px; min-height: auto; line-height: 1.2;">Buy Now</router-link>
        </div>
      </div>
    </article>
    
    <div v-if="reports.length === 0" class="no-results">
      No reports found for your search criteria.
    </div>
  </div>
</template>

<script setup>
defineProps({
  reports: Array,
  loading: Boolean
})
</script>

<style scoped>
.hover-primary-title {
  transition: color 0.2s ease-in-out;
}
.hover-primary-title:hover {
  color: #0783df;
}
</style>\n