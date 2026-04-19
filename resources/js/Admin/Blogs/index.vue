<script setup>
import { ref } from 'vue';
import ListBlog from './ListBlog.vue';
import AddBlog from './AddBlog.vue';
import { resetForm } from './variable';

const activeTab = ref('list'); // 'list' or 'add'
const editItem = ref(null);

const setTab = (tab) => {
  if (tab === 'add') {
    editItem.value = null; // Clear edit mode when manually switching to Add
    resetForm();
  }
  activeTab.value = tab;
};

const onEdit = (blog) => {
  editItem.value = blog;
  activeTab.value = 'add';
};

const onSaved = () => {
  activeTab.value = 'list';
};
</script>

<template>
  <div class="h-full bg-gray-900/50 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-hidden flex flex-col min-h-[calc(100vh-140px)]">
    <!-- Decorative Blob -->
    <div class="absolute -top-10 -right-10 w-64 h-64 bg-violet-600/10 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-blue-600/10 rounded-full blur-[100px] pointer-events-none"></div>
    
    <div class="relative z-10 flex flex-col h-full">
      <!-- Header & Tabs -->
      <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-6">
        <div>
          <h1 class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-violet-400 via-indigo-400 to-blue-400 tracking-tight drop-shadow-sm">
            Blog Management
          </h1>
          <p class="text-gray-400 mt-2 text-sm font-medium flex items-center">
            <span class="w-2 h-2 rounded-full bg-violet-500 mr-2"></span>
            Manage your news, articles, and industry insights
          </p>
        </div>

        <!-- Custom Tabs -->
        <div class="flex p-1 bg-gray-800/80 backdrop-blur-md rounded-2xl border border-gray-700/50 w-fit self-start md:self-center shadow-lg">
          <button
            @click="setTab('list')"
            :class="activeTab === 'list' 
              ? 'bg-gradient-to-r from-violet-600 to-indigo-600 text-white shadow-lg' 
              : 'text-gray-400 hover:text-gray-200 hover:bg-white/5'"
            class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 flex items-center"
          >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
            Blog List
          </button>
          <button
            @click="setTab('add')"
            :class="activeTab === 'add' 
              ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg' 
              : 'text-gray-400 hover:text-gray-200 hover:bg-white/5'"
            class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 flex items-center"
          >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            {{ editItem ? 'Edit Blog' : 'Add Blog' }}
          </button>
        </div>
      </div>

      <!-- Tab Content -->
      <div class="flex-grow">
        <div v-if="activeTab === 'list'" class="h-full">
          <ListBlog @edit="onEdit" />
        </div>
        <div v-else class="h-full max-w-5xl mx-auto">
          <AddBlog :blog="editItem" :mode="editItem ? 'edit' : 'add'" @saved="onSaved" @cancel="setTab('list')" />
        </div>
      </div>
    </div>
  </div>
</template>
