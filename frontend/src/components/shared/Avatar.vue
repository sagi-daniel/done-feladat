<script setup>
import { computed } from 'vue'

const props = defineProps({
  userName: String,
  size: {
    type: String,
    default: 'medium',
    validator: value => ['small', 'medium', 'large'].includes(value),
  },
})

const userIconWords = computed(() => props.userName.substring(0, 1).toUpperCase())

const sizeClasses = {
  small: 'text-base p-2 w-8 h-8',
  medium: 'text-lg p-3 w-12 h-12',
  large: 'text-2xl p-5 w-16 h-16',
}

const avatarClasses = computed(() =>
  [sizeClasses[props.size], 'font-semibold bg-action font-semibold rounded-full flex items-center justify-center'].join(
    ' '
  )
)
</script>

<template>
  <span :class="avatarClasses">
    {{ userIconWords }}
  </span>
</template>
