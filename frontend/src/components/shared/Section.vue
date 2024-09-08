<script setup>
import LoadingSpinner from './LoadingSpinner.vue'

const props = defineProps({
  isLoading: {
    type: Boolean,
    require: false,
  },
})
</script>

<template>
  <section class="size-full flex flex-col justify-between md:p-20">
    <div v-if="isLoading">
      <LoadingSpinner />
    </div>
    <div v-else>
      <slot />
    </div>
  </section>
</template>
