import axios from 'axios'
import { BASE_URL } from '../utils/constants'

const apiClient = axios.create({
  baseURL: BASE_URL,
  headers: {
    'Content-Type': 'application/json',
  },
})

// Lista lekérése
export const fetchClasses = async (queryParams = {}) => {
  try {
    const response = await apiClient.get('/classes', { params: queryParams })
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

// Új osztály létrehozása
export const createClass = async classData => {
  try {
    const response = await apiClient.post('/classes', classData)
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

// Egyes osztály részleteinek lekérése
export const fetchClassById = async id => {
  try {
    const response = await apiClient.get(`/classes/${id}`)
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

// Osztály frissítése
export const updateClassById = async (id, classData) => {
  try {
    const response = await apiClient.put(`/classes/${id}`, classData)
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

// Osztály törlése
export const deleteClassById = async id => {
  try {
    const response = await apiClient.delete(`/classes/${id}`)
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

// Hibakezelés
const handleApiError = error => {
  let errorMessage
  if (error.response) {
    errorMessage = error.response.data
  } else if (error.request) {
    errorMessage = 'No response received from the server.'
  } else {
    errorMessage = 'Error occurred while making the request.'
  }
  console.error('API Error:', errorMessage)
  return errorMessage
}
