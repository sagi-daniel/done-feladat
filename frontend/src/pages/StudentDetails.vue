<script setup>
import { ref, watch, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useStudentsStore } from '@/stores/students'
import { useStudentGradesStore } from '@/stores/studentGrades'
import Section from '../components/shared/Section.vue'
import Table from '../components/shared/Table.vue'
import DetailsCard from '../components/shared/DetailsCard.vue'
import Pagination from '../components/shared/Pagination.vue'
import NavBackButton from '../components/shared/NavBackButton.vue'

const router = useRouter()
const route = useRoute()
const studentsStore = useStudentsStore()
const studentGradesStore = useStudentGradesStore()

const studentData = ref(null)

const getStudent = async () => {
  await studentsStore.getStudentById(route.params.id)
  studentData.value = {
    ...studentsStore.studentDetails,
    gradesAvgCommon: studentsStore.gradesAvgCommon,
  }
}

const getStudentGrades = async () => {
  await studentGradesStore.getStudentById(route.params.id)
}

onMounted(async () => {
  await Promise.all([getStudent(), getStudentGrades()])
})

watch(
  () => studentGradesStore.currentPage,
  () => {
    getStudent()
    getStudentGrades()
  }
)

const onPageChange = async page => {
  await studentGradesStore.changePage(page)
}

const handleBack = () => {
  router.push('/students')
}
</script>

<template>
  <Section :isLoading="studentsStore.isLoading">
    <NavBackButton @back="handleBack" />
    <div class="flex space-x-4">
      <DetailsCard
        v-if="studentData"
        :data="studentData"
        :title="studentData.student_name"
        :fields="[
          { name: 'Tanulmányi átlag', key: 'gradesAvgCommon', rounding: true },
          { name: 'Osztály', key: 'classes[0].class_name' },
          { name: 'Email', key: 'student_email' },
          { name: 'Telefon', key: 'student_phone' },
          { name: 'Cím', key: 'student_address' },
        ]"
      />

      <div class="size-full md:w-1/2 rounded-lg">
        <Table
          :columns="[
            { name: 'Tantárgy', key: 'subject.subject_name' },
            { name: 'Átlag', key: 'average_grade', rounding: true },
          ]"
          :data="studentsStore.gradesAverageBySubject"
          :actions="[]"
        />
      </div>
    </div>

    <div class="rounded-lg mb-6">
      <h1 class="text-2xl mb-4">
        <strong>Érdemjegyek</strong>
      </h1>
      <Table
        :columns="[
          { name: 'Dátum', key: 'date' },
          { name: 'Tantárgy', key: 'subject_name' },
          { name: 'Érdemjegy', key: 'grade' },
        ]"
        :data="studentGradesStore.studentGrades"
        :actions="[]"
      />

      <Pagination
        :currentPage="studentGradesStore.currentPage"
        :totalPages="studentGradesStore.totalPages"
        :lastPage="studentGradesStore.lastPage"
        @page-change="onPageChange"
      />
    </div>
  </Section>
</template>
