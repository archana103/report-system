<script setup>
import { ref, watch } from 'vue';
import { formData, errors, isSubmitting, successMessage, resetForm, setFormData } from './variable';
import { storeBlog, updateBlog } from './api';
import BaseFileInput from '../../components/BaseFileInput.vue';

const props = defineProps({
  blog: { type: Object, default: null },
  mode: { type: String, default: 'add' }
});

const emit = defineEmits(['saved', 'cancel']);

watch(() => props.blog, (newVal) => {
  if (newVal && props.mode === 'edit') {
    setFormData(newVal);
  } else {
    resetForm();
  }
}, { immediate: true });

const submitForm = async () => {
  isSubmitting.value = true;
  for (let key in errors) delete errors[key];
  successMessage.value = '';

  try {
    if (props.mode === 'edit' && props.blog) {
      await updateBlog(props.blog.id, formData);
      successMessage.value = 'Blog updated successfully!';
      emit('saved');
    } else {
      await storeBlog(formData);
      successMessage.value = 'Blog added successfully!';
      resetForm();
      emit('saved');
    }
  } catch (error) {
    if (error.response && error.response.status === 422) {
      Object.assign(errors, error.response.data.errors);
    } else {
      successMessage.value = 'Failed to save! Please try again.';
    }
  } finally {
    isSubmitting.value = false;
  }
};
</script>

<template>
  <div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
    <div class="flex items-center justify-between mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600/10 to-transparent p-4 border-l-4 border-blue-500">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">
                {{ mode === 'edit' ? 'Edit Blog' : 'Add New Blog' }}
            </h2>
            <p class="text-gray-400 text-sm mt-1">Fill in the details below to {{ mode === 'edit' ? 'update the' : 'create a new' }} blog post.</p>
        </div>
        <div class="hidden md:block">
            <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center border border-blue-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
            </div>
        </div>
    </div>

    <div
      v-if="successMessage"
      class="mb-6 p-4 rounded-xl text-sm font-medium animate-in zoom-in-95 duration-300"
      :class="successMessage.includes('successfully')
        ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 shadow-[0_0_20px_rgba(16,185,129,0.1)]'
        : 'bg-red-500/10 text-red-400 border border-red-500/20'"
    >
      <div class="flex items-center">
        <svg v-if="successMessage.includes('successfully')" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
        {{ successMessage }}
      </div>
    </div>

    <form @submit.prevent="submitForm" class="space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 bg-gray-900/40 rounded-3xl border border-gray-800 shadow-xl">
        <!-- Left Side: Basic Info -->
        <div class="space-y-6">
          <div>
            <label class="block text-sm font-semibold text-gray-300 mb-2 ml-1">Blog Title</label>
            <input 
              v-model="formData.title" 
              type="text" 
              placeholder="Enter headline..."
              class="w-full bg-gray-800/50 border border-gray-700/50 rounded-xl px-5 py-3 text-sm text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all shadow-inner" 
            />
            <p v-if="errors.title" class="text-red-400 text-xs mt-2 ml-1 flex items-center"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" /></svg> {{ errors.title[0] }}</p>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-300 mb-2 ml-1 text-red-400">Author Name</label>
            <input 
              v-model="formData.author_name" 
              type="text" 
              placeholder="e.g. Sumit Ingle"
              class="w-full bg-gray-800/50 border border-gray-700/50 rounded-xl px-5 py-3 text-sm text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all border-red-500/50" 
            />
            <p v-if="errors.author_name" class="text-red-400 text-xs mt-2 ml-1 text-red-400">{{ errors.author_name[0] }}</p>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-300 mb-2 ml-1">URL (Slug)</label>
            <input 
              v-model="formData.url" 
              type="text" 
              placeholder="top-automotive-technologies..."
              class="w-full bg-gray-800/50 border border-gray-700/50 rounded-xl px-5 py-3 text-sm text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all" 
            />
          </div>
        </div>

        <!-- Right Side: Content & Media -->
        <div class="space-y-6">
          <div>
            <label class="block text-sm font-semibold text-gray-300 mb-2 ml-1">Blog Description</label>
            <textarea 
              v-model="formData.description" 
              rows="5" 
              placeholder="Write a brief overview..."
              class="w-full bg-gray-800/50 border border-gray-700/50 rounded-xl px-5 py-4 text-sm text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all min-h-[148px]"
            ></textarea>
          </div>

          <div>
            <BaseFileInput id="blogImage" label="Cover Image" v-model="formData.image" />
            <div v-if="mode === 'edit' && blog?.image && !formData.image" class="mt-4 p-2 bg-gray-800 rounded-lg border border-gray-700 w-fit">
              <p class="text-[10px] text-gray-500 mb-2 uppercase tracking-wider font-bold">Current Image</p>
              <img :src="'/storage/' + blog.image" class="h-20 w-32 object-cover rounded-md shadow-lg" />
            </div>
            <p class="text-[11px] text-gray-500 mt-2 ml-1">Recommended: JPG or PNG. Max 2MB.</p>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="flex items-center justify-end space-x-4">
        <button
          type="button"
          @click="$emit('cancel')"
          class="px-8 py-3 rounded-xl text-sm font-medium text-gray-400 hover:text-white hover:bg-white/5 transition-all border border-transparent hover:border-gray-700"
        >
          Cancel
        </button>
        <button
          type="submit"
          :disabled="isSubmitting"
          class="px-10 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 shadow-lg shadow-blue-500/20 transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed flex items-center"
        >
          <svg v-if="isSubmitting" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
          {{ mode === 'edit' ? 'Update Blog' : 'Add Blog' }}
        </button>
      </div>
    </form>
  </div>
</template>
