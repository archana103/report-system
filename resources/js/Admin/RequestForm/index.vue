<script setup>
import { ref, onMounted } from 'vue'
import DataTable from '@/components/DataTable.vue'
import ConfirmationModal from '@/components/ConfirmationModal.vue'
import { getRequestForms, deleteRequestForm } from './api.js'

const items = ref([])
const loading = ref(false)
const searchQuery = ref('')
const sortOptions = ref({ key: 'created_at', order: 'desc' })

const selectedItem = ref(null)
const showDeleteModal = ref(false)
const showViewModal = ref(false)

const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 20,
  total: 0,
  from: 0,
  to: 0
})

const headers = [
  { key: 'name', label: 'Name' },
  { key: 'email', label: 'Email' },
  { key: 'phone', label: 'Phone' },
  { key: 'subject', label: 'Subject' },
  { key: 'job_title', label: 'Job Title' },
  { key: 'created_at', label: 'Date' },
]

const formatDate = (dateStr) => {
  if (!dateStr) return '—'
  return new Intl.DateTimeFormat('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' }).format(new Date(dateStr))
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
    const response = await getRequestForms(params)
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
    console.error('Error fetching request forms:', error)
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
  const response = await getRequestForms(params)
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

const handleView = (item) => {
  selectedItem.value = item
  showViewModal.value = true
}

const handleDelete = (item) => {
  selectedItem.value = item
  showDeleteModal.value = true
}

const confirmDelete = async () => {
  if (!selectedItem.value) return
  try {
    await deleteRequestForm(selectedItem.value.id)
    showDeleteModal.value = false
    fetchData(pagination.value.current_page)
  } catch (error) {
    console.error('Error deleting request form:', error)
  }
}

onMounted(() => {
  fetchData()
})
</script>

<template>
  <div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-hidden flex flex-col">
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>
    
    <div class="relative z-10 flex-grow flex flex-col">
      <DataTable
        title="Report Requests"
        :headers="headers"
        :items="items"
        :loading="loading"
        :pagination="pagination"
        :exportDataFn="fetchExportData"
        :hasActions="true"
        @page-change="fetchData"
        @search="handleSearch"
        @sort="handleSort"
        @edit="handleView"
        @delete="handleDelete"
      >
        <template #item-created_at="{ item }">
          <span class="text-gray-400 text-sm whitespace-nowrap">{{ formatDate(item.created_at) }}</span>
        </template>
      </DataTable>
    </div>
  </div>

  <ConfirmationModal
    :show="showDeleteModal"
    title="Delete Request"
    :message="`Are you sure you want to delete the request from '${selectedItem?.name}'? This action cannot be undone.`"
    @confirm="confirmDelete"
    @cancel="showDeleteModal = false"
  />

  <!-- View Modal -->
  <Transition name="modal">
    <div v-if="showViewModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
      <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden animate-in zoom-in duration-200 flex flex-col max-h-[90vh]">
        <div class="px-6 py-4 border-b border-gray-700 flex justify-between items-center bg-gray-900/50">
          <h3 class="text-lg font-medium text-gray-200">Request Details</h3>
          <button @click="showViewModal = false" class="text-gray-400 hover:text-gray-200 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        
        <div class="p-6 overflow-y-auto" v-if="selectedItem">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Name</p>
              <p class="text-gray-200 font-medium">{{ selectedItem.name || '—' }}</p>
            </div>
            <div>
              <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Email</p>
              <p class="text-gray-200 font-medium">{{ selectedItem.email || '—' }}</p>
            </div>
            <div>
              <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Phone</p>
              <p class="text-gray-200 font-medium">{{ selectedItem.phone || '—' }}</p>
            </div>
            <div>
              <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Country</p>
              <p class="text-gray-200 font-medium">{{ selectedItem.country || '—' }}</p>
            </div>
            <div>
              <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Company Name</p>
              <p class="text-gray-200 font-medium">{{ selectedItem.company_name || '—' }}</p>
            </div>
            <div>
              <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Job Title</p>
              <p class="text-gray-200 font-medium">{{ selectedItem.job_title || '—' }}</p>
            </div>
            <div class="md:col-span-2">
              <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Subject</p>
              <p class="text-gray-200 font-medium">{{ selectedItem.subject || '—' }}</p>
            </div>
            <div class="md:col-span-2">
              <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Specific Research Requirement</p>
              <div class="bg-gray-900/50 p-4 rounded-xl border border-gray-700/50 mt-2">
                <p class="text-gray-300 whitespace-pre-wrap text-sm leading-relaxed">{{ selectedItem.specific_research_requirement || 'No specific requirements provided.' }}</p>
              </div>
            </div>
            <div class="md:col-span-2">
              <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Submitted At</p>
              <p class="text-gray-400 text-sm">{{ formatDate(selectedItem.created_at) }}</p>
            </div>
          </div>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-700 flex justify-end bg-gray-900/50">
          <button 
            @click="showViewModal = false"
            class="px-5 py-2.5 text-sm font-medium text-gray-300 bg-gray-800 hover:bg-gray-700 rounded-lg transition-colors border border-gray-600"
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </Transition>
</template>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.2s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
</style>
