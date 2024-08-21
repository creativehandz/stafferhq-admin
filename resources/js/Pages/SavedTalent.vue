<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link } from "@inertiajs/vue3";

const pageTitle = ref("Saved Talent");
</script>

<template>
    <Head title="Saved Talent" />

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
            <h1 class="text-title-xl2 font-semibold mb-4">Saved Talent</h1>
            <div class="flex items-center mb-4">
                <input
                    type="text"
                    placeholder=" Search in saved talent"
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
                                    class="flex justify-between items-center pb-5"
                                >
                                    <div class="flex gap-5">
                                        <div
                                            class="relative h-11.5 w-full max-w-11.5 rounded-full"
                                        >
                                            <img
                                                src="../../img/user/user-03.png"
                                                alt="user"
                                            /><span
                                                class="absolute -top-0.5 right-0.5 h-4 w-full max-w-4 rounded-full border-[2.3px] border-white bg-[#219653]"
                                            ></span>
                                        </div>
                                        <div class="w-full">
                                            <h4
                                                class="mb-[3px] text-title-xsm font-bold text-black dark:text-white"
                                            >
                                                Victor Peramud
                                            </h4>
                                            <p class="mb-[3px] font-medium">
                                                Expert Shopify Developer
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex gap-5 items-center">
                                        <PrimaryButton> Message </PrimaryButton>
                                        <svg
                                            class="fill-current"
                                            fill="#000000"
                                            width="18"
                                            height="18"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M20.5,4.609A5.811,5.811,0,0,0,16,2.5a5.75,5.75,0,0,0-4,1.455A5.75,5.75,0,0,0,8,2.5,5.811,5.811,0,0,0,3.5,4.609c-.953,1.156-1.95,3.249-1.289,6.66,1.055,5.447,8.966,9.917,9.3,10.1a1,1,0,0,0,.974,0c.336-.187,8.247-4.657,9.3-10.1C22.45,7.858,21.453,5.765,20.5,4.609Zm-.674,6.28C19.08,14.74,13.658,18.322,12,19.34c-2.336-1.41-7.142-4.95-7.821-8.451-.513-2.646.189-4.183.869-5.007A3.819,3.819,0,0,1,8,4.5a3.493,3.493,0,0,1,3.115,1.469,1.005,1.005,0,0,0,1.76.011A3.489,3.489,0,0,1,16,4.5a3.819,3.819,0,0,1,2.959,1.382C19.637,6.706,20.339,8.243,19.826,10.889Z"
                                            />
                                        </svg>
                                        <button
                                            class="text-black dark:text-white"
                                        >
                                            ...
                                        </button>
                                    </div>
                                </div>
                                <div
                                    class="flex flex-wrap items-center justify-between gap-5"
                                >
                                    <div
                                        class="flex items-center justify-between space-x-4"
                                    >
                                        <div class="flex-col">
                                            <div class="flex gap-5">
                                                <p class="font-medium">
                                                    $15.00/hr
                                                </p>
                                                <p class="font-medium">
                                                    $1M+ earned
                                                </p>

                                                <p class="font-medium">
                                                    100% Job Success
                                                </p>
                                                <p class="font-medium">
                                                    Top Rated Plus
                                                </p>
                                            </div>
                                            <div class="font-normal">
                                                <p>
                                                    Lorem Ipsum is simply dummy
                                                    text of the printing and
                                                    typesetting industry. Lorem
                                                    Ipsum has been the
                                                    industry's standard dummy
                                                    text ever since the 1500s,
                                                    when an unknown printer took
                                                    a galley of type and
                                                    scrambled it to make a type
                                                    specimen book. It has
                                                    survived not only five
                                                    centuries, but also the leap
                                                    into electronic typesetting,
                                                    remaining essentially
                                                    unchanged. It was
                                                    popularised in the 1960s
                                                    with the release of Letraset
                                                    sheets containing Lorem
                                                    Ipsum passages, and more
                                                    recently with desktop
                                                    publishing software like
                                                    Aldus PageMaker including
                                                    versions of Lorem Ipsum
                                                </p>
                                            </div>
                                        </div>
                                        <a
                                            aria-current="page"
                                            href="/ui-elements/cards#"
                                            class="uter-link-active router-link-exact-active block px-4"
                                            ><img
                                                src="../../img/cards/cards-01.png"
                                                alt="Cards"
                                        /></a>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="rounded-[10px] border-l-[5px] bg-white px-4 py-6 shadow-card dark:bg-boxdark sm:px-5 xl:px-7.5 border-meta-3"
                            >
                                <div
                                    class="flex justify-between items-center pb-5"
                                >
                                    <div class="flex gap-5">
                                        <div
                                            class="relative h-11.5 w-full max-w-11.5 rounded-full"
                                        >
                                            <img
                                                src="../../img/user/user-03.png"
                                                alt="user"
                                            /><span
                                                class="absolute -top-0.5 right-0.5 h-4 w-full max-w-4 rounded-full border-[2.3px] border-white bg-[#219653]"
                                            ></span>
                                        </div>
                                        <div class="w-full">
                                            <h4
                                                class="mb-[3px] text-title-xsm font-bold text-black dark:text-white"
                                            >
                                                Victor Peramud
                                            </h4>
                                            <p class="mb-[3px] font-medium">
                                                Expert Shopify Developer
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex gap-5 items-center">
                                        <PrimaryButton> Message </PrimaryButton>
                                        <svg
                                            class="fill-current"
                                            fill="#000000"
                                            width="18"
                                            height="18"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M20.5,4.609A5.811,5.811,0,0,0,16,2.5a5.75,5.75,0,0,0-4,1.455A5.75,5.75,0,0,0,8,2.5,5.811,5.811,0,0,0,3.5,4.609c-.953,1.156-1.95,3.249-1.289,6.66,1.055,5.447,8.966,9.917,9.3,10.1a1,1,0,0,0,.974,0c.336-.187,8.247-4.657,9.3-10.1C22.45,7.858,21.453,5.765,20.5,4.609Zm-.674,6.28C19.08,14.74,13.658,18.322,12,19.34c-2.336-1.41-7.142-4.95-7.821-8.451-.513-2.646.189-4.183.869-5.007A3.819,3.819,0,0,1,8,4.5a3.493,3.493,0,0,1,3.115,1.469,1.005,1.005,0,0,0,1.76.011A3.489,3.489,0,0,1,16,4.5a3.819,3.819,0,0,1,2.959,1.382C19.637,6.706,20.339,8.243,19.826,10.889Z"
                                            />
                                        </svg>
                                        <button
                                            class="text-black dark:text-white"
                                        >
                                            ...
                                        </button>
                                    </div>
                                </div>
                                <div
                                    class="flex flex-wrap items-center justify-between gap-5"
                                >
                                    <div
                                        class="flex items-center justify-between space-x-4"
                                    >
                                        <div class="flex-col">
                                            <div class="flex gap-5">
                                                <p class="font-medium">
                                                    $15.00/hr
                                                </p>
                                                <p class="font-medium">
                                                    $1M+ earned
                                                </p>

                                                <p class="font-medium">
                                                    100% Job Success
                                                </p>
                                                <p class="font-medium">
                                                    Top Rated Plus
                                                </p>
                                            </div>
                                            <div class="font-normal">
                                                <p>
                                                    Lorem Ipsum is simply dummy
                                                    text of the printing and
                                                    typesetting industry. Lorem
                                                    Ipsum has been the
                                                    industry's standard dummy
                                                    text ever since the 1500s,
                                                    when an unknown printer took
                                                    a galley of type and
                                                    scrambled it to make a type
                                                    specimen book. It has
                                                    survived not only five
                                                    centuries, but also the leap
                                                    into electronic typesetting,
                                                    remaining essentially
                                                    unchanged. It was
                                                    popularised in the 1960s
                                                    with the release of Letraset
                                                    sheets containing Lorem
                                                    Ipsum passages, and more
                                                    recently with desktop
                                                    publishing software like
                                                    Aldus PageMaker including
                                                    versions of Lorem Ipsum
                                                </p>
                                            </div>
                                        </div>
                                        <a
                                            aria-current="page"
                                            href="/ui-elements/cards#"
                                            class="uter-link-active router-link-exact-active block px-4"
                                            ><img
                                                src="../../img/cards/cards-01.png"
                                                alt="Cards"
                                        /></a>
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
