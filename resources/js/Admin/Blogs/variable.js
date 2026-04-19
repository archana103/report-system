import { reactive, ref } from 'vue';

export const formData = reactive({
    title: '',
    description: '',
    url: '',
    author_name: '',
    image: null,
});

export const errors = reactive({});
export const isSubmitting = ref(false);
export const successMessage = ref('');

export const resetForm = () => {
    formData.title = '';
    formData.description = '';
    formData.url = '';
    formData.author_name = '';
    formData.image = null;
    
    for (let key in errors) delete errors[key];
    successMessage.value = '';
};

export const setFormData = (data) => {
    formData.title = data.title || '';
    formData.description = data.description || '';
    formData.url = data.url || '';
    formData.author_name = data.author_name || '';
    formData.image = null; // Don't pre-fill image file input
};
