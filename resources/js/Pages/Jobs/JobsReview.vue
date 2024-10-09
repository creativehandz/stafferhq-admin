<template>
    <div class="container flex flex-row justify-between px-10 py-8">
  
      <!-- Left Section (Reviews and Ratings) -->
      <div class="w-1/3 pr-8">        
        <h2 class="mb-4 text-xl font-bold">Reviews and ratings</h2>
        <div class="flex items-center mb-4 space-x-2">
          <div class="flex items-center">
            <!-- Star SVGs -->
            <svg v-for="star in 5" :key="star" xmlns="http://www.w3.org/2000/svg" fill="orange" viewBox="0 0 24 24" class="w-5 h-5">
              <path d="M12 2.5l2.95 6.16 6.8.98-4.9 4.77 1.16 6.77L12 17.99l-6.05 3.19 1.16-6.77L2.1 9.64l6.8-.98L12 2.5z" />
            </svg>
          </div>
          <p class="text-lg font-semibold">4.8 out of 5</p>
        </div>
  
        <!-- Rating Breakdown -->
        <div class="space-y-2">
          <div class="flex items-center">
            <p class="w-16 text-sm">5 stars</p>
            <div class="relative w-full h-2 ml-2 bg-gray-200 rounded">
              <div class="absolute w-4/5 h-2 bg-orange-400 rounded"></div>
            </div>
          </div>
          <div class="flex items-center">
            <p class="w-16 text-sm">4 stars</p>
            <div class="relative w-full h-2 ml-2 bg-gray-200 rounded">
              <div class="absolute w-1/2 h-2 bg-orange-400 rounded"></div>
            </div>
          </div>
          <div class="flex items-center">
            <p class="w-16 text-sm">3 stars</p>
            <div class="relative w-full h-2 ml-2 bg-gray-200 rounded">
              <div class="absolute w-1/4 h-2 bg-orange-400 rounded"></div>
            </div>
          </div>
          <div class="flex items-center">
            <p class="w-16 text-sm">2 stars</p>
            <div class="relative w-full h-2 ml-2 bg-gray-200 rounded">
              <div class="absolute w-1/6 h-2 bg-orange-400 rounded"></div>
            </div>
          </div>
          <div class="flex items-center">
            <p class="w-16 text-sm">1 star</p>
            <div class="relative w-full h-2 ml-2 bg-gray-200 rounded">
              <div class="absolute w-1/12 h-2 bg-orange-400 rounded"></div>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Center Section (Reviews List) -->
      <div class="w-1/3">
        
        <div class="flex flex-col gap-5">
          <div v-for="(review, index) in reviews" :key="index" class="pb-4 border-b border-gray-300 review">
            <div class="flex items-center gap-3 mb-2">
              <!-- Placeholder Avatar -->
              <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gray"></div>
              <div class="flex flex-col">
                <p class="font-semibold">{{ review.name }}</p>
              </div>
            </div>
            <!-- Star Rating -->
            <div class="flex items-center mb-2">
              <span v-for="n in review.rating" :key="n" class="w-5 h-6 text-orange-500">&#9733;</span>
            </div>
            <p class="mb-1 font-bold">"{{ review.title }}"</p>
            <p class="text-gray-700">{{ review.content }}</p>
          </div>
        </div>
      </div>
      <div class="w-1/3">
        <JobPlans/>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
import JobPlans from './JobPlans.vue';

  interface Review {
    name: string;
    title: string;
    content: string;
    rating: number;
  }
  
  const reviews: Review[] = [
    {
      name: "Katrina Smith",
      title: "Loved this service!",
      content:
        "Aenean nec gravida purus. Proin consequat sit amet mauris molestie cous non felis ultrices tempus. Morbi ullamcorper dapibus tempor.",
      rating: 5,
    },
    {
      name: "Katrina Smith",
      title: "Loved this service!",
      content:
        "Aenean nec gravida purus. Proin consequat sit amet mauris molestie cous non felis ultrices tempus. Morbi ullamcorper dapibus tempor.",
      rating: 5,
    },
    {
      name: "Katrina Smith",
      title: "Loved this service!",
      content:
        "Aenean nec gravida purus. Proin consequat sit amet mauris molestie cous non felis ultrices tempus. Morbi ullamcorper dapibus tempor.",
      rating: 5,
    },
    {
      name: "Katrina Smith",
      title: "Loved this service!",
      content:
        "Aenean nec gravida purus. Proin consequat sit amet mauris molestie cous non felis ultrices tempus. Morbi ullamcorper dapibus tempor.",
      rating: 5,
    },
    {
      name: "Katrina Smith",
      title: "Loved this service!",
      content: "Aenean nec gravida purus.",
      rating: 5,
    },
  ];
  </script>
  
  <style scoped>
  /* Additional styling if needed */
  </style>
  