<script setup>
import { defineProps } from 'vue'

const props = defineProps({
  classes: {
    type: Array,
    required: true,
  },
})
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
        <th>Add Class</th>
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
          <button>edit</button>
          <button>del</button>
        </td>
      </tr>
    </tbody>
  </table>
</template>
