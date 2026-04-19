import { reactive, ref } from 'vue';

export const formData = reactive({
    blog_id: '',
    title: '',
    description: '',
    meta_title: '',
    meta_description: '',
    meta_keywords: '',
    canonical_tag: '',
    meta_robots: '',
    hreflang_tags: [],
    open_graph_tags: {
        tag_1: '', tag_2: '', tag_3: '', tag_4: '', tag_5: '', tag_6: ''
    },
    twitter_card_tags: {
        tag_1: '', tag_2: '', tag_3: '', tag_4: '', tag_5: '', tag_6: ''
    },
    schema_tag: '',
    schema_tag_2: '',
    schema_tag_3: '',
    faqs: [],
});

export const errors = reactive({});
export const isSubmitting = ref(false);
export const successMessage = ref('');

export const resetForm = () => {
    formData.blog_id = '';
    formData.title = '';
    formData.description = '';
    formData.meta_title = '';
    formData.meta_description = '';
    formData.meta_keywords = '';
    formData.canonical_tag = '';
    formData.meta_robots = '';
    formData.hreflang_tags = [];
    formData.open_graph_tags = { tag_1: '', tag_2: '', tag_3: '', tag_4: '', tag_5: '', tag_6: '' };
    formData.twitter_card_tags = { tag_1: '', tag_2: '', tag_3: '', tag_4: '', tag_5: '', tag_6: '' };
    formData.schema_tag = '';
    formData.schema_tag_2 = '';
    formData.schema_tag_3 = '';
    formData.faqs = [];
    
    for (let key in errors) delete errors[key];
    successMessage.value = '';
};

export const setFormData = (data) => {
    formData.blog_id = data.blog_id || '';
    formData.title = data.title || '';
    formData.description = data.description || '';
    formData.meta_title = data.meta_title || '';
    formData.meta_description = data.meta_description || '';
    formData.meta_keywords = data.meta_keywords || '';
    formData.canonical_tag = data.canonical_tag || '';
    formData.meta_robots = data.meta_robots || '';
    formData.hreflang_tags = Array.isArray(data.hreflang_tags) ? data.hreflang_tags : [];
    formData.open_graph_tags = data.open_graph_tags || { tag_1: '', tag_2: '', tag_3: '', tag_4: '', tag_5: '', tag_6: '' };
    formData.twitter_card_tags = data.twitter_card_tags || { tag_1: '', tag_2: '', tag_3: '', tag_4: '', tag_5: '', tag_6: '' };
    formData.schema_tag = data.schema_tag || '';
    formData.schema_tag_2 = data.schema_tag_2 || '';
    formData.schema_tag_3 = data.schema_tag_3 || '';
    formData.faqs = Array.isArray(data.faqs) ? data.faqs : [];
};
