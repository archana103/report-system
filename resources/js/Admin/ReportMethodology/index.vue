<template>
  <div class="animate-in fade-in duration-300 w-full max-w-7xl mx-auto p-4 md:p-6 lg:p-8 pt-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
      <h1 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-indigo-500">
        Report Methodology
      </h1>
    </div>

    <!-- Main Content Card -->
    <div class="bg-[#1e293b] border border-[#334155] rounded-xl shadow-xl p-6 relative overflow-hidden">
      <!-- Decorative background element -->
      <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-500/5 to-indigo-500/5 rounded-full blur-3xl -mt-20 -mr-20 pointer-events-none"></div>

      <!-- Success/Error Message -->
      <div
        v-if="message"
        class="mb-6 p-4 rounded-xl text-sm font-medium"
        :class="isError ? 'bg-red-500/10 text-red-400 border border-red-500/20' : 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20'"
      >
        {{ message }}
      </div>

      <form @submit.prevent="saveMethodology" class="space-y-6 relative z-10">
        <div>
          <label class="block text-sm font-semibold text-gray-300 mb-2">Global Methodology Content</label>
          <TinyMceEditor v-model="formData.content" id="report-methodology-editor" :config="editorConfig" />
        </div>

        <div class="flexjustify-end pt-4 border-t border-gray-700/50">
          <button
            type="submit"
            :disabled="isSubmitting"
            class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-400 hover:to-indigo-500 text-white font-medium py-2.5 px-6 rounded-xl shadow-lg shadow-blue-500/20 transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed flex items-center"
          >
            <svg v-if="isSubmitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span v-if="isSubmitting">Saving...</span>
            <span v-else>Save Methodology</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { getReportMethodology, storeReportMethodology } from './api';
import TinyMceEditor from '../../components/TinyMceEditor.vue';

const formData = ref({
  content: ''
});

const editorConfig = {
  extraPlugins: 'colorbutton,font,justify',
  content_style: 'body { font-family: "Inter", sans-serif; color: #f8fafc !important; } body * { color: #f8fafc !important; background-color: transparent !important; }',
};

const message = ref('');
const isError = ref(false);
const isSubmitting = ref(false);

const loadData = async () => {
  try {
    const data = await getReportMethodology();
    if (data && data.content) {
      formData.value.content = data.content;
    }
  } catch (error) {
    console.error("Failed to load methodology", error);
  }
};

const saveMethodology = async () => {
  isSubmitting.value = true;
  message.value = '';
  isError.value = false;
  try {
    await storeReportMethodology(formData.value);
    message.value = "Methodology saved successfully!";
  } catch (error) {
    isError.value = true;
    message.value = "Failed to save methodology. Please try again.";
    console.error(error);
  } finally {
    isSubmitting.value = false;
    setTimeout(() => {
      message.value = '';
    }, 3000);
  }
};

onMounted(() => {
  loadData();
});
</script>
