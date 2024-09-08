<script setup>
import { defineProps } from 'vue'

const props = defineProps({
  className: {
    type: String,
    required: true,
  },
  type: {
    type: String,
    default: 'button',
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  onClick: {
    type: Function,
    required: false,
  },
})
</script>

<template>
  <button :class="className" :type="type" :disabled="disabled" @click="onClick ? onClick() : null">
    <slot />
  </button>
</template>
