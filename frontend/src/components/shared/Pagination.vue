<script setup>
import { defineProps, defineEmits, ref } from 'vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faChevronLeft, faChevronRight } from '@fortawesome/free-solid-svg-icons'
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

// Debounced changePage function to prevent rapid state changes
const changePage = debounce(newPage => {
  if (newPage >= 1 && newPage <= props.totalPages) {
    emits('page-change', newPage)
  }
}, 300)
</script>

<template>
  <div class="flex justify-start items-center space-x-2">
    <button class="px-4 py-2 rounded-2xl" @click="changePage(currentPage - 1)" :disabled="currentPage === 1">
      <FontAwesomeIcon :icon="faChevronLeft" />
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
      <FontAwesomeIcon :icon="faChevronRight" />
    </button>
  </div>
</template>
