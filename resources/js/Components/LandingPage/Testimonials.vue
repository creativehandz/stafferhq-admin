<script setup lang="ts">
import { ref } from 'vue';

import testimonialImage from '@/assets/people.png';
import firstImage from '@/assets/cards-01.png';
import secondImage from '@/assets/cards-05.png';
import blockquote from '@/assets/blockquote.png';
import leftArrow from '@/assets/button-right.png';
import rightArrow from '@/assets/button-left.png';

const testimonials = ref([
  {
    quote: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,  ",
    author: "- John Doe, CEO of TheFaceCraft",
    image: testimonialImage,
  },
  {
    quote: "It has survived not only five centuries,  Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been  a type specimen book. the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make",
    author: "- Jane Smith, CTO of TechSolutions",
    image: firstImage,
  },
  {
    quote: " Lorem Ipsum  took a galley of type and scrambled it to make a type specimen book. is simply ved not only fdummy text of the printing and It has surviive centuries, typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer ",
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
        <h2 class="leading-none sm:text-[60px] mb-5  md:text-[60px] lg:text-[60px] xl:text-[60px] 2xl:text-[60px] font-bold  text-left">
          What people say about joining ToWork
        </h2>
        <div class="w-full overflow-hidden">
          <div
            class="flex transition-transform duration-500 ease-in-out"
            :style="{ transform: `translateX(-${currentIndex * 100}%)` }"
          >
            <div
              v-for="(testimonial, index) in testimonials"
              :key="index"
              class="flex items-center justify-center flex-shrink-0 w-full"
            >
              <div class="flex flex-col items-center justify-between py-5 md:flex-row">
                <div class="w-full pr-5 mr-5 text-center md:w-1/2 md:text-left ">
                  <p class="quote-do leading-[35px] sm:text-[25px] md:text-[25px] lg:text-[25px] xl:text-[25px] 2xl:text-[25px] ">
                    <img :src="blockquote" class="absolute" />
                    {{ testimonial.quote }}
                  </p>
                  <p class="mt-4 font-bold leading-[35px] sm:text-[25px] md:text-[25px] lg:text-[25px] xl:text-[25px] 2xl:text-[25px] text-right mr-3">
                    {{ testimonial.author }}
                  </p>
                </div>
                <div class="w-full md:w-1/2">
                  <img
                    :src="testimonial.image"
                    alt="Testimonial Image"
                    class="object-cover w-full rounded-3xl h-80"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Custom Navigation Buttons -->
    <div class="flex items-center justify-center space-x-10">
      <button @click="previousTestimonial">
        <img :src="rightArrow" class="w-8" alt="Previous" />
      </button>
      <button @click="nextTestimonial">
        <img :src="leftArrow" class="w-8" alt="Next" />
      </button>
    </div>
  </div>
</template>
