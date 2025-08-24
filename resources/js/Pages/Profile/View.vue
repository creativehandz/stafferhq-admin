<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

// Accept userName, userEmail, userPhone, userWebsite, userCompanySize, userCategories, and account info from backend
const props = defineProps({
    userName: {
        type: String,
        default: 'John Doe'
    },
    userEmail: {
        type: String,
        default: 'john.doe@example.com'
    },
    userPhone: {
        type: String,
        default: '+1 (555) 123-4567'
    },
    userWebsite: {
        type: String,
        default: 'https://johndoe.com'
    },
    userCompanySize: {
        type: String,
        default: null
    },
    userCategories: {
        type: Array,
        default: () => []
    },
    userRole: {
        type: Number,
        default: 2
    },
    userEmailVerifiedAt: {
        type: String,
        default: null
    },
    userCreatedAt: {
        type: String,
        default: null
    },
    userUpdatedAt: {
        type: String,
        default: null
    },
    userIsVerified: {
        type: Number,
        default: 0
    },
    userAboutCompany: {
        type: String,
        default: null
    },
    userLocation: {
        type: String,
        default: null
    },
    userSocialLinks: {
        type: String,
        default: null
    },
    userProfileImage: {
        type: String,
        default: null
    },
    status: {
        type: String,
        default: null
    }
});

// Helper function to handle categories (now expects array from backend)
const getCategories = () => {
    return props.userCategories || [];
};

// Helper function to get account type based on role
const getAccountType = () => {
    switch(props.userRole) {
        case 1: return 'Buyer';
        case 2: return 'Seller';
        case 3: return 'Admin';
        default: return 'User';
    }
};

// Helper function to format email verification status
const getEmailVerificationStatus = () => {
    if (props.userEmailVerifiedAt) {
        const date = new Date(props.userEmailVerifiedAt);
        return `✓ Verified on ${date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}`;
    }
    return '❌ Not verified';
};

// Helper function to format member since date
const getMemberSinceDate = () => {
    if (props.userCreatedAt) {
        const date = new Date(props.userCreatedAt);
        return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    }
    return 'Unknown';
};

// Helper function to format last updated date
const getLastUpdatedDate = () => {
    if (props.userUpdatedAt) {
        const date = new Date(props.userUpdatedAt);
        return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    }
    return 'Unknown';
};

// Helper function to parse social links
const getSocialLinks = () => {
    if (!props.userSocialLinks) return [];
    try {
        return JSON.parse(props.userSocialLinks);
    } catch (error) {
        console.error('Error parsing social links:', error);
        return [];
    }
};

// Helper function to get profile image URL
const getProfileImageUrl = () => {
    if (props.userProfileImage) {
        // If it's already a full URL, return as is
        if (props.userProfileImage.startsWith('http')) {
            return props.userProfileImage;
        }
        // Otherwise, construct the storage URL
        return `/storage/${props.userProfileImage}`;
    }
    // Default profile image
    return 'https://www.svgrepo.com/show/497407/profile-circle.svg';
};
</script>

<template>
    <Head title="View Profile" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Success Message -->
                <div v-if="status === 'profile-updated'" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline"> Your profile has been updated successfully.</span>
                </div>

                <!-- Profile Header -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center space-x-6">
                            <!-- Profile Picture -->
                            <div class="flex-shrink-0">
                                <img 
                                    class="h-24 w-24 rounded-full border-4 border-gray-200 dark:border-gray-600" 
                                    :src="getProfileImageUrl()" 
                                    alt="Profile Picture"
                                >
                            </div>

                            <!-- Profile Info -->
                            <div class="flex-1">
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ userName }}
                                </h1>
                                <p class="text-lg text-gray-600 dark:text-gray-300 mt-1">
                                    {{ userEmail }}
                                </p>
                                <div class="flex items-center mt-2 space-x-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ getAccountType() }}
                                    </span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        Member since {{ getMemberSinceDate() }}
                                    </span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex-shrink-0">
                                <a 
                                    :href="route('profile.edit')"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                Personal Information
                            </h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Full Name</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ userName }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ userEmail }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ userPhone || 'Not provided' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Company Size</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ userCompanySize || 'Not specified' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Website</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        <a v-if="userWebsite" :href="userWebsite" target="_blank" class="text-indigo-600 hover:text-indigo-800">
                                            {{ userWebsite }}
                                        </a>
                                        <span v-else class="text-gray-500">Not provided</span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Location</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ userLocation || 'Not specified' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                Account Information
                            </h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Type</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ getAccountType() }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Verified</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        <span :class="userEmailVerifiedAt ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'">
                                            {{ getEmailVerificationStatus() }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Member Since</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ getMemberSinceDate() }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ getLastUpdatedDate() }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Categories Section -->
                <div v-if="userCategories && userCategories.length > 0" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            Categories & Skills
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            <span 
                                v-for="category in getCategories()" 
                                :key="category"
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-800 dark:text-indigo-100"
                            >
                                {{ category }}
                            </span>
                            <span v-if="getCategories().length === 0" class="text-sm text-gray-500 dark:text-gray-400">
                                No categories added yet
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Social Links Section -->
                <div v-if="getSocialLinks().length > 0" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            Social Links
                        </h3>
                        <div class="flex flex-wrap gap-4">
                            <a 
                                v-for="link in getSocialLinks()" 
                                :key="link.platform"
                                :href="link.url"
                                target="_blank"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 transition-colors duration-200"
                            >
                                <svg v-if="link.platform === 'Twitter'" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                                <svg v-else-if="link.platform === 'LinkedIn'" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                                <svg v-else class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C5.374 0 0 5.373 0 12s5.374 12 12 12 12-5.373 12-12S18.626 0 12 0zm5.568 8.16l-.169 1.966c-.04.442-.146.55-.3.55-.109 0-.24-.05-.395-.15-.888-.562-1.394-.876-1.846-.876-.385 0-.711.228-.906.633-.157.323-.195.722-.195 1.15v2.714c0 .553-.447 1-.999 1h-1.5c-.553 0-1-.447-1-1v-2.714c0-.428-.038-.827-.195-1.15-.195-.405-.521-.633-.906-.633-.452 0-.958.314-1.846.876-.155.1-.286.15-.395.15-.154 0-.26-.108-.3-.55L7.432 8.16c-.04-.442.1-.8.539-.8.154 0 .315.045.479.134.888.481 1.527.719 2.55.719s1.662-.238 2.55-.719c.164-.089.325-.134.479-.134.439 0 .579.358.539.8z"/>
                                </svg>
                                {{ link.platform }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Bio/Description Section -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            About
                        </h3>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-600 dark:text-gray-300">
                                {{ userAboutCompany || 'No company description provided yet.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Account Settings -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            Account Settings
                        </h3>
                        
                        <div class="flex space-x-4">
                            <a 
                                :href="route('profile.edit')"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Edit Profile
                            </a>
                            
                            <button 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Account Settings
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
