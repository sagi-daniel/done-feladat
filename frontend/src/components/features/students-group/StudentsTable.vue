<script setup>
import { useRouter } from 'vue-router'
import Table from '../../../components/shared/Table.vue'

const props = defineProps({
  students: {
    type: Array,
    required: true,
  },
})

const router = useRouter()

const emits = defineEmits(['open-delete-modal', 'open-details-modal'])

const deleteHandler = studentItem => {
  emits('open-delete-modal', studentItem)
}

const detailsHandler = studentItem => {
  if (studentItem && studentItem.id) {
    router.push(`/students/${studentItem.id}`)
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
      { icon: 'trash', handler: deleteHandler },
    ]"
  />
</template>
