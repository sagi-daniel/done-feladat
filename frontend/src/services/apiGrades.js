import { apiClient } from './api'

export const fetchGrades = async (queryParams = {}) => {
  try {
    const response = await apiClient.get('/grades', { params: queryParams })
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

export const createGrade = async gradeData => {
  try {
    const response = await apiClient.post('/grades', gradeData)
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

export const fetchGradeById = async id => {
  try {
    const response = await apiClient.get(`/grades/${id}`)
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

export const fetchGradesByStudent = async (id, queryParams = {}) => {
  try {
    const response = await apiClient.get(`/students/${id}/grades`, { params: queryParams })
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

export const updateGradeById = async (id, gradeData) => {
  try {
    const response = await apiClient.put(`/grades/${id}`, gradeData)
    return response.data
  } catch (error) {
    throw handleApiError(error)
  }
}

export const deleteGradeById = async id => {
  try {
    const response = await apiClient.delete(`/grades/${id}`)
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
