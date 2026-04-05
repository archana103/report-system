<script setup>
import { ref } from 'vue';
import AddCategory from './AddCategory.vue';
import ListCategory from './ListCategory.vue';

const activeTab = ref('add'); // 'add', 'list', or 'edit'
const editingCategory = ref(null);

const handleEdit = (category) => {
  editingCategory.value = category;
  activeTab.value = 'edit';
};

const handleSaved = () => {
  editingCategory.value = null;
  activeTab.value = 'list';
};
</script>

<template>
  <div class="min-h-[500px] bg-gray-800/40 rounded-3xl p-6 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-hidden flex flex-col">
    <!-- Decorative Blob -->
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 flex-shrink-0">
      <h1 class="text-3xl font-medium pb-1 bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-500 mb-4 tracking-tight drop-shadow-sm">
         Report Category
      </h1>

      <!-- Tabs -->
      <div class="flex space-x-4 mb-4 border-b border-gray-700/50 pb-2">
        <button
          @click="activeTab = 'add'; editingCategory = null"
          :class="[
            'px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200',
            activeTab === 'add' ? 'bg-teal-500/20 text-teal-400 border border-teal-500/30' : 'text-gray-400 hover:text-gray-200 hover:bg-gray-800/50'
          ]"
        >
          Add Report Category
        </button>
        <button
          @click="activeTab = 'list'; editingCategory = null"
          :class="[
            'px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200',
            activeTab === 'list' ? 'bg-teal-500/20 text-teal-400 border border-teal-500/30' : 'text-gray-400 hover:text-gray-200 hover:bg-gray-800/50'
          ]"
        >
          List
        </button>
        <button
          v-if="activeTab === 'edit'"
          :class="[
            'px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200',
            'bg-teal-500/20 text-teal-400 border border-teal-500/30'
          ]"
        >
          Edit: {{ editingCategory?.name }}
        </button>
      </div>
    </div>

    <!-- Tab Content -->
    <div class="relative z-10 flex-grow bg-gray-900/50 rounded-2xl p-4 border border-gray-800 shadow-inner overflow-y-auto w-full">
      <AddCategory v-if="activeTab === 'add'" mode="add" @saved="handleSaved" />
      <ListCategory v-if="activeTab === 'list'" @edit="handleEdit" />
      <AddCategory v-if="activeTab === 'edit'" mode="edit" :category="editingCategory" @saved="handleSaved" />
    </div>
  </div>
</template>
