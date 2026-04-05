<script setup>
import ListCategory from '../CategoryReport/ListCategory.vue'
</script>

<template>
  <div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-hidden flex flex-col">
    <!-- Decorative Blob -->
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 flex-shrink-0">
      <h1 class="text-4xl font-medium pb-2 bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-indigo-500 mb-6 tracking-tight drop-shadow-sm">
        Category List
      </h1>
    </div>

    <!-- Tab Content Area (Reusable list) -->
    <div class="relative z-10 flex-grow bg-gray-900/50 rounded-2xl p-6 border border-gray-800 shadow-inner overflow-y-auto w-full">
      <ListCategory />
    </div>
  </div>
</template>
