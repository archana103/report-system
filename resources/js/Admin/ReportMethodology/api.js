import axios from 'axios';

export const getReportMethodology = async () => {
    const response = await axios.get('/admin/report-methodology-data');
    return response.data;
};

export const storeReportMethodology = async (data) => {
    const response = await axios.post('/admin/report-methodology-data', data);
    return response.data;
};
