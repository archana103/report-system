import { reactive, ref } from 'vue';

export const formData = reactive({
    report_category_id: '',
    name: '',
    status: 'Active',
});

export const errors = reactive({});
export const isSubmitting = ref(false);
export const successMessage = ref('');

export const setFormData = (data) => {
    formData.report_category_id = data.report_category_id || '';
    formData.name = data.name || '';
    formData.status = data.status || 'Active';
};

export const resetForm = () => {
    formData.report_category_id = '';
    formData.name = '';
    formData.status = 'Active';
    for (let key in errors) {
        delete errors[key];
    }
    successMessage.value = '';
};
