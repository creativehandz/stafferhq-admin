<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import Card from "@/Components/Cards/Card.vue";
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import BreadcrumbDefaultTwo from "@/Components/Breadcrumbs/BreadcrumbDefaultTwo.vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/swiper-bundle.css";
import { Navigation, Pagination } from 'swiper/modules';
import CardTwo from "@/Components/Cards/CardTwo.vue";

// Import Swiper modules
import SwiperCore from "swiper";

// Use the modules
SwiperCore.use([Navigation, Pagination]);

const pageTitle = ref("Employer Dashboard");
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

        <BreadcrumbDefaultTwo :pageTitle="pageTitle" />

        <div class="py-3">
            <div
                class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
            >
                <h2
                    class="text-title-md2 font-semibold text-black dark:text-white"
                >
                    Your jobs
                </h2>
                <PrimaryButton>Post a job</PrimaryButton>
            </div>

            <div
                class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
            >
                <div class="flex gap-3">
                    <button
                        class="inline-flex rounded-full border py-1 px-3 text-sm font-medium hover:opacity-80"
                        style="
                            border-color: rgb(249, 193, 7);
                            color: rgb(249, 193, 7);
                        "
                    >
                        In Progress
                    </button>
                    <button
                        class="inline-flex rounded-full border py-1 px-3 text-sm font-medium hover:opacity-80"
                        style="
                            border-color: rgb(60, 167, 69);
                            color: rgb(60, 167, 69);
                        "
                    >
                        Action Needed
                    </button>
                    <button
                        class="inline-flex rounded-full border py-1 px-3 text-sm font-medium hover:opacity-80"
                        style="
                            border-color: rgb(59, 162, 184);
                            color: rgb(59, 162, 184);
                        "
                    >
                        Drafts
                    </button>
                </div>
                <div class="flex gap-3">
                    <a href="" class="font-medium text-primary"
                        >View All Job Posts</a
                    >
                    <span> | </span>
                    <a href="" class="font-medium text-primary"
                        >View All Contracts</a
                    >
                </div>
            </div>

            <div class="py-6">
                <div class="max-w-fit">
                    <swiper
                        :slides-per-view="3"
                        space-between="30"
                        
                        navigation
                        class="mySwiper"
                    >
                        <swiper-slide v-for="n in 8" :key="n">
                            <Card />
                        </swiper-slide>
                    </swiper>
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
                    Your Hires
                </h2>
                <PrimaryButton>View all your hires</PrimaryButton>
            </div>

            <div class="py-6">
                <div class="max-w-fit">
                    <swiper
                        :slides-per-view="3"
                        space-between="30"
                        navigation
                    
                        class="mySwiper"
                    >
                        <swiper-slide v-for="n in 8" :key="n">
                            <CardTwo />
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
