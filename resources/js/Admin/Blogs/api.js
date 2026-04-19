import axios from 'axios';

export const getBlogs = async (params) => {
    const response = await axios.get('/admin/blogs', { params });
    return response.data;
};

export const storeBlog = async (data) => {
    const formData = new FormData();
    for (const key in data) {
        if (data[key] !== null) {
            formData.append(key, data[key]);
        }
    }
    const response = await axios.post('/admin/blogs', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
    });
    return response.data;
};

export const updateBlog = async (id, data) => {
    const formData = new FormData();
    for (const key in data) {
        if (data[key] !== null) {
            formData.append(key, data[key]);
        }
    }
    // Laravel needs _method=PUT for multipart/form-data updates
    formData.append('_method', 'PUT');
    
    const response = await axios.post(`/admin/blogs/${id}`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
    });
    return response.data;
};

export const deleteBlog = async (id) => {
    const response = await axios.delete(`/admin/blogs/${id}`);
    return response.data;
};
