<template>
  <Transition name="modal">
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
      <div class="bg-gray-800 border border-gray-700 rounded-3xl shadow-2xl max-w-4xl w-full overflow-hidden animate-in zoom-in duration-200 flex flex-col max-h-[90vh]">
        <div class="px-8 py-6 border-b border-gray-700 flex justify-between items-center bg-gray-800/50">
          <h2 class="text-xl text-gray-200 font-medium">Edit Report Category</h2>
          <button @click="$emit('cancel')" class="text-gray-400 hover:text-gray-200 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <div class="flex-grow overflow-y-auto p-8 custom-scrollbar">
          <div v-if="successMessage" class="mb-6 p-4 rounded-xl text-sm font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
             {{ successMessage }}
          </div>

          <form @submit.prevent="submitForm" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Name -->
              <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Report Category Name</label>
                <input v-model="form.name" type="text" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all" />
                <p v-if="errors.name" class="text-red-400 text-xs mt-1 ml-1">{{ errors.name[0] }}</p>
              </div>

              <!-- Status -->
              <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Status</label>
                <div class="relative">
                  <select v-model="form.status" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl pl-4 pr-10 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all appearance-none cursor-pointer">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                  </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                  </div>
                </div>
                <p v-if="errors.status" class="text-red-400 text-xs mt-1 ml-1">{{ errors.status[0] }}</p>
              </div>

              <!-- Main Heading -->
              <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Main Heading</label>
                <input v-model="form.main_heading" type="text" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all" />
                <p v-if="errors.main_heading" class="text-red-400 text-xs mt-1 ml-1">{{ errors.main_heading[0] }}</p>
              </div>

              <!-- Category Image -->
              <div>
                <BaseFileInput id="editCategoryImage" label="Category Image" v-model="form.category_image" />
                <p v-if="category.category_image && !form.category_image" class="text-[10px] text-teal-500 mt-1 ml-1">Current image exists</p>
                <p v-if="errors.category_image" class="text-red-400 text-xs mt-1 ml-1">{{ errors.category_image[0] }}</p>
              </div>

              <!-- Category Icon -->
              <div>
                <BaseFileInput id="editCategoryIcon" label="Category Icon (20x20px)" v-model="form.category_icon" />
                <p v-if="category.category_icon && !form.category_icon" class="text-[10px] text-teal-500 mt-1 ml-1">Current icon exists</p>
                <p v-if="errors.category_icon" class="text-red-400 text-xs mt-1 ml-1">{{ errors.category_icon[0] }}</p>
              </div>
            </div>

            <!-- Main Subheading (CKEditor) -->
            <div>
              <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Main Subheading</label>
              <div class="rounded-xl overflow-hidden shadow-sm border border-gray-700 focus-within:ring-2 focus-within:ring-teal-500/50 focus-within:border-teal-500/50 transition-all ck-editor-custom">
                <CkEditor4 v-model="form.main_subheading" :config="editorConfig" />
              </div>
              <p v-if="errors.main_subheading" class="text-red-400 text-xs mt-1 ml-1">{{ errors.main_subheading[0] }}</p>
            </div>
          </form>
        </div>

        <div class="px-8 py-4 bg-gray-900/30 border-t border-gray-700 flex justify-end items-center">
          <button @click="$emit('cancel')" class="mr-4 text-gray-400 hover:text-gray-200 font-medium py-2 px-6 rounded-xl hover:bg-gray-700/50 transition-all text-sm">
            Cancel
          </button>
          <button @click="submitForm" :disabled="isSubmitting" class="bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-400 hover:to-emerald-500 text-white font-medium py-2 px-8 rounded-xl shadow-lg shadow-teal-500/20 transition-all active:scale-95 flex items-center justify-center disabled:opacity-50 text-sm">
            <span v-if="isSubmitting">Saving Changes...</span>
            <span v-else>Update Category</span>
          </button>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { reactive, ref, watch } from 'vue'
import CkEditor4 from '../../components/CkEditor4.vue'
import BaseFileInput from '../../components/BaseFileInput.vue'
import { updateReportCategory } from './api.js'

const props = defineProps({
  show: Boolean,
  category: { type: Object, default: () => ({}) }
})

const emit = defineEmits(['updated', 'cancel'])

const editorConfig = {
    extraPlugins: 'colorbutton,font,justify'
}

const form = reactive({
  name: '',
  status: '',
  main_heading: '',
  main_subheading: '',
  category_image: null,
  category_icon: null
})

const errors = reactive({})
const isSubmitting = ref(false)
const successMessage = ref('')

// Pre-fill form when category prop changes or modal opens
watch(() => props.category, (newVal) => {
  if (newVal && props.show) {
    form.name = newVal.name || ''
    form.status = newVal.status || 'Active'
    form.main_heading = newVal.main_heading || ''
    form.main_subheading = newVal.main_subheading || ''
    form.category_image = null
    form.category_icon = null
    
    // Clear errors
    Object.keys(errors).forEach(key => delete errors[key])
    successMessage.value = ''
  }
}, { immediate: true })

const submitForm = async () => {
  isSubmitting.value = true
  successMessage.value = ''
  Object.keys(errors).forEach(key => delete errors[key])

  try {
    const response = await updateReportCategory(props.category.id, form)
    successMessage.value = 'Report Category updated successfully!'
    setTimeout(() => {
      emit('updated')
    }, 1000)
  } catch (error) {
    if (error.response && error.response.status === 422) {
      Object.assign(errors, error.response.data.errors)
    } else {
      console.error('Error updating category:', error)
    }
  } finally {
    isSubmitting.value = false
  }
}
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.25s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: rgba(31, 41, 55, 0.5);
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: rgba(107, 114, 128, 0.5);
  border-radius: 10px;
}
</style>
