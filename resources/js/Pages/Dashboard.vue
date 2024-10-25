<script setup lang="ts">
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { computed, ref } from 'vue'
import Orders from "./OtherPages/Orders.vue";
import axios from "axios";
import { onMounted } from "vue";

// Define the interface for the expected data
interface BuyerCheckout {
    order_details: string;
    billing_details: string;
    package_selected: string;
    total_price: number;
    status: string;
    user: {
        id: number;
        name: string;
    };
}
// Function to get the initials from the user name
const getUserInitials = (name: string) => {
  const initials = name.split(' ').map(n => n[0]).join('');
  return initials;
};

// Create a ref to hold buyer_checkout data
const buyerCheckoutData = ref<BuyerCheckout[]>([]);

// Create a ref for the selected status
const selectedStatus = ref<string>('');

// Fetch data from the backend
const fetchBuyerCheckout = async () => {
    try {
        const response = await axios.get('/seller-orders');  // Ensure the endpoint matches your API route
        buyerCheckoutData.value = response.data;  // Store the response data in the ref
    } catch (error) {
        console.error('Error fetching buyer checkout data:', error);
    }
};

// Call the fetch function when the component is mounted
onMounted(() => {
    fetchBuyerCheckout();
});

// Computed property to filter checkouts by the selected status
const filteredCheckoutData = computed(() => {
    if (selectedStatus.value) {
        return buyerCheckoutData.value.filter(checkout => checkout.status === selectedStatus.value);
    }
    return buyerCheckoutData.value;
});
// Computed property to calculate the total price of filtered checkouts
const totalPrice = computed(() => {
    return filteredCheckoutData.value.reduce((sum, checkout) => sum + checkout.total_price, 0);
});

// Page title
const pageTitle = ref('Dashboard');
const currentPage = ref(1); // Current page, initially set to 1
const itemsPerPage = 5; // Show 5 items per page

// Computed property to limit the number of orders displayed
const limitedCheckoutData = computed(() => {
  return buyerCheckoutData.value.slice(0, currentPage.value * itemsPerPage);
});

// Function to load more orders (increase page number)
const loadMore = () => {
  currentPage.value++;
};

// Function to reset pagination (show less orders)
const showLess = () => {
  currentPage.value = 1;
};

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Dashboard
            </h2>
        </template>

        <!-- Breadcrumb Start -->
    <BreadcrumbDefault :pageTitle="pageTitle" />
    <!-- Breadcrumb End -->

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="container p-4 mx-auto mt-6 bg-white shadow ">
                    <!-- Welcome Section -->
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-gray-900">Welcome, {{ $page.props.auth.user.name }} </h2>
                    </div>
                    <p class="mt-1 text-gray-500">Find important messages, tips, and links to helpful resources here:</p>

                    <!-- Grow your business section -->
                    <div class="mt-4">
                        <div class="flex items-center justify-between p-4 bg-white border rounded-lg">
                            <div>
                                <h3 class="text-lg font-bold">Grow your business with Seller Plus</h3>
                                <p class="text-gray-500">Check out all the tools and benefits that can help you scale your success.</p>
                            </div>
                            <button class="text-gray-400 hover:text-gray-500">&times;&nbsp;&gt;</button>
                        </div>

                        <!-- Set up inbox auto replies -->
                        <div class="flex items-center justify-between p-4 mt-4 bg-white border rounded-lg">
                            <div>
                                <h3 class="text-lg font-bold">Set up Inbox auto replies</h3>
                                <p class="text-gray-500">Greet new potential buyers with an auto reply to their first message.</p>
                            </div>
                            <button class="text-gray-400 hover:text-gray-500">&times;&nbsp;&gt;</button>
                        </div>
                    </div>

                        <!-- Active Orders Section -->
                        <div>
    <!-- Status and Total Orders -->
    <div class="flex items-center justify-between p-3 mt-6 bg-gray-100 rounded-lg">
      <div>
        <h3 class="text-lg font-bold">
          {{ selectedStatus ? selectedStatus.charAt(0).toUpperCase() + selectedStatus.slice(1) + ' Orders' : 'All Orders' }} 
          - {{ filteredCheckoutData.length }}
        </h3>
      </div>
      <div>
        <select v-model="selectedStatus" class="text-lg font-bold rounded-lg hover:cursor-pointer">
          <option value="">All</option>
          <option value="active">Active</option>
          <option value="inProgress">In Progress</option>
          <option value="completed">Completed</option>
          <option value="cancelled">Cancelled</option>
        </select>
      </div>
    </div>

    <!-- If no orders, show "Upgrade Your Business" -->
    <div v-if="filteredCheckoutData.length === 0" class="mt-8">
      <h3 class="pb-2 font-bold text-gray-800 border-b border-gray-200">Upgrade Your Business</h3>
      <div class="p-6 mt-4 bg-white rounded-lg shadow-lg">
        <h3 class="text-xl font-bold">3 steps to become a top seller on Fiverr</h3>
        <p class="mt-2 text-gray-600">The key to your success on Fiverr is the brand you build for yourself through your Fiverr reputation. We gathered some tips and resources to help you become a leading seller on Fiverr.</p>

        <div class="grid grid-cols-3 gap-6 mt-6">
          <!-- Step 1: Get noticed -->
          <div class="text-center">
            <img src="https://www.svgrepo.com/show/30925/book.svg" alt="Get noticed" class="mx-auto w-15">
            <h4 class="mt-4 font-bold">Get noticed</h4>
            <p class="mt-2 text-gray-500">Tap into the power of social media by sharing your Gig, and get expert help to grow your impact.</p>
            <button class="px-4 py-2 mt-4 text-white rounded-lg bg-primary">Share Your Gigs</button>
          </div>

          <!-- Step 2: Get more skills -->
          <div class="text-center">
            <img src="https://www.svgrepo.com/show/27861/book.svg" alt="Get more skills" class="mx-auto w-15">
            <h4 class="mt-4 font-bold">Get more skills & exposure</h4>
            <p class="mt-2 text-gray-500">Hone your skills and expand your knowledge with online courses. You'll be able to offer more services and gain more exposure with every course completed.</p>
            <button class="px-4 py-2 mt-4 text-white rounded-lg bg-primary">Explore Learn</button>
          </div>

          <!-- Step 3: Become a successful seller -->
          <div class="text-center">
            <img src="https://www.svgrepo.com/show/131752/badge.svg" alt="Become a successful seller" class="mx-auto w-15">
            <h4 class="mt-4 font-bold">Become a successful seller!</h4>
            <p class="mt-2 text-gray-500">Watch this free online course to learn how to create an outstanding service experience for your buyer and grow your career as an online freelancer.</p>
            <button class="px-4 py-2 mt-4 text-white rounded-lg bg-primary">Watch Free Course</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Display filtered orders -->
    <div v-else class="mt-4">
        <div>
    <!-- Display limited checkout orders -->
    <div 
      v-for="checkout in limitedCheckoutData" 
      :key="checkout.order_details" 
      class="flex items-center justify-between p-4 mt-4 bg-white border rounded-lg"
    >
    <div class="flex items-center space-x-2">
    <!-- Placeholder Image -->
    <img src="http://via.placeholder.com/1280x720" alt="placeholder" class="w-[77px] h-[46px] object-cover">

    <!-- User Profile Initials -->
    <div v-if="checkout.user?.name" class="flex items-center justify-center w-10 h-10 text-lg font-semibold text-gray-800 bg-green-400 rounded-full">
      {{ getUserInitials(checkout.user.name) }} <img src="" alt="">
    </div>

    <!-- Full Name -->
    <h1 class="text-lg font-semibold">
      {{ checkout.user?.name }}
    </h1>
  </div>
      <p>Total Price: {{ checkout.total_price }}</p>
      <p>Status: {{ checkout.status }}</p>
      <button class="underline">View</button>
    </div>

    <!-- View More / Show Less buttons -->
    <div v-if="buyerCheckoutData.length > itemsPerPage">
      <button 
        v-if="limitedCheckoutData.length < buyerCheckoutData.length" 
        @click="loadMore" 
        class="px-4 py-2 mt-4 text-white bg-blue-500 rounded-lg"
      >
        View More
      </button>
      <button 
        v-if="currentPage > 1" 
        @click="showLess" 
        class="px-4 py-2 mt-4 text-white bg-gray-500 rounded-lg"
      >
        Show Less
      </button>
    </div>
  </div>
    </div>
  </div>          
            <!-- <h1>Buyer Checkout Data</h1>
            <ul v-if="buyerCheckoutData">
            <li v-for="checkout in buyerCheckoutData" :key="checkout.order_details">
                <p>Order Details: {{ checkout.order_details }}</p>
                <p>Billing Details: {{ checkout.billing_details }}</p>
                <p>Package Selected: {{ checkout.package_selected }}</p>
                <p>Total Price: {{ checkout.total_price }}</p>
                <p>Status: {{ checkout.status }}</p>
                <p>User Name: {{ checkout.user?.name }}</p> 
            </li>
            </ul> -->
        </div>
    </div>
</div>
</AuthenticatedLayout>
</template>
