<template>
  <div class="w-full">
    <div class="bg-gray-800/60 backdrop-blur-md rounded-2xl border border-gray-700/50 shadow-xl overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-700/50 bg-gray-900/40">
        <h2 class="text-xl font-semibold text-gray-100">
          {{ mode === 'edit' ? 'Edit Press Release' : 'Add Press Release' }}
        </h2>
      </div>

      <form @submit.prevent="handleSubmit" class="p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Title -->
          <div class="space-y-1">
            <label class="block text-sm font-medium text-gray-300">Title <span class="text-rose-500">*</span></label>
            <input 
              v-model="form.title" 
              type="text" 
              required
              class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-2.5 text-gray-200 focus:outline-none focus:ring-2 focus:ring-fuchsia-500/50 focus:border-fuchsia-500/50 transition-all"
              placeholder="Enter title"
            />
          </div>

          <!-- Description -->
          <div class="space-y-1 md:row-span-2">
            <label class="block text-sm font-medium text-gray-300">Description <span class="text-rose-500">*</span></label>
            <textarea 
              v-model="form.description" 
              required
              rows="6"
              class="w-full h-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-2.5 text-gray-200 focus:outline-none focus:ring-2 focus:ring-fuchsia-500/50 focus:border-fuchsia-500/50 transition-all resize-none"
              placeholder="Enter description"
            ></textarea>
          </div>

          <!-- URL -->
          <div class="space-y-1">
            <label class="block text-sm font-medium text-gray-300">URL <span class="text-rose-500">*</span></label>
            <input 
              v-model="form.url" 
              type="text" 
              required
              class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-2.5 text-gray-200 focus:outline-none focus:ring-2 focus:ring-fuchsia-500/50 focus:border-fuchsia-500/50 transition-all"
              placeholder="Enter URL slug"
            />
          </div>

          <!-- Status -->
          <div class="space-y-1">
            <label class="block text-sm font-medium text-gray-300">Status <span class="text-rose-500">*</span></label>
            <div class="relative">
              <select 
                v-model="form.status" 
                required
                class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-2.5 text-gray-200 focus:outline-none focus:ring-2 focus:ring-fuchsia-500/50 focus:border-fuchsia-500/50 transition-all appearance-none"
              >
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
              </div>
            </div>
          </div>

          <!-- Main Image -->
          <div class="space-y-1">
            <label class="block text-sm font-medium text-gray-300">Main Image</label>
            <div class="flex items-center space-x-4">
              <label class="cursor-pointer bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded-lg text-sm font-medium text-gray-200 transition-colors border border-gray-600">
                <span>Choose File</span>
                <input type="file" class="hidden" accept="image/*" @change="(e) => handleFileChange(e, 'main_image')" />
              </label>
              <span class="text-sm text-gray-400 truncate flex-1">
                {{ form.main_image?.name || 'No file chosen' }}
              </span>
            </div>
            
            <!-- Existing Image Preview -->
            <div v-if="mode === 'edit' && release?.main_image && !form.main_image" class="mt-3">
              <p class="text-xs text-gray-500 mb-1">Current Image:</p>
              <div class="w-24 h-16 rounded overflow-hidden border border-gray-700 bg-gray-900">
                <img :src="release.main_image" class="object-cover w-full h-full" />
              </div>
            </div>
          </div>

          <!-- Thumbnail Image -->
          <div class="space-y-1">
            <label class="block text-sm font-medium text-gray-300">Thumbnail Image</label>
            <div class="flex items-center space-x-4">
              <label class="cursor-pointer bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded-lg text-sm font-medium text-gray-200 transition-colors border border-gray-600">
                <span>Choose File</span>
                <input type="file" class="hidden" accept="image/*" @change="(e) => handleFileChange(e, 'thumbnail_image')" />
              </label>
              <span class="text-sm text-gray-400 truncate flex-1">
                {{ form.thumbnail_image?.name || 'No file chosen' }}
              </span>
            </div>

            <!-- Existing Thumbnail Preview -->
            <div v-if="mode === 'edit' && release?.thumbnail_image && !form.thumbnail_image" class="mt-3">
              <p class="text-xs text-gray-500 mb-1">Current Thumbnail:</p>
              <div class="w-24 h-16 rounded overflow-hidden border border-gray-700 bg-gray-900">
                <img :src="release.thumbnail_image" class="object-cover w-full h-full" />
              </div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end space-x-4 px-6 py-4 bg-gray-900/30 border-t border-gray-700/50">
          <div v-if="successMessage || errorMessage" class="mr-auto text-sm font-medium px-4 py-2 rounded-xl" :class="successMessage ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20'">
            {{ successMessage || errorMessage }}
          </div>
          <button 
            type="button" 
            @click="$emit('saved')"
            class="px-5 py-2.5 text-sm font-medium text-gray-400 hover:text-gray-200 hover:bg-gray-800 rounded-xl transition-colors"
          >
            Cancel
          </button>
          <button 
            type="submit" 
            :disabled="loading"
            class="px-6 py-2.5 text-sm font-medium text-white bg-fuchsia-600 hover:bg-fuchsia-500 rounded-xl shadow-lg shadow-fuchsia-500/20 transition-all focus:outline-none focus:ring-2 focus:ring-fuchsia-500/50 disabled:opacity-50 disabled:cursor-not-allowed flex items-center"
          >
            <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ mode === 'edit' ? 'Update' : 'Add' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { storePressRelease, updatePressRelease } from './api.js'

const props = defineProps({
  mode: { type: String, default: 'add' },
  release: { type: Object, default: null }
})

const emit = defineEmits(['saved'])

const loading = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

const form = ref({
  title: '',
  description: '',
  url: '',
  status: 'Active',
  main_image: null,
  thumbnail_image: null,
})

const handleFileChange = (e, field) => {
  const file = e.target.files[0]
  if (file) {
    form.value[field] = file
  }
}

const handleSubmit = async () => {
  loading.value = true
  successMessage.value = ''
  errorMessage.value = ''
  
  try {
    const formData = new FormData()
    formData.append('title', form.value.title)
    formData.append('description', form.value.description)
    formData.append('url', form.value.url)
    formData.append('status', form.value.status)
    
    if (form.value.main_image) {
      formData.append('main_image', form.value.main_image)
    }
    if (form.value.thumbnail_image) {
      formData.append('thumbnail_image', form.value.thumbnail_image)
    }

    if (props.mode === 'edit') {
      await updatePressRelease(props.release.id, formData)
    } else {
      await storePressRelease(formData)
    }
    
    successMessage.value = props.mode === 'edit' ? 'Updated successfully!' : 'Added successfully!'
    setTimeout(() => {
      emit('saved')
    }, 1000)
  } catch (error) {
    console.error('Error saving press release:', error)
    errorMessage.value = error.response?.data?.message || 'An error occurred while saving.'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  if (props.mode === 'edit' && props.release) {
    form.value.title = props.release.title || ''
    form.value.description = props.release.description || ''
    form.value.url = props.release.url || ''
    form.value.status = props.release.status || 'Active'
    // Don't set file objects for images, keep them null unless new file chosen
  }
})
</script>
