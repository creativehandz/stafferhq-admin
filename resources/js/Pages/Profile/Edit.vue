<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    userName: {
        type: String,
        required: true
    },
    userEmail: {
        type: String,
        required: true
    },
    userPhone: {
        type: String,
        default: ''
    },
    userWebsite: {
        type: String,
        default: ''
    },
    userCompanySize: {
        type: String,
        default: ''
    },
    userLocation: {
        type: String,
        default: ''
    },
    userSocialLinks: {
        type: String,
        default: null
    },
    categories: {
        type: Array,
        default: () => []
    },
    userCategories: {
        type: Array,
        default: () => []
    }
});

// Parse existing social links
const parseSocialLinks = () => {
    if (!props.userSocialLinks) return {};
    try {
        const links = JSON.parse(props.userSocialLinks);
        const socialLinksObj = {};
        
        // Convert array to object with platform as key
        links.forEach(link => {
            if (link.platform && link.url) {
                socialLinksObj[link.platform.toLowerCase()] = link.url;
            }
        });
        
        return socialLinksObj;
    } catch (error) {
        console.error('Error parsing social links:', error);
        return {};
    }
};

const existingSocialLinks = parseSocialLinks();

// Form handling with Inertia
const form = useForm({
    name: props.userName,
    email: props.userEmail,
    phone: props.userPhone || '',
    website: props.userWebsite || '',
    company_size: props.userCompanySize || '',
    location: props.userLocation || '',
    categories: (props.userCategories || []).map(id => id.toString()),
    twitter: existingSocialLinks.twitter || '',
    linkedin: existingSocialLinks.linkedin || '',
    facebook: existingSocialLinks.facebook || '',
    instagram: existingSocialLinks.instagram || '',
    github: existingSocialLinks.github || '',
    youtube: existingSocialLinks.youtube || ''
});

const submit = () => {
    console.log('Form submission started...');
    console.log('Categories being sent (original):', form.categories);
    
    // Convert categories to integers before sending
    const formData = {
        ...form.data(),
        categories: form.categories.map(id => parseInt(id))
    };
    
    console.log('Categories being sent (converted):', formData.categories);
    console.log('Full form data:', formData);
    
    form.transform(() => formData).patch(route('profile.update'), {
        preserveScroll: true,
        onSuccess: (page) => {
            console.log('Form saved successfully!', page);
        },
        onError: (errors) => {
            console.error('Form save failed:', errors);
        }
    });
};

// Handle category checkbox changes
const toggleCategory = (categoryId) => {
    console.log('toggleCategory called with:', categoryId, typeof categoryId);
    
    // Convert to string for consistency with stored format
    const categoryIdStr = categoryId.toString();
    const index = form.categories.indexOf(categoryIdStr);
    
    console.log('Current form.categories:', form.categories);
    console.log('Looking for categoryIdStr:', categoryIdStr, 'at index:', index);
    
    if (index > -1) {
        // Remove category if already selected
        form.categories.splice(index, 1);
        console.log('Removed category:', categoryIdStr);
    } else {
        // Add category if not selected
        form.categories.push(categoryIdStr);
        console.log('Added category:', categoryIdStr);
    }
    
    console.log('Updated form.categories:', form.categories);
    console.log('Categories updated. Use Save Changes button to persist to database.');
};

// Check if category is selected
const isCategorySelected = (categoryId) => {
    // Handle both string and integer comparisons
    return form.categories.includes(categoryId) || 
           form.categories.includes(categoryId.toString()) || 
           form.categories.includes(parseInt(categoryId));
};

// Company size options
const companySizeOptions = [
    { value: '1-10', label: '1-10 employees' },
    { value: '11-50', label: '11-50 employees' },
    { value: '51-200', label: '51-200 employees' },
    { value: '201-500', label: '201-500 employees' },
    { value: '501-1000', label: '501-1000 employees' },
    { value: '1000+', label: '1000+ employees' }
];
</script>

<template>
    <Head title="Edit Profile" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Edit Profile Header -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                                    Edit Profile
                                </h1>
                                <p class="text-lg text-gray-600 dark:text-gray-300 mt-1">
                                    Update your profile information
                                </p>
                            </div>
                            <div class="flex space-x-4">
                                <a 
                                    :href="route('profile.show')"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Form -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name Field -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Full Name *
                                    </label>
                                    <input
                                        id="name"
                                        type="text"
                                        v-model="form.name"
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Enter your full name"
                                    />
                                    <div v-if="form.errors.name" class="mt-1 text-sm text-red-600 dark:text-red-400">
                                        {{ form.errors.name }}
                                    </div>
                                </div>

                                <!-- Email Field -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Email Address *
                                    </label>
                                    <input
                                        id="email"
                                        type="email"
                                        v-model="form.email"
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Enter your email address"
                                    />
                                    <div v-if="form.errors.email" class="mt-1 text-sm text-red-600 dark:text-red-400">
                                        {{ form.errors.email }}
                                    </div>
                                </div>

                                <!-- Phone Field -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Phone Number
                                    </label>
                                    <input
                                        id="phone"
                                        type="tel"
                                        v-model="form.phone"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Enter your phone number"
                                    />
                                    <div v-if="form.errors.phone" class="mt-1 text-sm text-red-600 dark:text-red-400">
                                        {{ form.errors.phone }}
                                    </div>
                                </div>

                                <!-- Website Field -->
                                <div>
                                    <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Website
                                    </label>
                                    <input
                                        id="website"
                                        type="url"
                                        v-model="form.website"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="https://example.com"
                                    />
                                    <div v-if="form.errors.website" class="mt-1 text-sm text-red-600 dark:text-red-400">
                                        {{ form.errors.website }}
                                    </div>
                                </div>

                                <!-- Company Size Field -->
                                <div>
                                    <label for="company_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Company Size
                                    </label>
                                    <select
                                        id="company_size"
                                        v-model="form.company_size"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                    >
                                        <option value="">Select company size</option>
                                        <option 
                                            v-for="option in companySizeOptions" 
                                            :key="option.value" 
                                            :value="option.value"
                                        >
                                            {{ option.label }}
                                        </option>
                                    </select>
                                    <div v-if="form.errors.company_size" class="mt-1 text-sm text-red-600 dark:text-red-400">
                                        {{ form.errors.company_size }}
                                    </div>
                                </div>

                                <!-- Location Field -->
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Location
                                    </label>
                                    <input
                                        id="location"
                                        type="text"
                                        v-model="form.location"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Enter your location"
                                    />
                                    <div v-if="form.errors.location" class="mt-1 text-sm text-red-600 dark:text-red-400">
                                        {{ form.errors.location }}
                                    </div>
                                </div>
                            </div>

                            <!-- Social Media Links Section -->
                            <div class="space-y-4">
                                <div class="border-t border-gray-200 dark:border-gray-600 pt-6">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                        Social Media Links
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Twitter Field -->
                                        <div>
                                            <label for="twitter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                                    </svg>
                                                    Twitter
                                                </div>
                                            </label>
                                            <input
                                                id="twitter"
                                                type="url"
                                                v-model="form.twitter"
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                                placeholder="https://twitter.com/username"
                                            />
                                        </div>

                                        <!-- LinkedIn Field -->
                                        <div>
                                            <label for="linkedin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                                    </svg>
                                                    LinkedIn
                                                </div>
                                            </label>
                                            <input
                                                id="linkedin"
                                                type="url"
                                                v-model="form.linkedin"
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                                placeholder="https://linkedin.com/in/username"
                                            />
                                        </div>

                                        <!-- Facebook Field -->
                                        <div>
                                            <label for="facebook" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-blue-700" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                                    </svg>
                                                    Facebook
                                                </div>
                                            </label>
                                            <input
                                                id="facebook"
                                                type="url"
                                                v-model="form.facebook"
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                                placeholder="https://facebook.com/username"
                                            />
                                        </div>

                                        <!-- Instagram Field -->
                                        <div>
                                            <label for="instagram" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.418-3.323C6.001 8.198 7.152 7.708 8.449 7.708s2.448.49 3.323 1.418c.875.876 1.365 2.026 1.365 3.323s-.49 2.448-1.365 3.323c-.875.807-2.026 1.297-3.323 1.297zm7.718-9.469c-.632 0-1.155-.523-1.155-1.155s.523-1.155 1.155-1.155 1.155.523 1.155 1.155-.523 1.155-1.155 1.155zM12.017 7.708c-2.607 0-4.739 2.132-4.739 4.739s2.132 4.739 4.739 4.739 4.739-2.132 4.739-4.739-2.132-4.739-4.739-4.739z"/>
                                                    </svg>
                                                    Instagram
                                                </div>
                                            </label>
                                            <input
                                                id="instagram"
                                                type="url"
                                                v-model="form.instagram"
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                                placeholder="https://instagram.com/username"
                                            />
                                        </div>

                                        <!-- GitHub Field -->
                                        <div>
                                            <label for="github" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-gray-800 dark:text-gray-200" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                                    </svg>
                                                    GitHub
                                                </div>
                                            </label>
                                            <input
                                                id="github"
                                                type="url"
                                                v-model="form.github"
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                                placeholder="https://github.com/username"
                                            />
                                        </div>

                                        <!-- YouTube Field -->
                                        <div>
                                            <label for="youtube" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                                    </svg>
                                                    YouTube
                                                </div>
                                            </label>
                                            <input
                                                id="youtube"
                                                type="url"
                                                v-model="form.youtube"
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                                placeholder="https://youtube.com/channel/username"
                                            />
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Add your social media profile links. These fields are for display purposes only.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Services Section -->
                            <div class="space-y-4">
                                <div class="border-t border-gray-200 dark:border-gray-600 pt-6">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                        Categories
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        <div 
                                            v-for="category in categories" 
                                            :key="category.id" 
                                            class="flex items-center"
                                        >
                                            <input
                                                :id="`category_${category.id}`"
                                                type="checkbox"
                                                :checked="isCategorySelected(category.id)"
                                                @change="toggleCategory(category.id)"
                                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700"
                                            />
                                            <label 
                                                :for="`category_${category.id}`" 
                                                class="ml-2 block text-sm text-gray-900 dark:text-gray-100"
                                            >
                                                {{ category.name }}
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Select the categories that best describe your services. These will help users find you.
                                        </p>
                                    </div>
                                    
                                    <!-- Debug Information -->
                                    <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Debug Information (Real-time):</h4>
                                        <div class="text-xs text-gray-700 dark:text-gray-300 space-y-1">
                                            <div><strong>Current Form Categories (Pending):</strong> <span class="font-mono bg-yellow-200 dark:bg-yellow-800 px-1 rounded">{{ JSON.stringify(form.categories) }}</span></div>
                                            <div><strong>Original Database Categories:</strong> {{ JSON.stringify(userCategories) }}</div>
                                            <div>
                                                <strong>Status:</strong> 
                                                <span v-if="form.processing" class="text-blue-600 font-bold">Saving...</span>
                                                <span v-else-if="JSON.stringify(form.categories) !== JSON.stringify(userCategories)" class="text-orange-600 font-bold">⚠ Changes Pending - Click Save Changes Button</span>
                                                <span v-else class="text-green-600 font-bold">✓ Saved</span>
                                            </div>
                                            <div><strong>📋 Checkbox ID Mapping:</strong></div>
                                            <div class="ml-4 grid grid-cols-1 md:grid-cols-2 gap-1">
                                                <div v-for="category in categories" :key="category.id" class="text-xs">
                                                    <span class="font-mono bg-blue-100 dark:bg-blue-900 px-1 rounded">ID: {{ category.id }}</span> 
                                                    <span class="mx-1">→</span>
                                                    <span class="text-gray-600 dark:text-gray-400">{{ category.name }}</span>
                                                    <span class="ml-2" :class="isCategorySelected(category.id) ? 'text-green-600 font-bold' : 'text-gray-400'">
                                                        {{ isCategorySelected(category.id) ? '✓ SELECTED' : '○' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mt-2"><strong>🔄 Form vs Database Comparison:</strong></div>
                                            <div class="ml-4">
                                                <div><span class="font-mono text-xs">Form IDs (as strings):</span> {{ JSON.stringify(form.categories) }}</div>
                                                <div><span class="font-mono text-xs">Database IDs (original):</span> {{ JSON.stringify(userCategories) }}</div>
                                                <div><span class="font-mono text-xs">Form IDs (as integers):</span> {{ JSON.stringify(form.categories.map(id => parseInt(id))) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Note -->
                            <div class="border-t border-gray-200 dark:border-gray-600 pt-6">
                                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                                    <p class="text-sm text-blue-700 dark:text-blue-300">
                                        <strong>Note:</strong> Fields marked with (*) are required. All changes will be saved to your profile immediately.
                                    </p>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-600">
                                <a 
                                    :href="route('profile.show')"
                                    class="inline-flex items-center px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    Cancel
                                </a>
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="inline-flex items-center px-6 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50"
                                >
                                    <span v-if="form.processing">
                                        <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Saving...
                                    </span>
                                    <span v-else>Save Changes</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
