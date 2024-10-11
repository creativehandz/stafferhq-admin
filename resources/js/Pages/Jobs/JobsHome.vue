<script setup lang="ts">
import Footer from '@/Components/LandingPage/Footer.vue'; 
import BuyerRecommendation from '../BuyerDashboard/BuyerRecommendation.vue';
import JobRecommendations from './JobRecommendations.vue';
// import JobsHero from './JobsHero.vue';
import toWork from '@/assets/toworkLogo.svg'

import JobRatingsDropdown from './JobRatingsDropdown.vue';
import ReviewsAndRatings from './ReviewsAndRatings.vue';
import crown from '@/assets/crown.svg'
import { ref } from 'vue';
  
  import profileIcon from '@/assets/profileIcon.png';
  // Reactive state for current tab
  const currentTab = ref('Basic');
import workStation from '@/assets/workStation.png';
// import toWork from '@/assets/toworkLogo.svg'
import { defineProps } from 'vue';

// Define the structure of the gig prop
interface Pricing {
  name: string;
  description: string;
  delivery_time: string;
  revisions: string;
  price: string;
}

interface Gig {
  id: number;
  gig_title: string;
  gig_description: string;
  pricing: {
    basic: Pricing;
    standard: Pricing;
    premium: Pricing;
  };
  user: {
    name: string;
  };
}

const props = defineProps<{
  gig: {
    id: number;
  gig_title: string;
  gig_description: string;
  pricing: {
    basic: Pricing;
    standard: Pricing;
    premium: Pricing;
  };
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
        <div class="sticky top-0 z-10 flex flex-col items-center ml-5">
  <div class="container max-w-md p-6 rounded-3xl bg-[#FFDECA] ">
    <!-- Tab Headers -->
    <div class="flex justify-between p-2 bg-gray-100 rounded-lg slide_text leading-none sm:text-[22px]  md:text-[22px] lg:text-[22px] xl:text-[22px] 2xl:text-[22px]">
      <button
        :class="currentTab === 'Basic' ? 'font-bold underline' : 'font-bold'"
        @click="currentTab = 'Basic'"
      >
        Basic
      </button>
      <button
        :class="currentTab === 'Standard' ? 'font-bold underline' : 'font-bold'"
        @click="currentTab = 'Standard'"
      >
        Standard
      </button>
      <button
        :class="currentTab === 'Premium' ? 'font-bold underline' : 'font-bold'"
        @click="currentTab = 'Premium'"
      >
        Premium
      </button>
    </div>

    <!-- Dynamic Box Content -->
    <div class="w-full p-6 mt-4 rounded-3xl transition-all duration-500 bg-[#f1b792]">
    
    <!-- Basic Plan -->
    <div v-if="currentTab === 'Basic'">
      <h3 class="text-2xl font-bold">${{ gig.pricing.basic.price }}</h3>
      <p class="mt-2 text-sm text-gray-700">
        {{ gig.pricing.basic.description }}
      </p>
      <ul class="mt-4 space-y-2">
        <li>✔️ Delivery time: {{ gig.pricing.basic.delivery_time }}</li>
        <li>✔️ Revisions: {{ gig.pricing.basic.revisions }}</li>
      </ul>
    </div>

    <!-- Standard Plan -->
    <div v-if="currentTab === 'Standard'">
      <h3 class="text-2xl font-bold">${{ gig.pricing.standard.price }}</h3>
      <p class="mt-2 text-sm text-gray-700">
        {{ gig.pricing.standard.description }}
      </p>
      <ul class="mt-4 space-y-2">
        <li>✔️ Delivery time: {{ gig.pricing.standard.delivery_time }}</li>
        <li>✔️ Revisions: {{ gig.pricing.standard.revisions }}</li>
      </ul>
    </div>

    <!-- Premium Plan -->
    <div v-if="currentTab === 'Premium'">
      <h3 class="text-2xl font-bold">${{ gig.pricing.premium.price }}</h3>
      <p class="mt-2 text-sm text-gray-700">
        {{ gig.pricing.premium.description }}
      </p>
      <ul class="mt-4 space-y-2">
        <li>✔️ Delivery time: {{ gig.pricing.premium.delivery_time }}</li>
        <li>✔️ Revisions: {{ gig.pricing.premium.revisions }}</li>
      </ul>
    </div>

  </div>

    <div>
  </div>

    <!-- Contact Section -->
  </div>
  <div class="flex items-center justify-center gap-4 mt-5">
    <img :src="profileIcon" alt="Profile Icon" class="w-10 h-10" />
    <button class="w-40 h-12 bg-[#F5F535] shadow-md rounded-3xl">
      Contact Me
    </button>
  </div>
  </div>     
        
       </div> 
     </div>
    <BuyerRecommendation/>
    <Footer/>
    </div>
</template>