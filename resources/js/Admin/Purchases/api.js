import axios from 'axios'

export const getPurchasesData = async (params) => {
  const response = await axios.get('/admin/purchases-data', { params })
  return response.data
}

export const deletePurchase = async (id) => {
  const response = await axios.delete(`/admin/purchases-data/${id}`)
  return response.data
}
