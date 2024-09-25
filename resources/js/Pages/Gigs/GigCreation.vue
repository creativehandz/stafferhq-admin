<template>
    <div>
      <!-- Progress Bar -->
      <div class="progress-bar">
        <button :class="{ active: currentStep === 1 }" @click="goToStep(1)">Overview</button>
        <button :class="{ active: currentStep === 2 }" @click="goToStep(2)">Pricing</button>
        <button :class="{ active: currentStep === 3 }" @click="goToStep(3)">Description & FAQ</button>
        <button :class="{ active: currentStep === 4 }" @click="goToStep(4)">Requirements</button>
        <button :class="{ active: currentStep === 5 }" @click="goToStep(5)">Gallery</button>
        <button :class="{ active: currentStep === 6 }" @click="goToStep(6)">Publish</button>
      </div>
  
      <!-- Dynamic Step Content will be rendered here -->
      <div class="step-content">
        <component :is="getCurrentStepComponent()"></component>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const currentStep = ref(1);
  
  const goToStep = (step) => {
    currentStep.value = step;
  };
  
  const getCurrentStepComponent = () => {
    switch (currentStep.value) {
      case 1:
        return 'OverviewComponent';
      case 2:
        return 'PricingComponent';
      // Add other steps here
      default:
        return 'OverviewComponent';
    }
  };
  </script>
  
  <style scoped>
  .progress-bar button.active {
    background-color: green;
  }
  </style>
  