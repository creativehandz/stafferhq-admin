<script setup lang="ts">
import Footer from '@/Components/LandingPage/Footer.vue'; 
import BuyerRecommendation from '../BuyerDashboard/BuyerRecommendation.vue';
import JobRecommendations from './JobRecommendations.vue';
// import JobsHero from './JobsHero.vue';
import toWork from '@/assets/toworkLogo.svg'
import JobPlans from './JobPlans.vue';
import JobRatingsDropdown from './JobRatingsDropdown.vue';
import ReviewsAndRatings from './ReviewsAndRatings.vue';
import crown from '@/assets/crown.svg'

import workStation from '@/assets/workStation.png';
// import toWork from '@/assets/toworkLogo.svg'
import { defineProps } from 'vue';

const props = defineProps<{
  gig: {
    id: number;
    gig_title: string;
    gig_description: string;
    user: {
      name: string;
    };
  };
}>();

</script>


<template>

    <div class="container text-black">
      <!-- Navbar -->
      <div class="flex items-center justify-between gap-5 p-5">
        <a href="/" ><img :src="toWork" alt="Logo" class="w-auto h-9"></a>
        
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
              <!-- Hero Section -->    
    <div class="max-w-4xl p-6 mx-auto mb-10 space-y-4 bg-white shadow-md rounded-xl">
      <!-- Breadcrumb -->
      <div class="text-sm text-gray-500">
        <span>Home /</span>
        <span> Lorem ipsum /</span>
        <span> Web designing</span>
      </div>

      <!-- Header and Main Image -->
      <div class="flex items-center space-x-4">
        <img
          :src="workStation"
          alt="Main Service Image"
          class="object-cover w-32 h-32 rounded-lg"
        />
        <div v-if="gig">
          <h2 class="flex items-center text-xl font-bold">{{ gig.user.name }} (online<p class="text-[10px]">🟢</p>)</h2>
          <p class="leading-none sm:text-[22px]  md:text-[22px] lg:text-[22px] xl:text-[22px] 2xl:text-[22px] font-bold">Web Designer | Visual Artist</p>
          <p class="text-gray-500">{{gig.gig_title }}</p>
          <div class="flex items-center mt-2">
            <span class="">★ 4.8 (2k)</span>
            <a href="#" class="ml-2 font-bold text-yellow-500 underline">See reviews</a>
          </div>
        </div>
      </div>

      <!-- Availability -->
      <div class="text-sm text-gray-600">
        <p>Available in 2 days</p>
        <p>Working on 4 projects</p>
        <p>Success rating of 98%</p>
      </div>

    <!-- Gallery of Thumbnails -->
      <div class="flex space-x-2">
        <img
          :src="workStation"
          alt="Thumbnail 1"
          class="object-cover w-16 h-16 rounded-lg"
        />
        <img
          :src="workStation"
          alt="Thumbnail 2"
          class="object-cover w-16 h-16 rounded-lg"
        />
        <img
          :src="workStation"
          alt="Thumbnail 3"
          class="object-cover w-16 h-16 border-orange-300 rounded-lg"
        />
        <img
          :src="workStation"
          alt="Thumbnail 4"
          class="object-cover w-16 h-16 rounded-lg"
        />
        <img
          :src="workStation"
          alt="Thumbnail 4"
          class="object-cover w-16 h-16 rounded-lg"
        />
      </div>

    <!-- About this service -->
      <div class="space-y-2">
        <h3 class="text-lg font-bold">About this service (500 char max)</h3>
        <p class="text-gray-600">
          {{ gig.gig_description }}
        </p>
      </div>

      <!-- Skills and languages -->
      <div class="space-y-2">
        <h3 class="text-lg font-bold">Skills and languages:</h3>
        <div class="flex space-x-2">
          <span class="px-2 py-1 text-sm text-pink-700 bg-pink-100 rounded-full">HTML</span>
          <span class="px-2 py-1 text-sm text-pink-700 bg-pink-100 rounded-full">SCSS</span>
          <span class="px-2 py-1 text-sm text-pink-700 bg-pink-100 rounded-full">JavaScript</span>
        </div>
      </div>
  </div>

         <div class="flex flex-row" >
          <ReviewsAndRatings/>
          <JobRatingsDropdown/>        
         </div>
       </div>
       <div class="">
         <JobPlans/>      
        
       </div> 
     </div>
    <JobRecommendations/>
    <Footer/>
    </div>
</template>