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
  selectedStudent: {
    type: Object,
    default: () => ({}),
  },
})

const studentForm = ref({
  student_name: '',
  class: 0,
  student_phone: '',
  student_address: '',
})

watch(
  () => props.selectedStudent,
  newClass => {
    if (newClass && Object.keys(newClass).length > 0) {
      studentForm.value = {
        student_name: newClass.student_name || '',
        class_id: newClass.class_id || 0,
        student_phone: newClass.student_phone || '',
        student_address: newClass.student_address || '',
      }
    } else {
      studentForm.value = {
        student_name: '',
        class_id: 0,
        student_phone: '',
        student_address: '',
      }
    }
  },
  { immediate: true }
)

const emits = defineEmits(['handle-save', 'cancel-save'])

const onSave = () => {
  emits('handle-save', studentForm.value)
}

const onClose = () => {
  emits('cancel-save')
}

const isFormValid = computed(() => {
  return (
    studentForm.value.student_name.trim() !== '' &&
    studentForm.value.class &&
    studentForm.value.student_phone.trim() !== '' &&
    studentForm.value.student_address.trim() !== ''
  )
})
</script>

<template>
  <Modal :isOpen="isOpen" @close="onClose">
    <h1>{{ selectedStudent && Object.keys(selectedStudent).length > 0 ? 'Szerkesztés' : 'Létrehozás' }}</h1>
    <form @submit.prevent="onSave" class="flex flex-col gap-5 justify-between">
      <Input
        type="text"
        label="Tanuló neve"
        v-model="studentForm.student_name"
        :required="true"
        placeholder="Adja meg a tanuló nevét..."
      />
      <!-- TODO itt le kell kérni a létező osztályokat -->
      <Input
        type="number"
        label="Osztály"
        v-model="studentForm.class"
        :required="true"
        placeholder="Adja meg az osztályt."
      />
      <Input
        type="text"
        label="Telefon"
        v-model="studentForm.student_phone"
        :required="true"
        placeholder="Adja meg a telefonszámát"
      />
      <Input
        type="text"
        label="Lakcím"
        v-model="studentForm.student_address"
        :required="true"
        placeholder="Adja meg a lakcímét..."
      />
      <Button type="submit" className="btn-add" :disabled="!isFormValid"> Mentés </Button>
    </form>
  </Modal>
</template>
