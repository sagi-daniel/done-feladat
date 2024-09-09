<script setup>
const props = defineProps({
  options: {
    type: Array,
    default: () => [],
  },
  placeholder: {
    type: String,
    default: '',
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
    default: 'border rounded px-3 py-2 w-full pr-8',
  },
})

const emit = defineEmits(['update:modelValue'])
</script>

<template>
  <div class="relative w-full text-primary">
    <select
      :value="modelValue"
      :required="required"
      :disabled="disabled"
      @change="$emit('update:modelValue', $event.target.value)"
      :class="className"
    >
      <option :value="''" disabled>{{ placeholder }}</option>
      <option v-for="option in options" :key="option.value" :value="option.value">
        {{ option.name }}
      </option>
    </select>
    <span class="absolute right-2 top-1/2 transform -translate-y-1/2 pointer-events-none">
      <font-awesome-icon icon="chevron-down" />
    </span>
  </div>
</template>
