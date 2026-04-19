<template>
  <div class="animate-in fade-in duration-300">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-medium text-white tracking-tight">Top Selling Reports</h2>
      <button 
        @click="openAddModal"
        class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-xl flex items-center shadow-lg transition-all active:scale-95 text-sm font-medium"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Add Report
      </button>
    </div>

    <DataTable
      title="Top Selling Reports (Frontend shows latest 5)"
      :headers="headers"
      :items="reports"
      :loading="loading"
      :hasActions="false"
      :exportable="false"
      :pagination="pagination"
      @page-change="fetchReports"
    >
      <template #item-report_title="{ item }">
        <span class="text-gray-200 group-hover:text-blue-400 transition-colors duration-200">
          {{ item.report_detail?.title || '—' }}
        </span>
      </template>

      <template #item-added_date="{ item }">
        <span class="text-gray-400 text-sm italic">{{ formatDate(item.created_at) }}</span>
      </template>

      <template #item-actions="{ item }">
         <button 
          @click="openDeleteModal(item)"
          class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-all flex items-center"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
          Remove
        </button>
      </template>
    </DataTable>

    <!-- Search/Add Modal -->
    <div v-if="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm animate-in fade-in duration-200">
      <div class="bg-gray-900 w-full max-w-xl rounded-2xl border border-gray-700 shadow-2xl overflow-hidden animate-in zoom-in-95 duration-200">
        <div class="px-6 py-4 border-b border-gray-700 flex justify-between items-center bg-gray-800/50">
          <h3 class="text-xl font-medium text-white">Add Top Selling Report</h3>
          <button @click="closeModal" class="text-gray-400 hover:text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>
        </div>

        <div class="p-6 space-y-4">
          <div class="relative group">
            <input 
              v-model="searchQuery"
              @input="handleSearch"
              type="text" 
              placeholder="Search reports..."
              class="w-full bg-gray-800 border border-gray-700 rounded-xl px-12 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all shadow-inner"
            />
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-blue-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <div v-if="searching" class="absolute right-4 top-1/2 -translate-y-1/2">
              <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-500"></div>
            </div>
          </div>

          <!-- Search Results -->
          <div class="max-h-64 overflow-y-auto rounded-xl border border-gray-700/50 bg-gray-800/30 custom-scrollbar">
            <div v-if="searchResults.length === 0 && searchQuery" class="p-8 text-center text-gray-500 italic">
               No reports found matching your search.
            </div>
            <div v-else-if="searchResults.length === 0 && searching" class="p-8 text-center text-gray-500">
               Searching reports...
            </div>
            <div v-else-if="searchResults.length === 0" class="p-8 text-center text-gray-500">
               No reports available to add.
            </div>
            <div 
              v-for="res in searchResults" 
              :key="res.id"
              @click="selectedReport = res"
              class="px-4 py-3 cursor-pointer transition-all duration-150 border-b border-gray-700/30 last:border-0"
              :class="selectedReport?.id === res.id ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-gray-700/50 text-gray-300 hover:text-white'"
            >
              <p class="text-sm border-l-3 transition-all pl-3" :class="selectedReport?.id === res.id ? 'border-white' : 'border-transparent'">
                {{ res.title }}
              </p>
            </div>
          </div>
        </div>

        <div class="px-6 py-4 bg-gray-800/50 border-t border-gray-700 flex justify-end space-x-3">
          <button 
            @click="closeModal"
            class="px-5 py-2.5 rounded-xl text-gray-400 hover:text-white hover:bg-gray-700 transition-all text-sm font-medium"
          >
            Cancel
          </button>
          <button 
            @click="addReport"
            :disabled="!selectedReport || adding"
            class="bg-emerald-600 hover:bg-emerald-500 disabled:opacity-50 disabled:cursor-not-allowed text-white px-5 py-2.5 rounded-xl shadow-lg transition-all active:scale-95 text-sm font-medium flex items-center"
          >
            <span v-if="adding">Adding...</span>
            <span v-else>Add Report</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <ConfirmationModal
      :show="showDeleteModal"
      title="Remove Top Selling Report"
      :message="`Are you sure you want to remove '${reportToDelete?.report_detail?.title}' from the top selling list? This will NOT delete the report detail itself.`"
      @confirm="confirmDelete"
      @cancel="showDeleteModal = false"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import DataTable from '@/components/DataTable.vue'
import ConfirmationModal from '@/components/ConfirmationModal.vue'

const reports = ref([])
const loading = ref(false)
const showAddModal = ref(false)
const searchQuery = ref('')
const searchResults = ref([])
const searching = ref(false)
const selectedReport = ref(null)
const adding = ref(false)

const showDeleteModal = ref(false)
const reportToDelete = ref(null)

const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 20,
  total: 0,
  from: 0,
  to: 0
})

const headers = [
  { key: 'report_title', label: 'Report Title' },
  { key: 'added_date', label: 'Added' },
  { key: 'actions', label: 'Action', sortable: false }
]

const fetchReports = async (page = 1) => {
  loading.value = true
  try {
    const response = await axios.get('/admin/top-selling-reports', { params: { page } })
    reports.value = response.data.data
    pagination.value = {
      current_page: response.data.current_page,
      last_page: response.data.last_page,
      per_page: response.data.per_page,
      total: response.data.total,
      from: response.data.from,
      to: response.data.to
    }
  } catch (error) {
    console.error('Error fetching reports:', error)
  } finally {
    loading.value = false
  }
}

let searchTimeout = null
const closeModal = () => {
  showAddModal.value = false
  searchQuery.value = ''
  searchResults.value = []
  selectedReport.value = null
}

const openAddModal = () => {
    showAddModal.value = true
    handleSearch() // Fetch all reports initially
}

const handleSearch = () => {
    if (searchTimeout) clearTimeout(searchTimeout)
    
    searching.value = true
    searchTimeout = setTimeout(async () => {
        try {
            const response = await axios.get('/admin/top-selling-reports/search', { params: { q: searchQuery.value } })
            searchResults.value = response.data
        } catch (error) {
            console.error('Error searching reports:', error)
        } finally {
            searching.value = false
        }
    }, 300)
}

const addReport = async () => {
    if (!selectedReport.value) return
    
    adding.value = true
    try {
      const response = await axios.post('/admin/top-selling-reports', {
        report_detail_id: selectedReport.value.id
      })
      // Add to list and close
      fetchReports()
      closeModal()
      alert(response.data.message)
    } catch (error) {
      alert(error.response?.data?.message || 'Failed to add report.')
    } finally {
      adding.value = false
    }
}

const openDeleteModal = (item) => {
  reportToDelete.value = item
  showDeleteModal.value = true
}

const confirmDelete = async () => {
  try {
    await axios.delete(`/admin/top-selling-reports/${reportToDelete.value.id}`)
    fetchReports()
    showDeleteModal.value = false
  } catch (error) {
    alert('Failed to remove report.')
  }
}

const formatDate = (dateStr) => {
  if (!dateStr) return '—'
  return new Intl.DateTimeFormat('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }).format(new Date(dateStr))
}

onMounted(() => {
  fetchReports()
})
</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: rgba(0, 0, 0, 0.1);
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #374151;
  border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: #4b5563;
}
</style>
