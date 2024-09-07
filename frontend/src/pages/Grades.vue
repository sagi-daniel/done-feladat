<script setup>
import { ref, onMounted, watch } from 'vue'
import { useGradesStore } from '../stores/grades'
import GradesTable from '../components/features/grades-group/GradesTable.vue'
import Pagination from '../components/shared/Pagination.vue'
import GradesForm from '../components/features/grades-group/GradesForm.vue'
import DeleteAlertModal from '../components/shared/DeleteAlertModal.vue'
import LoadingSpinner from '../components/shared/LoadingSpinner.vue'

const gradesStore = useGradesStore()

const isFormModalOpen = ref(false)
const isDeleteModalOpen = ref(false)
const selectedGrade = ref(null)

onMounted(() => {
  gradesStore.getGrades()
})

watch(
  () => gradesStore.currentPage,
  () => {
    gradesStore.getGrades()
  }
)

const toggleDeleteModal = gradeItem => {
  selectedGrade.value = gradeItem
  isDeleteModalOpen.value = !isDeleteModalOpen.value
}

const toggleFormModal = gradeItem => {
  selectedGrade.value = gradeItem
  isFormModalOpen.value = !isFormModalOpen.value
}

const onDelete = async () => {
  if (selectedGrade.value) {
    await gradesStore.removeGrade(selectedGrade.value.id)
    isDeleteModalOpen.value = false
  }
}

const onSave = async gradeItem => {
  if (selectedGrade.value) {
    await gradesStore.editGrade(selectedGrade.value.id, gradeItem)
    isFormModalOpen.value = false
  } else {
    await gradesStore.addGrade(gradeItem)
    isFormModalOpen.value = false
  }
}

const onPageChange = async page => {
  await gradesStore.changePage(page)
}
</script>

<template>
  <section class="size-full flex flex-col justify-between md:p-20">
    <div v-if="gradesStore.isLoading">
      <LoadingSpinner />
    </div>
    <div v-else>
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
    </div>
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
      <p v-if="selectedGrade && selectedGrade.subject" class="text-lg text-center">
        Biztosan törölni szeretné a <br />
        <span class="font-semibold">
          {{ `${selectedGrade.subject.subject_name} ${selectedGrade.grade}` }} érdemjegyet!
        </span>
        ?
      </p>
      <p v-else class="text-lg text-center">Nincs kiválasztott érdemjegy!</p>
    </DeleteAlertModal>
  </section>
</template>
