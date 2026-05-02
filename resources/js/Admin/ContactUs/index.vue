<script setup>
import { ref, onMounted } from 'vue'
import DataTable from '@/components/DataTable.vue'
import { getContactUsData } from './api.js'

const items = ref([])
const loading = ref(false)
const searchQuery = ref('')
const sortOptions = ref({ key: 'created_at', order: 'desc' })

const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 20,
  total: 0,
  from: 0,
  to: 0
})

const headers = [
  { key: 'full_name', label: 'Full Name' },
  { key: 'email', label: 'Business EmailId' },
  { key: 'phone', label: 'Contact No.' },
  { key: 'country', label: 'Country' },
  { key: 'company_name', label: 'Company Name' },
  { key: 'specific_research_requirement', label: 'Message' },
]

const fetchData = async (page = 1) => {
  loading.value = true
  try {
    const params = {
      page,
      limit: 20,
      search: searchQuery.value,
      sort_by: sortOptions.value.key,
      sort_dir: sortOptions.value.order
    }
    const response = await getContactUsData(params)
    items.value = response.data || []
    pagination.value = {
      current_page: response.current_page || 1,
      last_page: response.last_page || 1,
      per_page: response.per_page || 20,
      total: response.total || 0,
      from: response.from || 0,
      to: response.to || 0
    }
  } catch (error) {
    console.error('Error fetching contact us data:', error)
  } finally {
    loading.value = false
  }
}

const fetchExportData = async () => {
  const params = {
      search: searchQuery.value,
      sort_by: sortOptions.value.key,
      sort_dir: sortOptions.value.order,
      export: 'true'
  }
  const response = await getContactUsData(params)
  return Array.isArray(response) ? response : (response.data ? response.data : [])
}

const handleSort = (sort) => {
  sortOptions.value = sort
  fetchData(pagination.value.current_page)
}

const handleSearch = (query) => {
  searchQuery.value = query
  fetchData(1)
}

onMounted(() => {
  fetchData()
})
</script>

<template>
  <div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-hidden flex flex-col">
    <!-- Decorative Blob -->
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>
    
    <div class="relative z-10 flex-grow flex flex-col">
      <DataTable
        title="Contact Us Data"
        :headers="headers"
        :items="items"
        :loading="loading"
        :pagination="pagination"
        :exportDataFn="fetchExportData"
        :hasActions="false"
        @page-change="fetchData"
        @search="handleSearch"
        @sort="handleSort"
      >
        <template #item-specific_research_requirement="{ item }">
          <div class="max-w-md truncate whitespace-normal leading-relaxed text-sm">
            {{ item.specific_research_requirement }}
          </div>
        </template>
      </DataTable>
    </div>
  </div>
</template>
