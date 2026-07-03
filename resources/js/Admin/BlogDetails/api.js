import axios from 'axios';

export const getBlogDetails = async (params) => {
    const response = await axios.get('/admin/blog-details-data', { params });
    return response.data;
};

export const storeBlogDetail = async (data) => {
    const response = await axios.post('/admin/blog-details-data', data);
    return response.data;
};

export const updateBlogDetail = async (id, data) => {
    const response = await axios.put(`/admin/blog-details-data/${id}`, data);
    return response.data;
};

export const deleteBlogDetail = async (id) => {
    const response = await axios.delete(`/admin/blog-details-data/${id}`);
    return response.data;
};

export const getBlogsList = async () => {
    const response = await axios.get('/admin/blog-details/blogs-list');
    return response.data;
};
