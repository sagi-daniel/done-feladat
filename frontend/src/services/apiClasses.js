import axios from 'axios'
import { BASE_URL } from '../utils/constants'

const apiClient = axios.create({
  baseURL: BASE_URL,
  headers: {
    'Content-Type': 'application/json',
  },
})

// GET kérés a lista lekéréséhez
export const getClasses = async (queryParams = {}) => {
  try {
    const response = await apiClient.get('/classes', { params: queryParams })
    return response.data
  } catch (error) {
    handleError(error)
  }
}

// POST kérés az új osztály létrehozásához
export const createClass = async classData => {
  try {
    const response = await apiClient.post('/classes', classData)
    return response.data
  } catch (error) {
    handleError(error)
  }
}

// GET kérés az egyes osztályok részleteinek lekéréséhez
export const getClassById = async id => {
  try {
    const response = await apiClient.get(`/classes/${id}`)
    return response.data
  } catch (error) {
    handleError(error)
  }
}

// PUT kérés az osztály frissítéséhez
export const updateClass = async (id, classData) => {
  try {
    const response = await apiClient.put(`/classes/${id}`, classData)
    return response.data
  } catch (error) {
    handleError(error)
  }
}

// DELETE kérés az osztály törléséhez
export const deleteClass = async id => {
  try {
    const response = await apiClient.delete(`/classes/${id}`)
    return response.data
  } catch (error) {
    handleError(error)
  }
}

// Hibakezelő funkció
const handleError = error => {
  if (error.response) {
    // A válasz kódja az API-tól
    console.error('API hiba:', error.response.data)
  } else if (error.request) {
    // Ha nem érkezett válasz az API-tól
    console.error('API kérés hiba:', error.request)
  } else {
    // Kérés előtti hiba
    console.error('API kérés hiba:', error.message)
  }
}
