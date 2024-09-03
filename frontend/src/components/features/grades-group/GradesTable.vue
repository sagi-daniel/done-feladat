<script setup>
import { defineProps, defineEmits } from 'vue'
import Button from '../../shared/Button.vue'

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
  <table class="w-full">
    <thead>
      <tr class="text-center">
        <th>Tanuló</th>
        <th>Tantárgy</th>
        <th>Érdemjegy</th>
        <th>Dátum</th>
        <th>Osztály</th>
        <th>
          <Button className="btn-icon" :onClick="() => formHandler(null)">
            <font-awesome-icon icon="plus" />
          </Button>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="gradeItem in grades" :key="gradeItem.id" class="text-center hover:bg-gray-100">
        <td class="hidden md:table-cell">{{ gradeItem.date }}</td>
        <td>{{ gradeItem.student.student_name }}</td>
        <td>{{ gradeItem.subject }}</td>
        <td>{{ gradeItem.grade }}</td>
        <td class="flex justify-center items-center space-x-2">
          <Button className="btn-icon" :onClick="() => formHandler(gradeItem)">
            <font-awesome-icon icon="pencil" />
          </Button>
          <Button className="btn-icon" :onClick="() => deleteHandler(gradeItem)">
            <font-awesome-icon icon="trash" />
          </Button>
        </td>
      </tr>
    </tbody>
  </table>
</template>
