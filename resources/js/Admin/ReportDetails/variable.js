import { reactive, ref } from 'vue';

export const formData = reactive({
    report_list_id: '',
    title: '',
    description: '',
    table_of_contents: '',
    category_list_download: '',
    single_user_license_cost: '',
    team_user_license_cost: '',
    enterprise_user_license_cost: '',
    download_text: '',
    image: null,
    status: 'Active',
    slug_url: '',
    breadcrumb_title: '',
    page_main_title: '',
    report_sku: '',
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
    custom_schema_tags: [],
    faqs: [],
});

export const errors = reactive({});
export const isSubmitting = ref(false);
export const successMessage = ref('');

export const setFormData = (data) => {
    formData.report_list_id = data.report_list_id || '';
    formData.title = data.title || '';
    formData.description = data.description || '';
    formData.table_of_contents = data.table_of_contents || '';
    formData.category_list_download = data.category_list_download || '';
    formData.single_user_license_cost = data.single_user_license_cost || '';
    formData.team_user_license_cost = data.team_user_license_cost || '';
    formData.enterprise_user_license_cost = data.enterprise_user_license_cost || '';
    formData.download_text = data.download_text || '';
    formData.image = data.image || null;
    formData.status = data.status || 'Active';
    formData.slug_url = data.slug_url || '';
    formData.breadcrumb_title = data.breadcrumb_title || '';
    formData.page_main_title = data.page_main_title || '';
    formData.report_sku = data.report_sku || '';
    formData.meta_title = data.meta_title || '';
    formData.meta_description = data.meta_description || '';
    formData.meta_keywords = data.meta_keywords || '';
    formData.canonical_tag = data.canonical_tag || '';
    formData.meta_robots = data.meta_robots || '';
    formData.hreflang_tags = Array.isArray(data.hreflang_tags) ? [...data.hreflang_tags] : [];
    formData.open_graph_tags = Array.isArray(data.open_graph_tags) && data.open_graph_tags.length === 6 ? [...data.open_graph_tags] : ['', '', '', '', '', ''];
    formData.twitter_card_tags = Array.isArray(data.twitter_card_tags) && data.twitter_card_tags.length === 6 ? [...data.twitter_card_tags] : ['', '', '', '', '', ''];
    formData.schema_tag = data.schema_tag || '';
    formData.schema_tag_2 = data.schema_tag_2 || '';
    formData.custom_schema_tags = Array.isArray(data.custom_schema_tags) ? [...data.custom_schema_tags] : [];
    formData.faqs = Array.isArray(data.faqs) ? [...data.faqs] : [];
};

export const resetForm = () => {
    formData.report_list_id = '';
    formData.title = '';
    formData.description = '';
    formData.table_of_contents = '';
    formData.category_list_download = '';
    formData.single_user_license_cost = '';
    formData.team_user_license_cost = '';
    formData.enterprise_user_license_cost = '';
    formData.download_text = '';
    formData.image = null;
    formData.status = 'Active';
    formData.slug_url = '';
    formData.breadcrumb_title = '';
    formData.page_main_title = '';
    formData.report_sku = '';
    formData.meta_title = '';
    formData.meta_description = '';
    formData.meta_keywords = '';
    formData.canonical_tag = '';
    formData.meta_robots = '';
    formData.hreflang_tags = [];
    formData.open_graph_tags = ['', '', '', '', '', ''];
    formData.twitter_card_tags = ['', '', '', '', '', ''];
    formData.schema_tag = '';
    formData.schema_tag_2 = '';
    formData.custom_schema_tags = [];
    formData.faqs = [];
    for (let key in errors) {
        delete errors[key];
    }
    successMessage.value = '';
};
