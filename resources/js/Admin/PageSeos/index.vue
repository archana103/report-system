<template>
  <div class="animate-in fade-in duration-300">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-medium text-white tracking-tight">Page SEOs</h2>
      <button 
        @click="openAddModal"
        class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-xl flex items-center shadow-lg transition-all active:scale-95 text-sm font-medium"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Add Page SEO
      </button>
    </div>

    <!-- Dark Theme Table -->
    <div class="overflow-x-auto rounded-xl border border-gray-700/50 bg-gray-800/30 shadow-2xl">
      <table class="w-full text-sm text-left text-gray-300">
        <thead class="text-xs text-gray-400 uppercase bg-gray-900/50 border-b border-gray-700">
          <tr>
            <th scope="col" class="px-6 py-4 font-medium tracking-wider">URL Path</th>
            <th scope="col" class="px-6 py-4 font-medium tracking-wider">Last Updated</th>
            <th scope="col" class="px-6 py-4 font-medium tracking-wider text-center">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-700/50">
          <tr v-for="pageSEO in pageSeos" :key="pageSEO.id" class="hover:bg-gray-700/30 transition-colors duration-150">
            <td class="px-6 py-4 font-medium text-gray-200 whitespace-nowrap">{{ pageSEO.url_path }}</td>
            <td class="px-6 py-4 text-gray-400 text-sm italic">{{ formatDate(pageSEO.updated_at) }}</td>
            <td class="px-6 py-4 text-center">
              <button @click="openEditModal(pageSEO)" class="text-blue-400 hover:text-blue-300 mx-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
              </button>
              <button @click="deletePageSeo(pageSEO.id)" class="text-red-400 hover:text-red-300 mx-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </button>
            </td>
          </tr>
          <tr v-if="pageSeos.length === 0">
            <td colspan="3" class="px-6 py-8 text-center text-gray-500 italic">No Page SEO records found.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Dark Theme Modal -->
    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm overflow-y-auto pt-24 pb-12 animate-in fade-in duration-200">
      <div class="relative w-full max-w-2xl bg-gray-900 rounded-2xl border border-gray-700 shadow-2xl mt-auto mb-auto animate-in zoom-in-95 duration-200 text-left">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-700 bg-gray-800/50 rounded-t-2xl">
          <h3 class="text-xl font-medium text-white">
            {{ isEditing ? 'Edit Page SEO' : 'Add Page SEO' }}
          </h3>
          <button @click="closeModal" type="button" class="text-gray-400 hover:text-white transition-colors bg-transparent rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        
        <form @submit.prevent="submitForm">
          <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto custom-scrollbar">
            <div class="grid grid-cols-1 gap-4">
              <div>
                <label class="block mb-2 text-sm font-medium text-gray-300">URL Path <span class="text-red-500">*</span> (e.g. "about-us")</label>
                <input v-model="form.url_path" type="text" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all shadow-inner" placeholder="about-us" required>
              </div>
              
              <div>
                <label class="block mb-2 text-sm font-medium text-gray-300">Meta Tags (Raw HTML)</label>
                <textarea v-model="form.raw_tags" rows="6" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-2.5 text-blue-400 placeholder-gray-600 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all shadow-inner font-mono text-xs custom-scrollbar" placeholder='<meta name="title" content="...">\n<meta property="og:type" content="...">'></textarea>
              </div>

              <div>
                <label class="block mb-2 text-sm font-medium text-gray-300">Schema JSON</label>
                <textarea v-model="form.schema_tag" rows="5" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-2.5 text-green-400 placeholder-gray-600 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all shadow-inner font-mono text-xs custom-scrollbar" placeholder='{ "@context": "https://schema.org", ... }'></textarea>
              </div>
            </div>
          </div>
          <div class="flex items-center justify-end px-6 py-4 bg-gray-800/50 border-t border-gray-700 rounded-b-2xl space-x-3">
            <button type="button" @click="closeModal" class="px-5 py-2.5 rounded-xl text-gray-400 hover:text-white hover:bg-gray-700 transition-all text-sm font-medium">Cancel</button>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white px-5 py-2.5 rounded-xl shadow-lg transition-all active:scale-95 text-sm font-medium flex items-center">
               <span v-if="loading">Saving...</span>
               <span v-else>Save</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const pageSeos = ref([])
const loading = ref(false)
const isModalOpen = ref(false)
const isEditing = ref(false)
const form = ref({
  id: null,
  url_path: '',
  schema_tag: '',
  raw_tags: ''
})
const fetchPageSeos = async () => {
  loading.value = true
  try {
    const response = await axios.get('/admin/page-seos-data')
    
    // Safety check to prevent infinite loop crash if API returns HTML (e.g. 500 error page)
    if (Array.isArray(response.data)) {
        pageSeos.value = response.data
    } else if (response.data && Array.isArray(response.data.data)) {
        pageSeos.value = response.data.data
    } else if (typeof response.data === 'string') {
        try {
            const parsed = JSON.parse(response.data)
            pageSeos.value = Array.isArray(parsed) ? parsed : (parsed.data || [])
        } catch(e) {
            console.error('Failed to parse API string response:', e)
            alert('Server returned invalid HTML/String data. Is the route failing?')
        }
    } else {
        pageSeos.value = []
        console.error('API did not return an array. See payload:', response.data)
        alert('Server returned invalid data format: ' + typeof response.data)
    }
  } catch (error) {
    console.error('Error fetching data:', error)
    alert('Failed to fetch Page SEO data')
  } finally {
    loading.value = false
  }
}

const openAddModal = () => {
  isEditing.value = false
  form.value = { id: null, url_path: '', schema_tag: '', raw_tags: '' }
  isModalOpen.value = true
}

const openEditModal = (item) => {
  isEditing.value = true
  form.value = { ...item }
  isModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
}

const submitForm = async () => {
  loading.value = true
  try {
    let payload = { ...form.value }

    if (isEditing.value) {
      await axios.put(`/admin/page-seos-data/${payload.id}`, payload)
      alert('Page SEO updated successfully')
    } else {
      await axios.post('/admin/page-seos-data', payload)
      alert('Page SEO created successfully')
    }
    closeModal()
    fetchPageSeos()
  } catch (error) {
    console.error('Submission error:', error)
    if (error.response?.data?.errors) {
      const messages = Object.values(error.response.data.errors).flat().join('\n')
      alert(messages)
    } else {
      alert('An error occurred during submission')
    }
  } finally {
    loading.value = false
  }
}

const deletePageSeo = async (id) => {
  const result = confirm("Are you sure? You won't be able to revert this!")

  if (result) {
    loading.value = true
    try {
      await axios.delete(`/admin/page-seos-data/${id}`)
      alert('Page SEO has been deleted.')
      fetchPageSeos()
    } catch (error) {
      console.error('Deletion error:', error)
      alert('Failed to delete Page SEO')
    } finally {
      loading.value = false
    }
  }
}

const formatDate = (dateValue) => {
  if (!dateValue) return 'N/A'
  const date = new Date(dateValue)
  return new Intl.DateTimeFormat('en-GB', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  }).format(date)
}

onMounted(() => {
  fetchPageSeos()
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
