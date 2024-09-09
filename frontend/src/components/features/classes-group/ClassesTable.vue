<script setup>
import { useRouter } from 'vue-router'
import Table from '../../../components/shared/Table.vue'

const props = defineProps({
  classes: {
    type: Array,
    required: true,
  },
})

const router = useRouter()

const emits = defineEmits(['open-delete-modal'])

const formHandler = classItem => {
  router.push({ path: '/classes/create', state: { classItem } })
}

const detailsHandler = classItem => {
  router.push(`/classes/${classItem.id}`)
}

const deleteHandler = classItem => {
  emits('open-delete-modal', classItem)
}
</script>

<template>
  <Table
    :columns="[
      { name: 'Osztály', key: 'class_name' },
      { name: 'Osztályterem', key: 'classroom' },
      { name: 'Osztályfőnök', key: 'teacher', mobileVisible: false },
      { name: 'Osztályfőnök email', key: 'teacher_email', mobileVisible: false },
      { name: 'Létszám', key: 'students_count' },
    ]"
    :data="classes"
    :actions="[
      { icon: 'circle-info', handler: detailsHandler },
      { icon: 'pencil', handler: formHandler },
      { icon: 'trash', handler: deleteHandler },
    ]"
    :addHandler="formHandler"
  />
</template>
