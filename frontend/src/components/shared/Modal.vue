<script setup>
import { defineProps, defineEmits, ref, watch } from 'vue'
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

watch(
  () => props.isOpen,
  newValue => {
    if (!newValue) {
      // Handle any additional logic
    }
  }
)
</script>

<template>
  <div
    v-if="props.isOpen"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click="handleBackdropClick"
  >
    <div class="bg-secondary p-6 rounded-lg shadow-lg relative max-w-sm w-full" @click="handleModalClick">
      <CloseIcon @click="handleBackdropClick" />
      <div class="flex flex-col justify-center items-center px-10 py-2">
        <slot></slot>
      </div>
    </div>
  </div>
</template>
