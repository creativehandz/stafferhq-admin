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
      <div class="px-5 mb-4 text-sm text-gray-500">9,400+ results</div>
  
      <!-- Services Grid -->
      <div class="grid grid-cols-1 gap-6 px-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <div v-for="service in services" :key="service.id" class="transition border rounded-lg shadow hover:shadow-lg">
          <img :src="service.image" alt="service image" class="object-cover w-full h-40 rounded-t-lg" />
          <div class="p-4">
            <h3 class="mb-2 text-sm font-semibold text-gray-700">{{ service.title }}</h3>
            <div class="flex items-center mb-2 space-x-2 text-sm text-gray-500">
              <img :src="service.sellerAvatar" alt="seller avatar" class="w-6 h-6 rounded-full" />
              <span>{{ service.seller }}</span>
              <span class="text-xs font-semibold text-yellow-500">{{ service.rating }}</span>
              <span>({{ service.reviews }})</span>
            </div>
            <div class="text-sm font-semibold text-black">{{ service.price }}</div>
          </div>
        </div>
      </div>
      <Footer/>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref } from 'vue';
  
  const services = ref([
    {
      id: 1,
      image: 'https://via.placeholder.com/300x200',
      title: 'I will develop web application, web based software and mobile app',
      seller: 'Fabtechsol',
      sellerAvatar: 'https://via.placeholder.com/50',
      rating: 4.9,
      reviews: 194,
      price: 'From ₹132,365',
    },
    {
      id: 2,
      image: 'https://via.placeholder.com/300x200',
      title: 'I will do python scripts, projects, and machine learning',
      seller: 'Mujtaba Abbas',
      sellerAvatar: 'https://via.placeholder.com/50',
      rating: 4.9,
      reviews: 17,
      price: 'From ₹442',
    },
    {
      id: 3,
      image: 'https://via.placeholder.com/300x200',
      title: 'I will build custom bot software to automate any tasks',
      seller: 'Alzaal A',
      sellerAvatar: 'https://via.placeholder.com/50',
      rating: 5.0,
      reviews: 36,
      price: 'From ₹442',
    },
    {
      id: 4,
      image: 'https://via.placeholder.com/300x200',
      title: 'I will write code, scripts, assignments in python java c cpp sql',
      seller: 'Haseeb',
      sellerAvatar: 'https://via.placeholder.com/50',
      rating: 5.0,
      reviews: 40,
      price: 'From ₹442',
    },
  ]);

  import { Head, Link } from "@inertiajs/vue3";


import Navbar from "@/Components/LandingPage/Navbar.vue";
import Footer from "@/Components/LandingPage/Footer.vue";


const props = defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
}>();

function handleImageError() {
    document.getElementById("screenshot-container")?.classList.add("!hidden");
    document.getElementById("docs-card")?.classList.add("!row-span-1");
    document.getElementById("docs-card-content")?.classList.add("!flex-row");
    document.getElementById("background")?.classList.add("!hidden");
}
  </script>
  
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
  

<!-- <script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";

import Navbar from "@/Components/LandingPage/Navbar.vue";
import Footer from "@/Components/LandingPage/Footer.vue";


const props = defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
}>();

function handleImageError() {
    document.getElementById("screenshot-container")?.classList.add("!hidden");
    document.getElementById("docs-card")?.classList.add("!row-span-1");
    document.getElementById("docs-card-content")?.classList.add("!flex-row");
    document.getElementById("background")?.classList.add("!hidden");
}
</script>

<template>
    <Head title="Sellers" />
    <div class="text-black bg-white">
        <Navbar :can-login="canLogin" :can-register="canRegister" />

      
        <section id="categories" class="container w-[75%] py-12 sm:py-16">
            <div class="mb-10">
                <h1 class="font-bold text-title-xl2">
                    SubCategory Name
                </h1>
                <h2 class="font-normal text-title-md">
                    Short Description
                </h2>
            </div>
        </section>
        <Footer />
    </div>
</template> -->
