<script setup>
import { defineProps } from 'vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const props = defineProps({
  text: {
    type: String,
    default: '',
  },
  className: {
    type: String,
    required: true,
  },
  type: {
    type: String,
    default: 'button',
    validator: value => ['submit', 'reset', 'button'].includes(value),
  },
  icon: {
    type: Object,
    default: undefined,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  onClick: {
    type: Function,
    default: undefined,
  },
})
</script>

<template>
  <button :class="className" :type="type" :disabled="disabled" @click="props.onClick">
    <FontAwesomeIcon v-if="props.icon" :icon="props.icon" />
    {{ text }}
  </button>
</template>
