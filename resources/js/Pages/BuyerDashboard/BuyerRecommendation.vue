<template>
  <div class="container p-6 mt-5 mb-5 text-black">
    <h2 class="mb-4 leading-none sm:text-[45px] md:text-[45px] lg:text-[45px] xl:text-[45px] 2xl:text-[45px] font-bold">
      Explore similar products and services to your recent searches
    </h2>
    <div class="grid grid-cols-3 gap-4">
      <div v-for="(card, index) in cards" :key="index" :class="['p-4 rounded-lg shadow-md', card.bgColor]">
        <div class="flex items-center mb-2">
          <img src="../../../img/user/user-01.png" alt="user icon" class="w-6 h-6 mr-2" />
          <h3 class="font-bold">{{ card.name }}</h3>
          <span v-if="card.isPremium" class="w-5 ml-2"><img src="../../../img/crown.svg" /></span>
        </div>
        <p class="mb-1 text-lg font-bold">{{ card.price }}</p>
        <p class="font-semibold">{{ card.title }}</p>
        <p class="text-sm text-gray-600">{{ card.description }}</p>
        <div class="flex items-center justify-end mt-4 text-right">
          <span class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="black" viewBox="0 0 24 24" stroke="black" width="16" height="16" class="mr-1">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17.27l5.18 3.73-1.64-6.36 5-4.73-6.57-.54L12 2 9.03 9.37l-6.57.54 5 4.73L6.82 21z" />
            </svg>
            {{ card.rating }}
          </span>
          <span class="ml-2 text-sm text-gray-600">({{ card.reviews }}k)</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const cards = ref([
  {
    name: "John Doe",
    price: "$200",
    title: "Create a brief for clients",
    description: "Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.",
    rating: 4.8,
    reviews: 2,
    isPremium: false,
    icon: "user-icon.png", // Replace with your icon path
    bgColor: "bg-cyan-200"
  },
  {
    name: "John Doe",
    price: "$200",
    title: "Create a brief for clients",
    description: "Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.",
    rating: 4.9,
    reviews: 2,
    isPremium: true,
    icon: "user-icon.png", // Replace with your icon path
    bgColor: "bg-cyan-200"
  },
  {
    name: "John Doe",
    price: "$200",
    title: "Create a brief for clients",
    description: "Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.",
    rating: 5,
    reviews: 2,
    isPremium: false,
    icon: "user-icon.png", // Replace with your icon path
    bgColor: "bg-yellow-300"
  }
]);
</script>

<style scoped></style>
