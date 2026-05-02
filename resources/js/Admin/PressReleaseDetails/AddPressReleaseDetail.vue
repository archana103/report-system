<template>
  <div class="w-full">
    <div class="bg-gray-800/60 backdrop-blur-md rounded-2xl border border-gray-700/50 shadow-xl overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-700/50 bg-gray-900/40">
        <h2 class="text-xl font-semibold text-gray-100">
          {{ mode === 'edit' ? 'Edit Press Release Detail' : 'Add Press Release Detail' }}
        </h2>
      </div>

      <form @submit.prevent="handleSubmit" class="p-6 space-y-8">
        
        <!-- ======================= ADD MODE: BASIC FIELDS ======================= -->
        <div v-if="mode === 'add'" class="space-y-6">
          <div class="grid grid-cols-1 gap-6">
            <!-- Select Press Release -->
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1.5">Select Press Release <span class="text-rose-500">*</span></label>
              <div class="relative">
                <select 
                  v-model="form.press_release_id" 
                  required
                  class="w-full bg-gray-900/50 border border-gray-700 rounded-xl pl-4 pr-10 py-2.5 text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all appearance-none"
                >
                  <option value="" disabled>---</option>
                  <option v-for="rel in pressReleasesList" :key="rel.id" :value="rel.id">
                    {{ rel.title }}
                  </option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                  <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                  </svg>
                </div>
              </div>
            </div>

            <!-- Content (CKEditor4) -->
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1.5">Press Release Content</label>
              <CkEditor4 id="add-content-editor" v-model="form.content" />
            </div>

            <!-- Meta Title -->
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1.5">Press Release Meta Title</label>
              <textarea v-model="form.meta_title" rows="2" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-2 text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 transition-all" placeholder="Enter Meta Title"></textarea>
            </div>

            <!-- Meta Description -->
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1.5">Press Release Meta Description</label>
              <textarea v-model="form.meta_description" rows="3" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-2 text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 transition-all" placeholder="Enter Meta Description"></textarea>
            </div>

            <!-- Meta Keywords -->
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1.5">Press Release Meta Keywords</label>
              <textarea v-model="form.meta_keywords" rows="2" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-2 text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 transition-all" placeholder="Enter Meta Keywords"></textarea>
            </div>
          </div>
        </div>

        <!-- ======================= EDIT MODE: FULL SEO FIELDS ======================= -->
        <div v-if="mode === 'edit'" class="space-y-8">
          <!-- Main Content Section -->
          <div class="space-y-6">
            <h3 class="text-lg font-medium text-white border-b border-gray-700/50 pb-2">Main Content & Basic SEO</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Select Press Release <span class="text-rose-500">*</span></label>
                <div class="relative">
                  <select 
                    v-model="form.press_release_id" 
                    required
                    class="w-full bg-gray-900/50 border border-gray-700 rounded-xl pl-4 pr-10 py-2.5 text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all appearance-none"
                  >
                    <option value="" disabled>---</option>
                    <option v-for="rel in pressReleasesList" :key="rel.id" :value="rel.id">
                      {{ rel.title }}
                    </option>
                  </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                  </div>
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Slug URL</label>
                <input v-model="form.slug_url" type="text" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-2 text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50" placeholder="e.g. north-america-market-growth" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Page Main Title</label>
                <input v-model="form.page_main_title" type="text" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-2 text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50" />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Breadcrumb Title</label>
                <input v-model="form.breadcrumb_title" type="text" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-2 text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50" />
              </div>
            </div>

            <div class="pt-4">
              <label class="block text-sm font-medium text-gray-300 mb-1.5">Press Release Content</label>
              <CkEditor4 id="edit-content-editor" v-model="form.content" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Press Release Meta Title</label>
                <textarea v-model="form.meta_title" rows="2" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-2 text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 transition-all"></textarea>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Press Release Meta Description</label>
                <textarea v-model="form.meta_description" rows="2" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-2 text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 transition-all"></textarea>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Press Release Meta Keywords</label>
                <textarea v-model="form.meta_keywords" rows="2" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-2 text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 transition-all"></textarea>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Canonical Tag</label>
                <textarea v-model="form.canonical_tag" rows="2" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-2 text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 transition-all" placeholder="Enter canonical URL"></textarea>
              </div>
            </div>

            <div class="grid grid-cols-1 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Meta Robots Tag</label>
                <textarea v-model="form.meta_robots" rows="2" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-2 text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 transition-all" placeholder="e.g. index, follow"></textarea>
              </div>
            </div>
          </div>

          <!-- Advanced Hreflang Section -->
          <div class="space-y-4 pt-4 border-t border-gray-700/50">
            <div class="flex justify-between items-center">
              <h3 class="text-lg font-medium text-white">Press Release Hreflang Tags</h3>
              <button type="button" @click="addHreflang" class="bg-teal-600 hover:bg-teal-500 text-white px-3.5 py-1.5 text-sm rounded-lg flex items-center transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Hreflang Tag
              </button>
            </div>
            
            <div v-for="(tag, index) in form.hreflang_tags" :key="'href'+index" class="flex items-center space-x-3">
              <input v-model="form.hreflang_tags[index]" type="text" placeholder="Enter hreflang tag" class="flex-grow bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-teal-500/50 focus:outline-none" />
              <button type="button" @click="removeHreflang(index)" class="bg-rose-500/10 text-rose-400 hover:bg-rose-500/30 p-2.5 rounded-xl transition-colors border border-rose-500/20" title="Remove">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </button>
            </div>
            <p v-if="form.hreflang_tags.length === 0" class="text-gray-500 text-sm italic">No hreflang tags added.</p>
          </div>

          <!-- Advanced Meta Open Graph & Twitter Cards Section -->
          <div class="space-y-6 pt-4 border-t border-gray-700/50">
            <h3 class="text-lg font-medium text-white border-b border-gray-700/50 pb-2">Open Graph Meta Tags</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div v-for="index in 6" :key="'og'+index">
                <label class="block text-xs font-semibold text-gray-400 mb-1 ml-1">Open Graph Meta Tag {{ ['One','Two','Three','Four','Five','Six'][index-1] }}</label>
                <textarea v-model="form.open_graph_tags[index-1]" rows="2" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50"></textarea>
              </div>
            </div>

            <h3 class="text-lg font-medium text-white border-b border-gray-700/50 pb-2 mt-6">Twitter Card Meta Tags</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div v-for="index in 6" :key="'tw'+index">
                <label class="block text-xs font-semibold text-gray-400 mb-1 ml-1">Twitter Card Meta Tag {{ ['One','Two','Three','Four','Five','Six'][index-1] }}</label>
                <textarea v-model="form.twitter_card_tags[index-1]" rows="2" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50"></textarea>
              </div>
            </div>
          </div>

          <!-- Advanced Schema Section -->
          <div class="space-y-6 pt-4 border-t border-gray-700/50 pb-6">
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1.5">Schema tag</label>
              <textarea v-model="form.schema_tag" rows="3" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50"></textarea>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-1.5">Schema tag 2</label>
              <textarea v-model="form.schema_tag_2" rows="3" class="w-full bg-gray-900/50 border border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50"></textarea>
            </div>
          </div>
        </div>

        <!-- Submit and Reset Actions -->
        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-700/50">
          <button 
            type="button" 
            @click="$emit('saved')"
            class="px-5 py-2.5 text-sm font-medium text-gray-400 hover:text-gray-200 hover:bg-gray-800 rounded-xl transition-colors"
          >
            Cancel
          </button>
          <button 
            type="submit" 
            :disabled="loading"
            class="px-6 py-2.5 text-sm font-medium text-white bg-teal-600 hover:bg-teal-500 rounded-xl shadow-lg shadow-teal-500/20 transition-all focus:outline-none focus:ring-2 focus:ring-teal-500/50 flex items-center disabled:opacity-50"
          >
            <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ mode === 'edit' ? 'Update Details' : 'Add' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import CkEditor4 from '@/components/CkEditor4.vue'
import { getPressReleasesDropdown, storePressReleaseDetail, updatePressReleaseDetail } from './api.js'

const props = defineProps({
  mode: { type: String, default: 'add' },
  detail: { type: Object, default: null }
})

const emit = defineEmits(['saved'])

const loading = ref(false)
const pressReleasesList = ref([])

const form = ref({
  press_release_id: '',
  content: '',
  meta_title: '',
  meta_description: '',
  meta_keywords: '',
  canonical_tag: '',
  meta_robots: '',
  hreflang_tags: [],
  open_graph_tags: ['', '', '', '', '', ''],
  twitter_card_tags: ['', '', '', '', '', ''],
  schema_tag: '',
  schema_tag_2: '',
  slug_url: '',
  page_main_title: '',
  breadcrumb_title: '',
})

const addHreflang = () => {
  form.value.hreflang_tags.push('')
}

const removeHreflang = (index) => {
  form.value.hreflang_tags.splice(index, 1)
}

const fetchDropdownData = async () => {
  try {
    pressReleasesList.value = await getPressReleasesDropdown()
  } catch (error) {
    console.error('Error fetching press releases for dropdown:', error)
  }
}

const handleSubmit = async () => {
  loading.value = true
  try {
    if (props.mode === 'edit') {
      await updatePressReleaseDetail(props.detail.id, form.value)
    } else {
      await storePressReleaseDetail(form.value)
    }
    emit('saved')
  } catch (error) {
    console.error('Error submitting form:', error)
    alert(error.response?.data?.message || 'An error occurred while saving.')
  } finally {
    loading.value = false
  }
}

onMounted(async () => {
  await fetchDropdownData()
  
  if (props.mode === 'edit' && props.detail) {
    form.value.press_release_id = props.detail.press_release_id || ''
    form.value.content = props.detail.content || ''
    form.value.meta_title = props.detail.meta_title || ''
    form.value.meta_description = props.detail.meta_description || ''
    form.value.meta_keywords = props.detail.meta_keywords || ''
    form.value.canonical_tag = props.detail.canonical_tag || ''
    form.value.meta_robots = props.detail.meta_robots || ''
    form.value.hreflang_tags = Array.isArray(props.detail.hreflang_tags) ? [...props.detail.hreflang_tags] : []
    form.value.schema_tag = props.detail.schema_tag || ''
    form.value.schema_tag_2 = props.detail.schema_tag_2 || ''
    form.value.slug_url = props.detail.slug_url || ''
    form.value.page_main_title = props.detail.page_main_title || ''
    form.value.breadcrumb_title = props.detail.breadcrumb_title || ''

    if (Array.isArray(props.detail.open_graph_tags)) {
      form.value.open_graph_tags = [...props.detail.open_graph_tags]
    }
    if (Array.isArray(props.detail.twitter_card_tags)) {
      form.value.twitter_card_tags = [...props.detail.twitter_card_tags]
    }
  }
})
</script>
