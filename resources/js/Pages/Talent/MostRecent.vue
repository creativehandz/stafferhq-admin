<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

const pageTitle = ref("Most Recent");
</script>

<template>
    <Head title="Most Recent" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Most Recent
            </h2>
        </template>

        <!-- <BreadcrumbDefault :pageTitle="pageTitle" /> -->

        <div class="min-h-screen text-black dark:text-white p-4">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <Link :href="route('find-work')">
                        <button class="font-medium pb-2 mr-8">My Feed</button>
                    </Link>

                    <Link :href="route('best-matches')">
                        <button class="font-medium pb-2 mr-8">
                            Best Matches
                        </button>
                    </Link>

                    <button
                        class="font-medium text-primary border-b-2 border-blue-500 pb-2 mr-8"
                    >
                        Most Recent
                    </button>

                    <Link :href="route('saved-jobs')">
                        <button class="font-medium pb-2 mr-8">
                            Saved Jobs
                        </button>
                    </Link>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-boxdark overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        Most Recent page
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
