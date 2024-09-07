<script setup>
import { defineProps, defineEmits, computed } from 'vue'

const props = defineProps({
  options: {
    type: Array,
    default: () => [],
  },
  placeholder: {
    type: String,
    default: '',
  },
  modelValue: {
    type: String,
    default: '',
  },
  required: {
    type: Boolean,
    default: false,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  className: {
    type: String,
    default: 'border rounded px-3 py-2 w-full pr-8', // Added padding-right for icon
  },
})

const emit = defineEmits(['update:modelValue'])

const hasSelectedValue = computed(() => {
  return props.options.some(option => option.value === props.modelValue)
})
</script>

<template>
  <div class="relative mb-3">
    <select
      :value="hasSelectedValue ? modelValue : ''"
      :required="required"
      :disabled="disabled"
      @change="$emit('update:modelValue', $event.target.value)"
      :class="className"
    >
      <option :value="''" disabled :selected="!hasSelectedValue">{{ placeholder }}</option>
      <option v-for="option in options" :key="option.value" :value="option.value">
        {{ option.name }}
      </option>
    </select>
    <span class="absolute right-2 top-1/2 transform -translate-y-1/2 pointer-events-none">
      <font-awesome-icon icon="chevron-down" />
    </span>
  </div>
</template>

<style scoped>
/* Adjust the position of the icon */
.select-container {
  position: relative;
}
.select-container .fa-chevron-down {
  position: absolute;
  right: 8px; /* Adjust this value to fit your design */
  top: 50%;
  transform: translateY(-50%);
  pointer-events: none; /* Prevent icon from capturing clicks */
}
</style>
