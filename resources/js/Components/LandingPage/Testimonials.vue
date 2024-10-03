<template>
<div class="container px-4 py-8 mx-auto">  
  <div class="px-6 py-12 text-black md:px-16">
    <h2 class="mb-6 text-3xl font-semibold text-left dark:text-white">
      What people say about joining ToWork
    </h2>

    <div class="flex flex-col items-center justify-between space-x-0 space-y-6 md:flex-row md:space-x-6 md:space-y-0">
      <!-- Testimonial Text -->
      <div class="max-w-lg text-center md:text-left dark:text-white">
        <blockquote class="text-xl italic font-light text-gray-800">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac
          vulputate nisl. Lorem ipsum dolor sit amet, consectetur adipiscing
          elit. Etiam ac vulputate nisl.
        </blockquote>
        <p class="mt-4 text-sm font-semibold">
          - John Doe, CEO of TheFaceCraft
        </p>
      </div>

      <!-- Testimonial Image -->
      <img
        src="../../../img/people.png"
        alt="Testimonial Image"
        class="object-cover w-full h-auto max-w-xs rounded-md"
      />
    </div>

    <!-- Navigation Arrows -->
    <div class="flex justify-center mt-6 space-x-6">
      <!-- Left Arrow -->
      <button @click="prevSlide" class="text-gray-600">
        <svg
          class="w-6 h-6"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 19l-7-7 7-7"
          />
        </svg>
      </button>

      <!-- Right Arrow -->
      <button @click="nextSlide" class="text-gray-600">
        <svg
          class="w-6 h-6"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 5l7 7-7 7"
          />
        </svg>
      </button>
    </div>
  </div>
  </div>
</template>

<script setup lang="ts">
// Placeholder methods for navigation
const prevSlide = () => {
  console.log('Previous slide');
};
const nextSlide = () => {
  console.log('Next slide');
};
</script>

<style scoped>

</style>
