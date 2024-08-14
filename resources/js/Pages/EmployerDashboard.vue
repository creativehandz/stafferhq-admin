<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import Card from "@/Components/Cards/Card.vue";
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

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

        <BreadcrumbDefault :pageTitle="pageTitle" />

        <div class="py-6">
        <div
            class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
        >
            <h2 class="text-title-md2 font-semibold text-black dark:text-white">
                Your jobs
            </h2>
            <PrimaryButton>Post a job</PrimaryButton>
        </div>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card></Card>
            </div>
        </div>
    </div>

    <div class="py-6">
        <div
            class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
        >
            <h2 class="text-title-md2 font-semibold text-black dark:text-white">
                Your Hires
            </h2>
            <PrimaryButton>View all your hires</PrimaryButton>
        </div>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card></Card>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
