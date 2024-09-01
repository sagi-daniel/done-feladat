<script setup>
import { computed } from 'vue'
import Modal from './Modal.vue'
import Button from './Button.vue'

const props = defineProps({
  isOpen: {
    type: Boolean,
    required: true,
  },
  onClose: {
    type: Function,
    required: true,
  },
  selectedItems: {
    type: Array,
    required: true,
  },
  items: {
    type: Array,
    required: true,
  },
  handleDelete: {
    type: Function,
    required: true,
  },
})

// Computed property to get the name or count of selected items
const itemName = computed(() => {
  if (props.selectedItems.length === 1) {
    const item = props.items.find(item => item.id === props.selectedItems[0])
    return item ? item.name : 'Item'
  }
  return `${props.selectedItems.length} selected items`
})
</script>

<template>
  <Modal :isOpen="props.isOpen" :onClose="props.onClose">
    <p class="text-lg text-center">
      Do you want to delete <br />
      <span class="font-semibold">{{ itemName }}</span>
      from the list?
    </p>
    <div class="flex gap-2 justify-center items-center mt-5">
      <Button text="Delete" @click="props.handleDelete" class="btn-delete" />
      <Button text="Cancel" @click="props.onClose" class="btn-cancel" />
    </div>
  </Modal>
</template>

<style scoped>
.btn-delete {
  background-color: #e53e3e;
  color: white;
}

.btn-cancel {
  background-color: #edf2f7;
  color: #2d3748;
}
</style>
