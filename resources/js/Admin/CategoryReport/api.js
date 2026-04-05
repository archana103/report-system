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
