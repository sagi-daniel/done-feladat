<template>
  <nav>
    <h2 class="text-xs font-bold mb-2">{{ menuTitle }}</h2>
    <ul>
      <li
        v-for="(menuItem, index) in menuItems"
        :key="index"
        :class="['flex items-center mb-2 cursor-pointer', { 'text-action': isActive(menuItem) }]"
      >
        <router-link :to="menuItem.path || ''" class="flex items-center w-full gap-1">
          <font-awesome-icon :icon="menuItem.icon" class="mr-2" />
          {{ menuItem.name }}
        </router-link>
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { defineProps } from 'vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const props = defineProps({
  menuTitle: {
    type: String,
    default: 'Menü',
  },
  menuItems: Array,
  isActive: Function,
})
</script>
