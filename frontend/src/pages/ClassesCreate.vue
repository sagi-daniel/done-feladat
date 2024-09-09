<script setup>
import { ref, onMounted, watch, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useClassesStore } from '../stores/classes'
import Section from '../components/shared/Section.vue'
import ClassesForm from '../components/features/classes-group/ClassesForm.vue'
import NavBackButton from '../components/shared/NavBackButton.vue'

const classesStore = useClassesStore()

const router = useRouter()
const route = useRoute()
const classId = computed(() => route.query.id)

const currentClass = ref(null)
const isStudentFormModalOpen = ref(false)
const isStudentDeleteModalOpen = ref(false)
const selectedStudent = ref(null)

const fetchClass = async id => {
  if (id) {
    await classesStore.getClassById(id)
    currentClass.value = classesStore.classDetails
  } else {
    currentClass.value = {}
  }
}

onMounted(() => {
  fetchClass(classId.value)
})

watch(classId, newId => {
  fetchClass(newId)
})

const toggleDeleteModal = classItem => {
  console.log('toggleDeleteModal', classItem)
  selectedStudent.value = classItem
  isStudentDeleteModalOpen.value = !isStudentDeleteModalOpen.value
}

const toggleFormModal = classItem => {
  console.log('toggleFormModal', classItem)
  selectedStudent.value = classItem
  isStudentFormModalOpen.value = !isStudentFormModalOpen.value
}

const onSave = async () => {
  if (currentClass.value.id) {
    console.log('update', currentClass.value)
  } else {
    console.log('create', currentClass.value)
  }
}

const handleBack = () => {
  router.push(`/classes`)
}
</script>

<template>
  <Section :isLoading="classesStore.isLoading">
    <NavBackButton @back="handleBack" />
    <ClassesForm :selectedClass="currentClass" @handle-save="onSave" />
  </Section>
</template>
