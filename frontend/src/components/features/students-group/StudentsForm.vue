<script setup>
import { ref, watch } from 'vue'
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
  student_phone: '',
  student_email: '',
  student_address: '',
})

watch(
  () => props.selectedStudent,
  newStudent => {
    if (newStudent && Object.keys(newStudent).length > 0) {
      studentForm.value = {
        student_name: newStudent.student_name || '',
        student_phone: newStudent.student_phone || '',
        student_email: newStudent.student_email || '',
        student_address: newStudent.student_address || '',
      }
    } else {
      studentForm.value = {
        student_name: '',
        student_phone: '',
        student_email: '',
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
      <Input
        type="text"
        label="Telefon"
        v-model="studentForm.student_phone"
        :required="true"
        placeholder="Adja meg a telefonszámát"
      />
      <Input
        type="email"
        label="email"
        v-model="studentForm.student_email"
        :required="true"
        placeholder="Adja meg az email címét"
      />
      <Input
        type="text"
        label="Lakcím"
        v-model="studentForm.student_address"
        :required="true"
        placeholder="Adja meg a lakcímét..."
      />
      <Button type="submit" className="btn-add"> Mentés </Button>
    </form>
  </Modal>
</template>
