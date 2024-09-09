import { apiClient } from './api'

export const fetchClasses = async (queryParams = {}) => {
  try {
    const response = await apiClient.get('/classes', { params: queryParams })
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

export const fetchAllClasses = async () => {
  try {
    const response = await apiClient.get('/classes/all')
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

export const createClass = async classData => {
  try {
    const response = await apiClient.post('/classes', classData)
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

export const fetchClassById = async id => {
  try {
    const response = await apiClient.get(`/classes/${id}`)
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

export const updateClassById = async (id, classData) => {
  try {
    const response = await apiClient.put(`/classes/${id}`, classData)
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

export const deleteClassById = async id => {
  try {
    const response = await apiClient.delete(`/classes/${id}`)
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

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
