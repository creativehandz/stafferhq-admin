<script setup lang="ts">
import { ref } from 'vue';

import BuyerRecommendation from './BuyerRecommendation.vue';
import BuyerProfessionals from './BuyerProfessionals.vue';
import { Link } from "@inertiajs/vue3";
import Button from '@/Components/LandingPage/ui/button/Button.vue';
import ToggleTheme from '@/Components/LandingPage/ToggleTheme.vue';
import DropdownNotification from '@/Components/Header/DropdownNotification.vue';
import DropdownMessage from '@/Components/Header/DropdownMessage.vue';
import DropdownHeart from '@/Components/Header/DropdownHeart.vue';
import DropdownUserTwo from '@/Components/Header/DropdownUserTwo.vue';
import Footer from '@/Components/LandingPage/Footer.vue';
import GigDetails from './gigDetails.vue';
import BuyerNavbar from '../BuyerNavbar.vue';

// Reactive state for search input and username
const searchQuery = ref('');
const username = ref('User');

// Search method to handle the search button
const search = () => {
  if (searchQuery.value.trim()) {
    alert(`Searching for: ${searchQuery.value}`);
    // Implement search logic here (e.g., API call or route change)
  } else {
    alert('Please enter a service to search for.');
  }
};
</script>

<template>
    <section class="container">
    <BuyerNavbar/>
             <!-- BreadCrumbs -->
    <div class="mb-5 text-sm leading-none">
        <a href="/"><span>Home /</span>   </a>   
       <a href="/buyer-dashboard"> <span> Dashboard </span></a>
      </div>
         <!-- Hero section -->
        <div class="px-6 py-12 text-white bg-orange-500 rounded-3xl ">
           <div class="container flex ">
              <!-- Text Section -->                
                <!-- Right Content Section (Text Right Aligned and Single Line h1) -->
                <div class="flex flex-col justify-center w-1/2 text-right space-y-9">
                    <h1 class="font-bold text-left leading-none sm:text-[55px] md:text-[55px] lg:text-[55px] xl:text-[55px] 2xl:text-[55px]">
                        Welcome back, {{ $page.props.auth.user.name }}
                    </h1>
                    <div class="flex gap-4">
                        <button class="w-1/2 px-6 py-3 font-semibold text-black bg-teal-300 rounded-full hover:bg-teal-400 focus:outline-none">
                        Create a brief for clients
                        </button>
                        <button class="w-1/2 px-6 py-3 font-semibold text-black bg-teal-300 rounded-full hover:bg-teal-400 focus:outline-none">
                        Explore opportunities
                        </button>
                    </div>
                </div>                
                <div class="flex justify-center w-1/2">
                    <img src="../../../img/womenRiding.png" alt="Working Lady" />
                </div>                            
             </div>
        </div>
        <!-- Other Sections -->
        
</section>  
<BuyerRecommendation/>
<BuyerProfessionals/>
<!-- <GigDetails/> -->
<Footer/>

</template>
  

  
  <style scoped>
  /* Add any component-specific styles here */
  </style>
  