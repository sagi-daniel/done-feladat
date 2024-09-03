<script setup>
import { ref, watch } from 'vue'
import { now } from '../../../utils/helpers'
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
  date: now(),
  student_id: 0,
  subject: '',
  grade: 0,
})

watch(
  () => props.selectedGrade,
  newGrade => {
    if (newGrade && Object.keys(newGrade).length > 0) {
      gradeForm.value = {
        date: newGrade.date || now(),
        student_id: newGrade.student_id || 0,
        subject: newGrade.subject || '',
        grade: newGrade.grade || 0,
      }
    } else {
      gradeForm.value = {
        date: now(),
        student_id: 0,
        subject: '',
        grade: 0,
      }
    }
  },
  { immediate: true }
)

const emits = defineEmits(['handle-save', 'cancel-save'])

const onSave = () => {
  emits('handle-save', gradeForm.value)
}

const onClose = () => {
  emits('cancel-save')
}
</script>

<template>
  <Modal :isOpen="isOpen" @close="onClose">
    <h1>{{ selectedGrade && Object.keys(selectedGrade).length > 0 ? 'Szerkesztés' : 'Létrehozás' }}</h1>
    <form @submit.prevent="onSave" class="flex flex-col gap-5 justify-between">
      <Input type="date" label="Dátum" v-model="gradeForm.date" :required="true" placeholder="Adja meg a dátumot..." />
      <Input
        type="number"
        label="Tanuló"
        v-model="gradeForm.student_id"
        :required="true"
        placeholder="Adja meg a tanulót..."
      />
      <Input
        type="text"
        label="Tantárgy"
        v-model="gradeForm.subject"
        :required="true"
        placeholder="Adja meg a tantárgy nevét..."
      />
      <Input
        type="number"
        label="Érdemjegy"
        v-model="gradeForm.grade"
        :required="true"
        placeholder="Adja meg az érdemjegyet!"
      />
      <Button type="submit" className="btn-add"> Mentés </Button>
    </form>

    <!-- TODO új diák létrehozása megoldás (később)  -->
  </Modal>
</template>
