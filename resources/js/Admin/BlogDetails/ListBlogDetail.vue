<script setup>
import { ref, onMounted } from 'vue';
import DataTable from '../../components/DataTable.vue';
import ConfirmationModal from '../../components/ConfirmationModal.vue';
import { getBlogDetails, deleteBlogDetail } from './api';

const emit = defineEmits(['edit']);

const details = ref([]);
const loading = ref(false);
const showDeleteModal = ref(false);
const detailToDelete = ref(null);

const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 20,
  total: 0,
  from: 0,
  to: 0
});

const headers = [
  { key: 'blog_title', label: 'Blog Title' },
  { key: 'title', label: 'Blog Detail Title' },
  { key: 'description', label: 'Blog Detail Description' },
  { key: 'date', label: 'Date' }
];

const fetchDetails = async (page = 1) => {
  loading.value = true;
  try {
    const response = await getBlogDetails({ page });
    details.value = response.data;
    pagination.value = {
      current_page: response.current_page,
      last_page: response.last_page,
      per_page: response.per_page,
      total: response.total,
      from: response.from,
      to: response.to
    };
  } catch (error) {
    console.error('Failed to fetch blog details', error);
  } finally {
    loading.value = false;
  }
};

const openDeleteModal = (detail) => {
  detailToDelete.value = detail;
  showDeleteModal.value = true;
};

const confirmDelete = async () => {
  if (!detailToDelete.value) return;
  try {
    await deleteBlogDetail(detailToDelete.value.id);
    fetchDetails(pagination.value.current_page);
    showDeleteModal.value = false;
  } catch (error) {
    alert('Failed to delete blog detail.');
  }
};

const stripHtml = (html) => {
  const doc = new DOMParser().parseFromString(html, 'text/html');
  return doc.body.textContent || "";
};

const truncate = (text, length = 60) => {
  if (!text) return '—';
  const cleanText = stripHtml(text);
  if (cleanText.length <= length) return cleanText;
  return cleanText.substring(0, length) + '...';
};

const formatDate = (dateStr) => {
    if (!dateStr) return '—';
    return new Intl.DateTimeFormat('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }).format(new Date(dateStr));
};

onMounted(() => {
  fetchDetails();
});
</script>

<template>
  <div class="animate-in fade-in duration-500">
    <DataTable
      title="Blog Detailed Content List"
      :headers="headers"
      :items="details"
      :loading="loading"
      :pagination="pagination"
      @page-change="fetchDetails"
      @edit="(item) => $emit('edit', item)"
      @delete="openDeleteModal"
    >
      <template #item-blog_title="{ item }">
        <span class="text-sm font-semibold text-indigo-400 bg-indigo-500/5 px-2.5 py-1 rounded-lg border border-indigo-500/10 inline-block max-w-[200px] truncate" :title="item.blog?.title">
          {{ item.blog?.title || '—' }}
        </span>
      </template>

      <template #item-title="{ item }">
        <span class="font-medium text-gray-200 group-hover:text-blue-400 transition-colors" :title="item.title">
          {{ truncate(item.title, 40) }}
        </span>
      </template>

      <template #item-description="{ item }">
        <span class="text-gray-400 text-xs italic" :title="stripHtml(item.description)">
          {{ truncate(item.description, 80) }}
        </span>
      </template>

      <template #item-date="{ item }">
        <span class="text-gray-400 text-sm whitespace-nowrap">{{ formatDate(item.created_at) }}</span>
      </template>
    </DataTable>

    <ConfirmationModal
      :show="showDeleteModal"
      title="Delete Blog Detail"
      :message="`Are you sure you want to delete the detailed content for '${item?.blog?.title}'? This action is permanent.`"
      @confirm="confirmDelete"
      @cancel="showDeleteModal = false"
    />
  </div>
</template>
