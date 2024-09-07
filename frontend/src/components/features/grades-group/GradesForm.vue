<script setup>
import { ref, watch } from 'vue'
import { now } from '../../../utils/helpers'
import Modal from '../../shared/Modal.vue'
import Button from '../../shared/Button.vue'
import Input from '../../shared/Input.vue'
import SelectInput from '../../shared/SelectInput.vue'
import { GRADES, SUBJECTS } from '../../../utils/constants'

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
        subject: newGrade.subject.subject_name || '',
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
    <small v-if="selectedGrade">{{ selectedGrade.student.student_name }}</small>
    <form @submit.prevent="onSave" class="flex flex-col gap-5 justify-between">
      <Input type="date" label="Dátum" v-model="gradeForm.date" :required="true" placeholder="Adja meg a dátumot..." />
      <Input
        type="number"
        label="Tanuló"
        v-model="gradeForm.student_id"
        :required="true"
        :disabled="true"
        placeholder="Adja meg a tanulót..."
      />

      <SelectInput
        label="Érdemjegy"
        :options="SUBJECTS"
        v-model="gradeForm.grade"
        :required="true"
        placeholder="Válassza ki a tantárgyat!"
      />

      <SelectInput
        label="Érdemjegy"
        :options="GRADES"
        v-model="gradeForm.grade"
        :required="true"
        placeholder="Válassza ki a megfelelő érdemjegyet!"
      />
      <Button type="submit" className="btn-add"> Mentés </Button>
    </form>

    <!-- TODO új diák létrehozása megoldás (később)  -->
  </Modal>
</template>
