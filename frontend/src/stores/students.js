import { defineStore } from 'pinia'
import {
  fetchStudents,
  createStudent,
  fetchStudentById,
  updateStudentById,
  deleteStudentById,
} from '../services/apiStudents'

export const useStudentsStore = defineStore('students', {
  state: () => ({
    students: [],
    totalItems: 0,
    currentPage: 1,
    lastPage: 1,
    perPage: 10,
    isLoading: false,
    error: null,
    studentDetails: null,
  }),

  actions: {
    async getStudents(queryParams = {}) {
      this.isLoading = true
      this.error = null

      try {
        const params = {
          page: this.currentPage,
          perPage: this.perPage,
          ...queryParams,
        }

        const response = await fetchStudents(params)

        this.students = response.data
        this.totalItems = response.totalItems
        this.currentPage = response.currentPage
        this.lastPage = response.lastPage
        this.perPage = response.perPage
      } catch (error) {
        this.error = error
      } finally {
        this.isLoading = false
      }
    },

    async getStudentById(id) {
      this.isLoading = true
      this.error = null

      try {
        const response = await fetchStudentById(id)
        this.studentDetails = response
      } catch (error) {
        this.error = error
      } finally {
        this.isLoading = false
      }
    },

    async addStudent(studentData) {
      this.isLoading = true
      this.error = null

      try {
        await createStudent(studentData)
        await this.getStudents()
      } catch (error) {
        this.error = error
      } finally {
        this.isLoading = false
      }
    },

    async editStudent(id, studentData) {
      this.isLoading = true
      this.error = null

      try {
        await updateStudentById(id, studentData)
        await this.getStudents()
      } catch (error) {
        this.error = error
      } finally {
        this.isLoading = false
      }
    },

    async removeStudent(id) {
      this.isLoading = true
      this.error = null

      try {
        await deleteStudentById(id)
        await this.getStudents()
      } catch (error) {
        this.error = error
      } finally {
        this.isLoading = false
      }
    },

    async changePage(page) {
      this.currentPage = page
      await this.getStudents()
    },
  },

  getters: {
    totalPages: state => state.lastPage,
    studentCount: state => state.students.length,
  },
})
