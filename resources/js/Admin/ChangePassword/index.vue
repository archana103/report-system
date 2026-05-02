<template>
  <div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-hidden flex flex-col">
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 flex-grow max-w-2xl mx-auto w-full">
      <h2 class="text-3xl font-medium pb-2 bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-purple-500 mb-6 tracking-tight drop-shadow-sm">
        Change Admin Password
      </h2>

      <div
        v-if="message"
        class="mb-6 p-4 rounded-xl text-sm font-medium"
        :class="isError 
          ? 'bg-rose-500/10 text-rose-400 border border-rose-500/20' 
          : 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20'"
      >
        {{ message }}
      </div>

      <form @submit.prevent="handleSubmit" class="bg-gray-900/40 rounded-2xl p-6 border border-gray-800 shadow-inner space-y-6">
        <div>
          <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">New Password <span class="text-rose-500">*</span></label>
          <div class="relative flex items-center">
            <input
              v-model="form.new_password"
              :type="showPassword ? 'text' : 'password'"
              required
              class="w-full bg-gray-800/80 border border-gray-700 rounded-xl pl-4 pr-11 py-3 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all"
              placeholder="Enter new password"
            />
            <button 
              type="button" 
              @click="showPassword = !showPassword"
              class="absolute right-4 text-gray-500 hover:text-gray-300 focus:outline-none"
            >
              <svg v-if="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
              <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            </button>
          </div>
          <p class="text-xs text-rose-400 mt-1 ml-1">Minimum 8 characters required</p>
        </div>

        <div>
          <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Confirm New Password <span class="text-rose-500">*</span></label>
          <div class="relative flex items-center">
            <input
              v-model="form.new_password_confirmation"
              :type="showPassword ? 'text' : 'password'"
              required
              class="w-full bg-gray-800/80 border border-gray-700 rounded-xl pl-4 pr-11 py-3 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all"
              placeholder="Confirm your new password"
            />
            <button 
              type="button" 
              @click="showPassword = !showPassword"
              class="absolute right-4 text-gray-500 hover:text-gray-300 focus:outline-none"
            >
              <svg v-if="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
              <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            </button>
          </div>
        </div>

        <div class="pt-2">
          <button
            type="submit"
            :disabled="loading"
            class="px-6 py-3 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl shadow-lg shadow-indigo-500/20 transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500/50 flex items-center justify-center disabled:opacity-50 min-w-[120px]"
          >
            <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Submit
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const form = ref({
  new_password: '',
  new_password_confirmation: '',
})

const loading = ref(false)
const showPassword = ref(false)
const message = ref('')
const isError = ref(false)

const handleSubmit = async () => {
  if (form.value.new_password !== form.value.new_password_confirmation) {
    message.value = 'Passwords do not match.'
    isError.value = true
    return
  }

  if (form.value.new_password.length < 8) {
    message.value = 'Password must be at least 8 characters long.'
    isError.value = true
    return
  }

  loading.value = true
  message.value = ''
  isError.value = false

  try {
    // We can get user ID from localStorage/auth user if stored
    const storedUser = localStorage.getItem('user') || sessionStorage.getItem('user')
    const userId = storedUser ? JSON.parse(storedUser).id : 1 // fallback to 1

    const payload = {
      user_id: userId,
      new_password: form.value.new_password,
      new_password_confirmation: form.value.new_password_confirmation
    }

    const response = await axios.post('/admin/change-password', payload)
    message.value = response.data.message || 'Password updated successfully!'
    isError.value = false

    // Clear form fields
    form.value.new_password = ''
    form.value.new_password_confirmation = ''
  } catch (error) {
    console.error('Error changing password:', error)
    message.value = error.response?.data?.message || 'An error occurred while changing password.'
    isError.value = true
  } finally {
    loading.value = false
  }
}
</script>
