<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  type: {
    type: 'text' | 'email' | 'number' | 'password' | 'url' | 'email' | 'tel',
    default: 'text',
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
    default: 'border rounded px-3 py-2 w-full',
  },
})

const emit = defineEmits(['update:modelValue'])
</script>

<template>
  <div class="mb3">
    <input
      :type="type"
      :placeholder="placeholder"
      :value="modelValue"
      :required="required"
      :disabled="disabled"
      @input="$emit('update:modelValue', $event.target.value)"
      :className="className"
    />
  </div>
</template>
