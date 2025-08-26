<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";

// Define TypeScript interface for gig data
interface Gig {
    id: number;
    gig_title: string;
    gig_description: string;
    min_price: number;
    user: {
        id: number;
        name: string;
        email: string;
    };
    category?: {
        name: string;
    };
    subcategory?: {
        name: string;
    };
    pricing: {
        basic: { price: number; delivery_time: string };
        standard: { price: number; delivery_time: string };
        premium: { price: number; delivery_time: string };
    };
    status: string;
    created_at: string;
}

// Props from the controller
interface Props {
    gigs: Gig[];
}

const props = defineProps<Props>();
const pageTitle = ref("Hire a Talent");

// Format currency as Indian Rupee
const formatCurrency = (amount: number): string => {
    if (amount === null || amount === undefined) {
        return '₹0';
    }
    return `₹${amount.toLocaleString('en-IN')}`;
};

// Truncate description text
const truncateText = (text: string, maxLength: number = 100): string => {
    if (text.length <= maxLength) return text;
    return text.substring(0, maxLength) + '...';
};

// Format date
const formatDate = (dateString: string): string => {
    return new Date(dateString).toLocaleDateString('en-IN');
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Hire a Talent" />

        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Hire a Talent
            </h2>
        </template>

        <BreadcrumbDefault :pageTitle="pageTitle" />

        <div class="flex flex-col">
            <div class="bg-white border rounded-sm border-stroke shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="py-6 px-4 md:px-6 xl:px-7.5">
                    <h4 class="text-xl font-bold text-black dark:text-white">
                        Available Services
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                        Browse and hire talented professionals for your projects
                    </p>
                </div>

                <!-- Check if gigs exist -->
                <div v-if="props.gigs && props.gigs.length > 0">
                    <!-- Services Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                        <div 
                            v-for="gig in props.gigs" 
                            :key="gig.id"
                            class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200"
                        >
                            <!-- Service Header -->
                            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                    {{ gig.gig_title }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ truncateText(gig.gig_description) }}
                                </p>
                            </div>

                            <!-- Service Details -->
                            <div class="p-4">
                                <!-- Seller Info -->
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                        {{ gig.user?.name?.charAt(0).toUpperCase() || 'U' }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ gig.user?.name || 'Anonymous' }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Seller
                                        </p>
                                    </div>
                                </div>

                                <!-- Category Info -->
                                <div class="mb-3" v-if="gig.category || gig.subcategory">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ gig.category?.name || gig.subcategory?.name || 'General' }}
                                    </span>
                                </div>

                                <!-- Pricing -->
                                <div class="mb-4">
                                    <p class="text-lg font-bold text-green-600 dark:text-green-400">
                                        Starting from {{ formatCurrency(gig.min_price) }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Multiple packages available
                                    </p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <a 
                                        :href="`/job-description/${gig.id}`"
                                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-center"
                                    >
                                        View Details
                                    </a>
                                    <a 
                                        :href="`/checkout/${gig.id}`"
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-center"
                                    >
                                        Hire Now
                                    </a>
                                </div>

                                <!-- Posted Date -->
                                <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Posted on {{ formatDate(gig.created_at) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- No Gigs Available -->
                <div v-else class="p-12 text-center">
                    <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                        No Services Available
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        There are currently no active services posted by sellers.
                    </p>
                    <a 
                        href="/become-a-seller" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200"
                    >
                        Become a Seller
                    </a>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
