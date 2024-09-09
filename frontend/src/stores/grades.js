import { defineStore } from 'pinia'
import { fetchGrades, createGrade, fetchGradeById, updateGradeById, deleteGradeById } from '../services/apiGrades'

export const useGradesStore = defineStore('grades', {
  state: () => ({
    grades: [],
    gradeDetails: null,
    totalItems: 0,
    currentPage: 1,
    lastPage: 1,
    perPage: 10,
    isLoading: false,
    error: null,
  }),

  actions: {
    async getGrades(queryParams = {}) {
      this.isLoading = true
      this.error = null

      try {
        const params = {
          page: this.currentPage,
          perPage: this.perPage,
          ...queryParams,
        }

        const response = await fetchGrades(params)

        this.grades = response.data
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

    async getGradeById(id) {
      this.isLoading = true
      this.error = null

      try {
        const response = await fetchGradeById(id)
        this.gradeDetails = response
      } catch (error) {
        this.error = error
      } finally {
        this.isLoading = false
      }
    },

    async addGrade(gradeData) {
      this.isLoading = true
      this.error = null

      try {
        await createGrade(gradeData)
        await this.getGrades()
      } catch (error) {
        this.error = error
      } finally {
        this.isLoading = false
      }
    },

    async editGrade(id, gradeData) {
      this.isLoading = true
      this.error = null

      try {
        await updateGradeById(id, gradeData)
        await this.getGrades()
      } catch (error) {
        this.error = error
      } finally {
        this.isLoading = false
      }
    },

    async removeGrade(id) {
      this.isLoading = true
      this.error = null

      try {
        await deleteGradeById(id)
        await this.getGrades()
      } catch (error) {
        this.error = error
      } finally {
        this.isLoading = false
      }
    },

    async changePage(page) {
      this.currentPage = page
      await this.getGrades()
    },
  },

  getters: {
    totalPages: state => state.lastPage,
  },
})
