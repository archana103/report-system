<template>
  <DataTable
    title="Report List"
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
    <!-- Category Name -->
    <template #item-report_category="{ item }">
      <span class="text-blue-400 font-medium">
        {{ item.report_category?.name ?? '—' }}
      </span>
    </template>

    <!-- Status badge -->
    <template #item-status="{ item }">
      <span
        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border"
        :class="item.status === 'Active' || item.status === 1
          ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'
          : 'bg-gray-500/10 text-gray-400 border-gray-500/20'"
      >
        <span
          class="w-1.5 h-1.5 rounded-full mr-1.5"
          :class="item.status === 'Active' || item.status === 1 ? 'bg-emerald-400' : 'bg-gray-400'"
        ></span>
        {{ (item.status === 'Active' || item.status === 1) ? 'Active' : 'Inactive' }}
      </span>
    </template>

    <!-- Created At -->
    <template #item-created_at="{ item }">
      <span class="text-gray-400 text-sm">{{ formatDate(item.created_at) }}</span>
    </template>
  </DataTable>

  <!-- Delete Confirmation Modal -->
  <ConfirmationModal
    :show="showDeleteModal"
    title="Delete Report"
    :message="`Are you sure you want to delete '${selectedReport?.name}'? This action cannot be undone.`"
    @confirm="confirmDelete"
    @cancel="showDeleteModal = false"
  />
</template>

<script setup>
import { ref, onMounted } from 'vue'
import DataTable from '@/components/DataTable.vue'
import ConfirmationModal from '@/components/ConfirmationModal.vue'
import { getReportLists, deleteReportList } from './api.js'

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
  { key: 'report_category', label: 'Category' },
  { key: 'name', label: 'Report Name' },
  { key: 'status', label: 'Status' },
  { key: 'created_at', label: 'Created At' },
]

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
    const response = await getReportLists(params)
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
    console.error('Error fetching reports:', error)
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
  const response = await getReportLists(params)
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
    await deleteReportList(selectedReport.value.id)
    showDeleteModal.value = false
    fetchReports(pagination.value.current_page)
  } catch (error) {
    console.error('Error deleting report:', error)
  }
}

onMounted(() => {
  fetchReports()
})
</script>
