<script setup lang="ts">
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import axios from "axios";
import { computed, onMounted, ref } from 'vue';

// Gig Create routing using router
const goToGigCreation = () => {
    router.visit('/create-gig'); 
};

const pageTitle = ref('Gigs');

// Define the interface for the gig and status filtering
interface Gig {
  id: number;
  gig_title: string;
  impressions: number;
  clicks: number;
  orders: number;
  cancellations: number;
  status: string; // Status from the backend
}

const gigs = ref<Gig[]>([]); // Gigs array
const itemsPerPage = ref(9); // Number of gigs to display initially
const currentPage = ref(1);  // Current page number
const activeTab = ref('active'); // Active tab for filtering gigs
const dateRange = ref('last7Days'); // Date range filter

// Fetch gigs from the backend
const fetchGigs = async () => {
  try {
    const response = await axios.get('/gigs');
    gigs.value = response.data;
  } catch (error) {
    console.error('Error fetching gigs:', error);
  }
};

// Function to filter gigs based on the active tab
const filterGigs = (gigs: Gig[], activeTab: string): Gig[] => {
  switch (activeTab) {
    case "active":
      return gigs.filter((gig) => gig.status === "active");
    case "pendingApproval":
      return gigs.filter((gig) => gig.status === "pendingApproval");
    case "requiresModification":
      return gigs.filter((gig) => gig.status === "requiresModification");
    case "paused":
      return gigs.filter((gig) => gig.status === "paused");
    case "denied":
      return gigs.filter((gig) => gig.status === "denied");
    default:
      return gigs;
  }
};

// Computed property for visible gigs based on the current page and active tab
const visibleGigs = computed(() => {
  const filteredGigs = filterGigs(gigs.value, activeTab.value);
  return filteredGigs.slice(0, currentPage.value * itemsPerPage.value);
});

// Function to load more gigs (pagination)
const loadMore = () => {
  currentPage.value++;
};

// Function to show less gigs (reset pagination)
const showLess = () => {
  currentPage.value = 1;
};

// Call fetchGigs when the component is mounted
onMounted(() => {
  fetchGigs();
});

</script>

<template>
    <Head title="Design" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Design
            </h2>
        </template>

        <!-- Breadcrumb Start -->
        <BreadcrumbDefault :pageTitle="pageTitle" />
        <!-- Breadcrumb End --> 

        <!-- Main Content Start -->
        <div class="mb-14 w-full p-7.5">
            <!-- Tabs for Gig Status -->
            <div class="flex flex-wrap gap-3 pb-5 border-b border-stroke dark:border-strokedark">
                <!-- Tab Buttons -->
                <button
                    @click="activeTab = 'active'"
                    :class="[activeTab === 'active' ? 'bg-primary text-white' : 'bg-gray dark:bg-meta-4 text-black dark:text-white', 'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6']"
                >
                    Active ({{ filterGigs(gigs, 'active').length }})
                </button>
                <button
                    @click="activeTab = 'pendingApproval'"
                    :class="[activeTab === 'pendingApproval' ? 'bg-primary text-white' : 'bg-gray dark:bg-meta-4 text-black dark:text-white', 'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6']"
                >
                    Pending Approval ({{ filterGigs(gigs, 'pendingApproval').length }})
                </button>
                <button
                    @click="activeTab = 'requiresModification'"
                    :class="[activeTab === 'requiresModification' ? 'bg-primary text-white' : 'bg-gray dark:bg-meta-4 text-black dark:text-white', 'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6']"
                >
                    Requires Modification ({{ filterGigs(gigs, 'requiresModification').length }})
                </button>
                <button
                    @click="activeTab = 'paused'"
                    :class="[activeTab === 'paused' ? 'bg-primary text-white' : 'bg-gray dark:bg-meta-4 text-black dark:text-white', 'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6']"
                >
                    Paused ({{ filterGigs(gigs, 'paused').length }})
                </button>
                <button
                    @click="activeTab = 'denied'"
                    :class="[activeTab === 'denied' ? 'bg-primary text-white' : 'bg-gray dark:bg-meta-4 text-black dark:text-white', 'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6']"
                >
                    Denied ({{ filterGigs(gigs, 'denied').length }})
                </button>
                <button 
                    @click="goToGigCreation"
                    class="px-6 py-3 ml-2 text-white bg-green-500 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75">
                    CREATE A NEW GIG
                </button>
            </div>

            <!-- Gigs Table Display -->
            <div class="mt-5">
                <!-- Dropdown for Date Range -->
                <div class="flex justify-end">
                    <select v-model="dateRange" class="p-2 border border-gray-300 rounded-md">
                        <option value="last7Days">Last 7 Days</option>
                        <option value="last14Days">Last 14 Days</option>
                        <option value="last30Days">Last 30 Days</option>
                        <option value="last2Months">Last 2 Months</option>
                        <option value="last3Months">Last 3 Months</option>
                    </select>
                </div>

                <!-- Table Header -->
                <div class="flex items-center justify-between px-4 py-2 mt-3 font-semibold bg-gray-100">
                    <div class="w-2/5">Gig</div>
                    <div class="w-1/5">Impressions</div>
                    <div class="w-1/5">Clicks</div>
                    <div class="w-1/5">Orders</div>
                    <div class="w-1/5">Cancellations</div>
                </div>

                <!-- Table Rows for Gigs -->
                <div
                    v-for="gig in visibleGigs"
                    :key="gig.id"
                    class="flex items-center justify-between px-4 py-2 border-b"
                >
                    <!-- Gig Information -->
                    <div class="w-2/5">{{ gig.gig_title }}</div>
                    <div class="w-1/5">{{ gig.impressions }}</div>
                    <div class="w-1/5">{{ gig.clicks }}</div>
                    <div class="w-1/5">{{ gig.orders }}</div>
                    <div class="w-1/5">{{ gig.cancellations }}%</div>
                </div>

                <!-- Load More and Show Less Buttons -->
                <div class="mt-3">
                    <button v-if="visibleGigs.length < filterGigs(gigs, activeTab).length" @click="loadMore" class="px-4 py-2 text-white rounded-md bg-primary">Load More</button>
                    <button v-if="currentPage > 1" @click="showLess" class="px-4 py-2 ml-3 text-white bg-gray-500 rounded-md">Show Less</button>
                </div>
            </div>
        </div>
        <!-- Main Content End -->
    </AuthenticatedLayout>
</template>
