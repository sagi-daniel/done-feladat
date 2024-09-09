<script setup>
import { ref, watch, computed } from 'vue'
import Modal from '../../shared/Modal.vue'
import Button from '../../shared/Button.vue'
import Input from '../../shared/Input.vue'
import SelectInput from '../../shared/SelectInput.vue'
import ClassesSelect from '../classes-group/ClassesSelect.vue'
import StudentsSelect from '../students-group/StudentsSelect.vue'
import { GRADES, SUBJECTS } from '../../../utils/constants'
import { now } from '../../../utils/helpers'

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
  class_id: 0,
  student_id: 0,
  subject_id: '',
  grade: 0,
})

watch(
  () => props.selectedGrade,
  newGrade => {
    if (newGrade && Object.keys(newGrade).length > 0) {
      gradeForm.value = {
        date: newGrade.date || now(),
        class_id: newGrade.class_id || 0,
        student_id: newGrade.student_id || 0,
        subject_id: newGrade.subject_id || '',
        grade: newGrade.grade || 0,
      }
    } else {
      gradeForm.value = {
        date: now(),
        class_id: 0,
        student_id: 0,
        subject_id: '',
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
    <h1>{{ selectedGrade && Object.keys(props.selectedGrade).length > 0 ? 'Szerkesztés' : 'Létrehozás' }}</h1>
    <small v-if="selectedGrade" class="mb-3">{{ selectedGrade.student_name }}</small>
    <form @submit.prevent="onSave" class="flex flex-col gap-5 justify-between">
      <Input type="date" label="Dátum" v-model="gradeForm.date" :required="true" placeholder="Adja meg a dátumot..." />

      <ClassesSelect v-model="gradeForm.class_id" :require="true" placeholder="Válassza ki az osztályt..." />
      <StudentsSelect
        v-model="gradeForm.student_id"
        :classId="gradeForm.class_id"
        :require="true"
        :disabled="gradeForm.class_id === 0"
        placeholder="Válassza ki a tanulót..."
      />

      <div class="flex space-x-2">
        <SelectInput
          label="Tantárgy"
          :options="SUBJECTS"
          v-model="gradeForm.subject_id"
          :required="true"
          :disabled="gradeForm.student_id === 0"
          placeholder="Tantárgy!"
        />
        <SelectInput
          label="Érdemjegy"
          :options="GRADES"
          v-model="gradeForm.grade"
          :required="true"
          :disabled="gradeForm.student_id === 0"
          placeholder="Érdemjegy!"
        />
      </div>

      <Button type="submit" className="btn-add"> Mentés </Button>
    </form>
  </Modal>
</template>
