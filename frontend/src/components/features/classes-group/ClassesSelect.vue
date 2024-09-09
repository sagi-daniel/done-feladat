<script setup>
import { ref, watch } from 'vue'
import { useClassesStore } from '../../../stores/classes'

const props = defineProps({
  placeholder: {
    type: String,
    default: 'Select a class',
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
  className: {
    type: String,
    default: '',
  },
})

const emit = defineEmits(['update:modelValue'])

const classesStore = useClassesStore()
const options = ref([])
const dropdownOpen = ref(false)
const selectedClass = ref('')

watch(
  () => props.modelValue,
  newValue => {
    const option = options.value.find(o => o.id == newValue)
    selectedClass.value = option ? option.class_name : ''
  }
)

const fetchClasses = async () => {
  await classesStore.getAllClasses()
  options.value = classesStore.allClasses
}

fetchClasses()

const toggleDropdown = () => {
  if (props.disabled) return
  dropdownOpen.value = !dropdownOpen.value
}

const selectOption = option => {
  emit('update:modelValue', option.id)
  selectedClass.value = option.class_name
  dropdownOpen.value = false
}

document.addEventListener('click', event => {
  if (!event.target.closest('.relative')) {
    dropdownOpen.value = false
  }
})
</script>

<template>
  <div class="relative w-full text-primary">
    <div
      class="border rounded px-3 py-2 w-full pr-8 cursor-pointer bg-[#fff]"
      @click="toggleDropdown"
      :class="className"
    >
      {{ selectedClass || placeholder }}
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
        {{ option.class_name }}
      </div>
    </div>
  </div>
</template>
