<script setup>
import { ref } from 'vue';

const props = defineProps({
  id: { type: String, required: true },
  label: { type: String, required: true },
  accept: { type: String, default: '.jpg, .jpeg, .png, .gif, .svg' },
  buttonText: { type: String, default: 'Choose File' },
  modelValue: { type: [File, null], default: null }
});

const emit = defineEmits(['update:modelValue']);

const fileName = ref('No file chosen');

const onChange = (event) => {
  const file = event.target.files?.[0] || null;
  fileName.value = file?.name ?? 'No file chosen';
  emit('update:modelValue', file);
};
</script>

<template>
  <div>
    <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">{{ props.label }}</label>
    <div class="flex items-center space-x-3">
      <input
        :id="props.id"
        :accept="props.accept"
        type="file"
        class="hidden"
        @change="onChange"
      />
      <label :for="props.id" class="base-file-button">
        {{ props.buttonText }}
      </label>
      <span class="text-sm text-gray-400">{{ fileName }}</span>
    </div>
  </div>
</template>
