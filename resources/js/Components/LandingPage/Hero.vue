<script setup lang="ts">
import { useColorMode } from "@vueuse/core";
const mode = useColorMode();
</script>

<template>
  <section class="container">
    <div class="py-20">
      <div class="px-6 py-12 text-white bg-orange-500 rounded-3xl md:px-16">
         <div class="container flex flex-col items-center mx-auto md:flex-row">
            <!-- Text Section -->
                <div class="text-center md:text-left md:w-1/2">
                <h1 class="font-bold leading md:text-4xl">Work.&nbsp;Simplified.<br>Let's&nbsp;get&nbsp;ToWork.</h1>
                <p class="mt-4 text-base md:text-lg">
                Find&nbsp;all&nbsp;kinds&nbsp;of&nbsp;job&nbsp;opportunities&nbsp;in&nbsp;and&nbsp;around<br/> Malaysia. Sell your services. Or buy them.
                </p>
            </div>

      <!-- Image Section -->
      <div class="flex justify-center mt-6 md:mt-0 md:w-1/2">
        <img src="../../../img/womenPot.png" alt="Illustration" class="w-64 md:w-80">
      </div>
    </div>

    <!-- Search Section -->
    <div class="flex flex-col items-center mt-8">
      
        <div class="flex py-5 bg-white border-orange-500 rounded-full space-x-70 px-60">          
            <div>
              <input type="text" placeholder="Search for a service" class="w-full text-sm text-black border-none outline-none" />   
            </div>              
            <div>
              <button type="submit">
                <img src="search-icon.png" alt="search" class="w-5 h-5" />
              </button>
            </div>
        </div>

            <p class="mt-2 text-sm text-white below-box">
              Discover talent in a variety of sectors, including virtual and in-person services.
            </p>
          </div>
        </div> 
    </div>
  </section>

</template>

<style scoped>
    h1 {
        font-family: 'Crimson Pro', serif;
        font-size: 80px;
        line-height: 96px;
    }    
    p {
      font-family: Neue Montreal regular;
      font-size: 32px;
      line-height: 38.2px;      
    }
    .below-box {
      font-size: 20px;
      line-height: 24px;
    }
    
</style>