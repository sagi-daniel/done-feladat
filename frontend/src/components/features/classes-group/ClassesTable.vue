<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  classes: {
    type: Array,
    required: true,
  },
})

const emits = defineEmits(['open-form-modal', 'open-delete-modal'])

const formHandler = classItem => {
  emits('open-form-modal', classItem)
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
        <th class="hidden md:table-cell">Tanár</th>
        <th class="hidden md:table-cell">Email</th>
        <th>Létszám</th>
        <th>
          <button class="btn-icon" @click="formHandler(null)">
            <font-awesome-icon icon="plus" />
          </button>
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
          <button class="btn-icon" @click="formHandler(classItem)">
            <font-awesome-icon icon="pencil" />
          </button>
          <button class="btn-icon" @click="deleteHandler(classItem)">
            <font-awesome-icon icon="trash" />
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</template>
