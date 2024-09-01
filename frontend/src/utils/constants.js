import { faLandmark, faUserGraduate, faBook } from '@fortawesome/free-solid-svg-icons'

export const MENU = [
  { name: 'Osztályok', icon: faLandmark, path: '/classes' },
  { name: 'Tanulók', icon: faUserGraduate, path: '/students' },
  { name: 'Érdemjegyek', icon: faBook, path: '/grades' },
]

export const BASE_URL = 'http://127.0.0.1:8000/api'
