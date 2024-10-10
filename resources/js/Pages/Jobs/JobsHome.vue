<script setup lang="ts">
import Footer from '@/Components/LandingPage/Footer.vue'; 
import BuyerRecommendation from '../BuyerDashboard/BuyerRecommendation.vue';
import JobRecommendations from './JobRecommendations.vue';
import JobsHero from './JobsHero.vue';
import toWork from '@/assets/toworkLogo.svg'
import JobPlans from './JobPlans.vue';
import JobRatingsDropdown from './JobRatingsDropdown.vue';
import ReviewsAndRatings from './ReviewsAndRatings.vue';
import crown from '@/assets/crown.svg'

</script>


<template>

    <div class="container text-black">
      <!-- Navbar -->
      <div class="flex items-center justify-between gap-5 p-5">
        <img :src="toWork" alt="Logo" class="w-auto h-9">
        
        <div class="mt-5 mb-5">
            <input type="text" placeholder="Search for a service" class="w-[250px] rounded-3xl border text-black bg-transparent h-[44px] px-4">
        </div>

        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">              
              <button class="text-black leading-none sm:text-[18px]  md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px]">Premium </button><img :src="crown" class="w-6" alt="">
            </div>
            <button class="text-black leading-none sm:text-[18px]  md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px]">Find work</button>
            <button class="text-black leading-none sm:text-[18px]  md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px]">Become a seller</button>
            <button class="px-6 py-2 text-black shadow-lg bg-[#A4FCFF] rounded-3xl hover:bg-cyan-500 leading-none sm:text-[18px]  md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px]">Log In</button>
            <button class="px-6 py-2 text-black shadow-lg bg-[#A4FCFF] rounded-3xl hover:bg-cyan-500 leading-none sm:text-[18px]  md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px]">Sign Up</button>
        </div>
      </div>
    <!-- Navbar ends -->
     <div class="flex mt-5 mb-10">
       <div>      
          <JobsHero/>
         <div class="flex flex-row" >
          <ReviewsAndRatings/>
          <JobRatingsDropdown/>        
         </div>
       </div> 
       <JobPlans/>      
     </div>
    <JobRecommendations/>
    <Footer/>
    </div>
</template>