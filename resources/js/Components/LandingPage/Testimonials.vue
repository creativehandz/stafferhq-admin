<script setup lang="ts">
import { ref } from 'vue';

import testimonialImage from '@/assets/people.png';
import firstImage from '@/assets/cards-01.png';
import secondImage from '@/assets/cards-05.png';
import blockquote from '@/assets/blockquote.png';

const testimonials = ref([
  {
    quote: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac vulputate nisl.",
    author: "- John Doe, CEO of TheFaceCraft",
    image: testimonialImage,
  },
  {
    quote: "Suspendisse potenti. Morbi luctus nec neque at suscipit.",
    author: "- Jane Smith, CTO of TechSolutions",
    image: firstImage,
  },
  {
    quote: "Phasellus eget nunc sit amet lacus congue lacinia.",
    author: "- Mark Johnson, Founder of InnovateX",
    image: secondImage,
  },
  // Add more testimonials as needed
]);

const currentIndex = ref(0);

// Method to go to the next testimonial
const nextTestimonial = () => {
  currentIndex.value = (currentIndex.value + 1) % testimonials.value.length;
};

// Method to go to the previous testimonial
const previousTestimonial = () => {
  currentIndex.value = (currentIndex.value - 1 + testimonials.value.length) % testimonials.value.length;
};
</script>

<template>
  <div class="container mt-10 mb-10">
    <div class="relative flex items-center justify-center">
      <div class="text-center">
        <h2 class="leading-none sm:text-[60px] font-bold dark:text-white text-left">
          What people say about joining ToWork
        </h2>
        <div class="flex flex-col items-center justify-between py-5 md:flex-row">
          <div class="w-full text-center md:w-1/2 md:text-left dark:text-white">
            <p class="quote-do leading-none sm:text-[45px] dark:text-white">
              <img :src=blockquote class="absolute"/>
              {{ testimonials[currentIndex].quote }}
            </p>
            <p class="mt-4 leading-none font-bold sm:text-[30px] text-right mr-3">
              {{ testimonials[currentIndex].author }}
            </p>
          </div>
          <div class="w-full md:w-1/2">
            <img
              :src="testimonials[currentIndex].image"
              alt="Testimonial Image"
              class="object-cover w-full rounded-md h-80"
            />
          </div>
        </div>
      </div>
    </div>
          <!-- Custom Navigation Buttons -->
          <div class="flex items-center justify-center space-x-10">
        <button @click="previousTestimonial">
          <img src="../../../img/button-left.png" class="w-15"lt="Previous" />
        </button>
        <button @click="nextTestimonial">
          <img src="../../../img/button-right.png"class="w-15"  alt="Next" />
        </button>
      </div>
  </div>
</template>
