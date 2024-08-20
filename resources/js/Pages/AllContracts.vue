<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link } from "@inertiajs/vue3";

const pageTitle = ref("All Contracts");
</script>

<template>
    <Head title="All Contracts" />

    <AuthenticatedLayout>
        <!-- <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                All Job Posts
            </h2>
        </template>

        <BreadcrumbDefault :pageTitle="pageTitle" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <div
                    class="bg-white dark:bg-boxdark overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        All Job Posts
                    </div>
                </div>
            </div>
        </div> -->

        <div class="min-h-screen text-black dark:text-white p-4">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <Link :href="route('all-job-posts')">
                    <button class="pb-2 mr-8"
                       
                    >
                        All job posts
                    </button>
                </Link>
                   
                    <button  class="text-primary border-b-2 border-blue-500 pb-2">All contracts</button>
                    
                </div>
                <Link :href="route('post-a-job')">
                <PrimaryButton>Post a new job</PrimaryButton>
                </Link>
            </div>
            <h1 class="text-title-xl2 font-semibold mb-4">All Contracts</h1>
            <div class="flex items-center mb-4">
                <input
                    type="text"
                    placeholder="Search all contracts"
                    class="w-full p-2 rounded-lg bg-gray-800 placeholder-gray-500"
                />
                <button class="ml-2 text-primary">Filters</button>
            </div>
            <div class="space-y-4">
                <div
                    class="p-4 rounded-lg flex justify-between items-center border-b-2 border-black "
                >
                    <div class="flex items-center space-x-4">
                        <div>
                            <h2 class="text-xl">
                                Create strategy alert in trading view using
                                pi...
                            </h2>
                            <p class="text-gray-500">
                                Created last year by You
                            </p>
                            <p class="text-red-500">Closed - May 6, 2023</p>
                        </div>
                        <div class="flex items-center space-x-10">
                            <div class="">
                                <p>0</p>
                                <p>Proposals</p>
                            </div>
                            <div class="">
                                <p>5</p>
                                <p>Messaged</p>
                            </div>
                            <div class="">
                                <p>0</p>
                                <p>Hired</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <PrimaryButton> Reuse posting </PrimaryButton>
                        <button class="text-black dark:text-white">...</button>
                    </div>
                </div>
                <!-- Repeat similar structure for other job posts -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
