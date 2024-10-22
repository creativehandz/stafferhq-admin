
<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

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
}

const gigs = ref<Gig[]>([]);
const itemsPerPage = ref(9); // Number of gigs to display initially
const currentPage = ref(1);  // Current page number

// Fetch gigs from the backend
const fetchGigs = async () => {
  try {
    const response = await axios.get('/gigs');
    gigs.value = response.data;
  } catch (error) {
    console.error('Error fetching gigs:', error);
  }
};

// Computed property for visible gigs
const visibleGigs = computed(() => {
  return gigs.value.slice(0, currentPage.value * itemsPerPage.value);
});

// Load more gigs
const loadMore = () => {
  currentPage.value++;
};

// Show less gigs (reset to first page)
const showLess = () => {
  currentPage.value = 1;
};

// Fetch gigs on component mount
onMounted(() => {
  fetchGigs();
});
</script>


<template>
  <div class="container p-6 mt-5 mb-5 text-black">
    <h2 class="mb-4 leading-none sm:text-[45px] md:text-[45px] lg:text-[45px] xl:text-[45px] 2xl:text-[45px] font-bold">
      Explore similar products and services to your recent searches
    </h2>
    <div class="grid grid-cols-3 gap-4">
      <div v-for="(gig, index) in visibleGigs" :key="gig.id" class="p-4 rounded-lg shadow-md bg-cyan-200">
        <div class="flex items-center mb-2">
          <img src="../../../img/user/user-01.png" alt="user icon" class="w-6 h-6 mr-2" />
          <h3 class="font-bold">{{ gig.user.name }}</h3>
          <span class="w-5 ml-2">
            <img src="../../../img/crown.svg" />
          </span>
        </div>
        <p class="mb-1 text-lg font-bold">
          <div v-if="gig.pricing && gig.pricing.standard">
            Price: ${{ gig.pricing.standard.price }}
          </div>
        </p>
        <a :href="`/job-description/${gig.id}`">
          <p class="font-semibold">{{ gig.gig_title }}</p>
        </a>
        <p class="overflow-hidden text-sm turncate hover:text-clip ">{{ gig.gig_description.split(' ').slice(0, 30).join(' ') }}...</p>
        <div class="flex items-center justify-end mt-4 text-right">
          <span class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="black" viewBox="0 0 24 24" stroke="black" width="16" height="16" class="mr-1">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17.27l5.18 3.73-1.64-6.36 5-4.73-6.57-.54L12 2 9.03 9.37l-6.57.54 5 4.73L6.82 21z" />
            </svg>
            4.8
          </span>
          <span class="ml-2 text-sm">(2k)</span>
        </div>
      </div>
    </div>

    <!-- Load More and Show Less Buttons -->
    <div class="flex justify-center mt-6">
      <button v-if="visibleGigs.length < gigs.length" @click="loadMore" class="px-7 py-2 font-bold text-black transition-all duration-300 rounded-full shadow-md bg-[#F5F535] hover:bg-yellow-400 leading-none sm:text-[15px]  md:text-[15px] lg:text-[15px] xl:text-[15px] 2xl:text-[15px] footer-get-work">
        Load More
      </button>
      <button v-if="currentPage > 1" @click="showLess" class="px-4 py-2 text-black bg-red-500 rounded-lg">
        Show Less
      </button>
    </div>
  </div>
</template>

