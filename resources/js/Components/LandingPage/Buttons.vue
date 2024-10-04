<template>
    <div class="container px-8 py-8 mx-auto">
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <div 
          v-for="(item, index) in categories" 
          :key="index" 
          class="flex items-center justify-between px-6 py-8 transition-shadow duration-200 rounded-lg shadow-md cursor-pointer hover:shadow-lg"
        >
          <div class="flex items-center">
            <!-- SVG icon as an image -->
            <img v-if="item.icon" :src="item.icon" alt="Icon" class="w-6 h-6 mr-3">
            <span class="leading-none sm:text-[18px]  md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px] button-items">{{ item.name }}</span>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import webIcon from '../../../img/logos/Layer_2.svg';
  import translationIcon from '../../../img/logos/translation-icon.svg';
  import animationIcon from '../../../img/logos/camRa.svg';
  import graphicsIcon from '../../../img/logos/amination-icon.svg';
  import inpersonIcon from '../../../img/logos/scissors_2.svg';
  import aiIcon from '../../../img/logos/ai-icon.svg';
  import musicIcon from '../../../img/logos/music-icon.svg';
  import businessIcon from '../../../img/logos/businessM.svg';
  
  const categories = [
    { name: "Web and digital services", icon: webIcon },
    { name: "Translation and linguistics", icon: translationIcon },
    { name: "Animation and video", icon: animationIcon },
    { name: "Graphics and design", icon: graphicsIcon },
    { name: "In-person services", icon: inpersonIcon },
    { name: "AI and ML", icon: aiIcon },
    { name: "Music and audio", icon: musicIcon },
    { name: "Business and networking", icon: businessIcon },
  ];
  </script>
  

  