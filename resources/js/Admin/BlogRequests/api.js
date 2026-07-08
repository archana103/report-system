import axios from 'axios'

export const getBlogRequests = async (params) => {
  try {
    const response = await axios.get('/admin/blog-requests-data', { params })
    return response.data
  } catch (error) {
    throw error
  }
}

export const deleteBlogRequest = async (id) => {
  try {
    const response = await axios.delete(`/admin/blog-requests-data/${id}`)
    return response.data
  } catch (error) {
    throw error
  }
}
