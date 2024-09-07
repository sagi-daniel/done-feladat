<script setup>
import { defineProps, defineEmits } from 'vue'
import { useRouter } from 'vue-router'
import Button from '../../shared/Button.vue'

const props = defineProps({
  classes: {
    type: Array,
    required: true,
  },
})

const router = useRouter()

const emits = defineEmits(['open-delete-modal'])

const formHandler = classItem => {
  router.push(`/classes/${classItem.id}`)
}

const deleteHandler = classItem => {
  emits('open-delete-modal', classItem)
}
</script>

<template>
  <table class="w-full">
    <thead>
      <tr class="text-center">
        <th>Osztály</th>
        <th>Osztályterem</th>
        <th class="hidden md:table-cell">Osztályfőnök</th>
        <th class="hidden md:table-cell">Osztályfőnök email</th>
        <th>Létszám</th>
        <th>
          <Button className="btn-icon-square space-x-4" :onClick="() => formHandler(null)">
            <font-awesome-icon icon="landmark" />
            <font-awesome-icon icon="plus" />
          </Button>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="classItem in classes" :key="classItem.id" class="text-center hover:bg-gray-100">
        <td>{{ classItem.class_name }}</td>
        <td>{{ classItem.classroom }}</td>
        <td class="hidden md:table-cell">{{ classItem.teacher }}</td>
        <td class="hidden md:table-cell">{{ classItem.teacher_email }}</td>
        <td>{{ classItem.students_count }}</td>
        <td class="flex justify-center items-center space-x-2">
          <Button className="btn-icon " :onClick="() => formHandler(classItem)">
            <font-awesome-icon icon="circle-info" />
          </Button>
          <Button className="btn-icon" :onClick="() => deleteHandler(classItem)">
            <font-awesome-icon icon="trash" />
          </Button>
        </td>
      </tr>
    </tbody>
  </table>
</template>
