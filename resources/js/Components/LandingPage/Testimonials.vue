<script setup lang="ts">
import { ref, onMounted } from 'vue';
import ToggleTheme from './ToggleTheme.vue';
import Swiper from 'swiper';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

// Initialize Swiper on component mount
onMounted(() => {
  new Swiper('.mySwiper', {
    slidesPerView: 1,
    spaceBetween: 10,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
  });
});
</script>

<template>
  <div class="container px-6 py-12 mx-auto mt-10 mb-10">
    <div class="overflow-hidden swiper-container mySwiper">
      <div class="swiper-wrapper">
        <!-- Slide One -->
        <div class="swiper-slide">
          <h2 class="leading-none sm:text-[60px] md:text-[60px] lg:text-[60px] xl:text-[60px] 2xl:text-[60px] font-bold dark:text-white">
            What people say about joining ToWork
          </h2>
          <div class="flex flex-col items-center justify-between py-5 md:flex-row">
            <div class="w-full text-center md:w-1/2 md:text-left dark:text-white">
              <p class="quote-do leading-none sm:text-[45px]  md:text-[45px] lg:text-[45px] xl:text-[45px] 2xl:text-[45px]  dark:text-white">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac vulputate nisl. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac vulputate nisl.
              </p>
              <p class="mt-4 leading-none font-bold sm:text-[30px]  md:text-[30px] lg:text-[30px] xl:text-[30px] 2xl:text-[30px] text-right">- John Doe, CEO of TheFaceCraft</p>
            </div>
            <div class="w-full md:w-1/2">
              <img
                src="../../../img/people.png"
                alt="Testimonial Image"
                class="object-cover w-full rounded-md h-80"
              />
            </div>
          </div>
        </div>

        <!-- Slide One -->
        <div class="swiper-slide">
          <h2 class="leading-none sm:text-[60px] md:text-[60px] lg:text-[60px] xl:text-[60px] 2xl:text-[60px] font-bold dark:text-white">
            What people say about joining ToWork
          </h2>
          <div class="flex flex-col items-center justify-between py-5 md:flex-row">
            <div class="w-full text-center md:w-1/2 md:text-left dark:text-white">
              <p class="quote-do leading-none sm:text-[45px]  md:text-[45px] lg:text-[45px] xl:text-[45px] 2xl:text-[45px]  dark:text-white">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac vulputate nisl. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac vulputate nisl.
              </p>
              <p class="mt-4 leading-none font-bold sm:text-[30px]  md:text-[30px] lg:text-[30px] xl:text-[30px] 2xl:text-[30px] text-right">- John Doe, CEO of TheFaceCraft</p>
            </div>
            <div class="w-full md:w-1/2">
              <img
                src="../../../img/people.png"
                alt="Testimonial Image"
                class="object-cover w-full rounded-md h-80"
              />
            </div>
          </div>
        </div>

        <!-- Slide One -->
        <div class="swiper-slide">
          <h2 class="leading-none sm:text-[60px] md:text-[60px] lg:text-[60px] xl:text-[60px] 2xl:text-[60px] font-bold dark:text-white">
            What people say about joining ToWork
          </h2>
          <div class="flex flex-col items-center justify-between py-5 md:flex-row">
            <div class="w-full text-center md:w-1/2 md:text-left dark:text-white">
              <p class="quote-do leading-none sm:text-[45px]  md:text-[45px] lg:text-[45px] xl:text-[45px] 2xl:text-[45px]  dark:text-white">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac vulputate nisl. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac vulputate nisl.
              </p>
              <p class="mt-4 leading-none font-bold sm:text-[30px]  md:text-[30px] lg:text-[30px] xl:text-[30px] 2xl:text-[30px] text-right">- John Doe, CEO of TheFaceCraft</p>
            </div>
            <div class="w-full md:w-1/2">
              <img
                src="../../../img/people.png"
                alt="Testimonial Image"
                class="object-cover w-full rounded-md h-80"
              />
            </div>
          </div>
        </div>

        <!-- Slide One -->
        <div class="swiper-slide">
          <h2 class="leading-none sm:text-[60px] md:text-[60px] lg:text-[60px] xl:text-[60px] 2xl:text-[60px] font-bold dark:text-white">
            What people say about joining ToWork
          </h2>
          <div class="flex flex-col items-center justify-between py-5 md:flex-row">
            <div class="w-full text-center md:w-1/2 md:text-left dark:text-white">
              <p class="quote-do leading-none sm:text-[45px]  md:text-[45px] lg:text-[45px] xl:text-[45px] 2xl:text-[45px]  dark:text-white">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac vulputate nisl. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac vulputate nisl.
              </p>
              <p class="mt-4 leading-none font-bold sm:text-[30px]  md:text-[30px] lg:text-[30px] xl:text-[30px] 2xl:text-[30px] text-right">- John Doe, CEO of TheFaceCraft</p>
            </div>
            <div class="w-full md:w-1/2">
              <img
                src="../../../img/people.png"
                alt="Testimonial Image"
                class="object-cover w-full rounded-md h-80"
              />
            </div>
          </div>
        </div>        
    </div>
      <!-- Navigation Buttons
      <div class="bg-black rounded-full swiper-button-prev"></div>
      <div class="bg-black rounded-full swiper-button-next"></div> -->
      <div class="flex items-center justify-center space-x-4">
          <button>
            <img src="../../../img/button-left.png" />
          </button>
          <button>
            <img src="../../../img/button-right.png" />
          </button>
      </div>


      
      <!-- Pagination -->
      <div class="swiper-pagination"></div>
    </div>
  </div>
</template>

