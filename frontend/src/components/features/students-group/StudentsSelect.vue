<script setup>
import { ref, watch, onMounted } from 'vue'
import { useStudentsStore } from '../../../stores/students'

const props = defineProps({
  placeholder: {
    type: String,
    default: 'Select a student',
  },
  modelValue: {
    type: [String, Number],
    default: '',
  },
  required: {
    type: Boolean,
    default: false,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  classId: {
    type: [String, Number],
    default: 0,
  },
  className: {
    type: String,
    default: '',
  },
})

const emit = defineEmits(['update:modelValue'])

const studentStore = useStudentsStore()
const options = ref([])
const dropdownOpen = ref(false)
const selectedStudent = ref('')

watch(
  () => props.classId,
  async newClassId => {
    if (newClassId) {
      await fetchStudents(newClassId)
    } else {
      options.value = []
    }
  },
  { immediate: true }
)

const fetchStudents = async classId => {
  await studentStore.getStudentsByClassIdAll(classId)
  options.value = studentStore.allStudents
}

const toggleDropdown = () => {
  if (props.disabled) return
  dropdownOpen.value = !dropdownOpen.value
}

const selectOption = option => {
  emit('update:modelValue', option.id)
  selectedStudent.value = option.student_name
  dropdownOpen.value = false
}
</script>

<template>
  <div class="relative w-full text-primary">
    <div
      class="border rounded px-3 py-2 w-full pr-8 cursor-pointer bg-[#fff]"
      @click="toggleDropdown"
      :class="className"
    >
      {{ selectedStudent || placeholder }}
      <span class="absolute right-2 top-1/2 transform -translate-y-1/2 pointer-events-none">
        <font-awesome-icon icon="chevron-down" />
      </span>
    </div>
    <div
      v-if="dropdownOpen"
      class="absolute top-full left-0 w-full mt-1 bg-white border rounded max-h-60 overflow-y-auto z-10"
    >
      <div
        v-for="option in options"
        :key="option.id"
        @click="selectOption(option)"
        class="px-3 py-2 cursor-pointer bg-[#fff] hover:text-action"
      >
        {{ option.student_name }}
      </div>
    </div>
  </div>
</template>
