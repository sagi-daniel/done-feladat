<template>
  <span @click="$emit('close')" class="absolute text-lg top-2 right-2 text-black cursor-pointer hover:text-action">
    <font-awesome-icon :icon="faX" />
  </span>
</template>

<script setup>
import { faX } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
</script>
