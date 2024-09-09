<script setup>
import { ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useStudentsStore } from '../stores/students'
import Section from '../components/shared/Section.vue'
import Table from '../components/shared/Table.vue'
import DetailsCard from '../components/shared/DetailsCard.vue'
import Pagination from '../components/shared/Pagination.vue'
import NavBackButton from '../components/shared/NavBackButton.vue'

const router = useRouter()
const route = useRoute()
const studentsStore = useStudentsStore()

const classData = ref(null)

const getStudents = async () => {
  await studentsStore.getStudentsByClassId(route.params.id)
  if (studentsStore.students.length > 0 && studentsStore.students[0].classes) {
    classData.value = studentsStore.students[0].classes[0]
  } else {
    classData.value = null
  }
}

watch(
  () => route.params.id,
  async () => {
    await getStudents()
  },
  { immediate: true }
)

const handleBack = () => {
  router.push('/classes')
}

const onPageChange = async page => {
  studentsStore.currentPage = page
  await getStudents()
}
</script>

<template>
  <Section :isLoading="studentsStore.isLoading">
    <NavBackButton @back="handleBack" />
    <DetailsCard
      v-if="classData"
      :data="classData"
      :title="classData.class_name"
      :fields="[
        { name: 'Osztályterem', key: 'classroom' },
        { name: 'Osztályfőnök', key: 'teacher' },
        { name: 'Osztályfőnök email cím', key: 'teacher_email' },
      ]"
    />
    <Table
      :columns="[
        { name: 'Tanuló', key: 'student_name' },
        { name: 'Osztály', key: 'classes[0].class_name', mobileVisible: false },
        { name: 'Telefon', key: 'student_phone' },
        { name: 'Cím', key: 'student_address', mobileVisible: false },
        { name: 'Email', key: 'student_email', mobileVisible: false },
      ]"
      :data="studentsStore.students"
      :actions="[]"
    />
    <Pagination
      :currentPage="studentsStore.currentPage"
      :totalPages="studentsStore.totalPages"
      :lastPage="studentsStore.lastPage"
      @page-change="onPageChange"
    />
  </Section>
</template>
