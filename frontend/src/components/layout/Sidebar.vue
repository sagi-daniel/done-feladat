<template>
  <header class="relative">
    <!-- Hamburger ikon mobilhoz -->
    <div class="md:hidden flex justify-between items-center p-4 bg-slate-100">
      <span @click="toggleSidebar" class="text-2xl">
        <font-awesome-icon :icon="faBars" />
      </span>
    </div>

    <!-- Oldalpanel mobilhoz -->
    <div
      :class="[
        'fixed inset-0 bg-slate-100 text-slate-600 transition-transform transform',
        isSidebarOpen ? 'translate-x-0' : '-translate-x-full',
        'md:hidden z-50',
      ]"
    >
      <!-- Átlátszó háttér -->
      <div v-if="isSidebarOpen" class="fixed inset-0 bg-black opacity-50" @click="closeSidebar"></div>
      <div class="relative w-3/4 max-w-xs bg-slate-100 h-full p-6">
        <CloseIcon @onClose="closeSidebar" />
        <Logo />

        <!-- Menük -->
        <nav>
          <h2 class="text-xs text-black font-bold mb-2">MENÜ</h2>
          <ul>
            <li
              v-for="(menuItem, index) in MENU"
              :key="index"
              :class="['flex items-center mb-1 cursor-pointer', { 'text-action': isActive(menuItem) }]"
            >
              <router-link :to="menuItem.path || ''" class="flex items-center w-full">
                <font-awesome-icon :icon="menuItem.icon" class="mr-2" />
                {{ menuItem.name }}
              </router-link>
            </li>
          </ul>
        </nav>
      </div>
    </div>

    <!-- Asztali menü -->
    <div class="hidden md:flex flex-col gap-20 bg-slate-100 h-screen p-10">
      <Logo />
      <nav>
        <h2 class="text-xs text-black font-bold mb-2">MENÜ</h2>
        <ul>
          <li
            v-for="(menuItem, index) in MENU"
            :key="index"
            :class="['flex items-center mb-1 cursor-pointer', { 'text-action': isActive(menuItem) }]"
          >
            <router-link :to="menuItem.path || ''" class="flex items-center w-full">
              <font-awesome-icon :icon="menuItem.icon" class="mr-2" />
              {{ menuItem.name }}
            </router-link>
          </li>
        </ul>
      </nav>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import { faBars } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Logo from '../shared/Logo.vue'
import { MENU } from '../../utils/constants'

// Állapotkezelés
const isSidebarOpen = ref(false)

// Oldalpanel megnyitásának és bezárásának kezelése
const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value
}

const closeSidebar = () => {
  isSidebarOpen.value = false
}

// Aktív útvonal ellenőrzése
const route = useRoute()
const isActive = menuItem => {
  return route.path === menuItem.path
}
</script>
