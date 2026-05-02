<script setup>
import { ref } from 'vue';
import AddPressRelease from './AddPressRelease.vue';
import ListPressRelease from './ListPressRelease.vue';

const activeTab = ref('list');
const editingRelease = ref(null);

const handleEdit = (release) => {
  editingRelease.value = release;
  activeTab.value = 'edit';
};

const handleSaved = () => {
  editingRelease.value = null;
  activeTab.value = 'list';
};
</script>

<template>
  <div class="min-h-[500px] bg-gray-800/40 rounded-3xl p-6 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-hidden flex flex-col">
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-fuchsia-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 flex-shrink-0">
      <h1 class="text-3xl font-medium pb-1 bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-400 to-pink-500 mb-4 tracking-tight drop-shadow-sm">
        Press Release
      </h1>

      <!-- Tabs -->
      <div class="flex space-x-4 mb-4 border-b border-gray-700/50 pb-2">
        <button
          @click="activeTab = 'list'; editingRelease = null"
          :class="[
            'px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200',
            activeTab === 'list'
              ? 'bg-fuchsia-500/20 text-fuchsia-400 border border-fuchsia-500/30'
              : 'text-gray-400 hover:text-gray-200 hover:bg-gray-800/50'
          ]"
        >
          Press Release List
        </button>
        <button
          @click="activeTab = 'add'; editingRelease = null"
          :class="[
            'px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200',
            activeTab === 'add'
              ? 'bg-fuchsia-500/20 text-fuchsia-400 border border-fuchsia-500/30'
              : 'text-gray-400 hover:text-gray-200 hover:bg-gray-800/50'
          ]"
        >
          Add Press Release
        </button>
        <button
          v-if="activeTab === 'edit'"
          :class="[
            'px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200',
            'bg-fuchsia-500/20 text-fuchsia-400 border border-fuchsia-500/30'
          ]"
        >
          Edit: {{ editingRelease?.title }}
        </button>
      </div>
    </div>

    <!-- Tab Content -->
    <div class="relative z-10 flex-grow bg-gray-900/50 rounded-2xl p-4 border border-gray-800 shadow-inner overflow-y-auto w-full">
      <ListPressRelease v-if="activeTab === 'list'" @edit="handleEdit" />
      <AddPressRelease v-if="activeTab === 'add'" mode="add" @saved="handleSaved" />
      <AddPressRelease v-if="activeTab === 'edit'" mode="edit" :release="editingRelease" @saved="handleSaved" />
    </div>
  </div>
</template>
