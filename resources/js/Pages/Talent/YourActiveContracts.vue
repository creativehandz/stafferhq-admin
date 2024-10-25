<script setup lang="ts">
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import axios from "axios";
import { onMounted, ref } from "vue";

// Set up the page title and active tab
const pageTitle = ref("Manage Orders");
const activeTab = ref("priorityOrders");

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
// Function to parse the order_details string as JSON and extract relevant data
const parseOrderDetails = (orderDetails: string) => {
  try {
    return JSON.parse(orderDetails);
  } catch (e) {
    console.error('Invalid order_details format:', e);
    return {};
  }
};
// Function to get the initials from the user name
const getUserInitials = (name: string) => {
  const initials = name.split(' ').map(n => n[0]).join('');
  return initials;
};

// Create a ref to hold buyer_checkout data
const buyerCheckoutData = ref<BuyerCheckout[]>([]);

// Fetch data from the backend
const fetchBuyerCheckout = async () => {
    try {
        const response = await axios.get('/seller-orders'); // Make sure this endpoint matches your API route
        buyerCheckoutData.value = response.data; // Store the response data in the ref
    } catch (error) {
        console.error('Error fetching buyer checkout data:', error);
    }
};

// Call the fetch function when the component is mounted
onMounted(() => {
    fetchBuyerCheckout();
});

// Filter orders based on the active tab
const filterOrders = (orders: BuyerCheckout[], activeTab: string): BuyerCheckout[] => {
    switch (activeTab) {
        case "priorityOrders":
            return orders.filter((order) => order.status === "Priority");
        case "active":
            return orders.filter((order) => order.status === "Active");
        case "lateOrders":
            return orders.filter((order) => order.status === "Late");
        case "deliveredOrders":
            return orders.filter((order) => order.status === "Delivered");
        case "completedOrders":
            return orders.filter((order) => order.status === "Completed");
        case "cancelledOrders":
            return orders.filter((order) => order.status === "Cancelled");
        case "starredOrders":
            return orders.filter((order) => order.status === "Starred");
        default:
            return orders;
    }
};

// Get the count of orders by status
const getOrderCount = (status: string) => {
    return buyerCheckoutData.value.filter((order) => order.status === status).length;
};
</script>
<template>
  <Head title="Manage Orders" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Manage Orders
      </h2>
    </template>

    <!-- Breadcrumb Start -->
    <BreadcrumbDefault :pageTitle="pageTitle" />
    <!-- Breadcrumb End -->

   <!-- Main Content Start -->
   <div class="mb-14 w-full p-7.5 shadow">
    <!-- Tabs for Order Status with Counts -->
    <div class="flex flex-wrap gap-3 pb-5 border-b border-stroke dark:border-strokedark">
      <button
        @click="activeTab = 'priorityOrders'"
        :class="[activeTab === 'priorityOrders' ? 'bg-primary text-white' : 'bg-gray dark:bg-meta-4 text-black dark:text-white', 'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6']"
      >
        Priority ({{ getOrderCount('Priority') }})
      </button>

      <button
        @click="activeTab = 'activeOrders'"
        :class="[activeTab === 'activeOrders' ? 'bg-primary text-white' : 'bg-gray dark:bg-meta-4 text-black dark:text-white', 'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6']"
      >
        Active ({{ getOrderCount('active') }})
      </button>

      <button
        @click="activeTab = 'lateOrders'"
        :class="[activeTab === 'lateOrders' ? 'bg-primary text-white' : 'bg-gray dark:bg-meta-4 text-black dark:text-white', 'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6']"
      >
        Late ({{ getOrderCount('Late') }})
      </button>

      <button
        @click="activeTab = 'deliveredOrders'"
        :class="[activeTab === 'deliveredOrders' ? 'bg-primary text-white' : 'bg-gray dark:bg-meta-4 text-black dark:text-white', 'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6']"
      >
        Delivered ({{ getOrderCount('Delivered') }})
      </button>

      <button
        @click="activeTab = 'completedOrders'"
        :class="[activeTab === 'completedOrders' ? 'bg-primary text-white' : 'bg-gray dark:bg-meta-4 text-black dark:text-white', 'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6']"
      >
        Completed ({{ getOrderCount('Completed') }})
      </button>

      <button
        @click="activeTab = 'cancelledOrders'"
        :class="[activeTab === 'cancelledOrders' ? 'bg-primary text-white' : 'bg-gray dark:bg-meta-4 text-black dark:text-white', 'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6']"
      >
        Cancelled ({{ getOrderCount('Cancelled') }})
      </button>

      <button
        @click="activeTab = 'starredOrders'"
        :class="[activeTab === 'starredOrders' ? 'bg-primary text-white' : 'bg-gray dark:bg-meta-4 text-black dark:text-white', 'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6']"
      >
        Starred ({{ getOrderCount('Starred') }})
      </button>
    </div>

    <!-- Orders Display in Table Format -->
    <div class="mt-5">
      <!-- Table Header -->
      <div class="flex items-center justify-between px-4 py-2 font-semibold bg-gray-100">
        <div class="w-1/5">Buyer</div>
        <div class="w-1/5">Package</div>
        <div class="w-1/5">Due On</div>
        <div class="w-1/5">Total</div>
        <div class="w-1/5">Status</div>
      </div>

      <!-- Orders Rows -->
      <div
        v-for="checkout in filterOrders(buyerCheckoutData, activeTab)"
        :key="checkout.order_details"
        class="flex items-center justify-between px-4 py-2 border-b"
      >
        <!-- Buyer Information -->
        <div class="flex items-center w-1/5">
          <div v-if="checkout.user?.name" class="flex items-center justify-center w-10 h-10 text-lg font-semibold text-gray-800 bg-green-400 rounded-full">
            {{ getUserInitials(checkout.user.name) }}
          </div>
          <h3 class="ml-3">{{ checkout.user?.name }}</h3>
        </div>

        <!-- Package -->
        <div class="w-1/5">{{ checkout.package_selected }}</div>

        <!-- Due On -->
        <div class="w-1/5">{{ parseOrderDetails(checkout.order_details).deliveryTime }}</div>

        <!-- Total -->
        <div class="w-1/5">${{ checkout.total_price }}</div>

        <!-- Status -->
        <div class="w-1/5"><span class="status-label">{{ checkout.status }}</span></div>
      </div>
    </div>
  </div>  
  </AuthenticatedLayout>
</template>
<!-- {{ checkout.order_details }} {{ checkout.billing_details }} -->