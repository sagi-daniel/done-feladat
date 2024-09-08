<script setup>
import { defineEmits } from 'vue'

const emit = defineEmits()

const handleClick = () => {
  emit('back')
}
</script>

<template>
  <div class="flex justify-start items-start mb-6">
    <button class="btn-icon-square" @click="handleClick">
      <font-awesome-icon icon="chevron-left" />
      Vissza
    </button>
  </div>
</template>
