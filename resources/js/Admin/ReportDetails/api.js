import axios from 'axios';

export const getReportListsDropdown = async (params = {}) => {
    try {
        const response = await axios.get('/admin/report-lists-dropdown', { params });
        return response.data;
    } catch (error) {
        throw error;
    }
};

export const getReportDetails = async (params) => {
    try {
        const response = await axios.get('/admin/report-details', { params });
        return response.data;
    } catch (error) {
        throw error;
    }
};

export const storeReportDetail = async (data) => {
    const formData = new FormData();
    for (const key in data) {
        if (data[key] !== null && data[key] !== undefined) {
            if (['hreflang_tags', 'open_graph_tags', 'twitter_card_tags', 'custom_schema_tags', 'faqs'].includes(key)) {
                formData.append(key, JSON.stringify(data[key]));
            } else {
                formData.append(key, data[key]);
            }
        }
    }

    try {
        const response = await axios.post('/admin/report-details', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        return response.data;
    } catch (error) {
        throw error;
    }
};

export const updateReportDetail = async (id, data) => {
    const formData = new FormData();
    for (const key in data) {
        if (data[key] !== null && data[key] !== undefined) {
            // If it's a file input that hasn't changed, ignore it
            if (key === 'image' && typeof data[key] === 'string') continue; 
            
            if (['hreflang_tags', 'open_graph_tags', 'twitter_card_tags', 'custom_schema_tags', 'faqs'].includes(key)) {
                formData.append(key, JSON.stringify(data[key]));
            } else {
                formData.append(key, data[key]);
            }
        }
    }
    // Laravel method spoofing might not be strictly needed since route is POST, but doesn't hurt if we expect it.
    formData.append('_method', 'PUT');
    
    try {
        const response = await axios.post(`/admin/report-details/${id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        return response.data;
    } catch (error) {
        throw error;
    }
};

export const deleteReportDetail = async (id) => {
    try {
        const response = await axios.delete(`/admin/report-details/${id}`);
        return response.data;
    } catch (error) {
        throw error;
    }
};
