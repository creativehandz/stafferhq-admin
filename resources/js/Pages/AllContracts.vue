<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import { ref, computed } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link, router } from "@inertiajs/vue3";

interface Seller {
    id: number | null;
    name: string;
    email: string | null;
    profile_image: string | null;
    profile_image_url: string;
}

interface StatusInfo {
    color: string;
    bg_color: string;
    text: string;
    button_text: string;
}

interface Contract {
    id: number;
    service_title: string | null;
    package_selected: string;
    total_price: number;
    status: string;
    status_info: StatusInfo;
    seller?: Seller;
    delivery_time: string | null;
    created_at: string;
    updated_at: string;
    order_details: any;
    gig_id: number | null;
    can_activate_milestone: boolean;
    can_rehire: boolean;
}

interface Props {
    contracts: Contract[];
    totalContracts: number;
    activeContracts: number;
    completedContracts: number;
}

const props = defineProps<Props>();

const pageTitle = ref("All Contracts");
const searchQuery = ref("");
const selectedFilter = ref("all");

// Filter contracts based on search and status
const filteredContracts = computed(() => {
    let filtered = props.contracts;
    
    // Apply search filter
    if (searchQuery.value.trim()) {
        const query = searchQuery.value.toLowerCase();
        filtered = filtered.filter((contract: Contract) => 
            contract.package_selected.toLowerCase().includes(query) ||
            (contract.service_title?.toLowerCase().includes(query)) ||
            (contract.seller?.name?.toLowerCase().includes(query)) ||
            contract.status.toLowerCase().includes(query)
        );
    }
    
    // Apply status filter
    if (selectedFilter.value !== "all") {
        filtered = filtered.filter(contract => {
            switch (selectedFilter.value) {
                case "active":
                    return contract.status === "active";
                case "completed":
                    return ["completed", "delivered"].includes(contract.status);
                case "pending":
                    return ["pending", "Order Placed"].includes(contract.status);
                default:
                    return true;
            }
        });
    }
    
    return filtered;
});

// Format date for display
const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
    });
};

// Format currency
const formatCurrency = (amount: any) => {
    // Handle null, undefined, or empty values
    if (amount === null || amount === undefined || amount === '') {
        return '₹0.00';
    }
    
    // Convert to number if it's a string
    const numAmount = typeof amount === 'string' ? parseFloat(amount) : Number(amount);
    
    // Check if it's a valid number
    if (isNaN(numAmount)) {
        return '₹0.00';
    }
    
    return `₹${numAmount.toFixed(2)}`;
};

// Get user initials for avatar fallback
const getUserInitials = (name: string) => {
    return name.split(' ').map(n => n[0]).join('').substring(0, 2);
};

// Handle image loading errors
const handleImageError = (event: Event) => {
    const target = event.target as HTMLImageElement;
    if (target) {
        target.src = 'https://www.svgrepo.com/show/497407/profile-circle.svg';
    }
};
</script>

<template>
    <Head title="All Contracts" />

    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
            <!-- Header Section -->
            <div class="bg-white dark:bg-boxdark border-b border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Navigation tabs -->
                    <div class="flex space-x-8 py-4">
                        <Link :href="route('all-job-posts')">
                            <button class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 font-medium py-2 border-b-2 border-transparent hover:border-gray-300 transition-colors">
                                All job posts
                            </button>
                        </Link>
                        <button class="text-primary font-medium py-2 border-b-2 border-primary">
                            All contracts
                        </button>
                    </div>
                    
                    <!-- Page title and stats -->
                    <div class="py-6">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">All Contracts</h1>
                        <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                            <span class="flex items-center">
                                <span class="inline-block w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                {{ totalContracts }} total contracts
                            </span>
                            <span class="flex items-center">
                                <span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                {{ activeContracts }} active
                            </span>
                            <span class="flex items-center">
                                <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                                {{ completedContracts }} completed
                            </span>
                        </div>
                    </div>

                    <!-- Search and filters -->
                    <div class="pb-6">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1 max-w-md">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input
                                        v-model="searchQuery"
                                        type="text"
                                        placeholder="Search contracts, freelancers..."
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    />
                                </div>
                            </div>
                            <select 
                                v-model="selectedFilter"
                                class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            >
                                <option value="all">All Contracts</option>
                                <option value="active">Active</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contracts Grid -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Empty state -->
                <div v-if="filteredContracts.length === 0" class="text-center py-16">
                    <div class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-500 mb-6">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-full h-full">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">No contracts found</h3>
                    <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">
                        {{ searchQuery ? 'Try adjusting your search terms or filters.' : "You haven't placed any orders yet. Start by posting a job or browsing freelancers." }}
                    </p>
                    <div v-if="!searchQuery" class="mt-6">
                        <Link :href="route('post-a-job')" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-primary hover:bg-primary/90 transition-colors">
                            Post Your First Job
                        </Link>
                    </div>
                </div>

                <!-- Contracts Grid -->
                <div v-else class="grid gap-6">
                    <div
                        v-for="contract in filteredContracts"
                        :key="contract.id"
                        class="bg-white dark:bg-boxdark rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 overflow-hidden"
                        :style="{ borderLeftColor: contract.status_info.color }"
                    >
                        <!-- Contract Header -->
                        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">
                                        {{ contract.service_title || contract.package_selected }}
                                    </h3>
                                    <p v-if="contract.service_title" class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                        Package: {{ contract.package_selected }}
                                    </p>
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 space-x-4">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium"
                                            :style="{
                                                color: contract.status_info.color,
                                                backgroundColor: contract.status_info.bg_color
                                            }"
                                        >
                                            {{ contract.status_info.text }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            Order #{{ contract.id }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v1a3 3 0 003 3h3a3 3 0 003-3v-1m-9 0h9m-9 0V9a2 2 0 012-2h5a2 2 0 012 2v2"></path>
                                            </svg>
                                            {{ formatDate(contract.created_at) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Contract Details -->
                        <div class="p-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Freelancer Info -->
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        <div class="h-16 w-16 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700">
                                            <img
                                                v-if="contract.seller?.profile_image_url"
                                                :src="contract.seller.profile_image_url"
                                                :alt="contract.seller.name"
                                                class="h-full w-full object-cover"
                                                @error="handleImageError"
                                            />
                                            <div
                                                v-else
                                                class="h-full w-full bg-gradient-to-br from-primary to-blue-600 text-white flex items-center justify-center font-bold text-lg"
                                            >
                                                {{ getUserInitials(contract.seller?.name || 'Unknown') }}
                                            </div>
                                        </div>
                                        <span class="absolute -bottom-1 -right-1 h-5 w-5 rounded-full border-2 border-white bg-green-500 dark:border-gray-800"></span>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ contract.seller?.name || 'Unknown Seller' }}
                                        </h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ contract.seller?.email || 'No email' }}
                                        </p>
                                        <div class="flex items-center mt-1">
                                            <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">4.8</span>
                                            <span class="text-sm text-gray-500 dark:text-gray-400 ml-1">(124 reviews)</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contract Stats -->
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Budget -->
                                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Budget</p>
                                                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                                    {{ formatCurrency(contract.total_price) }}
                                                </p>
                                            </div>
                                            <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Timeline -->
                                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Timeline</p>
                                                <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    {{ contract.delivery_time || 'Not specified' }}
                                                </p>
                                            </div>
                                            <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                                <span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>
                                                Started {{ formatDate(contract.created_at) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contract Actions -->
                            <div class="mt-6 flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                                <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        Message freelancer
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        View details
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
