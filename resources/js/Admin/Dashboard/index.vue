<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const stats = ref({
  categories: 0,
  reports: 0,
  blogs: 0,
  pressReleases: 0
})

const usernameForm = ref({ name: '', email: '' })
const isUpdatingUsername = ref(false)
const usernameMessage = ref('')
const authError = ref('')

const sessions = ref([])
const isLoadingSessions = ref(false)

const user = ref(JSON.parse(localStorage.getItem('user') || '{}'))

onMounted(() => {
  usernameForm.value.name = user.value.name || ''
  usernameForm.value.email = user.value.email || ''
  fetchStats()
  fetchSessions()
})

const fetchStats = async () => {
  try {
    const { data } = await axios.get('/admin/dashboard-stats')
    stats.value = data
  } catch (error) {
    if (error.response && error.response.status === 401) {
      authError.value = error.response.data.error || 'Unauthenticated. Please log out and log back in to activate your session.'
    }
    console.error('Failed to fetch stats', error)
  }
}

const updateUsername = async () => {
  isUpdatingUsername.value = true
  usernameMessage.value = ''
  try {
    const { data } = await axios.post('/admin/update-username', usernameForm.value)
    usernameMessage.value = data.message
    
    // Update local storage
    if (data.user) {
      const storedUser = JSON.parse(localStorage.getItem('user') || '{}')
      storedUser.name = data.user.name
      storedUser.email = data.user.email
      localStorage.setItem('user', JSON.stringify(storedUser))
      user.value = storedUser
    }
    
    setTimeout(() => { usernameMessage.value = '' }, 3000)
  } catch (error) {
    usernameMessage.value = 'Failed to update profile'
  } finally {
    isUpdatingUsername.value = false
  }
}

const fetchSessions = async () => {
  isLoadingSessions.value = true
  try {
    const { data } = await axios.get('/admin/sessions')
    sessions.value = data.sessions || []
  } catch (error) {
    console.error('Failed to fetch sessions', error)
  } finally {
    isLoadingSessions.value = false
  }
}

const logoutSession = async (id) => {
  if (!confirm('Are you sure you want to log out this session?')) return
  try {
    await axios.delete(`/admin/sessions/${id}`)
    fetchSessions()
  } catch (error) {
    console.error('Failed to log out session', error)
  }
}

const logoutOtherSessions = async () => {
  if (!confirm('Are you sure you want to log out all other active sessions across all devices?')) return
  try {
    await axios.delete('/admin/sessions')
    fetchSessions()
  } catch (error) {
    console.error('Failed to log out other sessions', error)
  }
}
</script>

<template>
  <div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-y-auto">
    <!-- Decorative Blob -->
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-rose-500/20 rounded-full blur-3xl pointer-events-none"></div>
    
    <div class="relative z-10 max-w-5xl mx-auto space-y-8">
      
      <!-- Header -->
      <h1 class="text-4xl font-medium pb-2 bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-rose-500 tracking-tight drop-shadow-sm">
        Dashboard Overview
      </h1>

      <div v-if="authError" class="bg-rose-500/10 border border-rose-500/30 text-rose-400 p-4 rounded-xl flex items-center gap-3">
        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        <span class="font-medium">{{ authError }}</span>
      </div>
      
      <!-- Stats Row -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gray-900/50 rounded-2xl p-6 border border-gray-800 shadow-inner flex flex-col justify-center">
          <h3 class="text-gray-400 font-medium mb-2">Total Categories</h3>
          <p class="text-4xl font-medium text-white">{{ stats.categories }}</p>
        </div>
        <div class="bg-gray-900/50 rounded-2xl p-6 border border-gray-800 shadow-inner flex flex-col justify-center">
          <h3 class="text-gray-400 font-medium mb-2">Active Reports</h3>
          <p class="text-4xl font-medium text-white">{{ stats.reports }}</p>
        </div>
        <div class="bg-gray-900/50 rounded-2xl p-6 border border-gray-800 shadow-inner flex flex-col justify-center">
          <h3 class="text-gray-400 font-medium mb-2">Blogs</h3>
          <p class="text-4xl font-medium text-white">{{ stats.blogs }}</p>
        </div>
        <div class="bg-gray-900/50 rounded-2xl p-6 border border-gray-800 shadow-inner flex flex-col justify-center">
          <h3 class="text-gray-400 font-medium mb-2">Press Releases</h3>
          <p class="text-4xl font-medium text-white">{{ stats.pressReleases }}</p>
        </div>
      </div>

      <!-- Update Profile Section -->
      <div class="bg-gray-900/50 rounded-2xl p-6 border border-gray-800 shadow-inner">
        <h2 class="text-xl font-medium text-white mb-4">Profile Information</h2>
        <p class="text-sm text-gray-400 mb-6">Update your account's profile information.</p>
        
        <form @submit.prevent="updateUsername" class="max-w-md space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Name</label>
            <input 
              v-model="usernameForm.name" 
              type="text" 
              required
              class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition-colors"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Email</label>
            <input 
              v-model="usernameForm.email" 
              type="email" 
              required
              class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition-colors"
            />
          </div>
          
          <div class="flex items-center gap-4">
            <button 
              type="submit" 
              :disabled="isUpdatingUsername"
              class="bg-gray-800 hover:bg-gray-700 text-white font-medium py-2 px-6 rounded-lg border border-gray-700 transition-colors"
            >
              {{ isUpdatingUsername ? 'Saving...' : 'Save' }}
            </button>
            <span v-if="usernameMessage" class="text-sm text-emerald-400 transition-opacity">{{ usernameMessage }}</span>
          </div>
        </form>
      </div>

      <!-- Login Sessions Section -->
      <div class="bg-gray-900/50 rounded-2xl p-6 border border-gray-800 shadow-inner">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
          <div>
            <h2 class="text-xl font-medium text-white mb-1">Login Sessions</h2>
            <p class="text-sm text-gray-400">Places where you're logged into admin.</p>
          </div>
          <button 
            @click="logoutOtherSessions"
            class="bg-rose-500/10 hover:bg-rose-500/20 text-rose-500 border border-rose-500/30 font-medium py-2 px-4 rounded-lg transition-colors whitespace-nowrap text-sm"
          >
            Sign out all other sessions
          </button>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-sm text-gray-400">
            <thead class="text-xs text-gray-500 uppercase bg-gray-800/50 border-b border-gray-700">
              <tr>
                <th scope="col" class="px-4 py-3">Device & Browser</th>
                <th scope="col" class="px-4 py-3">IP Address</th>
                <th scope="col" class="px-4 py-3">Last Active</th>
                <th scope="col" class="px-4 py-3 text-right">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="isLoadingSessions">
                <td colspan="4" class="px-4 py-6 text-center text-gray-500">Loading sessions...</td>
              </tr>
              <tr v-else-if="sessions.length === 0">
                <td colspan="4" class="px-4 py-6 text-center text-gray-500">No active sessions found.</td>
              </tr>
              <tr 
                v-for="session in sessions" 
                :key="session.id"
                class="border-b border-gray-800 last:border-0 hover:bg-gray-800/20 transition-colors"
              >
                <td class="px-4 py-4 font-medium text-gray-300">
                  <div class="flex items-center gap-2">
                    <svg v-if="session.os === 'macOS' || session.os === 'Windows' || session.os === 'Linux'" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <svg v-else class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    <span>{{ session.os }} - {{ session.browser }}</span>
                  </div>
                </td>
                <td class="px-4 py-4">{{ session.ip_address }}</td>
                <td class="px-4 py-4">
                  <span v-if="session.is_current_device" class="text-emerald-400 font-medium">This device (Current Session)</span>
                  <span v-else>{{ session.last_active }}</span>
                </td>
                <td class="px-4 py-4 text-right">
                  <button 
                    v-if="!session.is_current_device"
                    @click="logoutSession(session.id)"
                    class="text-gray-400 hover:text-rose-400 transition-colors"
                    title="Sign out this session"
                  >
                    <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</template>
