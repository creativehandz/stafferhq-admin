<script setup lang="ts">
import Footer from '@/Components/LandingPage/Footer.vue'; 
import toWork from '@/assets/toworkLogo.svg'
import BuyerRecommendation from '../BuyerDashboard/BuyerRecommendation.vue';
import JobsReview from './JobsReview.vue';

</script>


<template>

    <div class="container text-black">
    
    <!-- Navbar -->
    <div class="flex items-center justify-between gap-5 p-5">
        <img :src="toWork" alt="Logo" class="w-auto h-12">
        
        <div class="mt-5 mb-5">
            <input type="text" placeholder="Search for a service" class="w-[250px] rounded-3xl border text-black bg-transparent h-[44px] px-4">
        </div>

        <div class="flex items-center gap-4">
            <button class="text-black">Premium</button>
            <button class="text-black">Find work</button>
            <button class="text-black">Become a seller</button>
            <button class="px-6 py-2 text-black shadow-lg bg-cyan-400 rounded-3xl hover:bg-cyan-500">Log In</button>
            <button class="px-6 py-2 text-black shadow-lg bg-cyan-400 rounded-3xl hover:bg-cyan-500">Sign Up</button>
        </div>
    </div>
    <!-- Navbar ends -->

    <!-- Hero Section -->
    <div class="max-w-3xl p-6 mx-auto space-y-4 bg-white shadow-md rounded-xl">
      <!-- Breadcrumb -->
      <div class="text-sm text-gray-500">
        <span>Home /</span>
        <span> Lorem ipsum /</span>
        <span> Web designing</span>
      </div>

      <!-- Header and Main Image -->
      <div class="flex items-center space-x-4">
        <img
          src="https://via.placeholder.com/150"
          alt="Main Service Image"
          class="object-cover w-32 h-32 rounded-lg"
        />
        <div>
          <h2 class="text-xl font-bold">Jane Doe</h2>
          <p class="text-gray-700">Web Designer | Visual Artist</p>
          <p class="text-gray-500">I will create a website for you from scratch! Short bio goes here.</p>
          <div class="flex items-center mt-2">
            <span class="text-yellow-500">★ 4.8 (2k)</span>
            <a href="#" class="ml-2 text-blue-500">See reviews</a>
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
          src="https://via.placeholder.com/100"
          alt="Thumbnail 1"
          class="object-cover w-16 h-16 rounded-lg"
        />
        <img
          src="https://via.placeholder.com/100"
          alt="Thumbnail 2"
          class="object-cover w-16 h-16 rounded-lg"
        />
        <img
          src="https://via.placeholder.com/100"
          alt="Thumbnail 3"
          class="object-cover w-16 h-16 rounded-lg"
        />
        <img
          src="https://via.placeholder.com/100"
          alt="Thumbnail 4"
          class="object-cover w-16 h-16 rounded-lg"
        />
      </div>

    <!-- About this service -->
      <div class="space-y-2">
        <h3 class="text-lg font-bold">About this service (500 char max)</h3>
        <p class="text-gray-600">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pretium est non nunc tempor
          laoreet. Nullam ac metus tristique arcu auctor commodo. Nam fringilla dapibus purus, eget
          tempor sapien aliquam id. Nunc et feugiat leo.
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

    
    <JobsReview/>
    <BuyerRecommendation/>
    <Footer/>
    </div>
</template>