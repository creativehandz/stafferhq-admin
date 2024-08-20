<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import { ref } from "vue";

const pageTitle = ref("All Contracts");
</script>

<template>
    <Head title="All Contracts" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                All Contracts
            </h2>
        </template>

        <BreadcrumbDefault :pageTitle="pageTitle" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto">
                <div
                    class="bg-white dark:bg-boxdark overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        All Contracts
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
