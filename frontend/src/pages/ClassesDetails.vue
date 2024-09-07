<script setup>
import { ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useStudentsStore } from '../stores/students'
import Pagination from '../components/shared/Pagination.vue'
import Button from '../components/shared/Button.vue'

const router = useRouter()
const route = useRoute()
const studentsStore = useStudentsStore()

const classId = ref('')
const classData = ref(null)

const fetchStudents = async () => {
  if (classId.value.trim()) {
    await studentsStore.getStudentsByClassId(classId.value)
    if (studentsStore.students.length > 0) {
      classData.value = studentsStore.students[0].classes[0]
    }
  }
}

watch(
  () => route.params.id,
  async newId => {
    classId.value = newId
    await fetchStudents()
  },
  { immediate: true }
)

const back = () => {
  router.push('/classes')
}

const onPageChange = async page => {
  studentsStore.currentPage = page
  await fetchStudents()
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

    <div v-if="classData" class="md:w-1/3 bg-action text-primary p-6 rounded-lg shadow-md mb-6">
      <h1 class="text-2xl mb-4">
        <strong>{{ classData.class_name }}</strong> osztály
      </h1>
      <p class="mb-2"><strong>Osztályterem:</strong> {{ classData.classroom }}</p>
      <p class="mb-2"><strong>Osztályfőnök:</strong> {{ classData.teacher }}</p>
      <p class="mb-2"><strong>Osztályfőnök email cím:</strong> {{ classData.teacher_email }}</p>
      <p class="mb-2">
        <strong>Létrehozva:</strong>
        {{ new Date(classData.created_at).toLocaleDateString() }}
      </p>
    </div>

    <table class="w-full">
      <thead>
        <tr class="text-center">
          <th>Tanuló</th>
          <th>Osztály</th>
          <th>Telefon</th>
          <th>Cím</th>
          <th>Email</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="studentItem in studentsStore.students" :key="studentItem.id" class="text-center">
          <td>{{ studentItem.student_name }}</td>
          <td>{{ studentItem.classes[0].class_name }}</td>
          <td>{{ studentItem.student_phone }}</td>
          <td>{{ studentItem.student_address }}</td>
          <td>{{ studentItem.student_email }}</td>
        </tr>
      </tbody>
    </table>

    <Pagination
      :currentPage="studentsStore.currentPage"
      :totalPages="studentsStore.totalPages"
      :lastPage="studentsStore.lastPage"
      @page-change="onPageChange"
    />
  </section>
</template>
