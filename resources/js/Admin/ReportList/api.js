import axios from 'axios';

export const getCategoriesDropdown = async () => {
    try {
        const response = await axios.get('/admin/report-categories-dropdown');
        return response.data;
    } catch (error) {
        throw error;
    }
};

export const getReportLists = async (params) => {
    try {
        const response = await axios.get('/admin/report-lists', { params });
        return response.data;
    } catch (error) {
        throw error;
    }
};

export const storeReportList = async (data) => {
    try {
        const response = await axios.post('/admin/report-lists', data);
        return response.data;
    } catch (error) {
        throw error;
    }
};

export const updateReportList = async (id, data) => {
    try {
        const response = await axios.put(`/admin/report-lists/${id}`, data);
        return response.data;
    } catch (error) {
        throw error;
    }
};

export const deleteReportList = async (id) => {
    try {
        const response = await axios.delete(`/admin/report-lists/${id}`);
        return response.data;
    } catch (error) {
        throw error;
    }
};
