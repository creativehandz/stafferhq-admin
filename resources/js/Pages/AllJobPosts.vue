<!-- <script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref } from "vue";

interface Job {
  id: number;
  description: string;
  created_at: string;
  status: string;
  proposals_count?: number;
  messages_count?: number;
  hired_count?: number;
}

const pageTitle = ref("All Job Posts");

defineProps<{
    jobs: Job[];
}>();

const formatDate = (date: string): string => {
    return new Date(date).toLocaleDateString();
};
</script>

<template>
    <Head title="All Job Posts" />

    <AuthenticatedLayout>
        <div class="min-h-screen text-black dark:text-white p-4">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <button class="font-medium text-primary border-b-2 border-blue-500 pb-2 mr-8">
                        All job posts
                    </button>
                    <Link :href="route('all-contracts')">
                        <button class="font-medium pb-2">All contracts</button>
                    </Link>
                </div>
                <Link :href="route('post-a-job')">
                    <PrimaryButton>Post a new job</PrimaryButton>
                </Link>
            </div>
            <h1 class="text-title-xl2 font-semibold mb-4">All job posts</h1>
            <div class="flex items-center mb-4">
                <input
                    type="text"
                    placeholder="Search job postings"
                    class="w-[50%] p-2 rounded-lg bg-gray-800 placeholder-gray-500 border-none"
                />
                <button class="ml-2 font-semibold text-primary">Filters</button>
            </div>
            <div class="space-y-4">
                <div v-for="job in jobs" :key="job.id"
                    class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="p-4 sm:p-6 xl:p-10">
                        <div class="rounded-[10px] border-l-[5px] bg-white px-4 py-6 shadow-card dark:bg-boxdark sm:px-5 xl:px-7.5 border-meta-3">
                            <div class="flex flex-wrap items-center justify-between gap-5">
                                <div class="flex gap-5">
                                    <div class="w-full">
                                        <h4 class="mb-[3px] text-title-xsm font-bold text-black dark:text-white">
                                            {{ job.description }}
                                        </h4>
                                        <p class="mb-[3px] font-medium">
                                            Created {{ formatDate(job.created_at) }} by You
                                        </p>
                                        <span class="text-sm font-medium">
                                            {{ job.status }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-10">
                                        <div class="font-medium">
                                            <p>{{ job.proposals_count || 0 }}</p>
                                            <p>Proposals</p>
                                        </div>
                                        <div class="font-medium">
                                            <p>{{ job.messages_count || 0 }}</p>
                                            <p>Messaged</p>
                                        </div>
                                        <div class="font-medium">
                                            <p>{{ job.hired_count || 0 }}</p>
                                            <p>Hired</p>
                                        </div>
                                    </div>
                                    <PrimaryButton>
                                        Reuse posting
                                    </PrimaryButton>
                                    <button class="text-black dark:text-white">
                                        ...
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> -->

<!-- New Changes -->
<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Card from "@/Components/Cards/Card.vue";
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import BreadcrumbDefaultTwo from "@/Components/Breadcrumbs/BreadcrumbDefaultTwo.vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/swiper-bundle.css";
import { Navigation, Pagination } from "swiper/modules";
import CardTwo from "@/Components/Cards/CardTwo.vue";

// Import Swiper modules
import SwiperCore from "swiper";

// Use the modules
SwiperCore.use([Navigation, Pagination]);

const pageTitle = ref("All Job Posts");
</script>

<template>
    <Head title="All Job Posts" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                All Job Posts
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
