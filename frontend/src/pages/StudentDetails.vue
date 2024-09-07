<script setup>
import { ref, watch, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useStudentsStore } from '@/stores/students'
import { useStudentGradesStore } from '@/stores/studentGrades'
import Avatar from '../components/shared/Avatar.vue'
import Pagination from '../components/shared/Pagination.vue'
import Button from '../components/shared/Button.vue'
import LoadingSpinner from '../components/shared/LoadingSpinner.vue'

const router = useRouter()
const route = useRoute()
const studentsStore = useStudentsStore()
const studentGradesStore = useStudentGradesStore()

const studentData = ref(null)

const gradesAverageBySubject = ref([])
const gradesAvgCommon = ref(0)

const getStudent = async () => {
  await studentsStore.getStudentById(route.params.id)
  studentData.value = studentsStore.studentDetails
  gradesAverageBySubject.value = studentsStore.gradesAverageBySubject
  gradesAvgCommon.value = studentsStore.gradesAvgCommon
}

const getStudentGrades = async () => {
  await studentGradesStore.getStudentById(route.params.id)
}

onMounted(async () => {
  await getStudent()
  await getStudentGrades()
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

const back = () => {
  router.push('/students')
}
</script>

<template>
  <section class="size-full flex flex-col justify-between md:p-20">
    <div class="flex items-start mb-6">
      <Button className="btn-icon-square" @click="back">
        <font-awesome-icon icon="chevron-left" />
        Vissza
      </Button>
    </div>
    <div v-if="studentData">
      <div class="flex flex-col md:gap-0 gap-5 md:flex-row w-full md:space-x-4">
        <div class="w-full md:w-1/2 flex justify-start items-start">
          <ul class="list-none pl-5 bg-secondary text-primary p-5 rounded-lg w-full">
            <li class="flex items-center justify-start space-x-2 mb-3">
              <Avatar :userName="studentData.student_name" size="large" />
              <span class="flex items-center justify-start text-2xl">
                <strong>{{ studentData.student_name }}</strong>
              </span>
            </li>
            <li>
              <strong>Tanulmányi átlag:</strong>
              {{ gradesAvgCommon.toFixed(2) }}
            </li>
            <li><strong>Osztály:</strong> {{ studentData.classes[0] ? studentData.classes[0].class_name : 'N/A' }}</li>
            <li><strong>Email:</strong> {{ studentData.student_email }}</li>
            <li><strong>Telefon:</strong> {{ studentData.student_phone }}</li>
            <li><strong>Cím:</strong> {{ studentData.student_address ? studentData.student_address : 'N/A' }}</li>
            <li>
              <strong>Létrehozva:</strong>
              {{ studentData.created_at ? new Date(studentData.created_at).toLocaleDateString() : 'N/A' }}
            </li>
          </ul>
        </div>
        <div class="w-full md:w-1/2 rounded-lg mb-5">
          <table class="w-full">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>Tantárgy</th>
                <th>Átlag</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(average, index) in gradesAverageBySubject" :key="index" class="text-center">
                <td>{{ `#${++index}` }}</td>
                <td>{{ average.subject.subject_name }}</td>
                <td>{{ average.average_grade ? parseFloat(average.average_grade).toFixed(2) : 'N/A' }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="rounded-lg mb-6">
        <h1 class="text-2xl mb-4">
          <strong>Érdemjegyek</strong>
        </h1>
        <table class="w-full">
          <thead>
            <tr class="text-center">
              <th>#</th>
              <th>Dátum</th>
              <th>Tantárgy</th>
              <th>Érdemjegy</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(grade, index) in studentGradesStore.studentGrades"
              :key="index"
              class="text-center hover:bg-gray-100"
            >
              <td>{{ `#${++index}` }}</td>
              <td>{{ grade.date }}</td>
              <td>{{ grade.subject_name }}</td>
              <td>{{ grade.grade }}</td>
            </tr>
          </tbody>
        </table>
        <Pagination
          :currentPage="studentGradesStore.currentPage"
          :totalPages="studentGradesStore.totalPages"
          :lastPage="studentGradesStore.lastPage"
          @page-change="onPageChange"
        />
      </div>
    </div>

    <div v-else>
      <LoadingSpinner />
    </div>
  </section>
</template>
