<script setup lang="ts">
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from 'vue'

const pageTitle = ref('Dashboard')
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Dashboard
            </h2>
        </template>

        <!-- Breadcrumb Start -->
    <BreadcrumbDefault :pageTitle="pageTitle" />
    <!-- Breadcrumb End -->

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="container mx-auto mt-6 p-4 bg-gray-50 rounded-lg shadow ">
                    <!-- Welcome Section -->
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold text-gray-900">Welcome, Username</h2>
                    </div>
                    <p class="text-gray-500 mt-1">Find important messages, tips, and links to helpful resources here:</p>
                    
                    <!-- Grow your business section -->
                    <div class="mt-4">
                        <div class="p-4 bg-white border rounded-lg flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-bold">Grow your business with Seller Plus</h3>
                                <p class="text-gray-500">Check out all the tools and benefits that can help you scale your success.</p>
                            </div>
                            <button class="text-gray-400 hover:text-gray-500">&times;&nbsp;&gt;</button>
                        </div>

                        <!-- Set up inbox auto replies -->
                        <div class="p-4 bg-white border mt-4 rounded-lg flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-bold">Set up Inbox auto replies</h3>
                                <p class="text-gray-500">Greet new potential buyers with an auto reply to their first message.</p>
                            </div>
                            <button class="text-gray-400 hover:text-gray-500">&times;&nbsp;&gt;</button>
                        </div>
                    </div>

                    <!-- Active Orders Section -->
                    <div class="mt-6 flex items-center justify-between bg-gray-100 p-3 rounded-lg">
                        <div>
                            <h3 class="text-lg font-bold">Active orders - 0 ($0)</h3>
                        </div>
                        <div>
                            <button class="bg-white text-gray-700 py-2 px-4 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50">
                                Active orders (0) 
                            </button>
                        </div>
                    </div>

                    <!-- Upgrade your business -->
                    <div class="mt-8">
                        <h3 class="font-bold text-gray-800 border-b pb-2 border-gray-200">Upgrade Your Business</h3>

                        <div class="bg-white mt-4 p-6 rounded-lg shadow-lg">
                            <h3 class="text-xl font-bold">3 steps to become a top seller on Fiverr</h3>
                            <p class="mt-2 text-gray-600">The key to your success on Fiverr is the brand you build for yourself through your Fiverr reputation. We gathered some tips and resources to help you become a leading seller on Fiverr.</p>

                            <div class="grid grid-cols-3 gap-6 mt-6">
                                <!-- Get noticed -->
                                <div class="text-center">
                                    <img src="https://www.svgrepo.com/show/30925/book.svg" alt="Get noticed" class="mx-auto w-15">
                                    <h4 class="font-bold mt-4">Get noticed</h4>
                                    <p class="text-gray-500 mt-2">Tap into the power of social media by sharing your Gig, and get expert help to grow your impact.</p>
                                    <button class="mt-4 bg-primary text-white py-2 px-4 rounded-lg">Share Your Gigs</button>
                                </div>

                                <!-- Get more skills & exposure -->
                                <div class="text-center">
                                    <img src="https://www.svgrepo.com/show/27861/book.svg" alt="Get more skills" class="mx-auto w-15">
                                    <h4 class="font-bold mt-4">Get more skills & exposure</h4>
                                    <p class="text-gray-500 mt-2">Hone your skills and expand your knowledge with online courses. You'll be able to offer more services and gain more exposure with every course completed.</p>
                                    <button class="mt-4 bg-primary text-white py-2 px-4 rounded-lg">Explore Learn</button>
                                </div>

                                <!-- Become a successful seller -->
                                <div class="text-center">
                                    <img src="https://www.svgrepo.com/show/131752/badge.svg" alt="Become a successful seller" class="mx-auto w-15">
                                    <h4 class="font-bold mt-4">Become a successful seller!</h4>
                                    <p class="text-gray-500 mt-2">Watch this free online course to learn how to create an outstanding service experience for your buyer and grow your career as an online freelancer.</p>
                                    <button class="mt-4 bg-primary text-white py-2 px-4 rounded-lg">Watch Free Course</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
