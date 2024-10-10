<template>
        <div class="flex flex-col gap-5">
                <!-- dropdown starts -->
                <div class="relative inline-block text-left">
                    <div>
                    <button
                        @click="toggleDropdown"
                        class="inline-flex justify-between w-full rounded-3xl  shadow-md px-4 py-2 bg-[#FFDECA] text-sm font-medium text-gray-700 hover:bg-[#FFCCAA]"
                        id="options-menu"
                        aria-haspopup="true"
                        aria-expanded="true"
                    >
                        Sort by {{ selectedOption }}
                        <svg
                        class="w-5 h-5 ml-2 -mr-1"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        aria-hidden="true"
                        >
                        <path
                            fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06 0L10 10.084l3.71-2.87a.75.75 0 111.06 1.06l-4.25 3.25a.75.75 0 01-1.06 0l-4.25-3.25a.75.75 0 010-1.06z"
                            clip-rule="evenodd"
                        />
                        </svg>
                    </button>
                    </div>

                    <div
                    v-if="isOpen"
                    class="absolute right-0 z-10 w-56 mt-2 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                    role="menu"
                    aria-orientation="vertical"
                    aria-labelledby="options-menu"
                    >
                    <div class="py-1" role="none">
                        <button
                        @click="selectOption('Top')"
                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                        role="menuitem"
                        >
                        Sort by top
                        </button>
                        <button
                        @click="selectOption('Newest')"
                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                        role="menuitem"
                        >
                        Sort by newest
                        </button>
                        <button
                        @click="selectOption('Oldest')"
                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                        role="menuitem"
                        >
                        Sort by oldest
                        </button>
                    </div>
                    </div>
                </div>
                <!-- dropdown ends -->
            
            
            <div v-for="(review, index) in reviews" :key="index" class="pb-4 border-b border-gray-300 review">
            <div class="flex items-center gap-3 mb-2">
              <!-- Placeholder Avatar -->
              <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gray"><img :src="profileIcon" alt="Profile Icon" class="w-10 h-10" /></div>
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
          <p class="underline font-bold text-center cursor-pointer text-[#FB7B24] leading-none sm:text-[18px]  md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px]">See more reviews</p>
        </div>
</template>

<script setup lang="ts">

import profileIcon from '@/assets/profileIcon.png';
import { ref } from 'vue';
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

  const isOpen = ref(false);
const selectedOption = ref('top');

const toggleDropdown = () => {
  isOpen.value = !isOpen.value;
};

const selectOption = (option: string) => {
  selectedOption.value = option;
  isOpen.value = false;
};
</script>