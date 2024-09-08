<script setup>
import { getValueDetailsCardComponent } from '../../utils/helpers'

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  data: {
    type: Object,
    required: true,
  },
  fields: {
    type: Array,
    required: true,
  },
})

const getValue = key => {
  return getValueDetailsCardComponent(key, props.data)
}

const roundedValue = key => {
  const value = getValue(key)
  return typeof value === 'number' ? value.toFixed(2) : value
}
</script>

<template>
  <div v-if="data" class="md:w-1/2 bg-secondary text-primary p-6 rounded-lg shadow-md mb-6">
    <h1 class="text-2xl mb-4">
      <strong>{{ title }}</strong>
    </h1>
    <div v-for="(field, index) in fields" :key="index" class="mb-2">
      <p>
        <strong>{{ field.name }}:</strong>
        <span v-if="field.rounding">
          {{ roundedValue(field.key) }}
        </span>
        <span v-else>
          {{ getValue(field.key) }}
        </span>
      </p>
    </div>
  </div>
</template>
