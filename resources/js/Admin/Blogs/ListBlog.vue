<script setup>
import { ref, onMounted } from 'vue';
import DataTable from '../../components/DataTable.vue';
import ConfirmationModal from '../../components/ConfirmationModal.vue';
import { getBlogs, deleteBlog } from './api';

const emit = defineEmits(['edit']);

const blogs = ref([]);
const loading = ref(false);
const showDeleteModal = ref(false);
const blogToDelete = ref(null);

const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 20,
  total: 0,
  from: 0,
  to: 0
});

const headers = [
  { key: 'title', label: 'Title' },
  { key: 'description', label: 'Description' },
  { key: 'url', label: 'URL' },
  { key: 'author_name', label: 'Author' },
  { key: 'image', label: 'Image', sortable: false },
  { key: 'date', label: 'Date' }
];

const fetchBlogs = async (page = 1) => {
  loading.value = true;
  try {
    const response = await getBlogs({ page });
    blogs.value = response.data.map((blog, index) => ({
      ...blog,
      sr: (page - 1) * response.per_page + (index + 1)
    }));
    pagination.value = {
      current_page: response.current_page,
      last_page: response.last_page,
      per_page: response.per_page,
      total: response.total,
      from: response.from,
      to: response.to
    };
  } catch (error) {
    console.error('Failed to fetch blogs', error);
  } finally {
    loading.value = false;
  }
};

const openDeleteModal = (blog) => {
  blogToDelete.value = blog;
  showDeleteModal.value = true;
};

const confirmDelete = async () => {
  if (!blogToDelete.value) return;
  try {
    await deleteBlog(blogToDelete.value.id);
    fetchBlogs(pagination.value.current_page);
    showDeleteModal.value = false;
  } catch (error) {
    alert('Failed to delete blog.');
  }
};

const formatDate = (dateStr) => {
  if (!dateStr) return '—';
  return new Intl.DateTimeFormat('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }).format(new Date(dateStr));
};

const stripHtml = (html) => {
  const doc = new DOMParser().parseFromString(html, 'text/html');
  return doc.body.textContent || "";
};

const truncate = (text, length = 50) => {
  if (!text) return '—';
  const cleanText = stripHtml(text);
  if (cleanText.length <= length) return cleanText;
  return cleanText.substring(0, length) + '...';
};

onMounted(() => {
  fetchBlogs();
});
</script>

<template>
  <div class="animate-in fade-in duration-500">
    <DataTable
      title="Recent Blog Posts"
      :headers="headers"
      :items="blogs"
      :loading="loading"
      :pagination="pagination"
      @page-change="fetchBlogs"
      @edit="(item) => $emit('edit', item)"
      @delete="openDeleteModal"
    >
      <template #item-title="{ item }">
        <span class="font-medium text-gray-200 group-hover:text-blue-400 transition-colors" :title="item.title">
          {{ truncate(item.title, 40) }}
        </span>
      </template>

      <template #item-description="{ item }">
        <span class="text-gray-400 text-xs italic" :title="stripHtml(item.description)">
          {{ truncate(item.description, 60) }}
        </span>
      </template>

      <template #item-url="{ item }">
        <span class="text-xs text-blue-500/80 bg-blue-500/5 px-2 py-1 rounded-md border border-blue-500/10">
          {{ truncate(item.url, 20) }}
        </span>
      </template>

      <template #item-image="{ item }">
        <div class="flex items-center justify-center py-1">
          <img 
            v-if="item.image" 
            :src="'/storage/' + item.image" 
            class="h-10 w-16 object-cover rounded-lg border border-gray-700 shadow-md hover:scale-110 transition-transform duration-200" 
            alt="Blog"
          />
          <div v-else class="h-10 w-16 bg-gray-800 rounded-lg border border-gray-700 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
          </div>
        </div>
      </template>

      <template #item-date="{ item }">
        <span class="text-gray-400 text-sm italic">{{ formatDate(item.created_at) }}</span>
      </template>
    </DataTable>

    <ConfirmationModal
      :show="showDeleteModal"
      title="Delete Blog Post"
      :message="`Are you sure you want to delete '${blogToDelete?.title}'? This action cannot be undone.`"
      @confirm="confirmDelete"
      @cancel="showDeleteModal = false"
    />
  </div>
</template>
