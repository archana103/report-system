import axios from 'axios'

export const getPressReleases = async (params) => {
  try {
    const response = await axios.get('/admin/press-releases', { params })
    return response.data
  } catch (error) {
    throw error
  }
}

export const storePressRelease = async (data) => {
  try {
    const response = await axios.post('/admin/press-releases', data, {
        headers: { 'Content-Type': 'multipart/form-data' }
    })
    return response.data
  } catch (error) {
    throw error
  }
}

export const updatePressRelease = async (id, data) => {
  try {
    const response = await axios.post(`/admin/press-releases/${id}`, data, {
        headers: { 'Content-Type': 'multipart/form-data' }
    })
    return response.data
  } catch (error) {
    throw error
  }
}

export const deletePressRelease = async (id) => {
  try {
    const response = await axios.delete(`/admin/press-releases/${id}`)
    return response.data
  } catch (error) {
    throw error
  }
}
