<script setup>
import Table from '../../shared/Table.vue'

const props = defineProps({
  grades: {
    type: Array,
    required: true,
  },
})

const emits = defineEmits(['open-form-modal', 'open-delete-modal'])

const formHandler = gradeItem => {
  emits('open-form-modal', gradeItem)
}

const deleteHandler = gradeItem => {
  emits('open-delete-modal', gradeItem)
}
</script>

<template>
  <Table
    :columns="[
      { name: 'Tanuló', key: 'student.student_name' },
      { name: 'Tantárgy', key: 'subject.subject_name' },
      { name: 'Osztály', key: 'student.classes[0].class_name', mobileVisible: false },
      { name: 'Érdemjegy', key: 'grade' },
      { name: 'Dátum', key: 'date', mobileVisible: false },
    ]"
    :data="grades"
    :actions="[{ icon: 'trash', handler: deleteHandler }]"
    :addHandler="formHandler"
  />
</template>
