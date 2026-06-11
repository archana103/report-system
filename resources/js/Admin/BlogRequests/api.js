import axios from 'axios'

export const getBlogRequests = async (params) => {
  try {
    const response = await axios.get('/admin/blog-requests', { params })
    return response.data
  } catch (error) {
    throw error
  }
}

export const deleteBlogRequest = async (id) => {
  try {
    const response = await axios.delete(`/admin/blog-requests/${id}`)
    return response.data
  } catch (error) {
    throw error
  }
}
