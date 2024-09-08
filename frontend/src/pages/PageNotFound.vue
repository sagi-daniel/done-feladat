<script setup>
import { useRouter } from 'vue-router'
import { faArrowLeft } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

// Vue Router használata a navigációhoz
const router = useRouter()

function goToInbox() {
  router.push('/')
}
</script>

<template>
  <div class="flex flex-col items-center justify-center text-content">
    <div class="text-center mt-40">
      <h1 class="text-9xl font-extrabold text-perm-text">404</h1>
      <h3 class="text-2xl md:text-3xl mb-3">Oldal nem található</h3>
      <p class="text-lg md:text-xl mb-8">Az oldal, amit keresel, nem található.</p>
      <div class="flex justify-center space-x-4">
        <button class="btn text-btn-disable bg-slate-200 hover:bg-slate-300 px-4 py-2 rounded-lg" @click="goToInbox">
          <font-awesome-icon :icon="faArrowLeft" class="2xl" /> Vissza
        </button>
      </div>
    </div>
  </div>
</template>
