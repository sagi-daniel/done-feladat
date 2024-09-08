<script setup>
import Modal from './Modal.vue'
import Button from './Button.vue'

const props = defineProps({
  isOpen: {
    type: Boolean,
    required: true,
  },
  selectedItem: {
    type: Object,
    default: {},
  },
})

const emits = defineEmits(['handle-delete', 'cancel-delete'])

const onDelete = classItem => {
  emits('handle-delete', classItem)
}

const onClose = () => {
  emits('cancel-delete')
}
</script>

<template>
  <Modal :isOpen="isOpen" @close="onClose">
    <slot></slot>
    <div class="flex gap-2 justify-center items-center mt-5">
      <Button :onClick="onDelete" className="btn-delete">Törlés</Button>
      <Button :onClick="onClose" className="btn-cancel">Mégse</Button>
    </div>
  </Modal>
</template>
