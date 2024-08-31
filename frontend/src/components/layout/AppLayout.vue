<template>
  <div class="flex justify-between">
    <Sidebar />
    <Main>
      <router-view />
    </Main>
  </div>
</template>

<script setup>
import Sidebar from './Sidebar.vue'
import Main from './Main.vue'
</script>
