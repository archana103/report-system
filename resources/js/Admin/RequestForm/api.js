import axios from 'axios'

export const getRequestForms = async (params) => {
  try {
    const response = await axios.get('/admin/request-forms', { params })
    return response.data
  } catch (error) {
    throw error
  }
}

export const deleteRequestForm = async (id) => {
  try {
    const response = await axios.delete(`/admin/request-forms/${id}`)
    return response.data
  } catch (error) {
    throw error
  }
}
