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
    if (route && route.query) {
      if (route.query.category) {
        selectedCategory.value = route.query.category
      }
      if (route.query.search) {
        searchQuery.value = route.query.search
      }
    }
    fetchCategories()
    fetchReports(1)
  })

  watch(
    () => [route?.query?.category, route?.query?.search],
    ([newCat, newSearch]) => {
      let changed = false;
      
      const categoryToSet = newCat || 'All';
      if (selectedCategory.value !== categoryToSet) {
          selectedCategory.value = categoryToSet;
          changed = true;
      }
      
      const searchToSet = newSearch || '';
      if (searchQuery.value !== searchToSet) {
          searchQuery.value = searchToSet;
          changed = true;
      }

      if (changed) {
          fetchReports(1);
      }
    },
    { deep: true }
  )

  const paginationRange = computed(() => {
    const current = currentPage.value;
    const last = totalPages.value;
    const delta = 1;
    const range = [];
    const rangeWithDots = [];
    let l;

    for (let i = 1; i <= last; i++) {
      if (i === 1 || i === 2 || i === last || i === last - 1 || (i >= current - delta && i <= current + delta)) {
        range.push(i);
      }
    }

    for (let i of range) {
      if (l) {
        if (i - l === 2) {
          rangeWithDots.push(l + 1);
        } else if (i - l !== 1) {
          rangeWithDots.push('...');
        }
      }
      rangeWithDots.push(i);
      l = i;
    }

    return rangeWithDots;
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