<script setup>
import { defineProps, defineEmits } from 'vue'
import Button from '../../shared/Button.vue'

const props = defineProps({
  students: {
    type: Array,
    required: true,
  },
})

const emits = defineEmits(['open-form-modal', 'open-delete-modal'])

const formHandler = studentItem => {
  emits('open-form-modal', studentItem)
}

const deleteHandler = studentItem => {
  emits('open-delete-modal', studentItem)
}
</script>

<template>
  <!-- TODO filtering -->
  <table class="w-full">
    <thead>
      <tr class="text-center">
        <th>Tanuló</th>
        <th>Osztály</th>
        <th class="hidden md:table-cell">Telefon</th>
        <!-- <th class="hidden md:table-cell">Cím</th> -->
        <th>Tanulmányi átlag</th>
        <th>
          <Button className="btn-icon" :onClick="() => formHandler(null)">
            <font-awesome-icon icon="plus" />
          </Button>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="studentItem in students" :key="studentItem.id" class="text-center hover:bg-gray-100">
        <td>{{ studentItem.student_name }}</td>
        <td>{{ studentItem.class.class_name }}</td>
        <td class="hidden md:table-cell">{{ studentItem.student_phone }}</td>
        <!-- <td class="hidden md:table-cell">{{ studentItem.address }}</td> -->
        <td>{{ studentItem.grades_avg }}</td>
        <td class="flex justify-center items-center space-x-2">
          <Button className="btn-icon" :onClick="() => formHandler(studentItem)">
            <font-awesome-icon icon="pencil" />
          </Button>
          <Button className="btn-icon" :onClick="() => deleteHandler(studentItem)">
            <font-awesome-icon icon="trash" />
          </Button>
        </td>
      </tr>
    </tbody>
  </table>
</template>
