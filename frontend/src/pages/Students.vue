<script setup>
import { ref, onMounted } from 'vue'
import { useStudentsStore } from '../stores/students'
import { removeAccents } from '../utils/helpers'
import Button from '../components/shared/Button.vue'
import Input from '../components/shared/Input.vue'
import Section from '../components/shared/Section.vue'
import StudentsTable from '../components/features/students-group/StudentsTable.vue'
import Pagination from '../components/shared/Pagination.vue'
import DeleteAlertModal from '../components/shared/DeleteAlertModal.vue'

const isFormModalOpen = ref(false)
const isDeleteModalOpen = ref(false)
const selectedStudent = ref(null)

const studentsStore = useStudentsStore()

onMounted(() => {
  studentsStore.getStudents()
})

const filters = ref({
  name: '',
  phone: '',
  class: '',
  min_average: 1,
  max_average: 5,
})

const applyFilters = async () => {
  const queryParams = {
    name: filters.value.name ? encodeURIComponent(removeAccents(filters.value.name)) : undefined,
    phone: filters.value.phone ? encodeURIComponent(removeAccents(filters.value.phone)) : undefined,
    class: filters.value.class ? encodeURIComponent(removeAccents(filters.value.class)) : undefined,
    min_average: filters.value.min_average ? Number(filters.value.min_average) : undefined,
    max_average: filters.value.max_average ? Number(filters.value.max_average) : undefined,
  }

  const cleanQueryParams = Object.fromEntries(Object.entries(queryParams).filter(([_, v]) => v !== undefined))

  await studentsStore.getStudents(cleanQueryParams)
}

const onDelete = async () => {
  if (selectedStudent.value) {
    await studentsStore.removeStudent(selectedStudent.value.id)
    isDeleteModalOpen.value = false
    filters.value = {
      name: '',
      phone: '',
      class: '',
      min_average: 1,
      max_average: 5,
    }
    await studentsStore.getStudents()
  }
}

const toggleDeleteModal = studentItem => {
  if (studentItem) {
    selectedStudent.value = studentItem
    isDeleteModalOpen.value = !isDeleteModalOpen.value
  }
}

const toggleFormModal = studentItem => {
  if (studentItem) {
    selectedStudent.value = studentItem
    isFormModalOpen.value = !isFormModalOpen.value
  }
}

const toggleDetailsModal = studentItem => {
  if (studentItem) {
    selectedStudent.value = studentItem
  }
}

const onPageChange = async page => {
  await studentsStore.changePage(page, {
    name: filters.value.name ? encodeURIComponent(removeAccents(filters.value.name)) : undefined,
    phone: filters.value.phone ? encodeURIComponent(removeAccents(filters.value.phone)) : undefined,
    class: filters.value.class ? encodeURIComponent(removeAccents(filters.value.class)) : undefined,
    min_average: filters.value.min_average ? Number(filters.value.min_average) : undefined,
    max_average: filters.value.max_average ? Number(filters.value.max_average) : undefined,
  })
}
</script>

<template>
  <Section :isLoading="studentsStore.isLoading">
    <div class="w-full flex justify-between items-center gap-4 py-5">
      <Input type="text" v-model="filters.name" placeholder="Név" />
      <Input type="tel" v-model="filters.phone" placeholder="Telefon" />
      <Input type="text" v-model="filters.class" placeholder="Osztály" />
      <div class="flex justify-center items-center gap-4">
        <Input type="number" v-model="filters.min_average" :min="1" :max="5" placeholder="min átlag" />
        <font-awesome-icon icon="minus" />
        <Input type="number" v-model="filters.max_average" :min="1" :max="5" placeholder="max átlag" />
      </div>
      <div>
        <Button :onClick="applyFilters" className="btn-add">Szűrés</Button>
      </div>
    </div>
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
    <DeleteAlertModal
      :isOpen="isDeleteModalOpen"
      :selectedItem="selectedStudent"
      @handle-delete="onDelete"
      @cancel-delete="toggleDeleteModal"
      ><p class="text-lg text-center">
        Biztosan törölni szeretné a <br />
        <span class="font-semibold">{{ selectedStudent.student_name }} nevű tanulót!</span>?
      </p></DeleteAlertModal
    >
  </Section>
</template>
