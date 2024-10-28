<script setup lang="ts">
import Navbar from '@/Components/LandingPage/Navbar.vue';
import { ref } from 'vue';
import BuyerNavbar from './BuyerNavbar.vue';

// Active tab reference
const activeTab = ref('orderDetails');

// Function to switch tabs
const switchTab = (tabName: string) => {
    activeTab.value = tabName;
};
</script>

<template>
    <div class="container">
    <BuyerNavbar/>
 
    <div class="flex justify-between">
    <!-- Left: Tab Navigation and Main Content -->
    <div class="w-3/4">
      <!-- Button Tab Navigation -->
      <div class="flex gap-4 p-5 mb-4">
        <button
          @click="switchTab('orderDetails')"
          :class="[activeTab === 'orderDetails' ? 'bg-primary text-white' : 'bg-gray-300', 'px-4 py-2 rounded']"
        >
          Order Details
        </button>
        <button
          @click="switchTab('billingDetails')"
          :class="[activeTab === 'billingDetails' ? 'bg-primary text-white' : 'bg-gray-300', 'px-4 py-2 rounded']"
        >
          Billing Details
        </button>
        <button
          @click="switchTab('shippingInfo')"
          :class="[activeTab === 'shippingInfo' ? 'bg-primary text-white' : 'bg-gray-300', 'px-4 py-2 rounded']"
        >
          Shipping Info
        </button>
        <button
          @click="switchTab('confirmation')"
          :class="[activeTab === 'confirmation' ? 'bg-primary text-white' : 'bg-gray-300', 'px-4 py-2 rounded']"
        >
          Confirmation
        </button>
      </div>

      <!-- Content Switch Based on Active Tab -->
      <div v-if="activeTab === 'orderDetails'">
        <div class="p-6">
    <!-- Header Section -->
    <div class="p-4 mb-6 bg-green-100 rounded-md">
      <h2 class="text-xl font-semibold text-green-600">prashar24 is new to Fiverr!</h2>
      <p class="text-gray-600">Make a great first impression by updating prashar24 about your progress and delivering superb work.</p>
    </div>

    <!-- Order Details Section -->
    <div class="p-4 mb-6 bg-white rounded-md shadow-md">
      <div class="flex items-center mb-2">
        <span class="p-2 text-purple-500 bg-purple-100 rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6M9 12l1.5 1.5m0-3L9 12m7.5 1.5L15 12m0 0l1.5-1.5m-3 1.5L9 12" />
          </svg>
        </span>
        <h3 class="ml-3 text-lg font-semibold">Your order details</h3>
      </div>
    </div>

    <!-- Order Timeline -->
    <div class="p-4 bg-white rounded-md shadow-md">
      <!-- Yesterday Section -->
      <h4 class="mb-4 text-sm font-bold text-gray-500">Yesterday</h4>
      <ul class="space-y-4">
        <li class="flex items-start">
          <span class="p-2 text-purple-500 bg-purple-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6M9 12l1.5 1.5m0-3L9 12m7.5 1.5L15 12m0 0l1.5-1.5m-3 1.5L9 12" />
            </svg>
          </span>
          <div class="ml-3">
            <p class="font-semibold">prashar24 placed the order</p>
            <p class="text-sm text-gray-500">Oct 24, 2024, 3:23 PM</p>
          </div>
        </li>
        <li class="flex items-start">
          <span class="p-2 text-blue-500 bg-blue-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6M9 12l1.5 1.5m0-3L9 12m7.5 1.5L15 12m0 0l1.5-1.5m-3 1.5L9 12" />
            </svg>
          </span>
          <div class="ml-3">
            <p class="font-semibold">prashar24 sent the requirements</p>
            <p class="text-sm text-gray-500">Oct 24, 2024, 3:25 PM</p>
          </div>
        </li>
        <li class="flex items-start">
          <span class="p-2 text-green-500 bg-green-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6M9 12l1.5 1.5m0-3L9 12m7.5 1.5L15 12m0 0l1.5-1.5m-3 1.5L9 12" />
            </svg>
          </span>
          <div class="ml-3">
            <p class="font-semibold">The order started</p>
            <p class="text-sm text-gray-500">Oct 24, 2024, 3:25 PM</p>
          </div>
        </li>
        <li class="flex items-start">
          <span class="p-2 text-gray-500 bg-gray-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6M9 12l1.5 1.5m0-3L9 12m7.5 1.5L15 12m0 0l1.5-1.5m-3 1.5L9 12" />
            </svg>
          </span>
          <div class="ml-3">
            <p class="font-semibold">Your delivery date was updated to October 25</p>
            <p class="text-sm text-gray-500">Oct 24, 2024, 3:25 PM</p>
          </div>
        </li>
      </ul>

      <!-- Today Section -->
      <h4 class="mt-6 mb-4 text-sm font-bold text-gray-500">Today</h4>
      <ul class="space-y-4">
        <li class="flex items-start">
          <span class="p-2 text-green-500 bg-green-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6M9 12l1.5 1.5m0-3L9 12m7.5 1.5L15 12m0 0l1.5-1.5m-3 1.5L9 12" />
            </svg>
          </span>
          <div class="ml-3">
            <p class="font-semibold">prashar24 is new to Fiverr! Make sure you're on the same page</p>
            <p class="text-sm text-gray-500">Oct 25, 2024, 4:51 PM</p>
          </div>
        </li>
      </ul>
    </div>

    <!-- View conversation -->
    <div class="mt-6 text-sm text-blue-500 underline cursor-pointer">
      View conversation with prashar24 in your inbox
    </div>
  </div>
      </div>

      <div v-if="activeTab === 'billingDetails'">
        <div class="p-6">
    <!-- Stock Media Section -->
    <div class="p-6 mb-6 bg-white rounded-md shadow-md">        
        <div class="flex justify-between">
            <div>
                <h1><strong>I will do a good banenr for google ads.</strong></h1>
                <p>Ordered by prasher24 (view history)|</p>                
                <p>Order number #FO62C8B154448</p>
            </div>
            <div>
                <p>total price</p>
                <p>$5</p>
            </div>                        
        </div>
        <p>I will create a basic banner</p>
        <div class="w-full">
            <table class="w-full" >
            <tr class="bg-gray-200" >
                <th>Item</th>
                <th>Quantity</th>
                <th>Duration</th>
                <th>Price</th>
            </tr>
            <tr>
                <td>Alfreds Futterkiste</td>
                <td>Maria Anders</td>
                <td>Germany</td>
            </tr>

            </table>

        </div>
        </div>
        </div>
      </div>

      <div v-if="activeTab === 'shippingInfo'">
        <div class="p-6 mb-6 bg-white rounded-md shadow-md">        
            <div class="justify-between">
                <h2 class="mb-4 text-xl font-semibold">If you’re ordering for a business, what’s your industry?(Optional)</h2>
                <p>Information Technology (IT)</p>
                <h2 class="mb-4 text-xl font-semibold">Is this order part of a bigger project you're working on?(Optional)</h2>
                <p>Banner creation</p>
                <p>Some information is shown in English language. <strong>Translate</strong></p>
                <h2 class="mb-4 text-xl font-semibold">What is the dimension you require ?</h2>
                <p>500X500 Pixel. </p>
                <p>Some information is shown in English language. <strong>Translate</strong></p>
        </div>
        </div>
      </div>

      <div v-if="activeTab === 'confirmation'">
        <div class="p-6">
    <!-- Stock Media Section -->
    <div class="p-6 mb-6 bg-white rounded-md shadow-md">
      <h2 class="mb-2 text-2xl font-semibold text-gray-800">Stock media</h2>
      <p class="mb-4 text-gray-600">Search Shutterstock's massive library of images, videos, and music and license them directly on Fiverr.</p>
      <a href="#" class="block mb-4 text-sm text-blue-500 underline">Terms & conditions</a>
      <div class="flex items-center justify-between mb-6">
        <button class="px-4 py-2 text-white bg-green-500 rounded-md">Search Media</button>
        <div class="p-4 text-center bg-blue-100 rounded-md">
          <p class="font-semibold text-blue-600">Raise the bar with licensed stock media</p>
          <p class="text-sm text-gray-600">Give buyers more value by including images, videos, and music right in your Gig.</p>
          <button class="px-4 py-2 mt-3 text-white bg-blue-500 rounded-md">Add to Gig</button>
        </div>
      </div>
    </div>

    <!-- Manage Media Section -->
    <div class="p-6 bg-white rounded-md shadow-md">
      <h2 class="mb-4 text-2xl font-semibold text-gray-800">Manage Media</h2>
      <div class="mb-6 border-b">
        <ul class="flex space-x-8">
          <li class="pb-2 text-green-500 border-b-2 border-green-500">Images</li>
          <li class="pb-2 text-gray-600">Videos</li>
          <li class="pb-2 text-gray-600">Music</li>
        </ul>
      </div>
      
      <!-- Media Content -->
      <div class="mb-6">
        <p class="font-semibold text-gray-800">Tried</p>
        <p class="mt-1 text-sm text-gray-600">You haven't tried any media yet. <a href="#" class="text-blue-500 underline">Search Shutterstock</a></p>
      </div>

      <div>
        <p class="font-semibold text-gray-800">Licensed (0/0)</p>
      </div>
    </div>
  </div>
      </div>
    </div>

  <!-- Right: Time to Deliver and Order Details -->
  <div class="w-1/4 p-5 space-y-4">
    <!-- Time to Deliver -->
    <div class="flex flex-col items-center p-4 rounded-md shadow-md">
      <h3 class="mb-2 text-lg font-semibold">Time left to deliver</h3>
      <!-- Time left -->
      <div class="flex mb-4 space-x-2 text-red-500">
        <div class="flex flex-col items-center">
          <p class="text-2xl font-bold">00</p>
          <p class="text-sm">Days</p>
        </div>
        <div class="flex flex-col items-center">
          <p class="text-2xl font-bold">00</p>
          <p class="text-sm">Hours</p>
        </div>
        <div class="flex flex-col items-center">
          <p class="text-2xl font-bold">00</p>
          <p class="text-sm">Minutes</p>
        </div>
        <div class="flex flex-col items-center">
          <p class="text-2xl font-bold">00</p>
          <p class="text-sm">Seconds</p>
        </div>
      </div>
      <!-- Deliver Now button -->
      <button class="w-full py-2 text-white bg-green-500 rounded-lg">Deliver Now</button>
      <p class="mt-2 text-sm text-blue-500 underline cursor-pointer">Extend delivery date</p>
    </div>

    <!-- Order Details -->
    <div class="p-4 rounded-md shadow-md">
      <h3 class="mb-2 text-lg font-semibold">Order Details</h3>
      <div>
        <img src="http://via.placeholder.com/1280x720" class="mb-5 w-30" alt="Order Image"/>
      </div>
      <ul class="space-y-1 text-gray-600">
        <li><span class="font-medium">Ordered by:</span> prashar24</li>
        <li><span class="font-medium">Delivery date:</span> Oct 25, 2024, 3:25 PM</li>
        <li><span class="font-medium">Total price:</span> $5</li>
        <li><span class="font-medium">Order number:</span> #FO62C8B154448</li>
        <li><span class="font-medium">Status:</span> In Progress</li>
      </ul>
      <hr class="my-3">
      <!-- Track Order -->
      <h3 class="mb-2 text-lg font-semibold">Track Order</h3>
      <ul class="space-y-2">
        <li class="flex items-center">
          <span class="inline-block w-6 h-6 bg-green-500 rounded-full"></span>
          <span class="ml-3">Order placed</span>
        </li>
        <li class="flex items-center">
          <span class="inline-block w-6 h-6 bg-green-500 rounded-full"></span>
          <span class="ml-3">Requirements submitted</span>
        </li>
        <li class="flex items-center">
          <span class="inline-block w-6 h-6 border border-gray-400 rounded-full"></span>
          <span class="ml-3">Order in progress</span>
        </li>
        <li class="flex items-center">
          <span class="inline-block w-6 h-6 border border-gray-400 rounded-full"></span>
          <span class="ml-3">Review delivery</span>
        </li>
        <li class="flex items-center">
          <span class="inline-block w-6 h-6 border border-gray-400 rounded-full"></span>
          <span class="ml-3">Complete order</span>
        </li>
      </ul>
    </div>
  </div>
  </div>
</div>
</template>

<style scoped>
.bg-primary {
  background-color: #3490dc; /* Your desired primary color */
}
</style>
