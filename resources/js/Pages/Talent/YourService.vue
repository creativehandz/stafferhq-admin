<script setup lang="ts">
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

const pageTitle = ref("Create and manage your service");
</script>

<template>
    <Head title="Your Service" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Your Service
            </h2>
        </template>

        <!-- Breadcrumb Start -->
        <BreadcrumbDefault :pageTitle="pageTitle" />
        <!-- Breadcrumb End -->

        <div class="py-6">
            <div
                class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
            >
                <h2
                    class="text-title-md2 font-semibold text-black dark:text-white"
                >
                    Consultations
                </h2>
                <PrimaryButton>Create a consultation</PrimaryButton>
            </div>
            <div class="flex justify-between items-center mb-6">
                <div>
                    <button
                        class="font-medium text-primary border-b-2 border-blue-500 pb-2 mr-8"
                    >
                        Approved
                    </button>

                    <button class="font-medium pb-2 mr-8">Under Review</button>

                    <button class="font-medium pb-2 mr-8">Drafts</button>
                </div>
            </div>
            <div class="space-y-4">
                <!-- Loop through jobs array and display each job -->
                <div
                    class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"
                >
                    <div class="p-4 sm:p-6 xl:p-10">
                        <h2
                            class="text-title-md font-semibold text-black dark:text-white"
                        >
                            Nothing to display here
                        </h2>
                    </div>
                </div>

            </div>
        </div>
        <div class="py-6">
            <div
                class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
            >
                <h2
                    class="text-title-md2 font-semibold text-black dark:text-white"
                >
                    Projects
                </h2>
                <PrimaryButton>Create a project</PrimaryButton>
            </div>
            <div class="flex justify-between items-center mb-6">
                <div>
                    <button
                        class="font-medium text-primary border-b-2 border-blue-500 pb-2 mr-8"
                    >
                        Approved
                    </button>

                    <button class="font-medium pb-2 mr-8">Under Review</button>

                    <button class="font-medium pb-2 mr-8">Drafts</button>
                </div>
            </div>
            <div class="space-y-4">
                <!-- Loop through jobs array and display each job -->
                <div
                    class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"
                >
                    <div class="p-4 sm:p-6 xl:p-10">
                        <p
                            class="text-title-xs font-semibold text-black dark:text-white"
                        >
                            You will get wordpress website with Divi Builder
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
