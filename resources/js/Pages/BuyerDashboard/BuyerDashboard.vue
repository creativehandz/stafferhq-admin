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

// TypeScript interfaces
interface User {
    id: number
    name: string
    email: string
    categories?: string
    [key: string]: any
}

interface Category {
    id: number
    name: string
}

interface Gig {
    id: number
    title: string
    description: string
    seller_name: string
    seller_email: string
    category_id: string
    pricing: any
    keywords: string
    status: string
    clicks: number
    orders: number
}

interface CategoryWithServices {
    category: Category
    services: Gig[]
    service_count: number
}

interface Props {
    user: User
    recommendedGigs: Gig[]
    categoriesWithServices: CategoryWithServices[]
    userCategories: Category[]
    totalRecommendations: number
}

const props = defineProps<Props>()

// Reactive state for search input and username
const searchQuery = ref('');

// Search method to handle the search button
const search = () => {
  if (searchQuery.value.trim()) {
    alert(`Searching for: ${searchQuery.value}`);
    // Implement search logic here (e.g., API call or route change)
  } else {
    alert('Please enter a service to search for.');
  }
};

// Function to get the starting price from pricing object
const getStartingPrice = (pricing: any) => {
    if (!pricing) return 'N/A';
    
    if (pricing.basic && pricing.basic.price) {
        return `$${pricing.basic.price}`;
    } else if (pricing.standard && pricing.standard.price) {
        return `$${pricing.standard.price}`;
    } else if (pricing.premium && pricing.premium.price) {
        return `$${pricing.premium.price}`;
    }
    
    return 'Contact for pricing';
};

// Function to truncate description
const truncateDescription = (description: string, wordLimit: number = 25) => {
    if (!description) return '';
    const words = description.split(' ');
    if (words.length <= wordLimit) return description;
    return words.slice(0, wordLimit).join(' ') + '...';
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
                        Welcome back, {{ props.user.name }}
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
        
        <!-- Services by Categories Section -->
        <div v-if="props.categoriesWithServices && props.categoriesWithServices.length > 0" class="container p-6 mt-8 mb-5 text-black">
            <div class="flex items-center justify-between mb-6">
                <h2 class="leading-none sm:text-[35px] md:text-[35px] lg:text-[35px] xl:text-[35px] 2xl:text-[35px] font-bold">
                    Services by Your Interests
                </h2>
                <p class="text-gray-600">
                    Found {{ props.totalRecommendations }} services across {{ props.categoriesWithServices.length }} categories
                </p>
            </div>
            
            <!-- Category Sections -->
            <div v-for="categoryData in props.categoriesWithServices" :key="categoryData.category.id" class="mb-12">
                <!-- Category Header -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <h3 class="text-2xl font-bold text-gray-800 mr-4">{{ categoryData.category.name }}</h3>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                            {{ categoryData.service_count }} service{{ categoryData.service_count !== 1 ? 's' : '' }}
                        </span>
                    </div>
                    <Link :href="`/sellers?category=${categoryData.category.id}`" 
                          class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
                        View all in {{ categoryData.category.name }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </Link>
                </div>
                
                <!-- Services Grid for this Category -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="gig in categoryData.services" :key="gig.id" 
                         class="p-6 rounded-lg shadow-md bg-white border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                        
                        <!-- Category Tag -->
                        <div class="mb-3">
                            <span class="inline-block px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-medium">
                                {{ categoryData.category.name }}
                            </span>
                        </div>
                        
                        <!-- Seller Info -->
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                {{ gig.seller_name.charAt(0).toUpperCase() }}
                            </div>
                            <div class="ml-3">
                                <h4 class="font-semibold text-gray-800">{{ gig.seller_name }}</h4>
                                <div class="flex items-center text-sm text-gray-500">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        4.8
                                    </span>
                                    <span class="ml-1">({{ gig.orders || 0 }} orders)</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Service Title -->
                        <Link :href="`/job-description/${gig.id}`" class="block">
                            <h5 class="font-bold text-lg text-gray-900 mb-3 hover:text-blue-600 transition-colors">
                                {{ gig.title }}
                            </h5>
                        </Link>
                        
                        <!-- Service Description -->
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            {{ truncateDescription(gig.description) }}
                        </p>
                        
                        <!-- Keywords -->
                        <div v-if="gig.keywords" class="mb-4">
                            <div class="flex flex-wrap gap-1">
                                <span v-for="keyword in gig.keywords.split(',')" :key="keyword" 
                                      class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded">
                                    {{ keyword.trim() }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Pricing and CTA -->
                        <div class="flex items-center justify-between">
                            <div class="text-xl font-bold text-green-600">
                                Starting at {{ getStartingPrice(gig.pricing) }}
                            </div>
                            <Link :href="`/job-description/${gig.id}`" 
                                  class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                View Details
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- View All Services Button -->
            <div class="text-center mt-8">
                <Link href="/sellers" class="inline-flex items-center px-6 py-3 bg-orange-500 text-white font-semibold rounded-full hover:bg-orange-600 transition-colors">
                    Explore All Services
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </Link>
            </div>
        </div>
        
        <!-- No Categories Selected Message -->
        <div v-else-if="!props.userCategories || props.userCategories.length === 0" class="container p-6 mt-8 mb-5">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                <div class="mb-4">
                    <svg class="mx-auto h-12 w-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-blue-900 mb-2">Set Your Interests</h3>
                <p class="text-blue-700 mb-4">
                    Select your interested categories in your profile to see personalized service recommendations organized by category.
                </p>
                <Link href="/buyer-profile/edit" 
                      class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Update Your Profile
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </Link>
            </div>
        </div>
        
        <!-- No Services Found -->
        <div v-else class="container p-6 mt-8 mb-5">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                <div class="mb-4">
                    <svg class="mx-auto h-12 w-12 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-yellow-900 mb-2">No Services Available</h3>
                <p class="text-yellow-700 mb-4">
                    Currently, there are no active services in your interested categories: 
                    <span v-for="(category, index) in props.userCategories" :key="category.id" class="inline-block">
                        <span class="font-medium">{{ category.name }}</span>
                        <span v-if="index < props.userCategories.length - 1">, </span>
                    </span>. 
                    Check back later or explore all available services!
                </p>
                <Link href="/sellers" 
                      class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                    Browse All Services
                </Link>
            </div>
        </div>
        
</section>  
<BuyerRecommendation/>
<BuyerProfessionals/>
<!-- <GigDetails/> -->
<Footer/>
</template>
  

  
  <style scoped>
  /* Add any component-specific styles here */
  </style>
  