<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import { ref, computed, onMounted } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";

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
    can_review?: boolean;
    has_buyer_review?: boolean;
    has_seller_review?: boolean;
    buyer_review?: {
        id: number;
        rating: number;
        review_text: string;
        reviewed_at: string;
    };
    seller_review?: {
        id: number;
        rating: number;
        review_text: string;
        reviewed_at: string;
    };
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

// Review modal state
const showReviewModal = ref(false);
const selectedContractForReview = ref<Contract | null>(null);
const isLoading = ref(false);
const reviewForm = ref({
    rating: 5,
    review_text: '',
    is_public: true,
    review_criteria: {
        communication: 5,
        work_quality: 5,
        professionalism: 5,
        deadline_adherence: 5
    }
});
const reviewErrors = ref<Record<string, string>>({});

// Show review details modal
const showReviewDetailsModal = ref(false);
const selectedReviewForDetails = ref<any>(null);

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

// Open review modal
const openReviewModal = (contract: Contract) => {
    selectedContractForReview.value = contract;
    showReviewModal.value = true;
    
    // Reset form
    reviewForm.value = {
        rating: 5,
        review_text: '',
        is_public: true,
        review_criteria: {
            communication: 5,
            work_quality: 5,
            professionalism: 5,
            deadline_adherence: 5
        }
    };
    reviewErrors.value = {};
};

// Submit review
const submitReview = async () => {
    if (!selectedContractForReview.value) return;
    
    try {
        isLoading.value = true;
        reviewErrors.value = {};

        const response = await axios.post(`/orders/${selectedContractForReview.value.id}/submit-buyer-review`, {
            rating: reviewForm.value.rating,
            review_text: reviewForm.value.review_text,
            is_public: reviewForm.value.is_public,
            review_criteria: reviewForm.value.review_criteria
        });

        if (response.data.success) {
            // Update the local data
            const contractIndex = props.contracts.findIndex(contract => contract.id === selectedContractForReview.value?.id);
            if (contractIndex !== -1) {
                props.contracts[contractIndex].has_buyer_review = true;
                props.contracts[contractIndex].can_review = false;
                props.contracts[contractIndex].buyer_review = response.data.review;
            }

            // Close modal and show success message
            showReviewModal.value = false;
            selectedContractForReview.value = null;
            
            alert('Review submitted successfully!');
        }
    } catch (error: any) {
        console.error('Error submitting review:', error);
        
        if (error.response?.data?.errors) {
            reviewErrors.value = error.response.data.errors;
        } else {
            alert(`Error submitting review: ${error.response?.data?.message || error.message}`);
        }
    } finally {
        isLoading.value = false;
    }
};

// Close review modal
const closeReviewModal = () => {
    showReviewModal.value = false;
    selectedContractForReview.value = null;
    reviewErrors.value = {};
};

// Show review details
const showReviewDetails = (review: any, type: 'buyer' | 'seller') => {
    selectedReviewForDetails.value = { ...review, type };
    showReviewDetailsModal.value = true;
};

// Close review details modal
const closeReviewDetailsModal = () => {
    showReviewDetailsModal.value = false;
    selectedReviewForDetails.value = null;
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
                <div v-else class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    <div
                        v-for="contract in filteredContracts"
                        :key="contract.id"
                        class="bg-white dark:bg-boxdark rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200 dark:border-gray-700 overflow-hidden group"
                    >
                        <!-- Contract Header -->
                        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mr-3"
                                            :style="{
                                                color: contract.status_info.color,
                                                backgroundColor: contract.status_info.bg_color
                                            }"
                                        >
                                            {{ contract.status_info.text }}
                                        </span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            #{{ contract.id }}
                                        </span>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1 h-14 flex items-start leading-tight">
                                        <span class="line-clamp-2">
                                            {{ contract.service_title || contract.package_selected }}
                                        </span>
                                    </h3>
                                    <p v-if="contract.service_title" class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ contract.package_selected }} Package
                                    </p>
                                </div>
                            </div>

                            <!-- Date Info -->
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v1a3 3 0 003 3h3a3 3 0 003-3v-1m-9 0h9m-9 0V9a2 2 0 012-2h5a2 2 0 012 2v2"></path>
                                </svg>
                                Started {{ formatDate(contract.created_at) }}
                            </div>
                        </div>

                        <!-- Contract Details -->
                        <div class="p-6">
                            <!-- Freelancer Info -->
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="relative">
                                    <div class="h-12 w-12 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700">
                                        <img
                                            v-if="contract.seller?.profile_image_url"
                                            :src="contract.seller.profile_image_url"
                                            :alt="contract.seller.name"
                                            class="h-full w-full object-cover"
                                            @error="handleImageError"
                                        />
                                        <div
                                            v-else
                                            class="h-full w-full bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center font-bold text-sm"
                                        >
                                            {{ getUserInitials(contract.seller?.name || 'U') }}
                                        </div>
                                    </div>
                                    <span class="absolute -bottom-0.5 -right-0.5 h-3.5 w-3.5 rounded-full border-2 border-white bg-green-500 dark:border-gray-800"></span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                        {{ contract.seller?.name || 'Unknown Seller' }}
                                    </h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Freelancer
                                    </p>
                                </div>
                            </div>

                            <!-- Contract Stats -->
                            <div class="space-y-3 mb-4">
                                <!-- Budget -->
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Budget</span>
                                    <span class="text-lg font-bold text-green-600 dark:text-green-400">
                                        {{ formatCurrency(contract.total_price) }}
                                    </span>
                                </div>

                                <!-- Timeline -->
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Timeline</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ contract.delivery_time || 'Not specified' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Progress Bar (for active contracts) -->
                            <div v-if="contract.status === 'active'" class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Progress</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">65%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full transition-all duration-300" style="width: 65%"></div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    Message
                                </button>
                                <button class="flex-1 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium py-2.5 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Details
                                </button>
                            </div>

                            <!-- Review Section -->
                            <div v-if="contract.status === 'completed'" class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                <!-- Review Button for Completed Orders -->
                                <button
                                    v-if="contract.can_review"
                                    @click="openReviewModal(contract)"
                                    class="w-full px-3 py-2 text-sm font-medium text-green-600 border border-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-colors duration-200 flex items-center justify-center"
                                >
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                    Review Seller
                                </button>

                                <!-- Show Review Status if Already Reviewed -->
                                <div v-else-if="contract.has_buyer_review" class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-green-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            You reviewed this seller
                                        </span>
                                        <button
                                            @click="showReviewDetails(contract.buyer_review, 'buyer')"
                                            class="text-xs text-blue-600 hover:text-blue-800 underline"
                                        >
                                            View Review
                                        </button>
                                    </div>
                                    <div v-if="contract.buyer_review" class="text-sm text-gray-600 dark:text-gray-400">
                                        ⭐ {{ contract.buyer_review.rating }}/5 stars
                                    </div>
                                </div>

                                <!-- Show Seller's Review if Available -->
                                <div v-if="contract.has_seller_review" class="mt-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-gray-700 dark:text-gray-300 font-medium">
                                            Seller's Review of You
                                        </span>
                                        <button
                                            @click="showReviewDetails(contract.seller_review, 'seller')"
                                            class="text-xs text-blue-600 hover:text-blue-800 underline"
                                        >
                                            View Details
                                        </button>
                                    </div>
                                    <div v-if="contract.seller_review" class="text-sm text-gray-600 dark:text-gray-400">
                                        ⭐ {{ contract.seller_review.rating }}/5 stars
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Modal -->
        <div v-if="showReviewModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white dark:bg-boxdark rounded-lg p-8 w-full max-w-2xl mx-4 max-h-[80vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-black dark:text-white">Review Seller</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Rate your experience with {{ selectedContractForReview?.seller?.name }}
                        </p>
                    </div>
                    <button 
                        @click="closeReviewModal"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="submitReview">
                    <!-- Overall Rating -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Overall Rating *
                        </label>
                        <div class="flex items-center space-x-1">
                            <button
                                v-for="star in 5"
                                :key="star"
                                type="button"
                                @click="reviewForm.rating = star"
                                class="text-2xl focus:outline-none transition-colors"
                                :class="star <= reviewForm.rating ? 'text-yellow-400' : 'text-gray-300'"
                            >
                                ⭐
                            </button>
                            <span class="ml-3 text-sm text-gray-600 dark:text-gray-400">{{ reviewForm.rating }}/5</span>
                        </div>
                        <div v-if="reviewErrors.rating" class="text-red-500 text-sm mt-1">{{ reviewErrors.rating[0] }}</div>
                    </div>

                    <!-- Detailed Criteria -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Detailed Ratings
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Communication -->
                            <div>
                                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Communication</label>
                                <div class="flex items-center">
                                    <button
                                        v-for="star in 5"
                                        :key="star"
                                        type="button"
                                        @click="reviewForm.review_criteria.communication = star"
                                        class="text-lg focus:outline-none"
                                        :class="star <= reviewForm.review_criteria.communication ? 'text-yellow-400' : 'text-gray-300'"
                                    >
                                        ⭐
                                    </button>
                                    <span class="text-xs text-gray-500 ml-2">{{ reviewForm.review_criteria.communication }}/5</span>
                                </div>
                            </div>

                            <!-- Work Quality -->
                            <div>
                                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Work Quality</label>
                                <div class="flex items-center">
                                    <button
                                        v-for="star in 5"
                                        :key="star"
                                        type="button"
                                        @click="reviewForm.review_criteria.work_quality = star"
                                        class="text-lg focus:outline-none"
                                        :class="star <= reviewForm.review_criteria.work_quality ? 'text-yellow-400' : 'text-gray-300'"
                                    >
                                        ⭐
                                    </button>
                                    <span class="text-xs text-gray-500 ml-2">{{ reviewForm.review_criteria.work_quality }}/5</span>
                                </div>
                            </div>

                            <!-- Professionalism -->
                            <div>
                                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Professionalism</label>
                                <div class="flex items-center">
                                    <button
                                        v-for="star in 5"
                                        :key="star"
                                        type="button"
                                        @click="reviewForm.review_criteria.professionalism = star"
                                        class="text-lg focus:outline-none"
                                        :class="star <= reviewForm.review_criteria.professionalism ? 'text-yellow-400' : 'text-gray-300'"
                                    >
                                        ⭐
                                    </button>
                                    <span class="text-xs text-gray-500 ml-2">{{ reviewForm.review_criteria.professionalism }}/5</span>
                                </div>
                            </div>

                            <!-- Deadline Adherence -->
                            <div>
                                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Deadline Adherence</label>
                                <div class="flex items-center">
                                    <button
                                        v-for="star in 5"
                                        :key="star"
                                        type="button"
                                        @click="reviewForm.review_criteria.deadline_adherence = star"
                                        class="text-lg focus:outline-none"
                                        :class="star <= reviewForm.review_criteria.deadline_adherence ? 'text-yellow-400' : 'text-gray-300'"
                                    >
                                        ⭐
                                    </button>
                                    <span class="text-xs text-gray-500 ml-2">{{ reviewForm.review_criteria.deadline_adherence }}/5</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review Text -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Your Review *
                        </label>
                        <textarea
                            v-model="reviewForm.review_text"
                            placeholder="Share your experience working with this seller..."
                            rows="4"
                            class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white"
                            :class="reviewErrors.review_text ? 'border-red-500' : ''"
                        ></textarea>
                        <div class="flex justify-between items-center mt-1">
                            <div v-if="reviewErrors.review_text" class="text-red-500 text-sm">{{ reviewErrors.review_text[0] }}</div>
                            <div class="text-xs text-gray-500">{{ reviewForm.review_text.length }}/1000 characters</div>
                        </div>
                    </div>

                    <!-- Public Review Option -->
                    <div class="mb-6">
                        <div class="flex items-center">
                            <input
                                v-model="reviewForm.is_public"
                                type="checkbox"
                                id="is_public"
                                class="mr-2 rounded border-gray-300 text-primary focus:ring-primary"
                            >
                            <label for="is_public" class="text-sm text-gray-700 dark:text-gray-300">
                                Make this review public (visible to other users)
                            </label>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-600">
                        <button
                            type="button"
                            @click="closeReviewModal"
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700"
                            :disabled="isLoading"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-6 py-2 text-sm font-medium text-white bg-primary rounded hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 disabled:opacity-50"
                            :disabled="isLoading || !reviewForm.review_text.trim()"
                        >
                            <span v-if="isLoading" class="inline-flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Submitting...
                            </span>
                            <span v-else>Submit Review</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Review Details Modal -->
        <div v-if="showReviewDetailsModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white dark:bg-boxdark rounded-lg p-8 w-full max-w-lg mx-4">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-black dark:text-white">
                        {{ selectedReviewForDetails?.type === 'buyer' ? 'Your Review' : 'Seller\'s Review' }}
                    </h3>
                    <button 
                        @click="closeReviewDetailsModal"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div v-if="selectedReviewForDetails">
                    <!-- Rating -->
                    <div class="mb-4">
                        <div class="flex items-center">
                            <span class="text-lg mr-2">{{ selectedReviewForDetails.rating }}/5</span>
                            <div class="flex">
                                <span v-for="i in 5" :key="i" class="text-lg">
                                    {{ i <= selectedReviewForDetails.rating ? '⭐' : '☆' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Review Text -->
                    <div class="mb-4">
                        <p class="text-gray-700 dark:text-gray-300">{{ selectedReviewForDetails.review_text }}</p>
                    </div>

                    <!-- Review Date -->
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Reviewed on {{ formatDate(selectedReviewForDetails.reviewed_at) }}
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button
                        @click="closeReviewDetailsModal"
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    word-wrap: break-word;
    hyphens: auto;
}
</style>
