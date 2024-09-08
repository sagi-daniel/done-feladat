import { defineStore } from 'pinia'
import { fetchGradesByStudent } from '../services/apiGrades'

export const useStudentGradesStore = defineStore('studentGrades', {
  state: () => ({
    studentGrades: [],
    totalItems: 0,
    currentPage: 1,
    lastPage: 1,
    perPage: 10,
    isLoading: false,
    error: null,
  }),

  actions: {
    async getStudentById(id) {
      this.isLoading = true
      this.error = null

      try {
        const params = {
          page: this.currentPage,
          perPage: this.perPage,
        }

        const response = await fetchGradesByStudent(id, params)

        this.studentGrades = response.data
        this.totalItems = response.totalItems
        this.currentPage = response.currentPage
        this.lastPage = response.lastPage
      } catch (error) {
        this.error = error
      } finally {
        this.isLoading = false
      }
    },

    async changePage(page) {
      this.currentPage = page
      await this.getStudentById(route.params.id, page)
    },
  },

  getters: {
    totalPages: state => state.lastPage,
  },
})
