<template>
    <div class="container">
      <BuyerNavbar/>
    
  
        <div class="flex justify-center p-5 space-x-4">
    <!-- Mobile Plan -->
    <div class="w-1/3 p-6 transition-transform transform bg-white border shadow-md rounded-3xl hover:-translate-y-2 hover:shadow-lg">
      <h3 class="px-4 py-2 text-lg font-semibold text-white bg-orange-300 rounded-3xl">
        Mobile
        <span class="block text-sm">480p</span>
      </h3>
      <div class="p-4">
        <p class="text-lg font-bold">₹149</p>
        <p class="text-gray-500">Monthly price</p>

        <p class="mt-4">Video and sound quality</p>
        <p class="text-gray-500">Fair</p>

        <p class="mt-4">Resolution</p>
        <p class="text-gray-500">480p</p>

        <p class="mt-4">Supported devices</p>
        <p class="text-gray-500">Mobile phone, tablet</p>

        <p class="mt-4">Devices your household can watch at the same time</p>
        <p class="text-gray-500">1</p>

        <p class="mt-4">Download devices</p>
        <p class="text-gray-500">1</p>
      </div>
    </div>

    <!-- Basic Plan -->
    <div class="relative w-1/3 p-6 transition-transform transform bg-white border shadow-md rounded-3xl hover:-translate-y-2 hover:shadow-lg">
      <h3 class="relative px-4 py-2 text-lg font-semibold text-white bg-orange-500 rounded-3xl">
        Basic
        <span class="block text-sm">720p</span>
        <span class="absolute top-0 right-0 px-2 py-1 text-xs text-white bg-purple-800">Most Popular</span>
      </h3>
      <div class="p-4">
        <p class="text-lg font-bold">₹199</p>
        <p class="text-gray-500">Monthly price</p>

        <p class="mt-4">Video and sound quality</p>
        <p class="text-gray-500">Good</p>

        <p class="mt-4">Resolution</p>
        <p class="text-gray-500">720p (HD)</p>

        <p class="mt-4">Supported devices</p>
        <p class="text-gray-500">TV, computer, mobile phone, tablet</p>

        <p class="mt-4">Devices your household can watch at the same time</p>
        <p class="text-gray-500">1</p>

        <p class="mt-4">Download devices</p>
        <p class="text-gray-500">1</p>
      </div>
    </div>

    <!-- Standard Plan -->
    <div class="w-1/3 p-6 transition-transform transform bg-white border shadow-md rounded-3xl hover:-translate-y-2 hover:shadow-lg">
      <h3 class="px-4 py-2 text-lg font-semibold text-white bg-orange-700 rounded-3xl">
        Standard
        <span class="block text-sm">1080p</span>
      </h3>
      <div class="p-4">
        <p class="text-lg font-bold">₹499</p>
        <p class="text-gray-500">Monthly price</p>

        <p class="mt-4">Video and sound quality</p>
        <p class="text-gray-500">Great</p>

        <p class="mt-4">Resolution</p>
        <p class="text-gray-500">1080p (Full HD)</p>

        <p class="mt-4">Supported devices</p>
        <p class="text-gray-500">TV, computer, mobile phone, tablet</p>

        <p class="mt-4">Devices your household can watch at the same time</p>
        <p class="text-gray-500">2</p>

        <p class="mt-4">Download devices</p>
        <p class="text-gray-500">2</p>
      </div>
    </div>
  </div>


    <Footer/>
    </div>

</template>

<script setup lang="ts">
import DropdownHeart from '@/Components/Header/DropdownHeart.vue';
import DropdownMessage from '@/Components/Header/DropdownMessage.vue';
import DropdownNotification from '@/Components/Header/DropdownNotification.vue';
import DropdownUserTwo from '@/Components/Header/DropdownUserTwo.vue';
import Footer from '@/Components/LandingPage/Footer.vue';
import BuyerNavbar from '../BuyerNavbar.vue';


</script>