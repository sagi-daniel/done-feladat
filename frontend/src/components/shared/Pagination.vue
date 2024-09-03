<script setup>
import { defineProps, defineEmits, ref, computed } from 'vue'
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
  lastPage: {
    type: Number,
    required: true,
  },
})

const emits = defineEmits(['page-change'])

const debounceDelay = 300
const changePage = debounce(newPage => {
  if (newPage >= 1 && newPage <= props.totalPages) {
    emits('page-change', newPage)
  }
}, debounceDelay)

const visiblePages = computed(() => {
  const delta = 2
  const range = []

  const start = Math.max(1, props.currentPage - delta)
  const end = Math.min(props.totalPages, props.currentPage + delta)

  for (let i = start; i <= end; i++) {
    range.push(i)
  }

  if (props.totalPages - end > 1) {
    if (props.totalPages !== props.currentPage) {
      range.push(props.totalPages)
    }
  }

  return range
})
</script>

<template>
  <div class="flex justify-start items-center space-x-2">
    <button class="px-4 py-2 rounded-2xl" @click="changePage(currentPage - 1)" :disabled="currentPage === 1">
      <font-awesome-icon icon="chevron-left" />
    </button>

    <span
      v-for="page in visiblePages"
      :key="page"
      @click="changePage(page)"
      :class="['cursor-pointer', currentPage === page ? 'text-action' : '']"
    >
      {{ page }}
    </span>

    <span v-if="props.totalPages - visiblePages[visiblePages.length - 1] > 1">
      <span @click="changePage(props.totalPages)" class="cursor-pointer"> {{ props.totalPages }} </span>
    </span>

    <button
      class="px-4 py-2 rounded-2xl cursor-pointer"
      @click="changePage(currentPage + 1)"
      :disabled="currentPage === props.totalPages"
    >
      <font-awesome-icon icon="chevron-right" />
    </button>
  </div>
</template>
