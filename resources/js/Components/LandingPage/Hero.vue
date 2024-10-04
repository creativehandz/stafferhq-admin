<script setup lang="ts">
import { useColorMode } from "@vueuse/core";
const mode = useColorMode();
</script>

<template>
  <section class="container">
    <div class="">
      <div class="px-6 py-12 text-white bg-orange-500 rounded-3xl md:px-16">
         <div class="container flex flex-col items-start mx-auto md:flex-row">
            <!-- Text Section -->
                <div class="text-center md:text-left md:w-1/2">
                <h1 class="font-bold leading-none sm:text-[70px]  md:text-[70px] lg:text-[70px] xl:text-[70px] 2xl:text-[70px]">Work. Simplified. Let's get ToWork.</h1>
                <p class="mt-4 sm:text-[20px]  md:text-[20px] lg:text-[20px] xl:text-[20px] 2xl:text-[20px]">
                Find all kinds of job opportunities in and around Malaysia. Sell your services. Or buy them.
                </p>
            </div>

      <!-- Image Section -->
      <div class="flex justify-center mt-6 md:mt-0 md:w-1/2">
        <img src="../../../img/womenPot.png" alt="Illustration" class="w-64 md:w-80">
      </div>
    </div>

    <!-- Search Section -->
    <div class="mt-8">
      
         <div class="flex w-3/6 m-auto bg-white rounded-full">
            <div class="px-3 py-2">
              <input type="text" placeholder="Search for a service" class="w-full text-sm text-black border-none outline-none search-box " />   
            </div>              
            <div class="flex items-end justify-end ">
              <button type="submit">
                <img src="search-icon.png" alt="search" class="w-5 h-5" />
              </button>
            </div>
            
        </div>      
          <div class="w-3/6 m-auto text-center">
            <p class="text-sm text-white ">
              Discover talent in a variety of sectors, including virtual and in-person services.
            </p>
          </div>            
          </div>
        </div> 
    </div>
  </section>

</template>

<style scoped>
    h1 {
        font-family: 'Crimson Pro', serif;        
    }    
    p {
      font-family: 'Neue Montreal regular';
      /* font-size: 32px; */

    }
    .below-box {
      font-size: 20px;
      line-height: 24px;
    }
    .search-box {
      justify-content: flex-start;
    }
    
    
</style>