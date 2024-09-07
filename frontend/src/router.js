import { createRouter, createWebHistory } from 'vue-router'

import Classes from './pages/Classes.vue'
import ClassesDetails from './pages/ClassesDetails.vue'
import ClassesCreate from './pages/ClassesCreate.vue'

import Students from './pages/Students.vue'
import StudentDetails from './pages/StudentDetails.vue'

import Grades from './pages/Grades.vue'

import PageNotFound from './pages/PageNotFound.vue'

const routes = [
  {
    path: '/',
    children: [
      {
        path: '/',
        redirect: '/classes',
      },
      {
        path: 'classes',
        component: Classes,
      },
      {
        path: 'classes/create',
        component: ClassesCreate,
      },
      {
        path: 'classes/:id',
        component: ClassesDetails,
      },
      {
        path: 'students',
        component: Students,
      },
      {
        path: 'students/:id',
        component: StudentDetails,
        props: true,
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
