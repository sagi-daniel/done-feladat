import { createRouter, createWebHistory } from 'vue-router'

import PageNotFound from './pages/PageNotFound.vue'
import Classes from './pages/Classes.vue'
import Students from './pages/Students.vue'
import Grades from './pages/Grades.vue'

const routes = [
  {
    path: '/',
    children: [
      {
        path: '',
        redirect: '/classes',
      },
      {
        path: 'classes',
        component: Classes,
      },
      {
        path: 'students',
        component: Students,
      },
      {
        path: 'grades',
        component: Grades,
      },
      {
        path: '/:pathMatch(.*)*',
        component: PageNotFound,
      },
    ],
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
