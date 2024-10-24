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
    <div class="mb-14 w-full p-7.5">
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

      <!-- Orders Display -->
      <div class="mt-5">
        <div
          v-for="checkout in filterOrders(buyerCheckoutData, activeTab)"
          :key="checkout.order_details"
          class="p-4 mb-3 bg-white border rounded-sm border-stroke shadow-default dark:border-strokedark dark:bg-boxdark"
        >
          <div class="flex items-center">
            <img :src="checkout.user?.avatar || '/path/to/placeholder.jpg'" alt="User Avatar" class="w-10 h-10 mr-3 rounded-full" />
            <h3 class="text-lg font-semibold">{{ checkout.user?.name }}</h3>
          </div>
          <p><strong>Gig:</strong> {{ checkout.order_details }} ({{ checkout.package_selected }})</p>
          <p><strong>Due on:</strong> {{ checkout.billing_details }}</p>
          <p><strong>Total:</strong> ${{ checkout.total_price }}</p>
          <p><strong>Note:</strong> N/A</p>
          <p><strong>Status:</strong> <span class="status-label">{{ checkout.status }}</span></p>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
