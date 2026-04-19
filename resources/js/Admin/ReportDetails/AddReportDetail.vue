<script setup>
import { ref, watch, onMounted } from 'vue';
import { formData, errors, isSubmitting, successMessage, resetForm, setFormData } from './variable';
import { storeReportDetail, updateReportDetail, getReportListsDropdown } from './api';
import BaseFileInput from '../../components/BaseFileInput.vue';

// CKEditor
import CkEditor4 from '../../components/CkEditor4.vue';

const props = defineProps({
  report: { type: Object, default: null },
  mode: { type: String, default: 'add' }
});

const emit = defineEmits(['saved']);

const editorConfig = {
    extraPlugins: 'colorbutton,font,justify'
};

const reportLists = ref([]);

const loadReportLists = async () => {
  try {
    reportLists.value = await getReportListsDropdown();
  } catch (e) {
    console.error('Failed to load report lists', e);
  }
};

watch(() => props.report, (newVal) => {
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
    if (props.mode === 'edit' && props.report) {
      await updateReportDetail(props.report.id, formData);
      successMessage.value = 'Report Detail updated successfully!';
      emit('saved');
    } else {
      await storeReportDetail(formData);
      successMessage.value = 'Report Detail saved successfully!';
      resetForm();
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

const cancelForm = () => {
  resetForm();
  emit('saved');
};

// Dynamic Array Handlers
const addHreflang = () => formData.hreflang_tags.push('');
const removeHreflang = (index) => formData.hreflang_tags.splice(index, 1);

const addCustomSchema = () => formData.custom_schema_tags.push('');
const removeCustomSchema = (index) => formData.custom_schema_tags.splice(index, 1);

const addFaq = () => formData.faqs.push({ question: '', answer: '' });
const removeFaq = (index) => formData.faqs.splice(index, 1);

onMounted(() => {
  loadReportLists();
});
</script>

<template>
  <div class="animate-in fade-in duration-300">
    <h2 class="text-xl text-gray-200 font-medium mb-6">
      {{ mode === 'edit' ? 'Edit Report Detail' : 'Add Report Details' }}
    </h2>

    <div
      v-if="successMessage"
      class="mb-4 p-4 rounded-xl text-sm font-medium"
      :class="successMessage.includes('successfully')
        ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20'
        : 'bg-red-500/10 text-red-400 border border-red-500/20'"
    >
      {{ successMessage }}
    </div>

    <form @submit.prevent="submitForm" class="space-y-8">
      
      <!-- Core Fields (Common to both or specialized for Add) -->
      <div v-if="mode === 'add'" class="space-y-6">
        <!-- Row 1: Select Report & Title -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Select Report</label>
            <select v-model="formData.report_list_id" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl pl-4 pr-10 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50">
              <option value="" disabled>---</option>
              <option v-for="list in reportLists" :key="list.id" :value="list.id">{{ list.name }}</option>
            </select>
            <p v-if="errors.report_list_id" class="text-red-400 text-xs mt-1 ml-1">{{ errors.report_list_id[0] }}</p>
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Report Details Title</label>
            <textarea v-model="formData.title" rows="2" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50"></textarea>
          </div>
        </div>

        <!-- Row 2: Description & Category List Download -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Report Details Description</label>
            <textarea v-model="formData.description" rows="3" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50"></textarea>
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Report Category List Download</label>
            <textarea v-model="formData.category_list_download" rows="3" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50"></textarea>
          </div>
        </div>

        <!-- Row 3: License Costs -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div>
            <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Single User License Cost</label>
            <input v-model="formData.single_user_license_cost" type="number" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Team User License Cost</label>
            <input v-model="formData.team_user_license_cost" type="number" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Enterprise User License Cost</label>
            <input v-model="formData.enterprise_user_license_cost" type="number" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
          </div>
        </div>

        <!-- Row 4: Download Text & Image -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Report Details Download Text</label>
            <textarea v-model="formData.download_text" rows="3" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50"></textarea>
          </div>
          <div>
            <BaseFileInput id="newReportImageAdd" label="Report Details Image" v-model="formData.image" />
            <p class="text-[11px] text-gray-500 mt-1.5 ml-1">Supported formats: JPG, JPEG, PNG, GIF (Max size: 2MB)</p>
          </div>
        </div>

        <!-- Row 5: Status -->
        <div class="w-full md:w-1/2">
          <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Status</label>
          <select v-model="formData.status" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50">
            <option value="" disabled>---</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
          </select>
        </div>
      </div>

      <!-- Edit Mode Full Form -->
      <div v-if="mode === 'edit'" class="space-y-8">
        <!-- General Information -->
        <div class="space-y-6">
          <h3 class="text-lg font-medium text-white border-b border-gray-700/50 pb-2">General Information</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
              <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Select Report</label>
              <select v-model="formData.report_list_id" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl pl-4 pr-10 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50">
                <option value="" disabled>---</option>
                <option v-for="list in reportLists" :key="list.id" :value="list.id">{{ list.name }}</option>
              </select>
              <p v-if="errors.report_list_id" class="text-red-400 text-xs mt-1 ml-1">{{ errors.report_list_id[0] }}</p>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Slug URL</label>
              <input v-model="formData.slug_url" type="text" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
              <p v-if="errors.slug_url" class="text-red-400 text-xs mt-1 ml-1">{{ errors.slug_url[0] }}</p>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Breadcrumb Title</label>
              <input v-model="formData.breadcrumb_title" type="text" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Page Main Title</label>
              <input v-model="formData.page_main_title" type="text" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Add Report Id:</label>
              <input v-model="formData.report_sku" type="text" placeholder="e.g. SE2148" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
            </div>

            <div>
              <BaseFileInput id="newReportImage" label="Upload New Image" v-model="formData.image" />
              <p class="text-[11px] text-gray-500 mt-1.5 ml-1">Supported formats: JPG, JPEG, PNG, GIF (Max size: 2MB)</p>
            </div>
          </div>
        </div>

        <!-- Core Details -->
        <div class="space-y-6">
          <h3 class="text-lg font-medium text-white border-b border-gray-700/50 pb-2">Report Content</h3>
          
          <div>
            <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Section 1. About This Report</label>
               <CkEditor4 id="editor-description" v-model="formData.description" :config="editorConfig" />
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Manage Table of Contents</label>
               <CkEditor4 id="editor-toc" v-model="formData.table_of_contents" :config="editorConfig" />
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
             <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Meta Title</label>
                <input v-model="formData.meta_title" type="text" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
             </div>
             <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Meta Description</label>
                <textarea v-model="formData.meta_description" rows="2" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50"></textarea>
             </div>
             <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Meta Keywords</label>
                <input v-model="formData.meta_keywords" type="text" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
             </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
             <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Canonical Tag</label>
                <input v-model="formData.canonical_tag" type="text" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
             </div>
             <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Meta Robots Tag</label>
                <input v-model="formData.meta_robots" type="text" placeholder="index, follow" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
             </div>
          </div>
        </div>

        <!-- Hreflang Tags -->
        <div class="space-y-4">
          <div class="flex justify-between items-center border-b border-gray-700/50 pb-2">
             <h3 class="text-lg font-medium text-white">Hreflang Tags</h3>
             <button type="button" @click="addHreflang" class="bg-emerald-600 hover:bg-emerald-500 text-white px-3 py-1 text-sm rounded-lg flex items-center transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg> Add
             </button>
          </div>
          <div v-for="(tag, index) in formData.hreflang_tags" :key="'href'+index" class="flex items-center space-x-3">
             <input v-model="formData.hreflang_tags[index]" type="text" placeholder="Enter hreflang tag" class="flex-grow bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
             <button type="button" @click="removeHreflang(index)" class="bg-red-500/20 text-red-400 hover:bg-red-500/30 p-2 rounded-lg transition-colors" title="Remove">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
             </button>
          </div>
          <div v-if="formData.hreflang_tags.length === 0" class="text-gray-500 text-sm italic">No tags added.</div>
        </div>

        <!-- Open Graph & Twitter Cards -->
        <div class="space-y-6">
          <h3 class="text-lg font-medium text-white border-b border-gray-700/50 pb-2">Open Graph Meta Tags</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
             <div v-for="index in 6" :key="'og'+index">
                <label class="block text-xs font-semibold text-gray-400 mb-1 ml-1">Open Graph Meta Tag {{ ['One','Two','Three','Four','Five','Six'][index-1] }}</label>
                <input v-model="formData.open_graph_tags[index-1]" type="text" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200" />
             </div>
          </div>

          <h3 class="text-lg font-medium text-white border-b border-gray-700/50 pb-2 mt-6">Twitter Card Meta Tags</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
             <div v-for="index in 6" :key="'tw'+index">
                <label class="block text-xs font-semibold text-gray-400 mb-1 ml-1">Twitter Card Meta Tag {{ ['One','Two','Three','Four','Five','Six'][index-1] }}</label>
                <input v-model="formData.twitter_card_tags[index-1]" type="text" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200" />
             </div>
          </div>
        </div>

        <!-- Schema Tags -->
        <div class="space-y-6 border-b border-gray-700/50 pb-6">
          <div>
             <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Schema tag</label>
             <textarea v-model="formData.schema_tag" rows="3" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50"></textarea>
          </div>
          <div>
             <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Schema tag 2</label>
             <textarea v-model="formData.schema_tag_2" rows="3" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50"></textarea>
          </div>

          <h3 class="text-lg font-medium text-white pt-4">Enter Schema Tags</h3>
          <div v-for="(tag, index) in formData.custom_schema_tags" :key="'schema'+index" class="bg-gray-800/40 p-4 rounded-xl border border-gray-700 mb-4 relative">
             <textarea v-model="formData.custom_schema_tags[index]" rows="3" placeholder="Enter Schema Tag" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-200 mb-3"></textarea>
             <button type="button" @click="removeCustomSchema(index)" class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-4 py-1.5 text-sm rounded-lg transition-colors inline-block">Remove</button>
          </div>
          <button type="button" @click="addCustomSchema" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 text-sm rounded-lg transition-colors">Add Schema Tag</button>
        </div>

        <!-- FAQs -->
        <div class="space-y-4">
          <h3 class="text-lg font-medium text-white">Frequently Asked Questions</h3>
          <div v-for="(faq, index) in formData.faqs" :key="'faq'+index" class="bg-gray-800/40 p-4 rounded-xl border border-gray-700 mb-4 relative grid grid-cols-1 gap-4">
             <div>
                <label class="block text-xs font-semibold text-gray-400 mb-1 ml-1">Question</label>
                <input v-model="faq.question" type="text" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200" />
             </div>
             <div>
                <label class="block text-xs font-semibold text-gray-400 mb-1 ml-1">Answer</label>
                <textarea v-model="faq.answer" rows="2" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200"></textarea>
             </div>
             <button type="button" @click="removeFaq(index)" class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-4 py-1.5 text-sm rounded-lg transition-colors justify-self-start">Remove FAQ</button>
          </div>
          <button type="button" @click="addFaq" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 text-sm rounded-lg transition-colors">Add FAQ</button>
        </div>

        <!-- Extended Details (Old Fields) -->
        <div class="space-y-6 pt-6 border-t border-gray-700/50">
          <h3 class="text-lg font-medium text-white pb-2">License & Downloads</h3>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
             <div>
               <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Report Details Title</label>
               <textarea v-model="formData.title" rows="2" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50"></textarea>
             </div>
             <div>
               <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Report Category List Download</label>
               <textarea v-model="formData.category_list_download" rows="2" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50"></textarea>
             </div>
             
             <div>
               <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Report Details Download Text</label>
               <textarea v-model="formData.download_text" rows="2" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50"></textarea>
             </div>
             
             <div>
               <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Status</label>
               <select v-model="formData.status" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50">
                 <option value="Active">Active</option>
                 <option value="Inactive">Inactive</option>
               </select>
             </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
              <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Single User License Cost</label>
              <input v-model="formData.single_user_license_cost" type="number" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Team User License Cost</label>
              <input v-model="formData.team_user_license_cost" type="number" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Enterprise User License Cost</label>
              <input v-model="formData.enterprise_user_license_cost" type="number" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
            </div>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="flex items-center pt-6 border-t border-gray-700/50">
        <button
          type="submit"
          :disabled="isSubmitting"
          class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-400 hover:to-indigo-500 text-white font-medium py-3 px-8 rounded-xl shadow-lg shadow-blue-500/20 transition-all active:scale-95 flex items-center justify-center disabled:opacity-50"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
          </svg>
          <span v-if="isSubmitting">Saving...</span>
          <span v-else>{{ mode === 'edit' ? 'Update Details' : 'Add' }}</span>
        </button>
        <button
          type="button"
          @click="cancelForm"
          class="ml-4 text-gray-400 hover:text-gray-200 font-medium py-3 px-8 rounded-xl hover:bg-gray-800 border border-transparent hover:border-gray-700 transition-all"
        >
          Close
        </button>
      </div>
    </form>
  </div>
</template>


