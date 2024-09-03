<script setup>
import { ref, onMounted, watch } from 'vue'
import { useClassesStore } from '../stores/classes'
import ClassesTable from '../components/features/classes-group/ClassesTable.vue'
import Pagination from '../components/shared/Pagination.vue'
import ClassesForm from '../components/features/classes-group/ClassesForm.vue'
import DeleteAlertModal from '../components/shared/DeleteAlertModal.vue'
import LoadingSpinner from '../components/shared/LoadingSpinner.vue'

const classesStore = useClassesStore()

const isFormModalOpen = ref(false)
const isDeleteModalOpen = ref(false)
const selectedClass = ref(null)

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

const onDelete = async () => {
  if (selectedClass.value) {
    await classesStore.removeClass(selectedClass.value.id)
    isDeleteModalOpen.value = false
  }
}

const onSave = async classItem => {
  if (selectedClass.value) {
    await classesStore.editClass(selectedClass.value.id, classItem)
    isFormModalOpen.value = false
  } else {
    await classesStore.addClass(classItem)
    isFormModalOpen.value = false
  }
}

const onPageChange = async page => {
  await classesStore.changePage(page)
}
</script>

<template>
  <section class="size-full flex flex-col justify-between md:p-20">
    <div v-if="classesStore.isLoading">
      <LoadingSpinner />
    </div>
    <div v-else>
      <ClassesTable
        :classes="classesStore.classes"
        @open-form-modal="toggleFormModal"
        @open-delete-modal="toggleDeleteModal"
      />
      <Pagination
        :currentPage="classesStore.currentPage"
        :totalPages="classesStore.totalPages"
        @page-change="onPageChange"
      />
    </div>
    <ClassesForm
      :isOpen="isFormModalOpen"
      :selectedClass="selectedClass"
      @handle-save="onSave"
      @cancel-save="toggleFormModal"
    />
    <DeleteAlertModal
      :isOpen="isDeleteModalOpen"
      :selectedClass="selectedClass"
      @handle-delete="onDelete"
      @cancel-delete="toggleDeleteModal"
      ><p class="text-lg text-center">
        Biztosan törölni szeretné: <br />
        <span class="font-semibold">{{ selectedClass.class_name }}</span
        >?
      </p></DeleteAlertModal
    >
  </section>
</template>
