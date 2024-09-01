<template>
  <header class="relative">
    <div class="md:hidden flex justify-between items-center p-4">
      <span @click="openSidebar" class="text-2xl cursor-pointer">
        <font-awesome-icon :icon="faBars" />
      </span>
    </div>

    <div
      :class="[
        'fixed inset-0 transition-transform transform',
        isSidebarOpen ? 'translate-x-0' : '-translate-x-full',
        'md:hidden z-50',
      ]"
    >
      <div v-if="isSidebarOpen" class="fixed inset-0 bg-black opacity-50" @click="closeSidebar"></div>
      <div class="relative w-3/4 max-w-xs h-full bg-primary p-10 flex flex-col gap-20">
        <CloseIcon @close="closeSidebar" />
        <Logo />
        <Menu :menuItems="MENU" :isActive="isActive" />
      </div>
    </div>

    <div class="hidden md:flex flex-col h-screen p-10 gap-20">
      <Logo />
      <Menu :menuItems="MENU" :isActive="isActive" />
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import { faBars } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Logo from '../shared/Logo.vue'
import CloseIcon from '../shared/CloseIcon.vue'
import Menu from '../shared/Menu.vue'
import { MENU } from '../../utils/constants'

const isSidebarOpen = ref(false)

const openSidebar = () => {
  isSidebarOpen.value = true
}

const closeSidebar = () => {
  isSidebarOpen.value = false
}

const route = useRoute()
const isActive = menuItem => {
  return route.path === menuItem.path
}
</script>
