<template>
  <div class="px-6 py-8">
    <div class="flex justify-between items-center mb-8">
      <h2 class="text-3xl font-semibold text-gray-100 items-center">Pricing Strategy</h2>
      <button v-if="pricings.length < 3" @click="openModal()" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-400 hover:to-indigo-500 text-white font-medium py-2.5 px-6 rounded-xl shadow-lg shadow-blue-500/20 transition-all flex items-center">
        + Add New Pricing Option
      </button>
    </div>

    <!-- Pricing List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="pricing in pricings" :key="pricing.id" class="bg-gray-800/60 p-6 rounded-2xl border border-gray-700 shadow-xl relative group transition-all hover:bg-gray-800">
         <div class="absolute top-4 right-4 flex space-x-2">
            <button @click="openModal(pricing)" class="text-gray-400 hover:text-blue-400 transition-colors p-2"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg></button>
            <button @click="deletePricing(pricing.id)" class="text-gray-400 hover:text-red-400 transition-colors p-2"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
         </div>
         <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold mb-4 border" :class="pricing.status === 'Active' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-red-500/10 text-red-400 border-red-500/20'">{{ pricing.status }}</span>
         <h3 class="text-xl font-bold text-white mb-2">{{ pricing.title }}</h3>
         <div class="mb-4">
             <p v-if="pricing.discount_cost" class="text-xl line-through text-gray-500 inline-block mr-2">$ {{ pricing.discount_cost }}</p>
             <p class="text-3xl font-bold text-gray-200 inline-block">$ {{ pricing.cost }}</p>
         </div>
         
         <ul class="space-y-2 mt-4">
           <li v-for="(feature, index) in parseDetails(pricing.details)" :key="index" class="flex text-sm text-gray-400">
             <span class="text-emerald-400 mr-2">✓</span> {{ feature }}
           </li>
         </ul>
      </div>
    </div>

    <!-- Modal Form -->
    <div v-if="isModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/80 backdrop-blur-sm p-4 animate-in fade-in duration-200">
      <div class="bg-gray-800 rounded-3xl border border-gray-700 shadow-2xl w-full max-w-xl overflow-hidden relative" @click.stop>
        <div class="px-8 py-6 border-b border-gray-700/50 flex justify-between items-center">
          <h3 class="text-xl font-semibold text-white">{{ isEditing ? 'Edit Pricing Option' : 'Add Pricing Option' }}</h3>
          <button @click="closeModal" class="text-gray-400 hover:text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>
        </div>
        <div class="p-8">
          <form @submit.prevent="submitForm">
            <div class="space-y-6">
              <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Plan Title</label>
                <input v-model="form.title" type="text" placeholder="Individual License" required class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Main Cost (Actual Price in USD)</label>
                <input v-model="form.cost" type="number" step="0.01" required class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Crossed Out Text (Inflated Price in USD) - Optional</label>
                <input v-model="form.discount_cost" type="number" step="0.01" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Pricing Details (One feature per line)</label>
                <textarea v-model="form.details" rows="5" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50"></textarea>
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Status</label>
                <select v-model="form.status" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50">
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                </select>
              </div>
            </div>
            
            <div class="mt-8 flex flex-col items-end">
              <div v-if="errorMessage" class="w-full mb-4 px-4 py-3 bg-red-500/10 text-red-500 border border-red-500/20 rounded-xl text-sm font-medium">
                {{ errorMessage }}
              </div>
              <div class="flex justify-end space-x-3 w-full">
                <button type="button" @click="closeModal" class="px-6 py-2.5 font-medium text-gray-300 hover:text-white rounded-xl hover:bg-gray-700/50 transition-colors">Cancel</button>
                <button type="submit" :disabled="isSubmitting" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-400 hover:to-indigo-500 disabled:opacity-50 text-white font-medium py-2.5 px-6 rounded-xl shadow-lg shadow-blue-500/20 transition-all">
                  {{ isSubmitting ? 'Saving...' : 'Save Options' }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const pricings = ref([]);
const isModalOpen = ref(false);
const isEditing = ref(false);
const isSubmitting = ref(false);
const errorMessage = ref('');

const form = ref({
  id: null,
  title: '',
  cost: '',
  discount_cost: '',
  details: '',
  status: 'Active'
});

const loadPricings = async () => {
  try {
    const response = await axios.get('/admin/pricings');
    pricings.value = response.data;
  } catch (error) {
    console.error('Error fetching pricings', error);
  }
};

const parseDetails = (detailsString) => {
  if (!detailsString) return [];
  return detailsString.split('\n').filter(line => line.trim() !== '');
};

const openModal = (pricing = null) => {
  if (pricing) {
    isEditing.value = true;
    form.value = { ...pricing };
  } else {
    isEditing.value = false;
    form.value = { id: null, title: '', cost: '', discount_cost: '', details: '', status: 'Active' };
  }
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
  errorMessage.value = '';
};

const submitForm = async () => {
  isSubmitting.value = true;
  try {
    if (isEditing.value) {
      await axios.put(`/admin/pricings/${form.value.id}`, form.value);
    } else {
      await axios.post('/admin/pricings', form.value);
    }
    await loadPricings();
    closeModal();
  } catch (error) {
    console.error('Error saving pricing', error);
    if (error.response && error.response.data && error.response.data.message) {
      errorMessage.value = error.response.data.message;
    } else {
      errorMessage.value = 'Failed to save pricing option.';
    }
  } finally {
    isSubmitting.value = false;
  }
};

const deletePricing = async (id) => {
  if (!confirm('Are you sure you want to delete this pricing option?')) return;
  try {
    await axios.delete(`/admin/pricings/${id}`);
    await loadPricings();
  } catch (error) {
    console.error('Error deleting pricing', error);
  }
};

onMounted(() => {
  loadPricings();
});
</script>
