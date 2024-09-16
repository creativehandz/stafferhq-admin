<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import { ref } from "vue";
import DataStatsOne from "@/Components/DataStats/DataStatsOne.vue";
import ChartOne from "@/Components/Charts/ChartOne.vue";
import ChatCard from "@/Components/ChatCard.vue";
const pageTitle = ref("Applications Statistics");
</script>

<template>
    <Head title="Employer Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Employer Dashboard
            </h2>
        </template>


        <BreadcrumbDefault :pageTitle="pageTitle" />

        <div
            class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5"
        >
            <DataStatsOne />
        </div>

        <div
            class="mt-4 grid grid-cols-12 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5"
        >
            <!-- ====== Chart One Start -->
            <ChartOne />
            <!-- ====== Chart One End -->

            <!-- ====== Chat Card Start -->
            <ChatCard />
            <!-- ====== Chat Card End -->

            <div class="col-span-12">
                <div
                    class="col-span-12 rounded-sm border border-stroke bg-white py-6 shadow-default dark:border-strokedark dark:bg-boxdark xl:col-span-4"
                >
                    <h4
                        class="mb-6 px-7.5 text-xl font-semibold text-black dark:text-white"
                    >
                        Recent Applicants
                    </h4>
                    <p class="mb-6 px-7.5">No applicants found</p>
                </div>
            </div>
        </div>


    </AuthenticatedLayout>
</template>
