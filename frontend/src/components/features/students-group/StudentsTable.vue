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

const emits = defineEmits(['open-delete-modal'])

const deleteHandler = studentItem => {
  emits('open-delete-modal', studentItem)
}

const createHandler = studentItem => {
  router.push(`/classes/create/${studentItem.id}`)
}

const detailsHandler = studentItem => {
  router.push(`/students/${studentItem.id}`)
}
</script>

<template>
  <!-- TODO filtering -->

  <Table
    :columns="[
      { name: 'Tanuló', key: 'student_name' },
      { name: 'Osztály', key: 'classes[0].class_name' },
      { name: 'Tanulmányi átlag', key: 'grades_avg', rounding: true, mobileVisible: false },
      { name: 'Telefon', key: 'student_phone' },
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
