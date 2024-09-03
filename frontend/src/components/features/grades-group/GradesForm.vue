<script setup>
import { ref, watch, computed } from 'vue'
import Modal from '../../shared/Modal.vue'
import Button from '../../shared/Button.vue'
import Input from '../../shared/Input.vue'

const props = defineProps({
  isOpen: {
    type: Boolean,
    required: true,
  },
  selectedGrade: {
    type: Object,
    default: () => ({}),
  },
})

const gradeForm = ref({
  class_name: '',
  classroom: 0,
  teacher: '',
  teacher_email: '',
})

const errorMessage = ref('') // Add error message state

watch(
  () => props.selectedGrade,
  newClass => {
    if (newClass && Object.keys(newClass).length > 0) {
      gradeForm.value = {
        class_name: newClass.class_name || '',
        classroom: newClass.classroom || 0,
        teacher: newClass.teacher || '',
        teacher_email: newClass.teacher_email || '',
      }
    } else {
      gradeForm.value = {
        class_name: '',
        classroom: 0,
        teacher: '',
        teacher_email: '',
      }
    }
  },
  { immediate: true }
)

const emits = defineEmits(['handle-save', 'cancel-save'])

const onSave = async () => {
  try {
    await emits('handle-save', gradeForm.value)
    errorMessage.value = '' // Clear error message on successful save
  } catch (error) {
    errorMessage.value = error.message || 'An error occurred while saving.' // Capture error message
  }
}

const onClose = () => {
  errorMessage.value = '' // Reset error message on close
  emits('cancel-save')
}

const isFormValid = computed(() => {
  return (
    gradeForm.value.class_name.trim() !== '' &&
    gradeForm.value.classroom > 0 &&
    gradeForm.value.teacher.trim() !== '' &&
    gradeForm.value.teacher_email.trim() !== ''
  )
})
</script>

<template>
  <Modal :isOpen="isOpen" @close="onClose">
    <h1>{{ selectedGrade && Object.keys(selectedGrade).length > 0 ? 'Szerkesztés' : 'Létrehozás' }}</h1>
    <!-- <form @submit.prevent="onSave" class="flex flex-col gap-5 justify-between">
      <Input
        type="text"
        label="Osztály név"
        v-model="gradeForm.class_name"
        :required="true"
        placeholder="Adja meg az osztály nevét..."
      />
      <Input
        type="number"
        label="Osztályterem"
        v-model="gradeForm.classroom"
        :required="true"
        placeholder="Adja meg az osztályterem számát..."
      />
      <Input
        type="text"
        label="Osztályfőnök neve"
        v-model="gradeForm.teacher"
        :required="true"
        placeholder="Adja meg az osztályfőnök nevét..."
      />
      <Input
        type="text"
        label="Osztályfőnök email címe"
        v-model="gradeForm.teacher_email"
        :required="true"
        placeholder="Adja meg az osztályfőnök email címét..."
      />
      <Button type="submit" className="btn-add" :disabled="!isFormValid"> Mentés </Button>
    </form> -->

    <!-- TODO új diák létrehozása megoldás (később)  -->
  </Modal>
</template>
