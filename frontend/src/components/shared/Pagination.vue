<script setup>
import { defineProps } from 'vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const props = defineProps({
  icon: {
    type: Object,
    required: true,
  },
  onClick: {
    type: Function,
    required: true,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  className: {
    type: String,
    default: '',
  },
})
</script>

<template>
  <button :class="['px-4 py-2 rounded-2xl', className]" @click="onClick" :disabled="disabled">
    <FontAwesomeIcon :icon="icon" />
  </button>
</template>
