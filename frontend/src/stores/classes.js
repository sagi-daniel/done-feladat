import { defineStore } from 'pinia'
import { getClasses, createClass, getClassById, updateClass, deleteClass } from '../services/apiClasses'

export const useClassesStore = defineStore('classes', {
  state: () => ({
    classes: [],
    totalItems: 0,
    currentPage: 1,
    lastPage: 1,
    perPage: 10,
    isLoading: false,
    error: null,
    classDetails: null,
  }),

  actions: {
    async fetchClasses(queryParams = {}) {
      this.isLoading = true
      this.error = null

      try {
        // Merge the queryParams with pagination settings
        const params = {
          page: this.currentPage,
          perPage: this.perPage,
          ...queryParams,
        }

        const response = await getClasses(params)

        // Update state with response data
        this.classes = response.data
        this.totalItems = response.totalItems
        this.currentPage = response.currentPage
        this.lastPage = response.lastPage
        this.perPage = response.perPage
      } catch (error) {
        this.handleError(error)
      } finally {
        this.isLoading = false
      }
    },

    async fetchClassById(id) {
      this.isLoading = true
      this.error = null

      try {
        const response = await getClassById(id)
        this.classDetails = response
      } catch (error) {
        this.handleError(error)
      } finally {
        this.isLoading = false
      }
    },

    async createNewClass(classData) {
      this.isLoading = true
      this.error = null

      try {
        const response = await createClass(classData)
        this.classes.push(response) // Optionally add the new class to the list
      } catch (error) {
        this.handleError(error)
      } finally {
        this.isLoading = false
      }
    },

    async updateExistingClass(id, classData) {
      this.isLoading = true
      this.error = null

      try {
        const response = await updateClass(id, classData)
        this.classes = this.classes.map(cls => (cls.id === id ? response : cls))
      } catch (error) {
        this.handleError(error)
      } finally {
        this.isLoading = false
      }
    },

    async deleteClassById(id) {
      this.isLoading = true
      this.error = null

      try {
        await deleteClass(id)
        this.classes = this.classes.filter(cls => cls.id !== id)
      } catch (error) {
        this.handleError(error)
      } finally {
        this.isLoading = false
      }
    },

    // Action to handle page changes
    async changePage(page) {
      this.currentPage = page
      await this.fetchClasses()
    },

    handleError(error) {
      if (error.response) {
        this.error = error.response.data
      } else if (error.request) {
        this.error = 'No response received from the server.'
      } else {
        this.error = 'Error occurred while making the request.'
      }
      console.error('API Error:', this.error)
    },
  },

  getters: {
    totalPages: state => state.lastPage,
    classCount: state => state.classes.length,
  },
})
