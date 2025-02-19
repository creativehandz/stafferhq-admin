<script setup lang="ts">
import Footer from '@/Components/LandingPage/Footer.vue'; 
import BuyerRecommendation from '../BuyerDashboard/BuyerRecommendation.vue';
import JobRatingsDropdown from './JobRatingsDropdown.vue';
import ReviewsAndRatings from './ReviewsAndRatings.vue';
import { computed, ref } from 'vue';
import profileIcon from '@/assets/profileIcon.png';
import workStation from '@/assets/workStation.png';
import { defineProps } from 'vue';
import DropdownUserTwo from '@/Components/Header/DropdownUserTwo.vue';
import DropdownHeart from '@/Components/Header/DropdownHeart.vue';
import DropdownMessage from '@/Components/Header/DropdownMessage.vue';
import DropdownNotification from '@/Components/Header/DropdownNotification.vue';
import Pricing from '@/Components/LandingPage/Pricing.vue';
import axios from 'axios';
import BuyerNavbar from '../BuyerNavbar.vue';
const currentTab = ref('Basic');
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
  positive_keywords: string;
  file_path: string;

  };
  
}>();

// Dynamically select the pricing based on the current tab
const selectedPricing = computed(() => {
  if (props.gig && props.gig.pricing) {
    const pricingKey = currentTab.value.toLowerCase(); // 'basic', 'standard', or 'premium'
    
    // Get the selected package (basic, standard, or premium)
    const selectedPackage = props.gig.pricing[pricingKey as keyof typeof props.gig.pricing];
    
    // Return the price of the selected package or '0' if not found
    return selectedPackage?.price || '0';
  }
  return '0'; // Return '0' if gig or pricing is unavailable
});
const selectedPackage = computed(() => {
  if (props.gig && props.gig.pricing) {
    const pricingKey = currentTab.value.toLowerCase(); // 'basic', 'standard', or 'premium'
    return props.gig.pricing[pricingKey as keyof typeof props.gig.pricing];
  }
  return { price: 0, description: '', delivery_time: '', revisions: '' };
});

// Convert the comma-separated string into an array
const keywordList = computed(() => props.gig.positive_keywords.split(','));

// State to control the visibility of the sidebar
const isOpen = ref(false);

// Function to open the sidebar
const openSidebar = () => {
  isOpen.value = true;
};

// Function to close the sidebar
const closeSidebar = () => {
  isOpen.value = false;
};
  // State for gig quantity
  const quantity = ref(1);
  
  // State for extras
  const extraFastDelivery = ref(false);
  const includeSourceFile = ref(false);
  
  // Prices
  const basePrice = 3972;
  const extraFastPrice = 1324;
  const includeSourcePrice = 1765;
  
  // Computed property to calculate the total
  const total = computed(() => {
    let totalAmount = basePrice * quantity.value;
    if (extraFastDelivery.value) totalAmount += extraFastPrice;
    if (includeSourceFile.value) totalAmount += includeSourcePrice;
    return totalAmount;
  });

  const storePackage = () => {
    const packageData = {
      packageName: currentTab.value,
      packagePrice: selectedPackage.value.price,
      packageDescription: selectedPackage.value.description,
      deliveryTime: selectedPackage.value.delivery_time,
      revisions: selectedPackage.value.revisions,
      gigId: props.gig.id,
    };

  axios.post('/store-package', packageData)
    .then(response => {
      // Redirect to the checkout page
      window.location.href = '/checkout';
    })
    .catch(error => {
      console.error("Error storing package data:", error);
    });
};

const getImageUrl = (filePath: string | string[]) => {
  if (Array.isArray(filePath) && filePath.length > 0) {
    // Handle already-parsed array
    return `/storage/${filePath[0]}`;
  } 
  if (typeof filePath === 'string') {
    try {
      // Handle JSON-encoded string
      const parsedPath = JSON.parse(filePath);
      if (Array.isArray(parsedPath) && parsedPath.length > 0) {
        return `/storage/${parsedPath[0]}`;
      }
    } catch (error) {
      console.error("Error parsing file path:", error);
    }
  }
  // Fallback image
  return '/images/default-gig.png';
};
</script>


<template>

    <div class="container text-black">
    <BuyerNavbar/>
    
     <div class="flex mt-5 mb-10">
       <div>      
    <!-- Hero Section -->    
    <div class="p-6 mx-auto mb-10 space-y-4 bg-white shadow-md rounded-xl">
      <!-- Breadcrumb -->
      <div class="text-sm text-gray-500">
        <span><a href="/">Home / </a></span>
        <span> <a href="/buyer-dashboard"> Dashboard /</a> </span>
        <span><a href="#"> {{gig.gig_title }}</a> </span>
      </div>

      <!-- Header and Main Image -->
      <div class="flex items-center space-x-4">
        <img
          :src="getImageUrl(gig.file_path)"
          alt="Main Service Image"
          class="object-cover w-32 h-32 rounded-lg"
        />
        <div v-if="gig">
          <h2 class="flex items-center text-xl font-bold">{{ gig.user.name }} (online<p class="text-[10px]">🟢</p>)</h2>
          <p class="leading-none sm:text-[22px]  md:text-[22px] lg:text-[22px] xl:text-[22px] 2xl:text-[22px] font-bold">{{gig.gig_title }}</p>
          <p class="text-gray-500"></p>
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
      <!--div class="flex space-x-2">
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
      </div-->

    <!-- About this service -->
      <div class="space-y-2">
        <h3 class="text-lg font-bold">About this service (500 char max)</h3>
        <p class="text-gray-600">
          {{ gig.gig_description }}
        </p>
      </div>

      <!-- Skills and languages -->
      <!--div class="space-y-2">
        <h3 class="text-lg font-bold">Skills and languages:</h3>
        <div class="flex space-x-2">
          <span v-for="(keyword, index) in keywordList" :key="index" class="px-2 py-1 text-sm text-pink-700 bg-pink-100 rounded-full">
            {{ keyword }}
          </span>
         </div>
      </div-->
  </div>

         <div class="flex flex-row" >
          <ReviewsAndRatings/>
          <JobRatingsDropdown/>        
         </div>
       </div>
       <div class="">
          <div class="sticky flex flex-col items-center ml-5 z-5 top-10">
            <div class="container w-70  p-6 rounded-3xl bg-[#FFDECA] ">
              <!-- Tab Headers -->
              <div class="flex justify-between p-2 bg-gray-100 rounded-lg slide_text leading-none sm:text-[18px]  md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px]">
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
        <!--li>✔️ Revisions: {{ gig.pricing.basic.revisions }}</li-->
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
        <!--li>✔️ Revisions: {{ gig.pricing.standard.revisions }}</li-->
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
        <!--li>✔️ Revisions: {{ gig.pricing.premium.revisions }}</li-->
      </ul>
    </div>
    <div class="flex flex-col items-center mt-5 text-center">
      <p class="mb-10"><strong>Select the packege. </strong></p>
      <button class="w-40 h-12 bg-[#F5F535] shadow-md rounded-3xl"  @click="openSidebar" > Continue </button>
    </div>
  </div>
  <div>
    <!-- Slider - Sidebar -->
    <div
      id="sidebar"
      :class="isOpen ? 'translate-x-0' : 'translate-x-full'"
      class="fixed top-0 right-0 z-50 w-64 h-full text-black transition-transform duration-300 transform bg-white"
    >
      <div class="flex items-center justify-between p-4 border-b">
        <h2 class="text-lg font-bold ">Order options</h2>
        <!-- Close button -->
        <button @click="closeSidebar" class="text-xl text-black-2">×</button>
      </div>
      
      <!-- Package Section -->
      <div class="p-4 border-b">
        <div class="flex items-center justify-between">
          <div>
              <h3 class="font-bold text-md">{{ currentTab }} Package</h3>
              <p class="text-sm text-gray-500">{{ selectedPackage.description }}</p>
              <ul class="mt-2 text-sm text-gray-500">
                <li>✔️ Delivery time: {{ selectedPackage.delivery_time }}</li>
                <li>✔️ Revisions: {{ selectedPackage.revisions }}</li>
              </ul>
            </div>
          
        </div>
      </div>
      <!-- Total Section -->
      <div class="p-4 border-t">
        <div class="flex items-center justify-between">
          <span class="font-semibold">Total:</span>
          <span class="text-lg font-bold">${{ selectedPackage.price }}</span>
        </div>
      </div>

      <div class="fixed bottom-0 w-full p-4 text-center" >
          <button class="w-full py-3 text-white bg-blue-600 rounded-md shadow-md hover:bg-blue-700" @click="storePackage" >Continue ${{ selectedPricing }}</button>
        <p class="leading-none sm:text-[12px]  md:text-[12px] lg:text-[12px] xl:text-[12px] 2xl:text-[12px]">You won’t be charged yet</p>  
      </div>

    </div>
    <!-- <a href="/demo-me"> -->
    <!-- Overlay when sidebar is open -->
    <div
      v-if="isOpen"
      @click="closeSidebar"
      class="fixed inset-0 bg-black opacity-50"
    ></div>
  </div>
  <!-- slider - sidebar ends -->
   
  <!-- <a :href="`/checkout/${gig.id}?pricing=${selectedPricing}`" class="w-20 bg-green-200 rounded-3xl"> -->
    <div>
  </div>

    <!-- Contact Section -->
  </div>
  <!--div class="flex items-center justify-center gap-4 mt-5">
    <img :src="profileIcon" alt="Profile Icon" class="w-10 h-10" />
    <a href="/contact-me">  <button class="w-40 h-12 bg-[#F5F535] shadow-md rounded-3xl">
      Contact Me
    </button> </a>
  </div-->
  </div>     
        
       </div> 
     </div>
    <BuyerRecommendation/>
    <Footer/>
    </div>
</template>