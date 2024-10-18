<template>
    <div class="container p-4 mx-auto">
        <h1 class="mb-4 text-2xl font-bold">Checkout</h1>
       <!-- <BillingInfo/>  -->
       <TotalAmount :gigId="gig.id" :selectedPrice="selectedPricing" :gigTitle="gig.gig_title" :package="selectedPackage.name" :description="selectedPackage.description" :deliveryTime="selectedPackage.delivery_time" :revisions="selectedPackage.revisions" :userId="selectedPackage.user_id"  />
    </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import TotalAmount from './TotalAmount.vue';

const props = defineProps({
  gig: Object,
  selectedPricing: String
});

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
