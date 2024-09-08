<script setup>
import { getValue } from '../../utils/helpers'
import Button from './Button.vue'

const props = defineProps({
  columns: Array,
  data: Array,
  actions: Array,
  addHandler: Function,
})

const roundedValue = key => {
  const value = getValue(key)
  return typeof value === 'number' ? value.toFixed(2) : value
}
</script>

<template>
  <table class="w-full">
    <thead>
      <tr class="text-center">
        <th
          v-for="column in columns"
          :key="column.name"
          :class="{ 'hidden md:table-cell': column.mobileVisible === false }"
          class="px-4 py-2"
        >
          {{ column.name }}
        </th>
        <th v-if="actions.length > 0">
          <Button v-if="addHandler" className="btn-icon-square space-x-4" :onClick="() => addHandler(null)">
            <font-awesome-icon icon="plus" />
          </Button>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(row, rowIndex) in data" :key="rowIndex" class="text-center hover:bg-gray-100">
        <td
          v-for="column in columns"
          :key="column.name"
          :class="{ 'hidden md:table-cell': column.mobileVisible === false }"
        >
          {{ getValue(row, column) }}
        </td>
        <td v-if="actions.length > 0" className="flex justify-center items-center space-x-4">
          <Button
            v-for="(action, index) in actions"
            :key="index"
            className="btn-icon"
            :onClick="() => action.handler(row)"
          >
            <font-awesome-icon :icon="action.icon" />
          </Button>
        </td>
      </tr>
    </tbody>
  </table>
</template>
