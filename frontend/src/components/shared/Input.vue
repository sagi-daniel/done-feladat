<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  type: {
    type: String,
    default: 'text',
    validator: value => ['text', 'email', 'number', 'password', 'url', 'tel'].includes(value),
  },
  label: {
    type: String,
    required: true,
  },
  placeholder: {
    type: String,
    default: '',
  },
  modelValue: {
    type: [String, Number],
    required: true,
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
    default: 'border rounded px-3 py-2 w-full',
  },
})

const emit = defineEmits(['update:modelValue'])
</script>

<template>
  <div class="mb-1">
    <label>{{ label }}</label>
    <input
      :type="type"
      :placeholder="placeholder"
      :value="modelValue"
      :required="required"
      :disabled="disabled"
      @input="$emit('update:modelValue', $event.target.value)"
      :class="className"
    />
  </div>
</template>
