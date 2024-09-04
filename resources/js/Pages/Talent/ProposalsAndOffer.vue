<script setup lang="ts">
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

const pageTitle = ref("My Proposal and offer");
</script>

<template>
    <Head title="My Proposal and offer" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                My Proposal and offer
            </h2>
        </template>

        <!-- Breadcrumb Start -->
        <BreadcrumbDefault :pageTitle="pageTitle" />
        <!-- Breadcrumb End -->

        <div class="min-h-screen text-black dark:text-white p-4">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <button
                        class="font-medium text-primary border-b-2 border-blue-500 pb-2 mr-8"
                    >
                        Active
                    </button>

                    <button class="font-medium pb-2 mr-8">Referrals</button>

                    <button class="font-medium pb-2 mr-8">Archived</button>
                </div>
            </div>

            <div class="space-y-4">
                <!-- Loop through jobs array and display each job -->
                <div
                    class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"
                >
                    <div class="p-4 sm:p-6 xl:p-10">
                        <h2
                            class="text-title-md2 font-semibold text-black dark:text-white"
                        >
                            Offers (0)
                        </h2>
                    </div>
                </div>

                <div
                    class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"
                >
                    <div class="p-4 sm:p-6 xl:p-10">
                        <h2
                            class="text-title-md2 font-semibold text-black dark:text-white"
                        >
                            Invitaion to interview (0)
                        </h2>
                        <div class="flex justify-between items-center py-2">
                            <div class="flex-col">
                                <p class="text-sm font-medium">
                                    Received Aug 12, 2024
                                </p>
                                <p class="text-xs font-medium">2 weeks ago</p>
                            </div>
                            <button class="font-medium text-amber-500">
                                Brand name generator developer
                            </button>
                            <div class="flex-col">
                                <p class="text-sm font-medium">
                                    About the client
                                </p>
                                <div class="flex gap-2">
                                    <p class="text-sm font-medium">$315 spent</p>
                                    <p class="text-sm font-medium">2 hires</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"
                >
                    <div class="p-4 sm:p-6 xl:p-10">
                        <h2
                            class="text-title-md2 font-semibold text-black dark:text-white"
                        >
                            Active Proposals (0)
                        </h2>
                        <div class="flex justify-between items-center py-2">
                            <div class="flex-col">
                                <p class="text-sm font-medium">
                                    Received Aug 12, 2024
                                </p>
                                <p class="text-xs font-medium">2 weeks ago</p>
                            </div>
                            <button class="font-medium text-amber-500">
                                Looking for wordpress developer
                            </button>
                            <p class="text-base font-normal">General Profile</p>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"
                >
                    <div class="p-4 sm:p-6 xl:p-10">
                        <h2
                            class="text-title-md2 font-semibold text-black dark:text-white"
                        >
                            Submitted Proposals (0)
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
