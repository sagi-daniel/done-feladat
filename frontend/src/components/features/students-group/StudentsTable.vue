<script setup>
import { defineProps, defineEmits } from 'vue'
import { useRouter } from 'vue-router'
import Table from '../../../components/shared/Table.vue'

const props = defineProps({
  students: {
    type: Array,
    required: true,
  },
})

const router = useRouter()

const emits = defineEmits(['open-delete-modal', 'open-form-modal', 'open-details-modal'])

const deleteHandler = studentItem => {
  if (studentItem && studentItem.id) {
    emits('open-delete-modal', studentItem)
  } else {
    console.error('Invalid studentItem provided for deleteHandler', studentItem)
  }
}

const createHandler = studentItem => {
  if (studentItem && studentItem.id) {
    router.push(`/classes/create/${studentItem.id}`)
  } else {
    console.error('Invalid studentItem provided for createHandler', studentItem)
  }
}

const detailsHandler = studentItem => {
  if (studentItem && studentItem.id) {
    router.push(`/students/${studentItem.id}`)
  } else {
    console.error('Invalid studentItem provided for detailsHandler', studentItem)
  }
}
</script>

<template>
  <Table
    :columns="[
      { name: 'Tanuló', key: 'student_name' },
      { name: 'Telefon', key: 'student_phone' },
      { name: 'Osztály', key: 'classes[0].class_name' },
      { name: 'Tanulmányi átlag', key: 'grades_avg', rounding: true, mobileVisible: false },
    ]"
    :data="students"
    :actions="[
      { icon: 'circle-info', handler: detailsHandler },
      { icon: 'pencil', handler: createHandler },
      { icon: 'trash', handler: deleteHandler },
    ]"
    :addHandler="createHandler"
  />
</template>
