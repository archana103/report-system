<template>
  <div class="filter-bar">
    <div class="search-input-group">
      <input type="text" :value="searchQuery" @input="$emit('update:searchQuery', $event.target.value)" placeholder="Search Report by Title or Keyword" @keyup.enter="$emit('search')" />
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="icon input-icon" aria-hidden="true">
        <circle cx="11" cy="11" r="8"></circle>
        <path d="m21 21-4.3-4.3" stroke-linecap="round" stroke-linejoin="round"></path>
      </svg>
    </div>
    
    <div class="category-select-group">
      <select :value="selectedCategory" @change="$emit('update:selectedCategory', $event.target.value); $emit('search')">
        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
      </select>
    </div>
    
    <button class="primary-button" @click="$emit('search')">Find Report</button>
  </div>
</template>

<script setup>
defineProps({
  searchQuery: String,
  selectedCategory: String,
  categories: Array
})
defineEmits(['update:searchQuery', 'update:selectedCategory', 'search'])
</script>\n