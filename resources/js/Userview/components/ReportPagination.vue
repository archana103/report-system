<template>
  <div v-if="totalPages > 0" class="pagination-wrapper">
    <button class="nav-btn prev-btn" :disabled="currentPage === 1" @click="$emit('page-change', currentPage - 1)">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="nav-icon"><path d="m15 18-6-6 6-6"/></svg>
      Previous
    </button>
    
    <div class="page-numbers">
      <template v-for="(page, index) in paginationRange" :key="index">
        <span v-if="page === '...'" class="pagination-dots">...</span>
        <button 
          v-else
          class="num-btn"
          :class="{ active: currentPage === page }"
          @click="$emit('page-change', page)"
        >
          {{ page }}
        </button>
      </template>
    </div>

    <button class="nav-btn next-btn" :disabled="currentPage === totalPages" @click="$emit('page-change', currentPage + 1)">
      Next
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="nav-icon"><path d="m9 18 6-6-6-6"/></svg>
    </button>
  </div>
</template>

<script setup>
defineProps({
  currentPage: Number,
  totalPages: Number,
  paginationRange: Array
})
defineEmits(['page-change'])
</script>\n