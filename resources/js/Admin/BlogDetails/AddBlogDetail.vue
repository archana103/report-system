<script setup>
import { ref, onMounted, watch } from 'vue';
import { formData, errors, isSubmitting, successMessage, resetForm, setFormData } from './variable';
import { storeBlogDetail, updateBlogDetail, getBlogsList } from './api';
import CkEditor4 from '../../components/CkEditor4.vue';

const props = defineProps({
  detail: { type: Object, default: null },
  mode: { type: String, default: 'add' }
});

const emit = defineEmits(['saved', 'cancel']);
const blogs = ref([]);

const editorConfig = {
    extraPlugins: 'colorbutton,font,justify'
};

const loadBlogs = async () => {
    try {
        blogs.value = await getBlogsList();
    } catch (e) {
        console.error('Failed to load blogs list', e);
    }
};

watch(() => props.detail, (newVal) => {
  if (newVal && props.mode === 'edit') {
    setFormData(newVal);
  } else {
    resetForm();
  }
}, { immediate: true });

const submitForm = async () => {
  isSubmitting.value = true;
  for (let key in errors) delete errors[key];
  successMessage.value = '';

  try {
    if (props.mode === 'edit' && props.detail) {
      await updateBlogDetail(props.detail.id, formData);
      successMessage.value = 'Blog Detail updated successfully!';
      emit('saved');
    } else {
      await storeBlogDetail(formData);
      successMessage.value = 'Blog Detail added successfully!';
      resetForm();
      emit('saved');
    }
  } catch (error) {
    if (error.response && error.response.status === 422) {
      Object.assign(errors, error.response.data.errors);
    } else {
      successMessage.value = 'Failed to save! Please try again.';
    }
  } finally {
    isSubmitting.value = false;
  }
};

// FAQ Helpers
const addFaq = () => {
    formData.faqs.push({ question: '', answer: '' });
};
const removeFaq = (index) => {
    formData.faqs.splice(index, 1);
};

// Hreflang Helpers
const addHreflang = () => {
    formData.hreflang_tags.push('');
};
const removeHreflang = (index) => {
    formData.hreflang_tags.splice(index, 1);
};

onMounted(() => {
    loadBlogs();
});
</script>

<template>
  <div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
    <div class="flex items-center justify-between mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600/10 to-transparent p-4 border-l-4 border-indigo-500">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">
                {{ mode === 'edit' ? 'Edit Blog Detail' : 'Add Blog Detail' }}
            </h2>
            <p class="text-gray-400 text-sm mt-1">Select a blog and add detailed rich content for it.</p>
        </div>
    </div>

    <div
      v-if="successMessage"
      class="mb-6 p-4 rounded-xl text-sm font-medium animate-in zoom-in-95 duration-300 shadow-lg shadow-emerald-500/10 border border-emerald-500/20"
      :class="successMessage.includes('successfully') ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400'"
    >
      {{ successMessage }}
    </div>

    <form @submit.prevent="submitForm" class="space-y-8 pb-12">
      <!-- Basic Info -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 bg-gray-900/40 rounded-3xl border border-gray-800 shadow-2xl backdrop-blur-sm">
          <div v-if="mode !== 'edit'">
            <label class="block text-sm font-semibold text-gray-300 mb-3 ml-1">Select Blog</label>
            <select 
              v-model="formData.blog_id" 
              class="w-full bg-gray-800 border border-gray-700/50 rounded-xl pl-4 pr-10 py-3 text-sm text-gray-200 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all shadow-inner appearance-none"
            >
              <option value="" disabled>---</option>
              <option v-for="blog in blogs" :key="blog.id" :value="blog.id">{{ blog.title }}</option>
            </select>
            <p v-if="errors.blog_id" class="text-red-400 text-xs mt-2 ml-1">{{ errors.blog_id[0] }}</p>
          </div>

          <div :class="mode === 'edit' ? 'col-span-2' : ''">
            <label class="block text-sm font-semibold text-gray-300 mb-3 ml-1">Blog detail Title</label>
            <input 
              v-model="formData.title" 
              type="text" 
              placeholder="Detailed subtitle or headline..."
              class="w-full bg-gray-800 border border-gray-700/50 rounded-xl px-5 py-3 text-sm text-gray-200 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all shadow-inner" 
            />
            <p v-if="errors.title" class="text-red-400 text-xs mt-2 ml-1">{{ errors.title[0] }}</p>
          </div>

          <div class="col-span-1 md:col-span-2">
            <label class="block text-sm font-semibold text-gray-300 mb-3 ml-1">Blog detail Description</label>
            <CkEditor4 id="blog-detail-editor" v-model="formData.description" :config="editorConfig" />
          </div>
      </div>

      <!-- Advanced Fields (Edit Mode Only) -->
      <template v-if="mode === 'edit'">
          <!-- SEO Section -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 bg-gray-900/40 rounded-3xl border border-gray-800 shadow-2xl backdrop-blur-sm">
              <div class="col-span-1 md:col-span-2 pb-2 border-b border-gray-800">
                  <h3 class="text-lg font-bold text-gray-300 flex items-center">SEO Optimization</h3>
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Meta Title</label>
                <input v-model="formData.meta_title" type="text" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-indigo-500/50" />
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Meta Description</label>
                <textarea v-model="formData.meta_description" rows="2" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-indigo-500/50"></textarea>
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Meta Keywords</label>
                <input v-model="formData.meta_keywords" type="text" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-indigo-500/50" />
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Canonical Tag</label>
                <input v-model="formData.canonical_tag" type="text" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-indigo-500/50" />
              </div>
              <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Meta Robots Tag</label>
                <textarea v-model="formData.meta_robots" rows="1" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-indigo-500/50"></textarea>
              </div>

              <!-- Hreflang Tags -->
              <div class="col-span-1 md:col-span-2 space-y-4">
                <div class="flex items-center justify-between">
                    <label class="block text-sm font-semibold text-gray-400 ml-1">Blog Hreflang Tags</label>
                    <button type="button" @click="addHreflang" class="text-xs text-emerald-400 hover:text-emerald-300 flex items-center bg-emerald-500/10 px-3 py-1.5 rounded-lg border border-emerald-500/20 transition-all font-bold">+ Add Hreflang</button>
                </div>
                <div v-for="(tag, index) in formData.hreflang_tags" :key="index" class="flex gap-2">
                    <input v-model="formData.hreflang_tags[index]" type="text" placeholder="Enter hreflang tag..." class="flex-grow bg-gray-800/40 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200" />
                    <button type="button" @click="removeHreflang(index)" class="p-2 text-red-400 hover:bg-red-500/10 rounded-lg transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                </div>
              </div>
          </div>

          <!-- Social Meta (OG & Twitter) -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 bg-gray-900/40 rounded-3xl border border-gray-800 shadow-2xl backdrop-blur-sm">
              <div class="col-span-1 md:col-span-2 pb-2 border-b border-gray-800">
                  <h3 class="text-lg font-bold text-gray-300">Open Graph Meta Tags</h3>
              </div>
              <div v-for="i in 6" :key="'og'+i">
                  <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Open Graph Meta Tag {{ ['One','Two','Three','Four','Five','Six'][i-1] }}</label>
                  <textarea v-model="formData.open_graph_tags['tag_'+i]" rows="2" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200"></textarea>
              </div>

              <div class="col-span-1 md:col-span-2 pb-2 border-b border-gray-800 mt-6">
                  <h3 class="text-lg font-bold text-gray-300">Twitter Card Meta Tags</h3>
              </div>
              <div v-for="i in 6" :key="'tw'+i">
                  <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Twitter Card Meta Tag {{ ['One','Two','Three','Four','Five','Six'][i-1] }}</label>
                  <textarea v-model="formData.twitter_card_tags['tag_'+i]" rows="2" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200"></textarea>
              </div>
          </div>

          <!-- Schema Section -->
          <div class="grid grid-cols-1 gap-8 p-8 bg-gray-900/40 rounded-3xl border border-gray-800 shadow-2xl backdrop-blur-sm">
              <div class="pb-2 border-b border-gray-800">
                  <h3 class="text-lg font-bold text-gray-300">Schema Tags</h3>
              </div>
              <div v-for="i in 3" :key="'schema'+i">
                  <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Schema Tag {{ i > 1 ? i : '' }}</label>
                  <textarea v-model="formData['schema_tag' + (i > 1 ? '_'+i : '')]" rows="5" placeholder="{ ... }" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-200 font-mono"></textarea>
              </div>
          </div>

          <!-- FAQs -->
          <div class="grid grid-cols-1 gap-6 p-8 bg-gray-900/40 rounded-3xl border border-gray-800 shadow-2xl backdrop-blur-sm">
              <div class="flex items-center justify-between pb-2 border-b border-gray-800">
                  <h3 class="text-lg font-bold text-gray-300">FAQs</h3>
                  <button type="button" @click="addFaq" class="text-xs text-blue-400 hover:text-blue-300 flex items-center bg-blue-500/10 px-3 py-1.5 rounded-lg border border-blue-500/20 transition-all font-bold">+ Add FAQ</button>
              </div>
              <div v-for="(faq, index) in formData.faqs" :key="index" class="p-4 bg-gray-800/20 rounded-2xl border border-gray-700/50 space-y-3 relative group">
                  <div class="flex gap-4">
                      <div class="flex-grow space-y-3">
                          <input v-model="faq.question" type="text" placeholder="Question" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200" />
                          <textarea v-model="faq.answer" rows="2" placeholder="Answer" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200"></textarea>
                      </div>
                      <button type="button" @click="removeFaq(index)" class="h-10 px-3 text-xs bg-red-500/10 text-red-500 border border-red-500/20 rounded-lg hover:bg-red-500 hover:text-white transition-all font-bold">Delete</button>
                  </div>
              </div>
          </div>
      </template>

      <!-- Actions -->
      <div class="flex items-center justify-end space-x-4">
        <button type="button" @click="$emit('cancel')" class="px-8 py-3 rounded-xl text-sm font-medium text-gray-400 hover:text-white transition-all">Cancel</button>
        <button
          type="submit"
          :disabled="isSubmitting"
          class="px-10 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 shadow-xl shadow-indigo-500/20 transition-all active:scale-95 disabled:opacity-50"
        >
          <span v-if="isSubmitting">Saving...</span>
          <span v-else>{{ mode === 'edit' ? 'Update Detail' : 'Add Detail' }}</span>
        </button>
      </div>
    </form>
  </div>
</template>
