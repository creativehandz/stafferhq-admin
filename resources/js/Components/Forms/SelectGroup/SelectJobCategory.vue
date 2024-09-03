<script setup lang="ts">
import { ref, defineEmits, defineProps, watch } from 'vue';

// Define props to receive the modelValue from the parent component
const props = defineProps({
  modelValue: String
});

// Define emits to update the modelValue in the parent component
const emit = defineEmits(['update:modelValue']);


//  Initialize selectedOption with the prop value
const selectedOption = ref(props.modelValue);
// const selectedOption = ref<string>('')
const isOptionSelected = ref<boolean>(false)

watch(() => props.modelValue, (newValue) => {
  selectedOption.value = newValue;
});

const changeTextColor = () => {
  isOptionSelected.value = true
}

const handleChange = (event: Event) => {
  const target = event.target as HTMLSelectElement;
  // Emit the updated value to the parent component
  emit('update:modelValue', target.value);
  changeTextColor();
};
</script>

<template>
  <div>
    <label class="mt-6 mb-3 block text-sm font-medium text-black dark:text-white">
      Job Category
    </label>
    <div class="relative z-20 bg-white dark:bg-form-input">
      <span class="absolute top-1/2 left-4 z-30 -translate-y-1/2">
        <svg fill="#637381" width="20" height="20" viewBox="0 0 24 24" id="Main" xmlns="http://www.w3.org/2000/svg"><path d="M18.23,2H5.77A3.77,3.77,0,0,0,2,5.77V18.23A3.77,3.77,0,0,0,5.77,22H18.23A3.77,3.77,0,0,0,22,18.23V5.77A3.77,3.77,0,0,0,18.23,2ZM20,18.23A1.77,1.77,0,0,1,18.23,20H5.77A1.77,1.77,0,0,1,4,18.23V5.77A1.77,1.77,0,0,1,5.77,4H18.23A1.77,1.77,0,0,1,20,5.77Z"/><path d="M8,11H7a1,1,0,0,0,0,2H8a1,1,0,0,0,0-2Z"/><path d="M8,14H7a1,1,0,0,0,0,2H8a1,1,0,0,0,0-2Z"/><path d="M13,11H11a1,1,0,0,0,0,2h2a1,1,0,0,0,0-2Z"/><path d="M13,14H11a1,1,0,0,0,0,2h2a1,1,0,0,0,0-2Z"/><path d="M8,17H7a1,1,0,0,0,0,2H8a1,1,0,0,0,0-2Z"/><path d="M13,17H11a1,1,0,0,0,0,2h2a1,1,0,0,0,0-2Z"/><path d="M17,11H16a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Z"/><path d="M18,5H6A1,1,0,0,0,5,6V9a1,1,0,0,0,1,1H18a1,1,0,0,0,1-1V6A1,1,0,0,0,18,5ZM17,8H7V7H17Z"/><rect height="5" rx="1" width="3" x="15" y="14"/></svg>
      </span>
      <select
        v-model="selectedOption"
        :class="{ 'text-black dark:text-white': isOptionSelected }"
        @change="handleChange"
        class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-12 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input"
      >
        <option value="" disabled selected>Select Job Category</option>
        <option value="Technology" class="text-body dark:text-bodydark">Technology</option>
        <option value="Makeup artist" class="text-body dark:text-bodydark">Makeup artist</option>
        <option value="Graphic Designer" class="text-body dark:text-bodydark">Graphic Designer</option>
        <option value="Cafe Manager" class="text-body dark:text-bodydark">Cafe Manager</option>
        <option value="Chef" class="text-body dark:text-bodydark">Chef</option>
        <option value="Logistics" class="text-body dark:text-bodydark">Logistics</option>
        <option value="Food Delivery" class="text-body dark:text-bodydark">Food Delivery</option>
        <option value="Media" class="text-body dark:text-bodydark">Media</option>
        <option value="Fitness" class="text-body dark:text-bodydark">Fitness</option>
      </select>
      <span class="absolute top-1/2 right-4 z-10 -translate-y-1/2">
        <svg
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <g opacity="0.8">
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
              fill="#637381"
            ></path>
          </g>
        </svg>
      </span>
    </div>
  </div>
</template>
