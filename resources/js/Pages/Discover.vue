<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import { ref } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/swiper-bundle.css";
import { Navigation, Pagination } from 'swiper/modules';
import CardTwo from "@/Components/Cards/CardTwo.vue";

// Import Swiper modules
import SwiperCore from "swiper";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CardThree from "@/Components/Cards/CardThree.vue";

// Use the modules
SwiperCore.use([Navigation, Pagination]);

const pageTitle = ref("Discover");
</script>

<template>
    <Head title="Discover" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Discover
            </h2>
        </template>

        <BreadcrumbDefault :pageTitle="pageTitle" />

        <div class="py-6">
            <div
                class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
            >
                <h2
                    class="text-title-md2 font-semibold text-black dark:text-white"
                >
                    Recently Viewed
                </h2>
                <PrimaryButton>see all recently viewed</PrimaryButton>
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
                            <CardThree />
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </div>


        <div class="py-6">
            <div
                class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
            >
            <div class="flex-col gap-2">
                <h2
                    class="text-title-md2 font-semibold text-black dark:text-white"
                >
                    Talent Skilled in UI/UX
                </h2>
                <p class="font-medium">Based on your job post draft</p>
            </div>
                <PrimaryButton>see more like this</PrimaryButton>
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
                            <CardThree />
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </div>

        <div class="py-6">
            <div
                class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
            >
            <div class="flex-col gap-2">
                <h2
                    class="text-title-md2 font-semibold text-black dark:text-white"
                >
                    Talent Skilled in Mobile app development
                </h2>
                <p class="font-medium">Based on your job post draft</p>
            </div>
                <PrimaryButton>see more like this</PrimaryButton>
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
                            <CardThree />
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </div>

        <div class="py-6">
            <div
                class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
            >
            <div class="flex-col gap-2">
                <h2
                    class="text-title-md2 font-semibold text-black dark:text-white"
                >
                    Talent Skilled in Web Design
                </h2>
                <p class="font-medium">Based on your job post draft</p>
            </div>
                <PrimaryButton>see more like this</PrimaryButton>
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
                            <CardThree />
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </div>

        <div class="py-6">
            <div
                class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
            >
            <div class="flex-col gap-2">
                <h2
                    class="text-title-md2 font-semibold text-black dark:text-white"
                >
                    Talent To Consider
                </h2>
                <p class="font-medium">Based on your job post draft</p>
            </div>
                <PrimaryButton>see more like this</PrimaryButton>
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
                            <CardThree />
                        </swiper-slide>
                    </swiper>
                </div>
            </div>
        </div>
        
    </AuthenticatedLayout>
</template>
