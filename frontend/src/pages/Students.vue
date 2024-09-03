<script setup>
import { ref, onMounted, watch } from 'vue'
import { useStudentsStore } from '../stores/students'
import StudentsTable from '../components/features/students-group/StudentsTable.vue'
import Pagination from '../components/shared/Pagination.vue'
import StudentsForm from '../components/features/students-group/StudentsForm.vue'
import DeleteAlertModal from '../components/shared/DeleteAlertModal.vue'
import LoadingSpinner from '../components/shared/LoadingSpinner.vue'

const studentsStore = useStudentsStore()

const isFormModalOpen = ref(false)
const isDeleteModalOpen = ref(false)
const selectedStudent = ref(null)

onMounted(() => {
  studentsStore.getStudents()
})

watch(
  () => studentsStore.currentPage,
  () => {
    studentsStore.getStudents()
  }
)

const toggleDeleteModal = studentItem => {
  selectedStudent.value = studentItem
  isDeleteModalOpen.value = !isDeleteModalOpen.value
}

const toggleFormModal = studentItem => {
  selectedStudent.value = studentItem
  isFormModalOpen.value = !isFormModalOpen.value
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
  <section class="size-full flex flex-col justify-between md:p-20">
    <div v-if="studentsStore.isLoading">
      <LoadingSpinner />
    </div>
    <div v-else>
      <StudentsTable
        :students="studentsStore.students"
        @open-form-modal="toggleFormModal"
        @open-delete-modal="toggleDeleteModal"
      />
      <Pagination
        :currentPage="studentsStore.currentPage"
        :totalPages="studentsStore.totalPages"
        @page-change="onPageChange"
      />
    </div>
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
  </section>
</template>
