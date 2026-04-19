<script setup>
import { ref, watch, onMounted } from 'vue';
import { formData, errors, isSubmitting, successMessage, resetForm, setFormData } from './variable';
import { storeReportList, updateReportList, getCategoriesDropdown } from './api';

const props = defineProps({
  report: { type: Object, default: null },
  mode: { type: String, default: 'add' }
});

const emit = defineEmits(['saved']);

const categories = ref([]);

const loadCategories = async () => {
  try {
    categories.value = await getCategoriesDropdown();
  } catch (e) {
    console.error('Failed to load categories', e);
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
    const payload = {
      report_category_id: formData.report_category_id,
      name: formData.name,
      status: formData.status,
    };

    if (props.mode === 'edit' && props.report) {
      await updateReportList(props.report.id, payload);
      successMessage.value = 'Report updated successfully!';
      emit('saved');
    } else {
      await storeReportList(payload);
      successMessage.value = 'Report saved successfully!';
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

onMounted(() => {
  loadCategories();
});
</script>

<template>
  <div class="animate-in fade-in duration-300">
    <h2 class="text-xl text-gray-200 font-medium mb-6">
      {{ mode === 'edit' ? 'Edit Report' : 'Add New Report' }}
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

    <form @submit.prevent="submitForm" class="space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Select Report Category -->
        <div>
          <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">
            Select Report Category
          </label>
          <div class="relative">
            <select
              v-model="formData.report_category_id"
              class="w-full bg-gray-800/80 border border-gray-700 rounded-xl pl-4 pr-10 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all appearance-none cursor-pointer"
            >
              <option value="" disabled>-- Select Category --</option>
              <option
                v-for="cat in categories"
                :key="cat.id"
                :value="cat.id"
              >{{ cat.name }}</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
              <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
              </svg>
            </div>
          </div>
          <p v-if="errors.report_category_id" class="text-red-400 text-xs mt-1 ml-1">
            {{ errors.report_category_id[0] }}
          </p>
        </div>

        <!-- New Report Name -->
        <div>
          <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">
            New Report Name
          </label>
          <textarea
            v-model="formData.name"
            rows="3"
            placeholder="Enter report name..."
            class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all resize-y"
          ></textarea>
          <p v-if="errors.name" class="text-red-400 text-xs mt-1 ml-1">
            {{ errors.name[0] }}
          </p>
        </div>

        <!-- Status -->
        <div>
          <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Status</label>
          <div class="relative">
            <select
              v-model="formData.status"
              class="w-full bg-gray-800/80 border border-gray-700 rounded-xl pl-4 pr-10 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all appearance-none cursor-pointer"
            >
              <option value="">---</option>
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
              <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
              </svg>
            </div>
          </div>
          <p v-if="errors.status" class="text-red-400 text-xs mt-1 ml-1">{{ errors.status[0] }}</p>
        </div>

      </div>

      <!-- Actions -->
      <div class="flex items-center pt-4 border-t border-gray-700/50">
        <button
          type="submit"
          :disabled="isSubmitting"
          class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-400 hover:to-indigo-500 text-white font-medium py-2.5 px-6 rounded-xl shadow-lg shadow-blue-500/20 transition-all active:scale-95 flex items-center justify-center disabled:opacity-50"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
          </svg>
          <span v-if="isSubmitting">Saving...</span>
          <span v-else>{{ mode === 'edit' ? 'Update Report' : 'Add Report' }}</span>
        </button>
        <button
          type="button"
          @click="cancelForm"
          class="ml-4 text-gray-400 hover:text-gray-200 font-medium py-2.5 px-6 rounded-xl hover:bg-gray-800 transition-all"
        >
          Cancel
        </button>
      </div>
    </form>
  </div>
</template>
