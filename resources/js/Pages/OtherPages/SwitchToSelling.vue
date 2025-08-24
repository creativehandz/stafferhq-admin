<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({});
const isLoading = ref(false);

const switchToSelling = () => {
    if (isLoading.value) return;
    
    isLoading.value = true;
    form.post(route('switch.to.selling'), {
        onSuccess: () => {
            // Handle success - maybe redirect or show success message
        },
        onError: () => {
            // Handle error
        },
        onFinish: () => {
            isLoading.value = false;
        }
    });
};
</script>

<template>
    <Head title="Switch to Selling" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Switch to Selling</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-center">
                            <h1 class="text-4xl font-bold text-gray-900 mb-6">
                                Start Selling Your Services
                            </h1>
                            
                            <p class="text-lg text-gray-600 mb-8">
                                Switch to selling mode and start offering your skills to clients worldwide.
                            </p>

                            <div class="grid md:grid-cols-3 gap-6 mb-10">
                                <div class="bg-blue-50 p-6 rounded-lg">
                                    <div class="text-blue-600 text-3xl mb-4">🎯</div>
                                    <h3 class="font-semibold text-lg mb-2">Create Gigs</h3>
                                    <p class="text-gray-600">Showcase your skills and services to attract clients</p>
                                </div>
                                
                                <div class="bg-green-50 p-6 rounded-lg">
                                    <div class="text-green-600 text-3xl mb-4">💰</div>
                                    <h3 class="font-semibold text-lg mb-2">Earn Money</h3>
                                    <p class="text-gray-600">Get paid for your expertise and time</p>
                                </div>
                                
                                <div class="bg-purple-50 p-6 rounded-lg">
                                    <div class="text-purple-600 text-3xl mb-4">🚀</div>
                                    <h3 class="font-semibold text-lg mb-2">Grow Business</h3>
                                    <p class="text-gray-600">Build your reputation and expand your client base</p>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-lg mb-8">
                                <h3 class="font-semibold text-lg mb-4">What happens when you switch?</h3>
                                <ul class="text-left max-w-md mx-auto space-y-2">
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Access to seller dashboard
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Ability to create and manage gigs
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Order management tools
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Earnings tracking and analytics
                                    </li>
                                </ul>
                            </div>

                            <button 
                                @click="switchToSelling"
                                :disabled="isLoading"
                                class="bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-200"
                            >
                                <span v-if="isLoading" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Switching...
                                </span>
                                <span v-else>
                                    Switch to Selling
                                </span>
                            </button>

                            <p class="text-sm text-gray-500 mt-4">
                                You can always switch back to buying mode later.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>