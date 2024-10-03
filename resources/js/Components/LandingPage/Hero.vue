<script setup lang="ts">
import { useColorMode } from "@vueuse/core";
const mode = useColorMode();

import { Badge } from "@/Components/LandingPage/ui/badge";
import { Button } from "@/Components/LandingPage/ui/button";
import { ArrowRight } from "lucide-vue-next";
import heroImageLight from '../../../img/LandingPage/heroImageLight.jpg'
import heroImageDark from '../../../img/LandingPage/heroImageDark.jpg'

</script>

<template>
  <section class="container">
    <div class="py-20">
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
                <h1 class="text-2xl font-bold leading md:text-4xl">Work. Simplified.<br>Let's get <span class="font-extrabold">ToWork.</span></h1>
                <p class="mt-4 text-base md:text-lg">
                  Find all kinds of job opportunities in and around<br/> Malaysia. Sell your services. Or buy them.
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
      </div>
    </div>
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

<style scoped>
    h1 {
        font-family: 'Crimson Pro', serif;
    }    
</style>