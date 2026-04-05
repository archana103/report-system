<script setup>
import { Ckeditor } from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import BaseFileInput from '../../components/BaseFileInput.vue';
import { formData, errors, isSubmitting, successMessage, resetForm } from './variable';
import { storeReportCategory } from './api';

const editor = ClassicEditor;
const editorConfig = {
    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo' ]
};

const submitForm = async () => {
    isSubmitting.value = true;
    for (let key in errors) delete errors[key];
    successMessage.value = '';

    try {
        await storeReportCategory(formData);
        successMessage.value = 'Report Category saved successfully!';
        resetForm();
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

const cancelForm = () => {
    resetForm();
    successMessage.value = '';
};
</script>

<template>
  <div class="animate-in fade-in duration-300">
    <h2 class="text-xl text-gray-200 font-medium mb-6">Add Report Category</h2>
    
    <div v-if="successMessage" class="mb-4 p-4 rounded-xl text-sm font-medium" :class="successMessage.includes('successfully') ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20'">
       {{ successMessage }}
    </div>

    <form @submit.prevent="submitForm" class="space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Row 1 -->
        <div>
          <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Report Category Name</label>
          <input v-model="formData.name" type="text" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all" />
          <p v-if="errors.name" class="text-red-400 text-xs mt-1 ml-1">{{ errors.name[0] }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Status</label>
          <div class="relative">
            <select v-model="formData.status" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl pl-4 pr-10 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all appearance-none cursor-pointer">
              <option value="">---</option>
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
              <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
            </div>
          </div>
          <p v-if="errors.status" class="text-red-400 text-xs mt-1 ml-1">{{ errors.status[0] }}</p>
        </div>

        <!-- Row 2 -->
        <div>
          <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Main Heading</label>
          <input v-model="formData.main_heading" type="text" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all" />
          <p v-if="errors.main_heading" class="text-red-400 text-xs mt-1 ml-1">{{ errors.main_heading[0] }}</p>
        </div>
        <div>
          <BaseFileInput id="categoryImage" label="Category Image" v-model="formData.category_image" />
          <p class="text-[11px] text-gray-500 mt-1.5 ml-1">Allowed formats: JPG, PNG, GIF, SVG</p>
          <p v-if="errors.category_image" class="text-red-400 text-xs mt-1 ml-1">{{ errors.category_image[0] }}</p>
        </div>

        <!-- Row 3 -->
        <div>
          <BaseFileInput id="categoryIcon" label="Category Icon (JPG, PNG, GIF, SVG - 20x20px)" v-model="formData.category_icon" />
          <p class="text-[11px] text-gray-500 mt-1.5 ml-1">Please upload an image file with dimensions exactly 20x20px</p>
          <p v-if="errors.category_icon" class="text-red-400 text-xs mt-1 ml-1">{{ errors.category_icon[0] }}</p>
        </div>
        <div class="hidden md:block"></div>
      </div>

      <!-- Row 4: CKEditor -->
      <div>
        <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Main Subheading</label>
        <div class="rounded-xl overflow-hidden shadow-sm border border-gray-700 focus-within:ring-2 focus-within:ring-teal-500/50 focus-within:border-teal-500/50 transition-all ck-editor-custom">
          <Ckeditor :editor="editor" v-model="formData.main_subheading" :config="editorConfig"></Ckeditor>
        </div>
        <p v-if="errors.main_subheading" class="text-red-400 text-xs mt-1 ml-1">{{ errors.main_subheading[0] }}</p>
      </div>

      <div class="flex items-center pt-4 border-t border-gray-700/50">
        <button type="submit" :disabled="isSubmitting" class="bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-400 hover:to-emerald-500 text-white font-medium py-2.5 px-6 rounded-xl shadow-lg shadow-teal-500/20 transition-all active:scale-95 flex items-center justify-center disabled:opacity-50">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
          </svg>
          <span v-if="isSubmitting">Saving...</span>
          <span v-else>Save Category</span>
        </button>
        <button type="button" @click="cancelForm" class="ml-4 text-gray-400 hover:text-gray-200 font-medium py-2.5 px-6 rounded-xl hover:bg-gray-800 transition-all">
          Cancel
        </button>
      </div>
    </form>
  </div>
</template>
