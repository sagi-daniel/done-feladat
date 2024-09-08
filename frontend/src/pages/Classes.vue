<script setup>
import { ref, onMounted, watch } from 'vue'
import { useClassesStore } from '../stores/classes'
import Section from '../components/shared/Section.vue'
import ClassesTable from '../components/features/classes-group/ClassesTable.vue'
import Pagination from '../components/shared/Pagination.vue'
import DeleteAlertModal from '../components/shared/DeleteAlertModal.vue'

const classesStore = useClassesStore()

const isDeleteModalOpen = ref(false)
const selectedClass = ref(null)

onMounted(() => {
  classesStore.getClasses()
})

const toggleDeleteModal = classItem => {
  selectedClass.value = classItem
  isDeleteModalOpen.value = !isDeleteModalOpen.value
}

const onDelete = async () => {
  if (selectedClass.value) {
    await classesStore.removeClass(selectedClass.value.id)
    isDeleteModalOpen.value = false
  }
}

const onPageChange = async page => {
  await classesStore.changePage(page)
}
</script>

<template>
  <Section :isLoading="classesStore.isLoading">
    <ClassesTable :classes="classesStore.classes" @open-delete-modal="toggleDeleteModal" />
    <Pagination
      :currentPage="classesStore.currentPage"
      :totalPages="classesStore.totalPages"
      :lastPage="classesStore.lastPage"
      @page-change="onPageChange"
    />

    <DeleteAlertModal
      :isOpen="isDeleteModalOpen"
      :selectedClass="selectedClass"
      @handle-delete="onDelete"
      @cancel-delete="toggleDeleteModal"
      ><p class="text-lg text-center">
        Biztosan törölni szeretné a <br />
        <span class="font-semibold">{{ selectedClass.class_name }} nevű osztályt!</span>?
      </p></DeleteAlertModal
    >
  </Section>
</template>
