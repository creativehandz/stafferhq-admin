<template>
    <div class="container max-w-md p-6 rounded-3xl bg-[#FFDECA]">
      <!-- Tab Headers -->
      <div class="flex justify-between p-2 bg-gray-100 rounded-lg">
        <button
          :class="currentTab === 'Basic' ? 'font-bold underline' : 'font-normal'"
          @click="currentTab = 'Basic'"
        >
          Basic
        </button>
        <button
          :class="currentTab === 'Standard' ? 'font-bold underline' : 'font-normal'"
          @click="currentTab = 'Standard'"
        >
          Standard
        </button>
        <button
          :class="currentTab === 'Premium' ? 'font-bold underline' : 'font-normal'"
          @click="currentTab = 'Premium'"
        >
          Premium
        </button>
      </div>
  
      <!-- Dynamic Box Content -->
      <div class="w-full rounded-3xl p-6 transition-all duration-500 bg-[#ff8e48] ">
        <div v-if="currentTab === 'Basic'">
          <h3 class="text-2xl font-bold">$200</h3>
          <p class="mt-2 text-sm text-gray-700">
            I will design a website for you from scratch! I'll design and develop the navbar and four
            modules from the ground up. Lorem ipsum dolor sit.
          </p>
          <ul class="mt-4 space-y-2">
            <li>✔️ Figma file</li>
            <li>✔️ Design palette</li>
          </ul>
        </div>
  
        <div v-if="currentTab === 'Standard'">
          <h3 class="text-2xl font-bold">$250</h3>
          <p class="mt-2 text-sm text-gray-700">
            I will design a website for you from scratch! I'll design and develop the navbar and six
            modules from the ground up. Lorem ipsum dolor sit amet.
          </p>
          <ul class="mt-4 space-y-2">
            <li>✔️ Figma file</li>
            <li>✔️ Design palette</li>
            <li>✔️ Basic landing page</li>
          </ul>
        </div>
  
        <div v-if="currentTab === 'Premium'">
          <h3 class="text-2xl font-bold">$300</h3>
          <p class="mt-2 text-sm text-gray-700">
            I will design a website for you from scratch! I'll design and develop the navbar and eight
            modules from the ground up. Lorem ipsum dolor sit amet.
          </p>
          <ul class="mt-4 space-y-2">
            <li>✔️ Figma file</li>
            <li>✔️ Design palette</li>
            <li>✔️ Basic landing page</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="flex items-center gap-4 mt-5">
      <img :src="logo"/>
      <button class="bg-yellow-300 shadow-md h-15 w-35 rounded-3xl"> Contact Me</button>
    </div>      
  </template>
  
  <script setup lang="ts">
  import { ref } from 'vue';
  import logo from '@/assets/button-right.png';
  // Reactive state for current tab
  const currentTab = ref('Basic');
  </script>
  
  <style scoped>
  /* Custom styles if needed */
  </style>
  