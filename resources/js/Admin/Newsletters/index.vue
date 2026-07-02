<template>
  <div class="min-h-[500px] bg-gray-800/40 rounded-3xl p-6 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-hidden flex flex-col">
    <!-- Decorative Blob -->
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="flex justify-between items-center mb-6 relative z-10">
      <h2 class="text-3xl font-medium pb-1 bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-purple-500 tracking-tight drop-shadow-sm">Newsletter Subscribers</h2>
    </div>

    <div class="bg-gray-900/50 rounded-2xl border border-gray-800 relative z-10 overflow-hidden">
      <div v-if="loading" class="p-8 text-center text-gray-400">
        Loading subscribers...
      </div>

      <div v-else-if="newsletters.length === 0" class="p-8 text-center text-gray-400">
        No newsletter subscribers found.
      </div>

      <div v-else class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700/50">
          <thead class="bg-gray-800/50">
            <tr>
              <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Email Address</th>
              <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Subscribed On</th>
              <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-700/50 group">
            <tr v-for="subscriber in newsletters" :key="subscriber.id" class="transition-colors hover:bg-gray-800/60 duration-200">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-200">
                {{ subscriber.email }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                {{ formatDate(subscriber.created_at) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <button @click="deleteSubscriber(subscriber.id)" class="px-3 py-1.5 rounded-lg text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 transition-colors focus:outline-none">
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const newsletters = ref([])
const loading = ref(true)

const fetchNewsletters = async () => {
  loading.value = true
  try {
    const response = await axios.get('/admin/newsletters-data')
    newsletters.value = response.data
  } catch (error) {
    console.error('Error fetching newsletters:', error)
    alert('Failed to fetch subscribers')
  } finally {
    loading.value = false
  }
}

const formatDate = (dateString) => {
  if (!dateString) return '-'
  const date = new Date(dateString)
  return new Intl.DateTimeFormat('en-US', {
    year: 'numeric', month: 'short', day: 'numeric',
    hour: '2-digit', minute: '2-digit'
  }).format(date)
}

const deleteSubscriber = async (id) => {
  if (confirm('Are you sure you want to delete this subscriber? You won\'t be able to revert this!')) {
    try {
      await axios.delete(`/admin/newsletters-data/${id}`)
      newsletters.value = newsletters.value.filter(n => n.id !== id)
      alert('Subscriber has been removed.')
    } catch (error) {
      console.error('Error deleting subscriber:', error)
      alert('Failed to delete subscriber.')
    }
  }
}

onMounted(() => {
  fetchNewsletters()
})
</script>
