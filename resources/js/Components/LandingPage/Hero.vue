<script setup lang="ts">
import { useColorMode } from "@vueuse/core";
const mode = useColorMode();

import { Badge } from "@/Components/LandingPage/ui/badge";
import { Button } from "@/Components/LandingPage/ui/button";
import { ArrowRight } from "lucide-vue-next";
import heroImageLight from '../../../img/LandingPage/heroImageLight.jpg'
import heroImageDark from '../../../img/LandingPage/heroImageDark.jpg'

import webIcon from '../../../img/logos/ai-icon.svg';
import translationIcon from '../../../img/logos/translation-icon.svg';
import animationIcon from '../../../img/logos/ai-icon.svg';
import graphicsIcon from '../../../img/logos/ai-icon.svg';
import inpersonIcon from '../../../img/logos/ai-icon.svg';
import aiIcon from '../../../img/logos/ai-icon.svg';
import musicIcon from '../../../img/logos/ai-icon.svg';
import businessIcon from '../../../img/logos/ai-icon.svg';

const categories = [
  { name: "Web and digital services", icon: webIcon },
  { name: "Translation and linguistics", icon: translationIcon },
  { name: "Animation and video", icon: animationIcon },
  { name: "Graphics and design", icon: graphicsIcon },
  { name: "In-person services", icon: inpersonIcon },
  { name: "AI and ML", icon: aiIcon },
  { name: "Music and audio", icon: musicIcon },
  { name: "Business and networking", icon: businessIcon },
];

</script>

<template>
  <section class="container">
    <div
      class="grid gap-8 py-20 mx-auto place-items-center lg:max-w-screen-xl md:py-32"
    >
      <!-- <div class="space-y-8 text-center">
        <Badge
          variant="outline"
          class="py-2 text-sm"
        >
          <span class="mr-2 text-primary">
            <Badge>New</Badge>
          </span>
          <span> Design is out now! </span>
        </Badge>

        <div
          class="max-w-screen-md mx-auto text-5xl font-bold text-center md:text-6xl"
        >
          <h1>
            Experience the
            <span
              class="text-transparent bg-gradient-to-r from-[#D247BF] to-primary bg-clip-text"
              >Shadcn/Vue
            </span>
            landing page
          </h1>
        </div>

        <p class="max-w-screen-sm mx-auto text-xl text-muted-foreground">
          We're more than just a tool, we're a community of passionate creators.
          Get access to exclusive resources, tutorials, and support.
        </p>

        <div class="space-y-4 md:space-y-0 md:space-x-4">
          <Button class="w-5/6 font-bold md:w-1/4 group/arrow">
            Get Started
            <ArrowRight
              class="ml-2 transition-transform size-5 group-hover/arrow:translate-x-1"
            />
          </Button>

          <Button
            as-child
            variant="secondary"
            class="w-5/6 font-bold md:w-1/4"
          >
            <a
              href="https://github.com/leoMirandaa/shadcn-vue-landing-page.git"
              target="_blank"
              >Github respository</a
            >
          </Button>
        </div>
      </div> -->

      <div class="px-6 py-12 text-white bg-orange-500 rounded-3xl md:px-16">
    <div class="container flex flex-col items-center mx-auto md:flex-row">
      <!-- Text Section -->
      <div class="text-center md:text-left md:w-1/2">
        <h1 class="text-2xl leading font-crimsonPro md:text-4xl">Work. Simplified.<br>Let's get <span class="font-extrabold">ToWork.</span></h1>
        <p class="mt-4 text-base md:text-lg">
          Find all kinds of job opportunities in and around Malaysia. Sell your services. Or buy them.
        </p>
      </div>

      <!-- Image Section -->
      <div class="flex justify-center mt-6 md:mt-0 md:w-1/2">
        <img src="../../../img/womenPot.png" alt="Illustration" class="w-64 md:w-80">
      </div>
    </div>

    <!-- Search Section -->
    <div class="flex flex-col items-center mt-8">
      <div class="flex items-center w-full px-4 py-2 bg-white rounded-full md:w-1/2">
        <input
          type="text"
          class="w-full px-4 py-2 text-black rounded-full focus:outline-none"
          placeholder="Search for a service"
        />
        <button class="text-gray-600 focus:outline-none">          
          <svg
              class="fill-body hover:fill-primary dark:fill-bodydark dark:hover:fill-primary"
              width="20"
              height="20"
              viewBox="0 0 20 20"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
          >
              <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M9.16666 3.33332C5.945 3.33332 3.33332 5.945 3.33332 9.16666C3.33332 12.3883 5.945 15 9.16666 15C12.3883 15 15 12.3883 15 9.16666C15 5.945 12.3883 3.33332 9.16666 3.33332ZM1.66666 9.16666C1.66666 5.02452 5.02452 1.66666 9.16666 1.66666C13.3088 1.66666 16.6667 5.02452 16.6667 9.16666C16.6667 13.3088 13.3088 16.6667 9.16666 16.6667C5.02452 16.6667 1.66666 13.3088 1.66666 9.16666Z"
                  fill=""
              />
              <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M13.2857 13.2857C13.6112 12.9603 14.1388 12.9603 14.4642 13.2857L18.0892 16.9107C18.4147 17.2362 18.4147 17.7638 18.0892 18.0892C17.7638 18.4147 17.2362 18.4147 16.9107 18.0892L13.2857 14.4642C12.9603 14.1388 12.9603 13.6112 13.2857 13.2857Z"
                  fill=""
              />
          </svg>
        </button>
      </div>


      <p class="mt-2 text-sm text-white">
        Discover talent in a variety of sectors, including virtual and in-person services.
      </p>
    </div>
  </div>

      
      <div class="relative group mt-14">

        <div class="container px-4 py-8 mx-auto">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
      <div 
        v-for="(item, index) in categories" 
        :key="index" 
        class="flex items-center justify-between p-4 transition-shadow duration-200 border rounded-lg shadow cursor-pointer hover:shadow-lg"
      >
        <div class="flex items-center">
          <!-- SVG icon as an image -->
          <img v-if="item.icon" :src="item.icon" alt="Icon" class="w-6 h-6 mr-3">
          <span class="text-sm md:text-base">{{ item.name }}</span>
        </div>
      </div>
    </div>
    </div>


        <!-- gradient shadow -->
        <!-- <div
          class="absolute -top-6 right-12 w-[90%] h-12 lg:h-[80%] bg-primary/50 blur-3xl rounded-full img-shadow-animation"
        ></div>

        <img
          class="w-full md:w-[1200px] mx-auto rounded-lg relative rouded-lg leading-none flex items-center border border-t-2 border-t-primary/30 img-border-animation"
          :src="
            mode == 'light' ? heroImageLight : heroImageDark
          "
          alt="dashboard using shadcn-vue"
        /> -->

        <!-- gradient effect img -->
        <!-- <div
          class="absolute bottom-0 left-0 w-full h-20 rounded-lg md:h-28 bg-gradient-to-b from-background/0 via-background/50 to-background"
        ></div> -->
      </div>
    </div>
  </section>


  <section>
    
  </section>
</template>

<style scoped>
.img-shadow-animation {
  animation-name: img-shadow-animation;
  animation-iteration-count: infinite;
  animation-duration: 2s;
  animation-timing-function: linear;
  animation-direction: alternate;
}

.img-border-animation {
  animation-name: img-border-animation;
  animation-iteration-count: infinite;
  animation-duration: 2s;
  animation-timing-function: linear;
  animation-direction: alternate;
}

@keyframes img-shadow-animation {
  from {
    opacity: 0.5;
    transform: translateY(30px);
  }

  to {
    opacity: 1;
    transform: translateY(0px);
  }
}
@keyframes img-border-animation {
  from {
    @apply border-t-primary/10;
  }

  to {
    @apply border-t-primary/60;
  }
}
</style>


<!--       <form action="" method="POST" class="px-16 bg-white rounded-2xl">
                <div class="relative">
                    <button class="absolute left-0 -translate-y-1/2 top-1/2">
                        <svg
                            class="fill-body hover:fill-primary dark:fill-bodydark dark:hover:fill-primary"
                            width="20"
                            height="20"
                            viewBox="0 0 20 20"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M9.16666 3.33332C5.945 3.33332 3.33332 5.945 3.33332 9.16666C3.33332 12.3883 5.945 15 9.16666 15C12.3883 15 15 12.3883 15 9.16666C15 5.945 12.3883 3.33332 9.16666 3.33332ZM1.66666 9.16666C1.66666 5.02452 5.02452 1.66666 9.16666 1.66666C13.3088 1.66666 16.6667 5.02452 16.6667 9.16666C16.6667 13.3088 13.3088 16.6667 9.16666 16.6667C5.02452 16.6667 1.66666 13.3088 1.66666 9.16666Z"
                                fill=""
                            />
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M13.2857 13.2857C13.6112 12.9603 14.1388 12.9603 14.4642 13.2857L18.0892 16.9107C18.4147 17.2362 18.4147 17.7638 18.0892 18.0892C17.7638 18.4147 17.2362 18.4147 16.9107 18.0892L13.2857 14.4642C12.9603 14.1388 12.9603 13.6112 13.2857 13.2857Z"
                                fill=""
                            />
                        </svg>
                    </button>

                    <input
                        type="text"
                        placeholder="Type to search..."
                        class="w-full pr-4 bg-transparent border-transparent pl-9 focus:outline-none rounded-xl"
                    />
                </div>
            </form> -->

            <style>
    body {
        font-family: 'Crimson Pro', serif;
    }
</style>