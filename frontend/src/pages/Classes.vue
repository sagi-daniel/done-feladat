<script setup>
import { ref, onMounted, watch } from 'vue'
import { useClassesStore } from '../stores/classes'
import ClassesTable from '../components/features/classes-group/ClassesTable.vue'
import Pagination from '../components/shared/Pagination.vue'
import ClassesForm from '../components/features/classes-group/ClassesForm.vue'
import DeleteAlertModal from '../components/shared/DeleteAlertModal.vue'

const classesStore = useClassesStore()

// Fetch classes on component mount
onMounted(() => {
  classesStore.fetchClasses()
})

// Watch for changes in the current page and refetch classes
watch(
  () => classesStore.currentPage,
  newPage => {
    classesStore.fetchClasses()
  }
)
</script>

<template>
  <section class="size-full md:p-20">
    <ClassesTable :classes="classesStore.classes" />
    <Pagination
      :currentPage="classesStore.currentPage"
      :totalPages="classesStore.totalPages"
      @page-change="classesStore.changePage"
    />
    <ClassesForm />
    <DeleteAlertModal />
  </section>
</template>
