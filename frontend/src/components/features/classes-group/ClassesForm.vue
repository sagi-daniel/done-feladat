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
  selectedClass: {
    type: Object,
    default: () => ({}),
  },
})

const classForm = ref({
  class_name: '',
  classroom: 0,
  teacher: '',
  teacher_email: '',
})

watch(
  () => props.selectedClass,
  newClass => {
    if (newClass && Object.keys(newClass).length > 0) {
      classForm.value = {
        class_name: newClass.class_name || '',
        classroom: newClass.classroom || 0,
        teacher: newClass.teacher || '',
        teacher_email: newClass.teacher_email || '',
      }
    } else {
      classForm.value = {
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

const onSave = () => {
  emits('handle-save', classForm.value)
}

const onClose = () => {
  emits('cancel-save')
}

const isFormValid = computed(() => {
  return (
    classForm.value.class_name.trim() !== '' &&
    classForm.value.classroom > 0 &&
    classForm.value.teacher.trim() !== '' &&
    classForm.value.teacher_email.trim() !== ''
  )
})
</script>

<template>
  <Modal :isOpen="isOpen" @close="onClose">
    <h1>{{ selectedClass && Object.keys(selectedClass).length > 0 ? 'Szerkesztés' : 'Létrehozás' }}</h1>
    <form @submit.prevent="onSave" class="flex flex-col gap-5 justify-between">
      <Input
        type="text"
        label="Osztály név"
        v-model="classForm.class_name"
        :required="true"
        placeholder="Adja meg az osztály nevét..."
      />
      <Input
        type="number"
        label="Osztályterem"
        v-model="classForm.classroom"
        :required="true"
        placeholder="Adja meg az osztályterem számát..."
      />
      <Input
        type="text"
        label="Osztályfőnök neve"
        v-model="classForm.teacher"
        :required="true"
        placeholder="Adja meg az osztályfőnök nevét..."
      />
      <Input
        type="text"
        label="Osztályfőnök email címe"
        v-model="classForm.teacher_email"
        :required="true"
        placeholder="Adja meg az osztályfőnök email címét..."
      />
      <Button type="submit" className="btn-add" :disabled="!isFormValid"> Mentés </Button>
    </form>

    <!-- TODO új diák létrehozása megoldás (később)  -->
  </Modal>
</template>
