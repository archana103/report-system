import axios from 'axios';

export const storeReportCategory = async (data) => {
    const formData = new FormData();
    for (const key in data) {
        if (data[key] !== null && data[key] !== undefined) {
            formData.append(key, data[key]);
        }
    }

    try {
        const response = await axios.post('/admin/report-categories', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        return response.data;
    } catch (error) {
        throw error;
    }
};

export const getReportCategories = async (params) => {
    try {
        const response = await axios.get('/admin/report-categories', { params });
        return response.data;
    } catch (error) {
        throw error;
    }
};

export const updateReportCategory = async (id, data) => {
    const formData = new FormData();
    for (const key in data) {
        if (data[key] !== null && data[key] !== undefined) {
            formData.append(key, data[key]);
        }
    }
    // Laravel spoofing for PUT request with FormData
    formData.append('_method', 'PUT');

    try {
        const response = await axios.post(`/admin/report-categories/${id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        return response.data;
    } catch (error) {
        throw error;
    }
};

export const deleteReportCategory = async (id) => {
    try {
        const response = await axios.delete(`/admin/report-categories/${id}`);
        return response.data;
    } catch (error) {
        throw error;
    }
};
