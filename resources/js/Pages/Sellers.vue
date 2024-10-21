
<script setup lang="ts">
import { onMounted, ref } from 'vue';
import axios from 'axios'
import { computed } from '@vue/reactivity';
import Navbar from "@/Components/LandingPage/Navbar.vue";
import Footer from "@/Components/LandingPage/Footer.vue";

// Define your interfaces
interface User {
  id: number;
  name: string;
}

interface PricingDetail {
  price: number;
}

interface Pricing {
  basic: PricingDetail;
  standard: PricingDetail;
  premium: PricingDetail;
}

interface Gig {
  id: number;
  gig_title: string;
  gig_description: string;
  pricing: Pricing;
  user: User;
  category_id: string;
  subcategory_id: string;
}

const gigs = ref<Gig[]>([]);
const extractedValue = ref<string>('');

// Fetch gigs from the backend
const fetchGigs = async () => {
  try {
    const response = await axios.get('/gigs');
    gigs.value = response.data;
  } catch (error) {
    console.error('Error fetching gigs:', error);
  }
};
onMounted(() => {
  fetchGigs();
  const url = window.location.href;
  const match = url.match(/categories\/([^\/]+)\/sellers/);
  if (match) {
    extractedValue.value = match[1];
  }
});
const filteredGigs = computed(() => {
  return gigs.value.filter(gig => gig.subcategory_id === extractedValue.value);
});
const props = defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
}>();
const countMatchingGigs = computed(() => {
  return filteredGigs.value.length;
});
function handleImageError() {
    document.getElementById("screenshot-container")?.classList.add("!hidden");
    document.getElementById("docs-card")?.classList.add("!row-span-1");
    document.getElementById("docs-card-content")?.classList.add("!flex-row");
    document.getElementById("background")?.classList.add("!hidden");
}
</script>

<template>
    <div class="container p-6">
      <Navbar :can-login="canLogin" :can-register="canRegister" />
     <!-- BreadCrumbs -->
      <div class="px-5 mb-5 text-sm leading-none">
        <a href="/"><span>Home /</span>   </a>   
       <a href="/buyer-dashboard"> <span> Dashboard </span></a>
      </div>
      <!-- Filter Section -->
      <div class="flex items-center justify-between px-5 mb-6">
        <div class="flex space-x-4">
          <select class="px-4 py-2 text-sm border border-gray-300 rounded-full">
            <option>Sort by: Service options</option>
              <option>Newest arrivals</option>
              <option>Highest rating</option>
          </select>
          <select class="px-4 py-2 text-sm border border-gray-300 rounded-full">
            <option>Sort by: Seller details</option>
              <option>Newest arrivals</option>
              <option>Highest rating</option>
          </select>
          <select class="px-4 py-2 text-sm border border-gray-300 rounded-full">
            <option>Sort by: Budget</option>
              <option>Newest arrivals</option>
              <option>Highest rating</option>
          </select>
          <select class="px-4 py-2 text-sm border border-gray-300 rounded-full">
            <option>Sort by: Delivery time</option>
              <option>Newest arrivals</option>
              <option>Highest rating</option>
          </select>
        </div>
        <!-- Toggle and Sort Dropdown -->
        <div class="flex items-center space-x-4">
          <label class="flex items-center cursor-pointer">
            <span class="mr-2">Pro services</span>
            <input type="checkbox" class="toggle-checkbox" />
          </label>
          <div class="relative">
            <select class="block w-full p-2 text-sm bg-white border border-gray-300 rounded-full">
              <option>Sort by: Best selling</option>
              <option>Newest arrivals</option>
              <option>Highest rating</option>
            </select>
          </div>
        </div>
      </div>
      
      <!-- Results count -->
      <div class="px-5 mb-4 text-sm text-gray-500">{{countMatchingGigs}} results</div>
  
      <!-- Services Grid -->
    <div class="grid grid-cols-1 gap-6 px-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <div  v-for="gig in filteredGigs" :key="gig.id" class="transition border rounded-lg shadow hover:shadow-lg">
          <img src="" alt="service image" class="object-cover w-full h-40 rounded-t-lg" />
          <div class="p-4">
            <h3 class="mb-2 text-sm font-semibold text-gray-700"><a :href="`/job-description/${gig.id}`">{{ gig.gig_title }}</a></h3>
            <div class="flex items-center mb-2 space-x-2 text-sm text-gray-500">
              <img src="" alt="seller avatar" class="w-6 h-6 rounded-full" />
              <span>{{gig.user.name}}</span>
              <span class="text-xs font-semibold text-yellow-500">ratings</span>
              <span>(reveiws)</span>
            </div>
            <div class="text-sm font-semibold text-black">${{gig.pricing.standard.price}}</div>
          </div>
        </div>
      </div>
      <Footer/>
    </div>
  </template>
  
  <style scoped>
  /* Tailwind CSS styling is used here. Scoped CSS can be added if needed. */
  .toggle-checkbox {
    position: relative;
    appearance: none;
    width: 40px;
    height: 20px;
    background-color: #ddd;
    border-radius: 9999px;
    transition: background-color 0.3s;
  }
  
  .toggle-checkbox:checked {
    background-color: #00c853;
  }
  
  .toggle-checkbox::before {
    content: '';
    position: absolute;
    top: 2px;
    left: 2px;
    width: 16px;
    height: 16px;
    background-color: white;
    border-radius: 9999px;
    transition: transform 0.3s;
  }
  
  .toggle-checkbox:checked::before {
    transform: translateX(20px);
  }
  </style>
  