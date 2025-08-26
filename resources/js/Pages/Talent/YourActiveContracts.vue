<script setup lang="ts">
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import axios from "axios";
import { onMounted, ref } from "vue";

// Set up the page title and active tab
const pageTitle = ref("Manage Orders");
const activeTab = ref("pendingOrders");

// Define the interface for the expected data
interface OrderStatus {
    id: number;
    name: string;
    slug: string;
    color: string;
    description: string;
}

interface BuyerCheckout {
    id: number;
    order_details: string;
    billing_details: string;
    package_selected: string;
    total_price: number;
    status: string;
    status_info?: OrderStatus;
    source?: string; // Add source field
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

// Function to get buyer name from order data
const getBuyerName = (checkout: BuyerCheckout) => {
  try {
    // First try to get buyer name from billing details
    const billingDetails = JSON.parse(checkout.billing_details);
    if (billingDetails.buyer_name) {
      return billingDetails.buyer_name;
    }
    
    // Then try to get buyer name from order details
    const orderDetails = JSON.parse(checkout.order_details);
    if (orderDetails.buyer) {
      return orderDetails.buyer;
    }
    
    // For buyer_checkout records, the user is actually the buyer
    if (checkout.source === 'buyer_checkout' && checkout.user?.name) {
      return checkout.user.name;
    }
    
    // Fallback
    return 'Unknown Buyer';
  } catch (e) {
    console.error('Error parsing buyer data:', e);
    return checkout.user?.name || 'Unknown Buyer';
  }
};

// Function to get the initials from the user name
const getUserInitials = (name: string) => {
  const initials = name.split(' ').map(n => n[0]).join('');
  return initials;
};

// Create refs to hold data
const buyerCheckoutData = ref<BuyerCheckout[]>([]);
const orderStatuses = ref<OrderStatus[]>([]);
const isLoading = ref(false);
const selectedOrderId = ref<number | null>(null);
const showStatusModal = ref(false);

// Fetch data from the backend
const fetchBuyerCheckout = async () => {
    try {
        isLoading.value = true;
        const response = await axios.get('/seller-orders');
        buyerCheckoutData.value = response.data;
    } catch (error) {
        console.error('Error fetching buyer checkout data:', error);
    } finally {
        isLoading.value = false;
    }
};

// Fetch order statuses
const fetchOrderStatuses = async () => {
    try {
        console.log('Fetching order statuses...');
        const response = await axios.get('/api/order-statuses');
        console.log('Order statuses response:', response.data);
        orderStatuses.value = response.data;
        console.log('Order statuses set:', orderStatuses.value);
    } catch (error: any) {
        console.error('Error fetching order statuses:', error);
        console.error('Error details:', error.response?.data || error.message);
    }
};

// Call the fetch functions when the component is mounted
onMounted(() => {
    fetchBuyerCheckout();
    fetchOrderStatuses();
});

// Filter orders based on the active tab
const filterOrders = (orders: BuyerCheckout[], activeTab: string): BuyerCheckout[] => {
    const statusMap: Record<string, string[]> = {
        "pendingOrders": ["pending"],
        "priorityOrders": ["Priority"],
        "activeOrders": ["Active", "active", "Order Accepted"], // Include both Active and Order Accepted
        "lateOrders": ["Late"],
        "deliveredOrders": ["Delivered"],
        "completedOrders": ["Completed", "completed"],
        "cancelledOrders": ["Cancelled"],
        "starredOrders": ["Starred"]
    };
    
    const statusNames = statusMap[activeTab];
    if (statusNames) {
        return orders.filter((order) => statusNames.includes(order.status));
    }
    return orders;
};

// Get the count of orders by status
const getOrderCount = (status: string) => {
    // Special handling for Active tab to include "Order Accepted" orders
    if (status === 'Active') {
        return buyerCheckoutData.value.filter((order) => 
            order.status === 'Active' || 
            order.status === 'active' || 
            order.status === 'Order Accepted'
        ).length;
    }
    
    // Special handling for Completed tab to include "completed" (lowercase)
    if (status === 'Completed') {
        return buyerCheckoutData.value.filter((order) => 
            order.status === 'Completed' || 
            order.status === 'completed'
        ).length;
    }
    
    return buyerCheckoutData.value.filter((order) => order.status === status).length;
};

// Update order status
const updateOrderStatus = async (orderId: number, statusId: number, notes?: string) => {
    try {
        console.log('Updating order status:', { orderId, statusId, notes });
        isLoading.value = true;
        
        const response = await axios.put(`/api/orders/${orderId}/status`, {
            status_id: statusId,
            notes: notes
        });
        
        console.log('API response:', response.data);
        
        // Update the local data
        const orderIndex = buyerCheckoutData.value.findIndex(order => order.id === orderId);
        console.log('Found order at index:', orderIndex);
        
        if (orderIndex !== -1) {
            console.log('Old status:', buyerCheckoutData.value[orderIndex].status);
            buyerCheckoutData.value[orderIndex].status = response.data.status_info.name;
            buyerCheckoutData.value[orderIndex].status_info = response.data.status_info;
            console.log('New status:', buyerCheckoutData.value[orderIndex].status);
        }
        
        // Close modal
        showStatusModal.value = false;
        selectedOrderId.value = null;
        
        console.log('✅ Status updated successfully:', response.data.message);
        
        // Show success notification (optional)
        alert(`Order status changed to: ${response.data.status_info.name}`);
        
    } catch (error: any) {
        console.error('❌ Error updating order status:', error);
        console.error('Error response:', error.response?.data);
        console.error('Error status:', error.response?.status);
        
        // Show error message to user
        alert(`Error updating status: ${error.response?.data?.message || error.message}`);
        
    } finally {
        isLoading.value = false;
    }
};

// Open status change modal
const openStatusModal = (orderId: number) => {
    console.log('Opening status modal for order:', orderId);
    console.log('Order ID type:', typeof orderId);
    console.log('Order ID raw value:', orderId);
    console.log('Available statuses:', getAvailableStatuses());
    
    // Ensure orderId is a number
    const numericOrderId = typeof orderId === 'string' ? parseInt(String(orderId).replace(/\D/g, '')) : orderId;
    console.log('Numeric order ID:', numericOrderId);
    
    selectedOrderId.value = numericOrderId;
    showStatusModal.value = true;
};

// Get status color for display
const getStatusColor = (statusInfo?: OrderStatus) => {
    return statusInfo?.color || '#6B7280';
};

// Get filtered statuses for status change modal
const getAvailableStatuses = () => {
    console.log('All order statuses:', orderStatuses.value);
    const filtered = orderStatuses.value.filter(status => status.name !== 'Order Placed');
    console.log('Filtered statuses for modal:', filtered);
    return filtered;
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
        @click="activeTab = 'pendingOrders'"
        :class="[activeTab === 'pendingOrders' ? 'bg-primary text-white' : 'bg-gray dark:bg-meta-4 text-black dark:text-white', 'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6']"
      >
        Pending ({{ getOrderCount('pending') }})
      </button>

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
        Active ({{ getOrderCount('Active') }})
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

    <!-- Loading State -->
    <div v-if="isLoading" class="flex justify-center items-center py-10">
      <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
      <span class="ml-2">Loading orders...</span>
    </div>

    <!-- Orders Display in Table Format -->
    <div v-else class="mt-5">
      <!-- Table Header -->
      <div class="flex items-center justify-between px-4 py-2 font-semibold bg-gray-100 dark:bg-meta-4">
        <div class="w-1/6">Buyer</div>
        <div class="w-1/6">Package</div>
        <div class="w-1/6">Due On</div>
        <div class="w-1/6">Total</div>
        <div class="w-1/6">Status</div>
        <div class="w-1/6">Actions</div>
      </div>

      <!-- No Orders Message -->
      <div v-if="filterOrders(buyerCheckoutData, activeTab).length === 0" class="text-center py-10 text-gray-500">
        No orders found for this status.
      </div>

      <!-- Orders Rows -->
      <div
        v-for="checkout in filterOrders(buyerCheckoutData, activeTab)"
        :key="checkout.id"
        class="flex items-center justify-between px-4 py-4 border-b border-stroke dark:border-strokedark hover:bg-gray-50 dark:hover:bg-meta-4"
      >
        <!-- Buyer Information -->
        <div class="flex items-center w-1/6">
          <div class="flex items-center justify-center w-10 h-10 text-lg font-semibold text-white bg-primary rounded-full">
            {{ getUserInitials(getBuyerName(checkout)) }}
          </div>
          <h3 class="ml-3 text-sm font-medium">{{ getBuyerName(checkout) }}</h3>
        </div>

        <!-- Package -->
        <div class="w-1/6 text-sm">{{ checkout.package_selected }}</div>

        <!-- Due On -->
        <div class="w-1/6 text-sm">{{ parseOrderDetails(checkout.order_details).deliveryTime || 'N/A' }}</div>

        <!-- Total -->
        <div class="w-1/6 text-sm font-semibold">${{ checkout.total_price }}</div>

        <!-- Status -->
        <div class="w-1/6">
          <span 
            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white"
            :style="{ backgroundColor: getStatusColor(checkout.status_info) }"
          >
            {{ checkout.status }}
          </span>
        </div>

        <!-- Actions -->
        <div class="w-1/6">
          <button
            @click="openStatusModal(checkout.id)"
            class="px-3 py-1 text-xs font-medium text-primary border border-primary rounded hover:bg-primary hover:text-white transition-colors"
          >
            Change Status
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Status Change Modal -->
  <div v-if="showStatusModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white dark:bg-boxdark rounded-lg p-8 w-full max-w-2xl mx-4 max-h-[80vh] overflow-y-auto">
      <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-semibold text-black dark:text-white">Change Order Status</h3>
        <button 
          @click="showStatusModal = false"
          class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div
          v-for="status in getAvailableStatuses()"
          :key="status.id"
          @click="updateOrderStatus(selectedOrderId!, status.id)"
          class="flex items-center p-4 border border-stroke dark:border-strokedark rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-meta-4 hover:border-primary transition-all duration-200 hover:shadow-md"
        >
          <span 
            class="inline-flex items-center justify-center w-5 h-5 rounded-full mr-4 flex-shrink-0"
            :style="{ backgroundColor: status.color }"
          ></span>
          <div class="flex-1">
            <div class="font-semibold text-black dark:text-white text-base">{{ status.name }}</div>
            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ status.description }}</div>
          </div>
        </div>
      </div>

      <div class="flex justify-end mt-6 space-x-3">
        <button
          @click="showStatusModal = false; selectedOrderId = null"
          class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 border border-stroke dark:border-strokedark rounded hover:bg-gray-50 dark:hover:bg-meta-4"
        >
          Cancel
        </button>
      </div>
    </div>
  </div>
  </AuthenticatedLayout>
</template>
<!-- {{ checkout.order_details }} {{ checkout.billing_details }} -->