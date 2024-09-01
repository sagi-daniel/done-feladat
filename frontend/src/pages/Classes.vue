<script setup>
import { ref } from 'vue'
import { getClasses, createClass, getClassById, updateClass, deleteClass } from '../services/apiClasses'

import ClassesTable from '../components/features/classes-group/ClassesTable.vue'
import Pagination from '../components/shared/Pagination.vue'

// Reaktív változók
const classes = ref([])
const error = ref(null)
const newClass = ref({
  class_name: '',
  classroom: '',
  teacher: '',
  teacher_email: '',
})

// Funkciók
const fetchClasses = async () => {
  try {
    const data = await getClasses()
    classes.value = data.data
  } catch (err) {
    error.value = 'Hiba történt az osztályok lekérésekor'
  }
}

const addClass = async () => {
  try {
    await createClass(newClass.value)
    await fetchClasses() // Frissítjük az osztályok listáját
    // Tisztítjuk az űrlapot
    newClass.value = {
      class_name: '',
      classroom: '',
      teacher: '',
      teacher_email: '',
    }
  } catch (err) {
    error.value = 'Hiba történt az osztály létrehozásakor'
  }
}

const fetchClassById = async id => {
  try {
    const data = await getClassById(id)
    console.log(data.data)
  } catch (err) {
    error.value = 'Hiba történt az osztály lekérésekor'
  }
}

const updateClassById = async (id, updatedClass) => {
  try {
    await updateClass(id, updatedClass)
    await fetchClasses() // Frissítjük az osztályok listáját
  } catch (err) {
    error.value = 'Hiba történt az osztály frissítésekor'
  }
}

const removeClass = async id => {
  try {
    await deleteClass(id)
    await fetchClasses() // Frissítjük az osztályok listáját
  } catch (err) {
    error.value = 'Hiba történt az osztály törlésekor'
  }
}

// Form submit kezelése
const handleAddClass = () => {
  addClass()
}

// Inicializálás
fetchClasses()
</script>

<template>
  <div>
    <ClassesTable />
    <Pagination />
    <ClassesFormModal />
    <DeleteAlertModal />
  </div>
</template>
