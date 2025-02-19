<script setup lang="ts">
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

interface Category {
    id: number;
    name: string;
}

interface SubCategory {
    id: number;
    name: string;
}

interface Job {
    id: number;
    job_title: string;
    job_description: string;
    location: string;
    category_id: number;
    sub_category_id?: number | null;
    budget: number;
    image?: string | null;
    category?: Category;       // Optional relationship field
    sub_category?: SubCategory; // Optional relationship field
}


const props = defineProps<{
    jobs: Job[];
}>();


const pageTitle = ref("Job Posted");
</script>

<template>
    <Head title="Jobs Posted By Buyers" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Jobs Posted By Buyers
            </h2>
        </template>

        <!-- Breadcrumb Start -->
        <BreadcrumbDefault :pageTitle="pageTitle" />
        <!-- Breadcrumb End -->

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="text-3xl">Job Posted by buyers</h1>
                <div class="bg-white dark:bg-boxdark overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                       
                        <!-- Job Listings -->
                        <div v-if="props.jobs?.length > 0">
                            <div v-for="job in props.jobs" :key="job.id" class="border-b py-4">
                                <h4 class="text-xl text-black dark:text-white font-medium">{{ job.job_title }}</h4>
                                <p>{{ job.job_description }}</p>
                                <p><strong>Location:</strong> {{ job.location }}</p>
                                <p><strong>Budget:</strong> ${{ job.budget }}</p>
                                <p><strong>Category:</strong> {{ job.category?.name }}</p>
                                <p v-if="job.sub_category_id"><strong>Subcategory:</strong> {{ job.sub_category?.name }}</p>
                                 <!-- Image (if exists) -->
                                 <div v-if="job.image" class="mt-2">
                                    <img :src="'/' + job.image" alt="Job Image" class="w-32 h-32 object-cover rounded">
                                </div>
                            </div>
                        </div>

                        <div v-else>
                            <p>No jobs posted yet!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
