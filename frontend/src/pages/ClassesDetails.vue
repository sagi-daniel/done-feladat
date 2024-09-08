<script setup>
import { ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useStudentsStore } from '../stores/students'
import Table from '../components/shared/Table.vue'
import DetailsCard from '../components/shared/DetailsCard.vue'
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
  </section>
</template>
