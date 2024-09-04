<script setup>
import { useRouter } from 'vue-router'
import GradesTable from '../grades-group/GradesTable.vue'

const studentGrades = ref()

const router = useRouter()

//TODO bal felülre visszanyíl
const onClose = () => {
  router.push(`/students`)
}
</script>

<template>
  <section class="size-full flex flex-col justify-between md:p-20">
    <!-- <div v-if="studentsStore.isLoading">
      <LoadingSpinner />
    </div>
    <div v-else> -->
    <GradesTable
      :grades="studentsStore.students"
      @open-form-modal="toggleFormModal"
      @open-delete-modal="toggleDeleteModal"
      @open-details-modal="toggleDetailsModal"
    />
    <Pagination
      :currentPage="studentsStore.currentPage"
      :totalPages="studentsStore.totalPages"
      :lastPage="studentsStore.lastPage"
      @page-change="onPageChange"
    />
    <!-- </div> -->
  </section>
</template>
