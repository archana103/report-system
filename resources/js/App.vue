<template>
  <div :class="layoutClass">
    <router-view />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const layoutClass = computed(() => {
  return route.path.startsWith('/admin') ? 'admin-theme' : 'user-theme'
})
</script>
