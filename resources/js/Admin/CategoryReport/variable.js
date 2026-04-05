import { reactive, ref } from 'vue';

export const formData = reactive({
    name: '',
    status: '',
    main_heading: '',
    main_subheading: '',
    category_image: null,
    category_icon: null
});

export const errors = reactive({});
export const isSubmitting = ref(false);
export const successMessage = ref('');

export const resetForm = () => {
    formData.name = '';
    formData.status = '';
    formData.main_heading = '';
    formData.main_subheading = '';
    formData.category_image = null;
    formData.category_icon = null;
    
    for (let key in errors) {
        delete errors[key];
    }
};
