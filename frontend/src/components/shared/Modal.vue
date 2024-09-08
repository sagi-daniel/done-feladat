<script setup>
import CloseIcon from './CloseIcon.vue'

const props = defineProps({
  isOpen: {
    type: Boolean,
    required: true,
  },
  onClose: {
    type: Function,
    required: true,
  },
})

const emit = defineEmits(['close'])

const handleBackdropClick = () => {
  emit('close')
}

const handleModalClick = event => {
  event.stopPropagation()
}
</script>

<template>
  <div
    v-if="isOpen"
    class="fixed inset-0 bg-primary bg-opacity-90 flex items-center justify-center z-50"
    @click="handleBackdropClick"
  >
    <div class="bg-secondary text-primary p-6 rounded-lg shadow-lg relative max-w-sm w-full" @click="handleModalClick">
      <CloseIcon @click="handleBackdropClick" class="absolute top-2 right-2 cursor-pointer" />
      <div class="flex flex-col justify-center items-center px-10 py-2">
        <slot></slot>
      </div>
    </div>
  </div>
</template>
