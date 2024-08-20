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
                        <button class="font-medium pb-2 mr-8">
                            All job posts
                        </button>
                    </Link>
                    <button
                        class="font-medium text-primary border-b-2 border-blue-500 pb-2"
                    >
                        All contracts
                    </button>
                </div>
            </div>
            <h1 class="text-title-xl2 font-semibold mb-4">All Contracts</h1>
            <div class="flex items-center mb-4">
                <input
                    type="text"
                    placeholder=" Search by contract, freelancer or agency name"
                    class="w-[50%] p-2 rounded-lg bg-gray-800 placeholder-gray-500 border-none"
                />
                <button class="ml-2 font-semibold text-primary">Filters</button>
            </div>
            <div class="space-y-4">
                <div
                    class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"
                >
                    <!-- <div
                class="border-b border-stroke px-4 py-4 dark:border-strokedark sm:px-6 xl:px-7.5"
            >
                <h3 class="font-medium text-black dark:text-white">
                    Notifications Style 4
                </h3>
            </div> -->
                    <div class="p-4 sm:p-6 xl:p-10">
                        <div class="flex flex-col gap-5">
                            <div
                                class="rounded-[10px] border-l-[5px] bg-white px-4 py-6 shadow-card dark:bg-boxdark sm:px-5 xl:px-7.5 border-meta-3"
                            >
                                <div
                                    class="flex flex-wrap items-center justify-between gap-5"
                                >
                                    <div class="flex gap-5">
                                        <!-- <div
                                    class="relative h-11.5 w-full max-w-11.5 rounded-full"
                                >
                                    <img
                                        src="/assets/user-03-l9Ao8BuR.png"
                                        alt="user"
                                    /><span
                                        class="absolute -top-0.5 right-0.5 h-4 w-full max-w-4 rounded-full border-[2.3px] border-white bg-[#219653]"
                                    ></span>
                                </div> -->
                                        <div class="w-full">
                                            <h4
                                                class="mb-[3px] text-title-xsm font-bold text-black dark:text-white"
                                            >
                                                Create strategy alert in trading
                                                view using pi...
                                            </h4>
                                            <p class="mb-[3px] font-medium">
                                                Created last year by You
                                            </p>
                                            <span class="text-sm font-medium"
                                                >Closed - May 6, 2023</span
                                            >
                                        </div>
                                    </div>
                                    <!-- <span
                                class="inline-flex rounded-md bg-gray px-2.5 py-1.5 text-sm font-medium leading-[22px] dark:bg-graydark"
                                >24, Nov 2027</span
                            > -->

                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="flex items-center space-x-10"
                                        >
                                            <div class="font-medium">
                                                <p>0</p>
                                                <p>Proposals</p>
                                            </div>
                                            <div class="font-medium">
                                                <p>5</p>
                                                <p>Messaged</p>
                                            </div>
                                            <div class="font-medium">
                                                <p>0</p>
                                                <p>Hired</p>
                                            </div>
                                        </div>
                                        <PrimaryButton>
                                            Reuse posting
                                        </PrimaryButton>
                                        <button
                                            class="text-black dark:text-white"
                                        >
                                            ...
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="rounded-[10px] border-l-[5px] bg-white px-4 py-6 shadow-card dark:bg-boxdark sm:px-5 xl:px-7.5 border-meta-3"
                            >
                                <div
                                    class="flex flex-wrap items-center justify-between gap-5"
                                >
                                    <div class="flex gap-5">
                                        <!-- <div
                                    class="relative h-11.5 w-full max-w-11.5 rounded-full"
                                >
                                    <img
                                        src="/assets/user-22-sQ1aGBoD.png"
                                        alt="user"
                                    /><span
                                        class="absolute -top-0.5 right-0.5 h-4 w-full max-w-4 rounded-full border-[2.3px] border-white bg-[#219653]"
                                    ></span>
                                </div> -->
                                        <div class="w-full">
                                            <h4
                                                class="mb-[3px] text-title-xsm font-bold text-black dark:text-white"
                                            >
                                                Create high converting landing
                                                page
                                            </h4>
                                            <p class="mb-[3px] font-medium">
                                                Created last year by You
                                            </p>
                                            <span class="text-sm font-medium"
                                                >Draft saved Feb 10, 2023</span
                                            >
                                        </div>
                                    </div>
                                    <!-- <span
                                class="inline-flex rounded-md bg-gray px-2.5 py-1.5 text-sm font-medium leading-[22px] dark:bg-graydark"
                                >24, Nov 2027</span
                            > -->

                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="flex items-center space-x-10"
                                        >
                                            <div class="font-medium">
                                                <p>0</p>
                                                <p>Proposals</p>
                                            </div>
                                            <div class="font-medium">
                                                <p>5</p>
                                                <p>Messaged</p>
                                            </div>
                                            <div class="font-medium">
                                                <p>0</p>
                                                <p>Hired</p>
                                            </div>
                                        </div>
                                        <PrimaryButton>
                                            Reuse posting
                                        </PrimaryButton>
                                        <button
                                            class="text-black dark:text-white"
                                        >
                                            ...
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="rounded-[10px] border-l-[5px] bg-white px-4 py-6 shadow-card dark:bg-boxdark sm:px-5 xl:px-7.5 border-meta-3"
                            >
                                <div
                                    class="flex flex-wrap items-center justify-between gap-5"
                                >
                                    <div class="flex gap-5">
                                        <!-- <div
                                    class="relative h-11.5 w-full max-w-11.5 rounded-full"
                                >
                                    <img
                                        src="/assets/user-23-3B4z8FNt.png"
                                        alt="user"
                                    /><span
                                        class="absolute -top-0.5 right-0.5 h-4 w-full max-w-4 rounded-full border-[2.3px] border-white bg-[#219653]"
                                    ></span>
                                </div> -->
                                        <div class="w-full">
                                            <h4
                                                class="mb-[3px] text-title-xsm font-bold text-black dark:text-white"
                                            >
                                                Install SSL or HTTPS on my
                                                website
                                            </h4>
                                            <p class="mb-[3px] font-medium">
                                                Created 2 years ago by you
                                            </p>
                                            <span class="text-sm font-medium"
                                                >Closed - 12 min ago</span
                                            >
                                        </div>
                                    </div>
                                    <!-- <span
                                class="inline-flex rounded-md bg-gray px-2.5 py-1.5 text-sm font-medium leading-[22px] dark:bg-graydark"
                                >12, Jan 2027</span
                            > -->

                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="flex items-center space-x-10"
                                        >
                                            <div class="font-medium">
                                                <p>0</p>
                                                <p>Proposals</p>
                                            </div>
                                            <div class="font-medium">
                                                <p>5</p>
                                                <p>Messaged</p>
                                            </div>
                                            <div class="font-medium">
                                                <p>0</p>
                                                <p>Hired</p>
                                            </div>
                                        </div>
                                        <PrimaryButton>
                                            Reuse posting
                                        </PrimaryButton>
                                        <button
                                            class="text-black dark:text-white"
                                        >
                                            ...
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="rounded-[10px] border-l-[5px] bg-white px-4 py-6 shadow-card dark:bg-boxdark sm:px-5 xl:px-7.5 border-red"
                            >
                                <div
                                    class="flex flex-wrap items-center justify-between gap-5"
                                >
                                    <div class="flex gap-5">
                                        <!-- <div
                                    class="relative h-11.5 w-full max-w-11.5 rounded-full"
                                >
                                    <img
                                        src="/assets/user-24-UtLCsKhv.png"
                                        alt="user"
                                    /><span
                                        class="absolute -top-0.5 right-0.5 h-4 w-full max-w-4 rounded-full border-[2.3px] border-white bg-red"
                                    ></span>
                                </div> -->
                                        <div class="w-full">
                                            <h4
                                                class="mb-[3px] text-title-xsm font-bold text-black dark:text-white"
                                            >
                                                Need python dev for Trading view
                                                app
                                            </h4>
                                            <p class="mb-[3px] font-medium">
                                                Created 2 years ago by you
                                            </p>
                                            <span class="text-sm font-medium"
                                                >Closed 1 year ago</span
                                            >
                                        </div>
                                    </div>
                                    <!-- <span
                                class="inline-flex rounded-md bg-gray px-2.5 py-1.5 text-sm font-medium leading-[22px] dark:bg-graydark"
                                >09, Dec 2026</span
                            > -->
                                    <!-- <div class="flex items-center space-x-10">
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
                            </div> -->
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="flex items-center space-x-10"
                                        >
                                            <div class="font-medium">
                                                <p>0</p>
                                                <p>Proposals</p>
                                            </div>
                                            <div class="font-medium">
                                                <p>5</p>
                                                <p>Messaged</p>
                                            </div>
                                            <div class="font-medium">
                                                <p>0</p>
                                                <p>Hired</p>
                                            </div>
                                        </div>
                                        <PrimaryButton>
                                            Reuse posting
                                        </PrimaryButton>
                                        <button
                                            class="text-black dark:text-white"
                                        >
                                            ...
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="rounded-[10px] border-l-[5px] bg-white px-4 py-6 shadow-card dark:bg-boxdark sm:px-5 xl:px-7.5 border-meta-3"
                            >
                                <div
                                    class="flex flex-wrap items-center justify-between gap-5"
                                >
                                    <div class="flex gap-5">
                                        <!-- <div
                                    class="relative h-11.5 w-full max-w-11.5 rounded-full"
                                >
                                    <img
                                        src="/assets/user-25-vk7qvY78.png"
                                        alt="user"
                                    /><span
                                        class="absolute -top-0.5 right-0.5 h-4 w-full max-w-4 rounded-full border-[2.3px] border-white bg-[#219653]"
                                    ></span>
                                </div> -->
                                        <div class="w-full">
                                            <h4
                                                class="mb-[3px] text-title-xsm font-bold text-black dark:text-white"
                                            >
                                                Jordyn Torff
                                            </h4>
                                            <p class="mb-[3px] font-medium">
                                                You have changed your password
                                                successfully
                                            </p>
                                            <span class="text-sm font-medium"
                                                >1 year ago</span
                                            >
                                        </div>
                                    </div>
                                    <!-- <span
                                class="inline-flex rounded-md bg-gray px-2.5 py-1.5 text-sm font-medium leading-[22px] dark:bg-graydark"
                                >30, Mar 2026</span
                            > -->
                                    <!-- <div class="flex items-center space-x-10">
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
                            </div> -->
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="flex items-center space-x-10"
                                        >
                                            <div class="font-medium">
                                                <p>0</p>
                                                <p>Proposals</p>
                                            </div>
                                            <div class="font-medium">
                                                <p>5</p>
                                                <p>Messaged</p>
                                            </div>
                                            <div class="font-medium">
                                                <p>0</p>
                                                <p>Hired</p>
                                            </div>
                                        </div>
                                        <PrimaryButton>
                                            Reuse posting
                                        </PrimaryButton>
                                        <button
                                            class="text-black dark:text-white"
                                        >
                                            ...
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Repeat similar structure for other job posts -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
