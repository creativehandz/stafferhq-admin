<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

const pageTitle = ref("Add New Company");
</script>

<template>
    <Head title="Analytics" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Analytics
            </h2>
        </template>

        <BreadcrumbDefault :pageTitle="pageTitle" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-boxdark overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        Add New Company page
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
