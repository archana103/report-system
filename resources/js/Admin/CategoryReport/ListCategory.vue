<template>
  <DataTable 
    title="Category List"
    :headers="headers"
    :items="categories"
    :loading="loading"
    :pagination="pagination"
    @page-change="fetchCategories"
    @edit="handleEdit"
    @delete="handleDelete"
    @search="handleSearch"
  >
    <!-- Custom slot for Description (stripping HTML) -->
    <template #item-main_subheading="{ item }">
      <div class="text-gray-400 line-clamp-1" :title="stripHtml(item.main_subheading)">
        {{ stripHtml(item.main_subheading) }}
      </div>
    </template>

    <!-- Custom slot for Status -->
    <template #item-status="{ item }">
      <span 
        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border"
        :class="item.status === 'active' || item.status === 1 ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-gray-500/10 text-gray-400 border-gray-500/20'"
      >
        <span 
          class="w-1.5 h-1.5 rounded-full mr-1.5"
          :class="item.status === 'active' || item.status === 1 ? 'bg-emerald-400' : 'bg-gray-400'"
        ></span>
        {{ (item.status === 'active' || item.status === 1) ? 'Active' : 'Inactive' }}
      </span>
    </template>
  </DataTable>

  <!-- Delete Confirmation Modal -->
  <ConfirmationModal 
    :show="showDeleteModal"
    title="Delete Category"
    :message="`Are you sure you want to delete '${selectedCategory?.name}'? This action cannot be undone.`"
    @confirm="confirmDelete"
    @cancel="showDeleteModal = false"
  />

  <!-- Edit Category Modal -->

</template>

<script setup>
import { ref, onMounted } from 'vue'
import DataTable from '@/components/DataTable.vue'
import ConfirmationModal from '@/components/ConfirmationModal.vue'
import { getReportCategories, deleteReportCategory } from './api.js'

const emit = defineEmits(['edit'])

const categories = ref([])
const loading = ref(false)
const selectedCategory = ref(null)
const showDeleteModal = ref(false)


const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 20,
  total: 0,
  from: 0,
  to: 0
})

const headers = [
  { key: 'name', label: 'Category Name' },
  { key: 'main_subheading', label: 'Description' },
  { key: 'status', label: 'Status' },
]

const searchQuery = ref('')
const stripHtml = (html) => {
    if (!html) return '';
    const temp = document.createElement('div');
    temp.innerHTML = html;
    return temp.textContent || temp.innerText || "";
}

const fetchCategories = async (page = 1) => {
  loading.value = true
  try {
    const params = {
      page,
      limit: 20,
      search: searchQuery.value
    }
    const response = await getReportCategories(params)
    
    // Adjust mapping based on actual API response structure (usually Laravel Pagination)
    categories.value = response.data || []
    pagination.value = {
      current_page: response.current_page || 1,
      last_page: response.last_page || 1,
      per_page: response.per_page || 20,
      total: response.total || 0,
      from: response.from || 0,
      to: response.to || 0
    }
  } catch (error) {
    console.error('Error fetching categories:', error)
  } finally {
    loading.value = false
  }
}

const handleSearch = (query) => {
  searchQuery.value = query
  fetchCategories(1)
}

const handleEdit = (item) => {
  emit('edit', item)
}

const handleDelete = (item) => {
  selectedCategory.value = item
  showDeleteModal.value = true
}

const confirmDelete = async () => {
  if (!selectedCategory.value) return
  
  try {
    await deleteReportCategory(selectedCategory.value.id)
    showDeleteModal.value = false
    fetchCategories(pagination.value.current_page)
  } catch (error) {
    console.error('Error deleting category:', error)
  }
}

onMounted(() => {
  fetchCategories()
})
</script>
