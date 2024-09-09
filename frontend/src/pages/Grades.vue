<script setup>
import { ref, onMounted } from 'vue'
import { useGradesStore } from '../stores/grades'
import { SUBJECTS } from '../utils/constants'
import { removeAccents } from '../utils/helpers'
import Button from '../components/shared/Button.vue'
import Input from '../components/shared/Input.vue'
import SelectInput from '../components/shared/SelectInput.vue'
import Section from '../components/shared/Section.vue'
import GradesTable from '../components/features/grades-group/GradesTable.vue'
import Pagination from '../components/shared/Pagination.vue'
import GradesForm from '../components/features/grades-group/GradesForm.vue'
import DeleteAlertModal from '../components/shared/DeleteAlertModal.vue'

const gradesStore = useGradesStore()

const isFormModalOpen = ref(false)
const isDeleteModalOpen = ref(false)
const selectedGrade = ref(null)

onMounted(() => {
  gradesStore.getGrades()
})

const filters = ref({
  name: '',
  subject: '',
  class: '',
  min_grade: 1,
  max_grade: 5,
})

const applyFilters = async () => {
  const queryParams = {
    name: filters.value.name ? encodeURIComponent(removeAccents(filters.value.name)) : undefined,
    subject: filters.value.subject ? encodeURIComponent(removeAccents(filters.value.subject)) : undefined,
    class: filters.value.class ? encodeURIComponent(removeAccents(filters.value.class)) : undefined,
    min_grade: filters.value.min_grade ? Number(filters.value.min_grade) : undefined,
    max_grade: filters.value.max_grade ? Number(filters.value.max_grade) : undefined,
  }

  const cleanQueryParams = Object.fromEntries(Object.entries(queryParams).filter(([_, v]) => v !== undefined))

  await gradesStore.getGrades(cleanQueryParams)
}

const toggleDeleteModal = gradeItem => {
  selectedGrade.value = gradeItem
  isDeleteModalOpen.value = !isDeleteModalOpen.value
}

const toggleFormModal = gradeItem => {
  selectedGrade.value = gradeItem
  isFormModalOpen.value = !isFormModalOpen.value
}

const onSave = async gradeItem => {
  if (gradeItem) {
    const saveGrade = {
      student_id: parseInt(gradeItem.student_id),
      subject_id: parseInt(gradeItem.subject),
      grade: parseInt(gradeItem.grade),
      date: gradeItem.date,
    }
    await gradesStore.addGrade(saveGrade)
    isFormModalOpen.value = false
  }
}

const onDelete = async () => {
  if (selectedGrade.value) {
    await gradesStore.removeGrade(selectedGrade.value.id)
    isDeleteModalOpen.value = false
    filters.value = {
      name: '',
      subject: '',
      class: '',
      min_grade: 1,
      max_grade: 5,
    }
    await gradesStore.getGrades()
  }
}

const onPageChange = async page => {
  await gradesStore.changePage(page, {
    name: filters.value.name ? encodeURIComponent(removeAccents(filters.value.name)) : undefined,
    subject: filters.value.subject ? encodeURIComponent(removeAccents(filters.value.subject)) : undefined,
    class: filters.value.class ? encodeURIComponent(removeAccents(filters.value.class)) : undefined,
    min_grade: filters.value.min_grade ? Number(filters.value.min_grade) : undefined,
    max_grade: filters.value.max_grade ? Number(filters.value.max_grade) : undefined,
  })
}
</script>

<template>
  <Section :isLoading="gradesStore.isLoading">
    <div class="w-full flex justify-between items-center gap-4 py-5">
      <Input type="text" v-model="filters.name" placeholder="Név" />
      <Input type="text" v-model="filters.subject" placeholder="Tantárgy" />
      <Input type="text" v-model="filters.class" placeholder="Osztály" />
      <div class="flex justify-center items-center gap-4">
        <Input type="number" v-model="filters.min_grade" :min="1" :max="5" placeholder="min átlag" />
        <font-awesome-icon icon="minus" />
        <Input type="number" v-model="filters.max_grade" :min="1" :max="5" placeholder="max átlag" />
      </div>

      <Button :onClick="applyFilters" className="btn-add">Szűrés</Button>
    </div>

    <GradesTable
      :grades="gradesStore.grades"
      @open-form-modal="toggleFormModal"
      @open-delete-modal="toggleDeleteModal"
    />
    <Pagination
      :currentPage="gradesStore.currentPage"
      :totalPages="gradesStore.totalPages"
      :lastPage="gradesStore.lastPage"
      @page-change="onPageChange"
    />
    <GradesForm
      :isOpen="isFormModalOpen"
      :selectedGrade="selectedGrade"
      @handle-save="onSave"
      @cancel-save="toggleFormModal"
    />
    <DeleteAlertModal
      :isOpen="isDeleteModalOpen"
      :selectedGrade="selectedGrade"
      @handle-delete="onDelete"
      @cancel-delete="toggleDeleteModal"
    >
      <p class="text-lg text-center">
        Biztosan törölni szeretné a <br />
        <span class="font-semibold">
          {{ `${selectedGrade.subject.subject_name} ${selectedGrade.grade}` }} érdemjegyet!
        </span>
        ?
      </p>
    </DeleteAlertModal>
  </Section>
</template>
