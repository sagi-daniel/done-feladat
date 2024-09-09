import { defineStore } from 'pinia'
import {
  fetchClasses,
  fetchAllClasses,
  createClass,
  fetchClassById,
  updateClassById,
  deleteClassById,
} from '../services/apiClasses'

export const useClassesStore = defineStore('classes', {
  state: () => ({
    classes: [],
    allClasses: [],
    totalItems: 0,
    currentPage: 1,
    lastPage: 1,
    perPage: 10,
    isLoading: false,
    error: null,
    classDetails: null,
  }),

  actions: {
    async getClasses(queryParams = {}) {
      this.isLoading = true
      this.error = null

      try {
        const params = {
          page: this.currentPage,
          perPage: this.perPage,
          ...queryParams,
        }

        const response = await fetchClasses(params)

        this.classes = response.data
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

    async getAllClasses() {
      this.isLoading = true
      this.error = null

      try {
        const response = await fetchAllClasses()
        this.allClasses = response.data
      } catch (error) {
        this.error = error
      } finally {
        this.isLoading = false
      }
    },

    async getClassById(id) {
      this.isLoading = true
      this.error = null

      try {
        const response = await fetchClassById(id)
        this.classDetails = response
      } catch (error) {
        this.error = error
      } finally {
        this.isLoading = false
      }
    },

    async addClass(classData) {
      this.isLoading = true
      this.error = null

      try {
        await createClass(classData)
        await this.getClasses()
      } catch (error) {
        this.error = error
      } finally {
        this.isLoading = false
      }
    },

    async editClass(id, classData) {
      this.isLoading = true
      this.error = null

      try {
        await updateClassById(id, classData)
        await this.getClasses()
      } catch (error) {
        this.error = error
      } finally {
        this.isLoading = false
      }
    },

    async removeClass(id) {
      this.isLoading = true
      this.error = null

      try {
        await deleteClassById(id)
        await this.getClasses()
      } catch (error) {
        this.error = error
      } finally {
        this.isLoading = false
      }
    },

    async changePage(page) {
      this.currentPage = page
      await this.getClasses()
    },
  },

  getters: {
    totalPages: state => state.lastPage,
    classCount: state => state.classes.length,
  },
})
