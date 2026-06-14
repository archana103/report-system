<template>
  <DataTable
    title="Press Release List"
    :headers="headers"
    :items="items"
    :loading="loading"
    :pagination="pagination"
    :exportDataFn="fetchExportData"
    @page-change="fetchData"
    @edit="handleEdit"
    @delete="handleDelete"
    @search="handleSearch"
    @sort="handleSort"
  >
    <template #item-main_image="{ item }">
      <div v-if="item.main_image" class="w-16 h-12 rounded overflow-hidden border border-gray-700/50 bg-gray-800 flex items-center justify-center">
        <img :src="item.main_image" class="object-cover w-full h-full" alt="Main Image" />
      </div>
      <div v-else class="text-gray-500 text-xs italic">No Image</div>
    </template>

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

    <template #item-description="{ item }">
      <div class="max-w-xs truncate" :title="item.description">
        {{ item.description }}
      </div>
    </template>

    <template #item-created_at="{ item }">
      <span class="text-gray-400 text-sm whitespace-nowrap">{{ formatDate(item.created_at) }}</span>
    </template>
  </DataTable>

  <ConfirmationModal
    :show="showDeleteModal"
    title="Delete Press Release"
    :message="`Are you sure you want to delete '${selectedItem?.title}'? This action cannot be undone.`"
    @confirm="confirmDelete"
    @cancel="showDeleteModal = false"
  />
</template>

<script setup>
import { ref, onMounted } from 'vue'
import DataTable from '@/components/DataTable.vue'
import ConfirmationModal from '@/components/ConfirmationModal.vue'
import { getPressReleases, deletePressRelease } from './api.js'

const emit = defineEmits(['edit'])

const items = ref([])
const loading = ref(false)
const selectedItem = ref(null)
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
  { key: 'title', label: 'Title' },
  { key: 'description', label: 'Description' },
  { key: 'url', label: 'URL' },
  { key: 'main_image', label: 'Image', sortable: false },
  { key: 'status', label: 'Status' },
  { key: 'created_at', label: 'Date' },
]

const formatDate = (dateStr) => {
  if (!dateStr) return '—'
  return new Intl.DateTimeFormat('en-US', { year: 'numeric', month: 'short', day: 'numeric' }).format(new Date(dateStr))
}

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
    const response = await getPressReleases(params)
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
    console.error('Error fetching press releases:', error)
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
  const response = await getPressReleases(params)
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
    await deletePressRelease(selectedItem.value.id)
    showDeleteModal.value = false
    fetchData(pagination.value.current_page)
  } catch (error) {
    console.error('Error deleting press release:', error)
  }
}

onMounted(() => {
  fetchData()
})
</script>
