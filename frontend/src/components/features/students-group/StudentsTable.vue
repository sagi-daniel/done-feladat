<script setup>
import { defineProps, defineEmits } from 'vue'
import { useRouter } from 'vue-router'
import Button from '../../shared/Button.vue'

const props = defineProps({
  students: {
    type: Array,
    required: true,
  },
})

const router = useRouter()

const emits = defineEmits(['open-form-modal', 'open-delete-modal'])

const formHandler = studentItem => {
  emits('open-form-modal', studentItem)
}

const deleteHandler = studentItem => {
  emits('open-delete-modal', studentItem)
}

const detailsHandler = studentItem => {
  router.push(`/students/${studentItem.id}`)
}
</script>

<template>
  <!-- TODO filtering -->
  <table class="w-full">
    <thead>
      <tr class="text-center">
        <th>Tanuló</th>
        <th>Osztály</th>
        <th>Tanulmányi átlag</th>
        <th class="hidden md:table-cell">Telefon</th>
        <th>
          <Button className="btn-icon-square" :onClick="() => formHandler(null)">
            <font-awesome-icon icon="user-plus" />
          </Button>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="studentItem in props.students" :key="studentItem.id" class="text-center hover:bg-gray-100">
        <td>{{ studentItem.student_name }}</td>
        <td>{{ studentItem.classes[0] ? studentItem.classes[0].class_name : 'N/A' }}</td>
        <td>{{ studentItem.grades_avg ? studentItem.grades_avg.toFixed(2) : 'N/A' }}</td>

        <td class="hidden md:table-cell">{{ studentItem.student_phone }}</td>
        <td class="flex justify-center items-center space-x-2">
          <Button className="btn-icon" :onClick="() => detailsHandler(studentItem)">
            <font-awesome-icon icon="circle-info" />
          </Button>
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
