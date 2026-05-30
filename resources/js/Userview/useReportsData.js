import { ref, computed, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'

export function useReportsData() {
  const route = useRoute()
  const categories = ref(['All'])
  const selectedCategory = ref('All')
  const searchQuery = ref('')
  const reports = ref([])
  const loading = ref(false)
  const currentPage = ref(1)
  const totalPages = ref(1)

  const fetchCategories = async () => {
    try {
      const response = await axios.get('/admin/report-categories-dropdown')
      if (response.data && response.data.length > 0) {
        categories.value = ['All', ...response.data.map(cat => cat.name)]
      }
    } catch (error) {
      console.error('Failed to fetch categories', error)
    }
  }

  const fetchReports = async (page) => {
    loading.value = true
    currentPage.value = page
    try {
      const response = await axios.get('/api/reports-list', {
        params: {
          page: page,
          category: selectedCategory.value,
          search: searchQuery.value
        }
      })
      
      reports.value = response.data.data
      totalPages.value = response.data.last_page
    } catch (error) {
      console.error('Failed to fetch reports', error)
    } finally {
      loading.value = false
    }
  }

  onMounted(() => {
    if (route && route.query && route.query.category) {
      selectedCategory.value = route.query.category
    }
    fetchCategories()
    fetchReports(1)
  })

  watch(() => route && route.query ? route.query.category : null, (newCat) => {
    selectedCategory.value = newCat || 'All'
    fetchReports(1)
  })

  const paginationRange = computed(() => {
    const current = currentPage.value;
    const last = totalPages.value;
    const range = [];

    let start = Math.max(1, current - 1);
    let end = Math.min(last, start + 2);
    
    if (end - start < 2 && start > 1) {
      start = Math.max(1, end - 2);
    }

    for (let i = start; i <= end; i++) {
      range.push(i);
    }

    return range;
  });

  return {
    categories,
    selectedCategory,
    searchQuery,
    reports,
    loading,
    currentPage,
    totalPages,
    fetchReports,
    paginationRange
  }
}