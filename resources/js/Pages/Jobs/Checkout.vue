<template>
  
    <div class="container p-4 mx-auto">
      <!-- Navbar starts -->
      <div class="relative flex items-center justify-between py-5 z-100">
        <!-- Logo Button -->
        <button>
            <a href="/"> <img src="../../../img/toworkLogo.svg" alt="Logo" /></a>
        </button>
        
        <!-- Right side content -->
        <div v-if="$page.props.auth.user" class="flex items-center gap-10">
            <!-- Search box -->
            <div class="flex px-3 py-2 bg-transparent border rounded-full w-96">
                <input
                    type="text"
                    placeholder="Search for a service"
                    class="w-full text-sm text-black border-none outline-none"
                />
                <button type="submit">
                    <img src="../../../img/mag-glass.png" alt="search" class="w-5 h-5" />
                </button>
            </div>

            <!-- Right side buttons and dropdowns -->
            <ul class="flex items-center gap-6">
                <!-- Notification Menu Area -->
                <DropdownNotification />
                <!-- Chat Notification Area -->
                <DropdownMessage />
                <!-- Favorites/Heart -->
                <DropdownHeart />

                <!-- Orders Button -->
                <button class="text-sm text-black">Orders</button>

                <!-- Switch to Selling Button -->
                <button class="text-sm text-black">Switch to Selling</button>

                <!-- User Dropdown Area -->
                <DropdownUserTwo />
            </ul>
        </div>
    </div>
    <!-- Navbar ends -->
        <h1 class="mb-4 text-2xl font-bold">Checkout for, {{ $page.props.auth.user.name }}</h1>
       <!-- <BillingInfo/>  -->
       <TotalAmount :gigId="gig.id" :selectedPrice="selectedPricing" :gigTitle="gig.gig_title" :package="selectedPackage.name" :description="selectedPackage.description" :deliveryTime="selectedPackage.delivery_time" :revisions="selectedPackage.revisions" :userId="selectedPackage.user_id"  />
       <Footer/>
    </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import TotalAmount from './TotalAmount.vue';
import Navbar from '@/Components/LandingPage/Navbar.vue';
import Footer from '@/Components/LandingPage/Footer.vue';
import DropdownUserTwo from '@/Components/Header/DropdownUserTwo.vue';
import DropdownHeart from '@/Components/Header/DropdownHeart.vue';
import DropdownMessage from '@/Components/Header/DropdownMessage.vue';
import DropdownNotification from '@/Components/Header/DropdownNotification.vue';



const props = defineProps<{
  gig: Record<string, unknown>; // Define the type of the gig object as needed
  selectedPricing: string;
  canLogin?: boolean;
  canRegister?: boolean;
}>();

const gigs = ref<Array<{
    id: number;
    gig_title: string;
    gig_description: string;
    pricing: string; // Assuming it's a JSON string
}>>([]);


// Compute the selected package based on the selectedPricing
const selectedPackage = computed(() => {
  // Check if gig and gig.pricing exist
  if (!props.gig || !props.gig.pricing) return null;
  
  // If gig.pricing is a string, parse it; otherwise, use it directly
  const pricing = typeof props.gig.pricing === 'string'
    ? JSON.parse(props.gig.pricing)
    : props.gig.pricing;

  // Match the selectedPricing with one of the pricing packages
  if (pricing.basic.price === props.selectedPricing) {
    return pricing.basic;
  } else if (pricing.standard.price === props.selectedPricing) {
    return pricing.standard;
  } else if (pricing.premium.price === props.selectedPricing) {
    return pricing.premium;
  } else {
    return null; // Return null if no matching price is found
  }
});

</script>

<style scoped>
/* Add any additional styles here */
</style>
