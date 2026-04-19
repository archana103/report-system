<template>
  <DataTable
    title="Report Details List"
    :headers="headers"
    :items="reports"
    :loading="loading"
    :pagination="pagination"
    :exportDataFn="fetchExportData"
    @page-change="fetchReports"
    @edit="handleEdit"
    @delete="handleDelete"
    @search="handleSearch"
    @sort="handleSort"
  >
    <template #item-report_list="{ item }">
      <span class="text-blue-400 font-medium" :title="stripHtml(item.report_list?.name)">
        {{ truncate(item.report_list?.name) }}
      </span>
    </template>
    
    <template #item-title="{ item }">
      <span class="text-gray-300" :title="stripHtml(item.title)">
        {{ truncate(item.title) }}
      </span>
    </template>

    <template #item-description="{ item }">
      <span class="text-gray-400 text-xs" :title="stripHtml(item.description)">
        {{ truncate(item.description) }}
      </span>
    </template>

    <template #item-category_list_download="{ item }">
      <span class="text-gray-400 text-xs" :title="stripHtml(item.category_list_download)">
        {{ truncate(item.category_list_download) }}
      </span>
    </template>

    <template #item-download_text="{ item }">
      <span class="text-gray-400 text-xs" :title="stripHtml(item.download_text)">
        {{ truncate(item.download_text) }}
      </span>
    </template>

    <template #item-image="{ item }">
      <div v-if="item.image" class="h-12 w-12 rounded overflow-hidden border border-gray-700">
        <img :src="`/storage/${item.image}`" alt="Report Image" class="w-full h-full object-cover" />
      </div>
      <span v-else class="text-gray-500">—</span>
    </template>

    <template #item-status="{ item }">
      <span
        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border"
        :class="String(item.status).toLowerCase() === 'active' || item.status === 1
          ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'
          : 'bg-gray-500/10 text-gray-400 border-gray-500/20'"
      >
        <span
          class="w-1.5 h-1.5 rounded-full mr-1.5"
          :class="String(item.status).toLowerCase() === 'active' || item.status === 1 ? 'bg-emerald-400' : 'bg-gray-400'"
        ></span>
        {{ (String(item.status).toLowerCase() === 'active' || item.status === 1) ? 'Active' : 'Inactive' }}
      </span>
    </template>

    <template #item-created_at="{ item }">
      <span class="text-gray-400 text-sm whitespace-nowrap">{{ formatDate(item.created_at) }}</span>
    </template>
  </DataTable>

  <!-- Delete Confirmation Modal -->
  <ConfirmationModal
    :show="showDeleteModal"
    title="Delete Report Detail"
    :message="`Are you sure you want to delete this report detail? This action cannot be undone.`"
    @confirm="confirmDelete"
    @cancel="showDeleteModal = false"
  />
</template>

<script setup>
import { ref, onMounted } from 'vue'
import DataTable from '@/components/DataTable.vue'
import ConfirmationModal from '@/components/ConfirmationModal.vue'
import { getReportDetails, deleteReportDetail } from './api.js'

const emit = defineEmits(['edit'])

const reports = ref([])
const loading = ref(false)
const selectedReport = ref(null)
const showDeleteModal = ref(false)
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
  { key: 'report_list', label: 'Report Category List Name' },
  { key: 'title', label: 'Report Details title' },
  { key: 'description', label: 'Report Details description' },
  { key: 'category_list_download', label: 'Report Details Download' },
  { key: 'image', label: 'Report Details Image', sortable: false },
  { key: 'download_text', label: 'Report Details Text' },
  { key: 'status', label: 'Status' },
  { key: 'created_at', label: 'Date' },
]

const stripHtml = (html) => {
  if (!html) return ''
  const doc = new DOMParser().parseFromString(html, 'text/html')
  return doc.body.textContent || ''
}

const truncate = (text, length = 50) => {
  const cleanText = stripHtml(text).trim()
  if (!cleanText) return '—'
  return cleanText.length > length ? cleanText.substring(0, length) + '...' : cleanText
}

const formatDate = (dateStr) => {
  if (!dateStr) return '—'
  return new Intl.DateTimeFormat('en-US', { year: 'numeric', month: 'short', day: 'numeric' }).format(new Date(dateStr))
}

const fetchReports = async (page = 1) => {
  loading.value = true
  try {
    const params = {
      page,
      limit: 20,
      search: searchQuery.value,
      sort_by: sortOptions.value.key,
      sort_dir: sortOptions.value.order
    }
    const response = await getReportDetails(params)
    reports.value = response.data || []
    pagination.value = {
      current_page: response.current_page || 1,
      last_page: response.last_page || 1,
      per_page: response.per_page || 20,
      total: response.total || 0,
      from: response.from || 0,
      to: response.to || 0
    }
  } catch (error) {
    console.error('Error fetching report details:', error)
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
  const response = await getReportDetails(params)
  return Array.isArray(response) ? response : (response.data ? response.data : [])
}

const handleSort = (sort) => {
  sortOptions.value = sort
  fetchReports(pagination.value.current_page)
}

const handleSearch = (query) => {
  searchQuery.value = query
  fetchReports(1)
}

const handleEdit = (item) => {
  emit('edit', item)
}

const handleDelete = (item) => {
  selectedReport.value = item
  showDeleteModal.value = true
}

const confirmDelete = async () => {
  if (!selectedReport.value) return
  try {
    await deleteReportDetail(selectedReport.value.id)
    showDeleteModal.value = false
    fetchReports(pagination.value.current_page)
  } catch (error) {
    console.error('Error deleting report detail:', error)
  }
}

onMounted(() => {
  fetchReports()
})
</script>
