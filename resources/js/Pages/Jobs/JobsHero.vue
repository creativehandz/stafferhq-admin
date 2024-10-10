<template>
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
        <div>
          <h2 class="flex items-center text-xl font-bold">Jane Doe (online<p class="text-[10px]">🟢</p>)</h2>
          <p class="leading-none sm:text-[22px]  md:text-[22px] lg:text-[22px] xl:text-[22px] 2xl:text-[22px] font-bold">Web Designer | Visual Artist</p>
          <p class="text-gray-500">I will create a website for you from scratch! Short bio goes here.</p>
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

</template>

<script setup lang="ts">
import workStation from '@/assets/workStation.png';
import toWork from '@/assets/toworkLogo.svg'
</script>


<style scoped>
h2{
    font-family: "Crimson ro";
}
</style>