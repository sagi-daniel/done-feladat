<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useClassesStore } from '../stores/classes'
import Pagination from '../components/shared/Pagination.vue'
import LoadingSpinner from '../components/shared/LoadingSpinner.vue'

const classesStore = useClassesStore()

const isFormModalOpen = ref(false)
const isDeleteModalOpen = ref(false)
const selectedClass = ref(null)

const router = useRouter()

onMounted(() => {
  classesStore.getClasses()
})

watch(
  () => classesStore.currentPage,
  () => {
    classesStore.getClasses()
  }
)

const toggleDeleteModal = classItem => {
  selectedClass.value = classItem
  isDeleteModalOpen.value = !isDeleteModalOpen.value
}

const toggleFormModal = classItem => {
  selectedClass.value = classItem
  isFormModalOpen.value = !isFormModalOpen.value
}

const onSave = async classItem => {}

//TODO bal felülre visszanyíl
const onClose = () => {
  router.push(`/classes`)
}

const onPageChange = async page => {
  await classesStore.changePage(page)
}
</script>

<template>
  <section class="size-full flex flex-col justify-between md:p-20">
    <div v-if="studentsStore.isLoading">
      <LoadingSpinner />
    </div>
    <div v-else></div>
  </section>
</template>
