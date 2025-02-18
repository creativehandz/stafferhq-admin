<template>
  <div>
    <h1>Gigs</h1>
    <ul>
      <li v-for="gig in gigs" :key="gig.id" >
        <h1>Gig user {{ gig.user.name }}</h1>
        <h2>{{ gig.gig_title }}</h2>
        <p>{{ gig.gig_description }}</p>

        <!-- Extract and display the standard price from pricing object -->
        <div v-if="gig.pricing && gig.pricing.standard">
          <h3>Standard Pricing</h3>
          <p>Price: ${{ gig.pricing.standard.price }}</p> <!-- Standard price displayed here -->
        </div>

        <p v-if="selectedUser?.id === gig.user.id">User: {{ gig.user.name }}</p>
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
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
  // revisions: string
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
</script>
