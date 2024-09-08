<script setup>
import { ref, onMounted, watch } from 'vue'
import { useStudentsStore } from '../stores/students'
import Section from '../components/shared/Section.vue'
import StudentsTable from '../components/features/students-group/StudentsTable.vue'
import Pagination from '../components/shared/Pagination.vue'
import StudentsForm from '../components/features/students-group/StudentsForm.vue'
import DeleteAlertModal from '../components/shared/DeleteAlertModal.vue'

const studentsStore = useStudentsStore()

const isFormModalOpen = ref(false)
const isDeleteModalOpen = ref(false)

const selectedStudent = ref(null)

onMounted(() => {
  studentsStore.getStudents()
})

const toggleDeleteModal = studentItem => {
  selectedStudent.value = studentItem
  isDeleteModalOpen.value = !isDeleteModalOpen.value
}

const toggleFormModal = studentItem => {
  selectedStudent.value = studentItem
  isFormModalOpen.value = !isFormModalOpen.value
}

const toggleDetailsModal = studentItem => {
  selectedStudent.value = studentItem
}

const onDelete = async () => {
  if (selectedStudent.value) {
    await studentsStore.removeStudent(selectedStudent.value.id)
    isDeleteModalOpen.value = false
  }
}

const onSave = async studentItem => {
  if (selectedStudent.value) {
    await studentsStore.editStudent(selectedStudent.value.id, studentItem)
    isFormModalOpen.value = false
  } else {
    await studentsStore.addStudent(studentItem)
    isFormModalOpen.value = false
  }
}

const onPageChange = async page => {
  await studentsStore.changePage(page)
}
</script>

<template>
  <Section :isLoading="studentsStore.isLoading">
    <StudentsTable
      :students="studentsStore.students"
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
    <StudentsForm
      :isOpen="isFormModalOpen"
      :selectedStudent="selectedStudent"
      @handle-save="onSave"
      @cancel-save="toggleFormModal"
    />
    <DeleteAlertModal
      :isOpen="isDeleteModalOpen"
      :selectedStudent="selectedStudent"
      @handle-delete="onDelete"
      @cancel-delete="toggleDeleteModal"
      ><p class="text-lg text-center">
        Biztosan törölni szeretné a <br />
        <span class="font-semibold">{{ selectedStudent.student_name }} nevű diákot!</span>?
      </p></DeleteAlertModal
    >
  </Section>
</template>
