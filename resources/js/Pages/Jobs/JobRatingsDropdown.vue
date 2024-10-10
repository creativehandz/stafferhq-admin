<template>
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
</template>

<script setup lang="ts">
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