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
      
         <div class="flex w-[650px] py-5 bg-white border-orange-500 rounded-full search-box space-x-70 px-60">          
            <div>
              <input type="text" placeholder="Search for a service" class="w-full text-sm text-black border-none outline-none search-box " />   
            </div>              
            <div>
              <button type="submit">
                <img src="search-icon.png" alt="search" class="w-5 h-5" />
              </button>
            </div>
        </div> 
        <!-- <div class="w-full" data-style="clean"><label for="member_email" class="hidden">Email address</label><div class="relative h-full"><div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none"><svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16"><path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"></path><path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"></path></svg></div><input type="email" id="member_email" name="email_address" class="block w-full px-3 py-4 text-base text-gray-900 bg-white border border-gray-200 pl-11 rounded-l-xl formkit-input focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder:text-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter your email" ></div></div> -->      
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
      font-family: 'Neue Montreal regular';
      font-size: 32px;
      line-height: 38.2px;      
    }
    .below-box {
      font-size: 20px;
      line-height: 24px;
    }
    .search-box {
      justify-content: flex-start;
    }
    
    
</style>