<script setup>
import { ref, onMounted } from 'vue'
import DataTable from '@/components/DataTable.vue'
import ConfirmationModal from '@/components/ConfirmationModal.vue'
import { getPurchasesData, deletePurchase } from './api.js'

const items = ref([])
const loading = ref(false)
const searchQuery = ref('')
const sortOptions = ref({ key: 'created_at', order: 'desc' })

const showDeleteModal = ref(false)
const purchaseToDelete = ref(null)

const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 20,
  total: 0,
  from: 0,
  to: 0
})

const headers = [
  { key: 'full_name', label: 'Customer Name' },
  { key: 'business_email', label: 'Email' },
  { key: 'reportDetail', label: 'Report' },
  { key: 'pricing', label: 'License Type' },
  { key: 'country', label: 'Country' },
  { key: 'payment_status', label: 'Payment Status' },
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
    const response = await getPurchasesData(params)
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
    console.error('Error fetching purchases data:', error)
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
  const response = await getPurchasesData(params)
  return Array.isArray(response) ? response : (response.data ? response.data : [])
}

const handleDelete = (item) => {
  purchaseToDelete.value = item
  showDeleteModal.value = true
}

const confirmDelete = async () => {
  if (!purchaseToDelete.value) return
  
  try {
    await deletePurchase(purchaseToDelete.value.id)
    showDeleteModal.value = false
    purchaseToDelete.value = null
    fetchData(pagination.value.current_page)
  } catch (error) {
    console.error('Error deleting purchase:', error)
  }
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
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
    
    <div class="relative z-10 flex-grow flex flex-col">
      <DataTable
        title="Checkout Purchases"
        :headers="headers"
        :items="items"
        :loading="loading"
        :pagination="pagination"
        :exportDataFn="fetchExportData"
        :hasActions="true"
        @page-change="fetchData"
        @search="handleSearch"
        @sort="handleSort"
        @delete="handleDelete"
      >
        <template #item-reportDetail="{ item }">
          <div class="max-w-xs truncate whitespace-normal leading-relaxed text-sm">
            {{ item.report_detail?.title || 'Unknown Report' }}
          </div>
        </template>
        
        <template #item-pricing="{ item }">
          <span class="px-2 py-1 bg-white/10 rounded-md text-xs font-semibold text-gray-300 whitespace-nowrap">
            {{ item.pricing?.title || 'Custom pricing' }}
          </span>
        </template>
        
        <template #item-payment_status="{ item }">
          <span 
            class="px-2.5 py-1 text-xs font-bold rounded-full uppercase tracking-wider"
            :class="item.payment_status === 'COMPLETED' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-amber-500/20 text-amber-300'"
          >
            {{ item.payment_status }}
          </span>
        </template>
      </DataTable>

      <ConfirmationModal
        :show="showDeleteModal"
        title="Delete Purchase Record"
        message="Are you sure you want to delete this purchase record? This action cannot be undone."
        @confirm="confirmDelete"
        @cancel="showDeleteModal = false"
      />
    </div>
  </div>
</template>
