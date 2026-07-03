<template>
  <DataTable
    title="Press Release Details List"
    :headers="headers"
    :items="items"
    :loading="loading"
    :pagination="pagination"
    :exportDataFn="fetchExportData"
    @page-change="fetchData"
    @edit="handleEdit"
    @delete="handleDelete"
    @search="handleSearch"
  >
    <template #item-press_release="{ item }">
      <span class="text-gray-200 font-medium">{{ item.press_release?.title || '—' }}</span>
    </template>

    <template #item-content="{ item }">
      <div class="max-w-xs text-gray-400 text-sm italic" :title="stripHtml(item.content)">
        {{ truncateText(item.content, 80) }}
      </div>
    </template>

    <template #item-created_at="{ item }">
      <span class="text-gray-400 text-sm whitespace-nowrap">{{ formatDate(item.created_at) }}</span>
    </template>
  </DataTable>

  <ConfirmationModal
    :show="showDeleteModal"
    title="Delete Press Release Detail"
    :message="`Are you sure you want to delete the details for '${selectedItem?.press_release?.title || 'this release'}'? This action cannot be undone.`"
    @confirm="confirmDelete"
    @cancel="showDeleteModal = false"
  />
</template>

<script setup>
import { ref, onMounted } from 'vue'
import DataTable from '@/components/DataTable.vue'
import ConfirmationModal from '@/components/ConfirmationModal.vue'
import { getPressReleaseDetails, deletePressReleaseDetail } from './api.js'

const emit = defineEmits(['edit'])

const items = ref([])
const loading = ref(false)
const selectedItem = ref(null)
const showDeleteModal = ref(false)
const searchQuery = ref('')

const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 20,
  total: 0,
  from: 0,
  to: 0
})

const headers = [
  { key: 'press_release', label: 'Press Release Title' },
  { key: 'content', label: 'Press Release Content' },
  { key: 'created_at', label: 'Date' },
]

const formatDate = (dateStr) => {
  if (!dateStr) return '—'
  return new Intl.DateTimeFormat('en-US', { year: 'numeric', month: 'short', day: 'numeric' }).format(new Date(dateStr))
}

const stripHtml = (html) => {
  if (!html) return "";
  const doc = new DOMParser().parseFromString(html, 'text/html');
  return doc.body.textContent || "";
};

const truncateText = (text, length = 60) => {
  if (!text) return '—';
  const cleanText = stripHtml(text);
  if (cleanText.length <= length) return cleanText;
  return cleanText.substring(0, length) + '...';
};

const fetchData = async (page = 1) => {
  loading.value = true
  try {
    const params = {
      page,
      limit: 20,
      search: searchQuery.value,
    }
    const response = await getPressReleaseDetails(params)
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
    console.error('Error fetching press release details:', error)
  } finally {
    loading.value = false
  }
}

const fetchExportData = async () => {
  const params = {
      search: searchQuery.value,
      export: 'true'
  }
  const response = await getPressReleaseDetails(params)
  return Array.isArray(response) ? response : (response.data ? response.data : [])
}

const handleSearch = (query) => {
  searchQuery.value = query
  fetchData(1)
}

const handleEdit = (item) => {
  emit('edit', item)
}

const handleDelete = (item) => {
  selectedItem.value = item
  showDeleteModal.value = true
}

const confirmDelete = async () => {
  if (!selectedItem.value) return
  try {
    await deletePressReleaseDetail(selectedItem.value.id)
    showDeleteModal.value = false
    fetchData(pagination.value.current_page)
  } catch (error) {
    console.error('Error deleting press release detail:', error)
  }
}

onMounted(() => {
  fetchData()
})
</script>
