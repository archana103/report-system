import axios from 'axios'

export const getContactUsData = async (params) => {
  try {
    const response = await axios.get('/admin/contact-us-data', { params })
    return response.data
  } catch (error) {
    throw error
  }
}
