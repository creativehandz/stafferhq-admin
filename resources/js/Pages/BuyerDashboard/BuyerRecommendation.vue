<template>
  <div class="container p-6 mt-5 mb-5 text-black">
    <h2 class="mb-4 leading-none sm:text-[45px] md:text-[45px] lg:text-[45px] xl:text-[45px] 2xl:text-[45px] font-bold">
      Explore similar products and services to your recent searches
    </h2>
    <div class="grid grid-cols-3 gap-4">
      <div v-for="gig in gigs" :class="['p-4 rounded-lg shadow-md bg-cyan-200']">
        <div class="flex items-center mb-2">
          <img src="../../../img/user/user-01.png" alt="user icon" class="w-6 h-6 mr-2" />
          <h3 class="font-bold">{{ gig.user.name }}</h3>
          <span  class="w-5 ml-2"><img src="../../../img/crown.svg" /></span>
        </div>
        <p class="mb-1 text-lg font-bold"> 
          <div v-if="gig.pricing && gig.pricing.standard">
              <p>Price: ${{ gig.pricing.standard.price }}</p>
          </div>
        </p>
        <p class="font-semibold">{{ gig.gig_title }}</p>
        <p class="text-sm text-gray-600">{{ gig.gig_description }}</p>
        <div class="flex items-center justify-end mt-4 text-right">
          <span class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="black" viewBox="0 0 24 24" stroke="black" width="16" height="16" class="mr-1">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17.27l5.18 3.73-1.64-6.36 5-4.73-6.57-.54L12 2 9.03 9.37l-6.57.54 5 4.73L6.82 21z" />
            </svg>
            4.8
          </span>
          <span class="ml-2 text-sm text-gray-600">(2k)</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios'

// Define the types for users and pricing details
interface User {
  id: number
  name: string
}

interface PricingDetail {
  name: string
  description: string
  delivery_time: string
  revisions: string
  price: number // Assuming price is a string based on your data structure
}

interface Pricing {
  basic: PricingDetail
  standard: PricingDetail
  premium: PricingDetail
}

interface Gig {
  id: number
  gig_title: string
  gig_description: string
  pricing: Pricing // Include pricing in the gig type
  user: User // Include user in the gig type
}

// Reactive variable for storing gigs and selected user
const gigs = ref<Gig[]>([])
const selectedUser = ref<User | null>(null)

// Fetch gigs from the backend
const fetchGigs = async () => {
  try {
    const response = await axios.get('/gigs')
    gigs.value = response.data
  } catch (error) {
    console.error('Error fetching gigs:', error)
  }
}

// // Toggle function to show/hide user info
// const toggleUserInfo = (user: User) => {
//   if (selectedUser.value?.id === user.id) {
//     selectedUser.value = null // Hide if the same user is clicked
//   } else {
//     selectedUser.value = user // Show user info
//   }
// }

// Fetch gigs on component mount
onMounted(() => {
  fetchGigs()
})

const cards = ref([
  {
    name: "John Doe",
    price: "$200",
    title: "Create a brief for clients",
    description: "Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.",
    icon: "user-icon.png", // Replace with your icon path
  },
  {
    name: "John Dose",
    price: "$200",
    title: "Create a brief for clients",
    description: "Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.",
    icon: "user-icon.png", // Replace with your icon path
  },
  {
    name: "John Doe",
    price: "$200",
    title: "Create a brief for clients",
    description: "Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.",
    icon: "user-icon.png", // Replace with your icon path
  }
]);
</script>

<style scoped></style>