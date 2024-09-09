<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useStudentsStore } from '../../../stores/students'
import { useClassesStore } from '../../../stores/classes'
import StudentsForm from '../students-group/StudentsForm.vue'
import Table from '../../shared/Table.vue'
import Button from '../../shared/Button.vue'
import Input from '../../shared/Input.vue'

const isDeleteModalOpen = ref(false)
const isStudentModalOpen = ref(false)
const selectedStudent = ref(null)
const newStudent = ref({ student_name: '', student_phone: '' })
const route = useRoute()
const router = useRouter()

const studentsStore = useStudentsStore()
const classesStore = useClassesStore()

const classForm = ref({
  class_name: '',
  classroom: 0,
  teacher: '',
  teacher_email: '',
  students: [],
})

const students = ref([])

const resetClassForm = () => {
  classForm.value = {
    class_name: '',
    classroom: 0,
    teacher: '',
    teacher_email: '',
    students: [],
  }
  students.value = []
}

const fetchClassById = async classId => {
  if (!classId) return
  const classData = await classesStore.getClassById(classId)
  if (classData) {
    classForm.value = {
      class_name: classData.class_name,
      classroom: classData.classroom,
      teacher: classData.teacher,
      teacher_email: classData.teacher_email,
      students: classData.students || [],
    }
    students.value = classData.students || []
  } else {
    resetClassForm()
  }
}

const fetchStudentsByClassId = async classId => {
  if (!classId) return
  await studentsStore.getStudentsByClassIdAll(classId)
  students.value = studentsStore.allStudents
}

onMounted(async () => {
  const classId = route.query.id
  const classItem = route.state?.classItem

  if (classItem) {
    classForm.value = {
      class_name: classItem.class_name,
      classroom: classItem.classroom,
      teacher: classItem.teacher,
      teacher_email: classItem.teacher_email,
      students: classItem.students || [],
    }
    students.value = classItem.students || []

    if (classId) {
      await fetchClassById(classId)
      await fetchStudentsByClassId(classId)
    }
  } else if (classId) {
    await fetchClassById(classId)
    await fetchStudentsByClassId(classId)
  } else {
    resetClassForm()
  }
})

const onSave = async () => {
  const classData = {
    ...classForm.value,
    students: students.value,
  }

  if (route.query.id) {
    await classesStore.editClass(route.query.id, classData)
  } else {
    await classesStore.addClass(classData)
  }

  router.push({ path: '/classes' })
}

const onDelete = async () => {
  if (selectedStudent.value) {
    students.value = students.value.filter(student => student.id !== selectedStudent.value.id)
    await studentsStore.removeStudent(selectedStudent.value.id)
    isDeleteModalOpen.value = false
    selectedStudent.value = null
  }
}

const addStudent = studentItem => {
  if (selectedStudent.value) {
    const index = students.value.findIndex(student => student.id === selectedStudent.value.id)
    if (index !== -1) {
      students.value[index] = studentItem
    }
  } else {
    students.value.push(studentItem)
  }

  isStudentModalOpen.value = false
  selectedStudent.value = null
}

const toggleDeleteModal = studentItem => {
  if (studentItem) {
    selectedStudent.value = studentItem
  }
  isDeleteModalOpen.value = !isDeleteModalOpen.value
}

const toggleStudentModal = (studentItem = null) => {
  if (studentItem) {
    selectedStudent.value = studentItem
  } else {
    selectedStudent.value = null
  }
  isStudentModalOpen.value = !isStudentModalOpen.value
}
</script>

<template>
  <div>
    <div class="flex flex-col gap-10">
      <h1>{{ route.query.id ? 'Osztály szerkesztése' : 'Új osztály létrehozása' }}</h1>
      <form @submit.prevent="onSave" class="flex flex-col gap-5 justify-between">
        <Input
          type="text"
          label="Osztály név"
          v-model="classForm.class_name"
          :required="true"
          placeholder="Adja meg az osztály nevét..."
        />
        <Input
          type="number"
          label="Osztályterem"
          v-model="classForm.classroom"
          :required="true"
          placeholder="Adja meg az osztályterem számát..."
        />
        <Input
          type="text"
          label="Osztályfőnök neve"
          v-model="classForm.teacher"
          :required="true"
          placeholder="Adja meg az osztályfőnök nevét..."
        />
        <Input
          type="text"
          label="Osztályfőnök email címe"
          v-model="classForm.teacher_email"
          :required="true"
          placeholder="Adja meg az osztályfőnök email címét..."
        />
        <Button type="submit" className="btn-add" :disabled="!classForm.class_name || !classForm.classroom">
          Mentés
        </Button>
      </form>
      <Table
        :columns="[
          { name: 'Tanuló', key: 'student_name' },
          { name: 'Telefon', key: 'student_phone' },
          { name: 'Email', key: 'student_email' },
          { name: 'Cím', key: 'student_address' },
        ]"
        :data="students"
        :actions="[
          { icon: 'pencil', handler: toggleStudentModal },
          { icon: 'trash', handler: toggleDeleteModal },
        ]"
        :addHandler="toggleStudentModal"
      />

      <StudentsForm
        :isOpen="isStudentModalOpen"
        :selectedStudent="selectedStudent"
        @handle-save="addStudent"
        @cancel-save="toggleStudentModal"
      />
    </div>
  </div>
</template>
