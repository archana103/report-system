<template>
  <div class="animate-in fade-in duration-300">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl text-gray-200 font-medium">{{ title }}</h2>
      <div v-if="searchable" class="relative">
        <input 
          type="text" 
          @input="$emit('search', $event.target.value)"
          placeholder="Search..." 
          class="bg-gray-800/80 border border-gray-700 rounded-xl pl-10 pr-4 py-2 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all w-64" 
        />
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 absolute left-3.5 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-700/50 shadow-sm transition-all duration-300" :class="{ 'opacity-50 pointer-events-none': loading }">
      <table class="w-full text-left text-sm text-gray-400">
        <thead class="text-xs text-gray-300 uppercase bg-gray-800/80 border-b border-gray-700/50">
          <tr>
            <th v-for="header in headers" :key="header.key" scope="col" class="px-4 py-3 font-semibold">
              {{ header.label }}
            </th>
            <th v-if="hasActions" scope="col" class="px-4 py-3 text-right font-semibold">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-700/50 bg-gray-800/30">
          <tr v-if="items.length === 0" class="hover:bg-gray-800/60 transition-colors">
            <td :colspan="headers.length + (hasActions ? 1 : 0)" class="px-4 py-4 text-center text-gray-500 italic">
               No data found.
            </td>
          </tr>
          <tr v-for="(item, index) in items" :key="index" class="hover:bg-gray-800/60 transition-colors">
            <td v-for="header in headers" :key="header.key" class="px-4 py-3">
              <slot :name="`item-${header.key}`" :item="item">
                <div class="text-gray-200">{{ item[header.key] }}</div>
              </slot>
            </td>
            <td v-if="hasActions" class="px-4 py-3 text-right">
              <div class="flex justify-end space-x-2">
                <button 
                  @click="$emit('edit', item)"
                  class="text-teal-400 hover:text-teal-300 transition-colors p-1.5 rounded hover:bg-teal-400/10 flex items-center justify-center"
                  title="Edit"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                </button>
                <button 
                  @click="$emit('delete', item)"
                  class="text-rose-400 hover:text-rose-300 transition-colors p-1.5 rounded hover:bg-rose-400/10 flex items-center justify-center"
                  title="Delete"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div v-if="pagination && pagination.total > pagination.per_page" class="mt-6 flex items-center justify-between">
      <div class="text-sm text-gray-400">
        Showing <span class="font-medium text-gray-200">{{ pagination.from }}</span> to <span class="font-medium text-gray-200">{{ pagination.to }}</span> of <span class="font-medium text-gray-200">{{ pagination.total }}</span> results
      </div>
      <div class="flex space-x-1">
        <button 
          @click="$emit('page-change', pagination.current_page - 1)"
          :disabled="pagination.current_page === 1"
          class="px-3 py-1.5 rounded-lg text-sm transition-all duration-200"
          :class="pagination.current_page === 1 ? 'text-gray-600 bg-gray-800/10 cursor-not-allowed' : 'text-gray-400 hover:text-teal-400 hover:bg-teal-500/10 bg-gray-800/50 border border-gray-700/50'"
        >
          Previous
        </button>
        
        <template v-for="page in pagination.last_page" :key="page">
           <button 
            v-if="page === 1 || page === pagination.last_page || (page >= pagination.current_page - 1 && page <= pagination.current_page + 1)"
            @click="$emit('page-change', page)"
            class="px-3.5 py-1.5 rounded-lg text-sm transition-all duration-200 font-medium"
            :class="pagination.current_page === page ? 'bg-teal-500/20 text-teal-400 border border-teal-500/30' : 'text-gray-400 hover:text-teal-400 hover:bg-teal-500/10 bg-gray-800/50 border border-gray-700/50'"
          >
            {{ page }}
          </button>
          <span v-else-if="page === pagination.current_page - 2 || page === pagination.current_page + 2" class="px-2 py-1.5 text-gray-500">...</span>
        </template>

        <button 
          @click="$emit('page-change', pagination.current_page + 1)"
          :disabled="pagination.current_page === pagination.last_page"
          class="px-3 py-1.5 rounded-lg text-sm transition-all duration-200"
          :class="pagination.current_page === pagination.last_page ? 'text-gray-600 bg-gray-800/10 cursor-not-allowed' : 'text-gray-400 hover:text-teal-400 hover:bg-teal-500/10 bg-gray-800/50 border border-gray-700/50'"
        >
          Next
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: { type: String, default: 'Data List' },
  headers: { type: Array, required: true },
  items: { type: Array, required: true },
  loading: { type: Boolean, default: false },
  searchable: { type: Boolean, default: true },
  hasActions: { type: Boolean, default: true },
  pagination: { 
    type: Object, 
    default: () => ({
      current_page: 1,
      last_page: 1,
      per_page: 20,
      total: 0,
      from: 0,
      to: 0
    })
  }
})

defineEmits(['edit', 'delete', 'page-change', 'search'])
</script>
