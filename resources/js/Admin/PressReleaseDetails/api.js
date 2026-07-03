import axios from 'axios'

export const getPressReleaseDetails = async (params) => {
  try {
    const response = await axios.get('/admin/press-release-details-data', { params })
    return response.data
  } catch (error) {
    throw error
  }
}

export const getPressReleasesDropdown = async (params) => {
  try {
    const response = await axios.get('/admin/press-releases-dropdown', { params })
    return response.data
  } catch (error) {
    throw error
  }
}

export const storePressReleaseDetail = async (data) => {
  try {
    const response = await axios.post('/admin/press-release-details-data', data)
    return response.data
  } catch (error) {
    throw error
  }
}

export const updatePressReleaseDetail = async (id, data) => {
  try {
    const response = await axios.put(`/admin/press-release-details-data/${id}`, data)
    return response.data
  } catch (error) {
    throw error
  }
}

export const deletePressReleaseDetail = async (id) => {
  try {
    const response = await axios.delete(`/admin/press-release-details-data/${id}`)
    return response.data
  } catch (error) {
    throw error
  }
}
