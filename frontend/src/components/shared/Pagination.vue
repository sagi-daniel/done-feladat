<script setup>
import { defineProps, defineEmits, ref } from 'vue'
import { debounce } from '../../utils/helpers'

const props = defineProps({
  currentPage: {
    type: Number,
    required: true,
  },
  totalPages: {
    type: Number,
    required: true,
  },
})

const emits = defineEmits(['page-change'])

const changePage = debounce(newPage => {
  if (newPage >= 1 && newPage <= props.totalPages) {
    emits('page-change', newPage)
  }
}, 300)
</script>

<template>
  <div class="flex justify-start items-center space-x-2">
    <button class="px-4 py-2 rounded-2xl" @click="changePage(currentPage - 1)" :disabled="currentPage === 1">
      <font-awesome-icon icon="chevron-left" />
    </button>

    <span
      v-for="page in totalPages"
      :key="page"
      @click="changePage(page)"
      :class="['cursor-pointer', currentPage === page ? 'text-action' : '']"
    >
      {{ page }}
    </span>

    <button class="px-4 py-2 rounded-2xl" @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages">
      <font-awesome-icon icon="chevron-right" />
    </button>
  </div>
</template>
