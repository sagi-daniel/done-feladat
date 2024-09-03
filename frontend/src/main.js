import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import './style.css'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {
  faChevronLeft,
  faChevronRight,
  faTrash,
  faPencil,
  faPlus,
  faLandmark,
  faUserGraduate,
  faBook,
} from '@fortawesome/free-solid-svg-icons'

library.add(faChevronLeft, faChevronRight, faTrash, faPencil, faPlus, faLandmark, faUserGraduate, faBook)

const pinia = createPinia()
const app = createApp(App)
app.use(router)
app.component('font-awesome-icon', FontAwesomeIcon)
app.use(pinia)
app.mount('#app')
