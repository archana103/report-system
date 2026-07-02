<template>
  <div class="top-seller-widget">
    <h3 class="widget-title">Top Seller Reports</h3>
    
    <div v-if="loading" class="widget-loading">
      <div class="spinner"></div>
    </div>
    
    <div v-else-if="reports.length === 0" class="widget-empty">
      No top selling reports available.
    </div>
    
    <div v-else class="widget-reports-list">
      <div v-for="(item, index) in reports" :key="index" class="widget-report-item">
        <p class="report-title" :title="item.report_detail?.title">
          {{ item.report_detail?.title }}
        </p>
        <router-link :to="`/checkout/${item.report_detail?.slug_url}`" class="buy-now-link">
          Buy Now <ArrowRight style="width: 14px; height: 14px; stroke-width: 2.5;" />
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { ArrowRight } from '../icons'

const reports = ref([])
const loading = ref(true)

const fetchTopSelling = async () => {
  loading.value = true
  try {
    const response = await axios.get('/api/public-top-selling-reports')
    reports.value = response.data
  } catch (error) {
    console.error('Error fetching top selling reports:', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchTopSelling()
})
</script>

<style scoped>
.top-seller-widget {
  background: #ffffff;
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  padding: 24px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
}

.widget-title {
  font-size: 18px;
  font-weight: 800;
  color: #111827;
  margin: 0 0 16px;
  border-bottom: 1px solid #e5e7eb;
  padding-bottom: 12px;
}

.widget-loading {
  display: flex;
  justify-content: center;
  padding: 20px 0;
}

.spinner {
  width: 24px;
  height: 24px;
  border: 3px solid #f3f4f6;
  border-top: 3px solid #0783df;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.widget-empty {
  font-size: 14px;
  color: #6b7280;
  padding: 20px 0;
  text-align: center;
}

.widget-reports-list {
  display: flex;
  flex-direction: column;
}

.widget-report-item {
  padding: 16px 0;
  border-bottom: 1px solid #f3f4f6;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.widget-report-item:last-child {
  border-bottom: none;
  padding-bottom: 0;
}

.report-title {
  font-size: 13px;
  font-weight: 600;
  color: #4b5563;
  margin: 0;
  line-height: 1.5;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.buy-now-link {
  font-size: 14px;
  font-weight: 700;
  color: #0783df;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 4px;
  transition: opacity 0.2s;
}

.buy-now-link:hover {
  opacity: 0.8;
}
</style>
