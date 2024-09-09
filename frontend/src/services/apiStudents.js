import { apiClient } from './api'

export const fetchStudents = async (queryParams = {}) => {
  try {
    const response = await apiClient.get('/students', { params: queryParams })
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

export const fetchStudentsAll = async id => {
  try {
    const response = await apiClient.get(`/students/${id}/all`)
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

export const createStudent = async studentData => {
  try {
    const response = await apiClient.post('/students', studentData)
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

export const fetchStudentById = async id => {
  try {
    const response = await apiClient.get(`/students/${id}`)
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

export const updateStudentById = async (id, studentData) => {
  try {
    const response = await apiClient.put(`/students/${id}`, studentData)
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

export const deleteStudentById = async id => {
  try {
    const response = await apiClient.delete(`/students/${id}`)
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
