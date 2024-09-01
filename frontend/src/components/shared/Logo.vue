<template>
  <div :class="['flex', alignmentClasses[align], sizeClasses[size], 'h-auto']">
    <router-link to="/">
      <img :src="logoSrc" alt="logo" />
    </router-link>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { defineProps } from 'vue'

const props = defineProps({
  align: {
    type: String,
    default: 'left',
  },
  size: {
    type: String,
    default: 'large',
  },
})

const logoSrc = 'assets/brand/logo-l.svg'

const alignmentClasses = {
  left: 'justify-start',
  center: 'justify-center',
  right: 'justify-end',
}

const sizeClasses = {
  xsmall: 'w-16',
  small: 'w-20',
  medium: 'w-32',
  large: 'w-40',
}
</script>
