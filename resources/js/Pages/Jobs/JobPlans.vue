<template>
  <div class="sticky top-0 z-10 flex flex-col items-center ml-5">
  <div class="container max-w-md p-6 rounded-3xl bg-[#FFDECA] ">
    <!-- Tab Headers -->
    <div class="flex justify-between p-2 bg-gray-100 rounded-lg slide_text leading-none sm:text-[22px]  md:text-[22px] lg:text-[22px] xl:text-[22px] 2xl:text-[22px]">
      <button
        :class="currentTab === 'Basic' ? 'font-bold underline' : 'font-bold'"
        @click="currentTab = 'Basic'"
      >
        Basic
      </button>
      <button
        :class="currentTab === 'Standard' ? 'font-bold underline' : 'font-bold'"
        @click="currentTab = 'Standard'"
      >
        Standard
      </button>
      <button
        :class="currentTab === 'Premium' ? 'font-bold underline' : 'font-bold'"
        @click="currentTab = 'Premium'"
      >
        Premium
      </button>
    </div>

    <!-- Dynamic Box Content -->
    <div class="w-full p-6 mt-4 rounded-3xl transition-all duration-500 bg-[#f1b792]">
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

    <!-- Contact Section -->
  </div>
  <div class="flex items-center justify-center gap-4 mt-5">
    <img :src="profileIcon" alt="Profile Icon" class="w-10 h-10" />
    <button class="w-40 h-12 bg-[#F5F535] shadow-md rounded-3xl">
      Contact Me
    </button>
  </div>
  </div>
</template>
  <script setup lang="ts">
  import { ref } from 'vue';
  
  import profileIcon from '@/assets/profileIcon.png';
  // Reactive state for current tab
  const currentTab = ref('Basic');
  </script>
  
  <style scoped>
  /* Custom styles if needed */
  .slide_text {
    font-family: "Crimson Pro"
  }
  </style>
  