<script setup lang="ts">
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import { formatDate } from "@/stores/formateDistanceToNow";
import { Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

// Define a type for a Job
// Define the Job type
type Job = {
    id: number;
    title: string;
    project_type: string;
    category?: string;
    skills?: string[];
    experience_level: string;
    budget_type?: string;
    budget: number;
    description: string;
    location?: string;
    attachment?: File | null;
    created_at: string;
    // Add any other fields that are present in your job object
};

// Define the type for the props
type Props = {
    jobs: Job[];
};

// Receive the jobs data passed from the backend with correct type
const props = defineProps<Props>();

const pageTitle = ref("Find Work");
</script>

<template>
    <Head title="Find Work" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                <a href="/categories">Find Work</a> 
            </h2>
        </template>

        <div class="min-h-screen p-4 text-black dark:text-white">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <button
                        class="pb-2 mr-8 font-medium border-b-2 border-blue-500 text-primary"
                    >
                        My Feed
                    </button>

                    <Link :href="route('best-matches')">
                        <button class="pb-2 mr-8 font-medium">
                            Best Matches
                        </button>
                    </Link>
                    <Link :href="route('most-recent')">
                        <button class="pb-2 mr-8 font-medium">
                            Most Recent
                        </button>
                    </Link>
                    <Link :href="route('saved-jobs')">
                        <button class="pb-2 mr-8 font-medium">
                            Saved Jobs
                        </button>
                    </Link>
                </div>
            </div>

            <div class="space-y-4">
                <!-- Loop through jobs array and display each job -->
                <div
                    v-for="job in props.jobs"
                    :key="job.id"
                    class="bg-white border rounded-sm border-stroke shadow-default dark:border-strokedark dark:bg-boxdark"
                >
                    <Link :href="route('job.show', { id: job.id })">
                        <div class="p-4 sm:p-6 xl:p-10">
                            <div class="flex flex-col gap-5">
                                <div
                                    class="flex-col flex-wrap items-center justify-between gap-5"
                                >
                                    <div class="flex gap-5">
                                        <div class="w-full">
                                            <div class="flex justify-between">
                                                <p class="text-xs font-medium">
                                                    Posted
                                                    {{
                                                        formatDate(
                                                            job.created_at
                                                        )
                                                    }}
                                                </p>
                                                <div class="flex gap-5">
                                                    <!-- Icons, e.g., favorite or share -->
                                                </div>
                                            </div>
                                            <div class="flex justify-between">
                                                <h4
                                                    class="mb-[3px] text-title-md2 font-bold text-black dark:text-white"
                                                >
                                                    {{ job.title }}
                                                </h4>
                                                <PrimaryButton
                                                    >View Details</PrimaryButton
                                                >
                                            </div>
                                            <span class="text-xs font-medium"
                                                >{{ job.budget_type }} ${{ job.budget }} - ${{
                                                    job.budget
                                                }}</span
                                            >
                                            <span class="text-xs font-medium">
                                                -
                                                {{ job.experience_level }}</span
                                            >
                                            <span class="text-xs font-medium">
                                                - Est. Time:
                                                {{ job.project_type }}</span
                                            >
                                            <p class="mt-2 mb-[3px]">
                                                {{ job.description }}
                                            </p>
                                        </div>
                                    </div>

                                    <div
                                        class="flex flex-col gap-3 my-3 sm:flex-row sm:items-center sm:justify-between"
                                    >
                                        <div class="flex gap-3">
                                            <!-- <button 
                                              v-for="skill in job.skills" 
                                              :key="skill" 
                                              class="inline-flex px-3 py-1 text-sm font-medium border rounded-full hover:opacity-80"
                                              :style="{ borderColor: skill.color, color: skill.color }"
                                            >
                                                {{ skill.name }}
                                            </button> -->
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="flex items-center space-x-10"
                                        >
                                            <!-- <div class="flex items-center justify-center gap-1 font-medium">
                                                <span>svg</span>
                                                <p>{{ job.payment_status }}</p>
                                            </div>
                                            <div class="font-medium">
                                                <p>{{ job.rating }}</p>
                                                <p>{{ job.review_count }} Reviews</p>
                                            </div>
                                            <div class="font-medium">
                                                <p>{{ job.spent }}</p>
                                                <p>Total Spent</p>
                                            </div> -->
                                            <div class="flex gap-1">
                                                <svg
                                                    class="fill-current"
                                                    width="18"
                                                    height="18"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        d="M12 2c-4.4 0-8 3.6-8 8 0 5.4 7 11.5 7.3 11.8.2.1.5.2.7.2.2 0 .5-.1.7-.2.3-.3 7.3-6.4 7.3-11.8 0-4.4-3.6-8-8-8zm0 17.7c-2.1-2-6-6.3-6-9.7 0-3.3 2.7-6 6-6s6 2.7 6 6-3.9 7.7-6 9.7zM12 6c-2.2 0-4 1.8-4 4s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                                                        fill=""
                                                    />
                                                </svg>
                                                <p class="text-sm font-medium">
                                                    {{ job.location }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-sm font-medium">
                                            Proposal less than 5
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Link>
                </div>

                <div
                    class="bg-white border rounded-sm border-stroke shadow-default dark:border-strokedark dark:bg-boxdark"
                >
                    <div class="p-4 sm:p-6 xl:p-10">
                        <div class="flex flex-col gap-5">
                            <div
                                class="rounded-[10px] border-l-[5px] bg-white px-4 py-6 shadow-card dark:bg-boxdark sm:px-5 xl:px-7.5 border-meta-3"
                            >
                                <div
                                    class="flex-col flex-wrap items-center justify-between gap-5"
                                >
                                    <div class="flex gap-5">
                                        <div class="w-full">
                                            <div class="flex justify-between">
                                                <p class="text-xs font-medium">
                                                    Posted 5 minutes ago
                                                </p>
                                                <!-- <div class="flex gap-5">
                                                <svg class="fill-current" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M16.52 5.65002L13.42 3.25002C13.02 2.85002 12.12 2.65002 11.52 2.65002H7.71998C6.51998 2.65002 5.21998 3.55002 4.91998 4.75002L2.51998 12.05C2.01998 13.45 2.91998 14.65 4.41998 14.65H8.41998C9.01998 14.65 9.51998 15.15 9.41998 15.85L8.91998 19.05C8.71998 19.95 9.31998 20.95 10.22 21.25C11.02 21.55 12.02 21.15 12.42 20.55L16.52 14.45" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10"/>
<path d="M21.62 5.65V15.45C21.62 16.85 21.02 17.35 19.62 17.35H18.62C17.22 17.35 16.62 16.85 16.62 15.45V5.65C16.62 4.25 17.22 3.75 18.62 3.75H19.62C21.02 3.75 21.62 4.25 21.62 5.65Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
<svg class="fill-current" fill="none" width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M20.5,4.609A5.811,5.811,0,0,0,16,2.5a5.75,5.75,0,0,0-4,1.455A5.75,5.75,0,0,0,8,2.5,5.811,5.811,0,0,0,3.5,4.609c-.953,1.156-1.95,3.249-1.289,6.66,1.055,5.447,8.966,9.917,9.3,10.1a1,1,0,0,0,.974,0c.336-.187,8.247-4.657,9.3-10.1C22.45,7.858,21.453,5.765,20.5,4.609Zm-.674,6.28C19.08,14.74,13.658,18.322,12,19.34c-2.336-1.41-7.142-4.95-7.821-8.451-.513-2.646.189-4.183.869-5.007A3.819,3.819,0,0,1,8,4.5a3.493,3.493,0,0,1,3.115,1.469,1.005,1.005,0,0,0,1.76.011A3.489,3.489,0,0,1,16,4.5a3.819,3.819,0,0,1,2.959,1.382C19.637,6.706,20.339,8.243,19.826,10.889Z"/></svg>
                                            </div> -->
                                            </div>
                                            <div class="flex justify-between">
                                                <h4
                                                    class="mb-[3px] text-title-xsm font-bold text-black dark:text-white"
                                                >
                                                    Website Devloper Hostinger
                                                    and GoDaddy expert
                                                </h4>
                                                <PrimaryButton
                                                    >View Details</PrimaryButton
                                                >
                                            </div>
                                            <span class="text-xs font-medium"
                                                >Hourly $15 -$30</span
                                            >
                                            <span class="text-xs font-medium">
                                                - intermediate</span
                                            >
                                            <span class="text-xs font-medium">
                                                - Est. Time: less than 1
                                                month,</span
                                            >
                                            <span class="text-xs font-medium">
                                                Less than 30hrs/week</span
                                            >
                                            <p
                                                class="mt-2 mb-[3px] font-medium"
                                            >
                                                need to transfer my website on
                                                Hostinger made in wordpress to
                                                godaddy
                                            </p>
                                        </div>
                                    </div>
                                    <!-- <span
                                class="inline-flex rounded-md bg-gray px-2.5 py-1.5 text-sm font-medium leading-[22px] dark:bg-graydark"
                                >24, Nov 2027</span
                            > -->

                                    <div
                                        class="flex flex-col gap-3 my-3 sm:flex-row sm:items-center sm:justify-between"
                                    >
                                        <div class="flex gap-3">
                                            <button
                                                class="inline-flex px-3 py-1 text-sm font-medium border rounded-full hover:opacity-80"
                                                style="
                                                    border-color: rgb(
                                                        249,
                                                        193,
                                                        7
                                                    );
                                                    color: rgb(249, 193, 7);
                                                "
                                            >
                                                GoDaddy
                                            </button>
                                            <button
                                                class="inline-flex px-3 py-1 text-sm font-medium border rounded-full hover:opacity-80"
                                                style="
                                                    border-color: rgb(
                                                        60,
                                                        167,
                                                        69
                                                    );
                                                    color: rgb(60, 167, 69);
                                                "
                                            >
                                                WordPress
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="flex items-center space-x-10"
                                        >
                                            <div
                                                class="flex items-center justify-center gap-1 font-medium"
                                            >
                                                <svg
                                                    class="fill-current"
                                                    width="18"
                                                    height="18"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M15.4179 5.64279C15.1352 5.19159 14.5978 4.96897 14.0788 5.08813L12.28 5.50122C12.0959 5.5435 11.9046 5.5435 11.7205 5.50122L9.92162 5.08813C9.4027 4.96897 8.86524 5.19159 8.58257 5.64279L7.60269 7.20685C7.5024 7.36694 7.36713 7.50221 7.20704 7.60251L5.64297 8.58238C5.19177 8.86506 4.96915 9.40251 5.08832 9.92144L5.5014 11.7203C5.54369 11.9044 5.54369 12.0957 5.50141 12.2798L5.08832 14.0787C4.96915 14.5976 5.19177 15.135 5.64297 15.4177L7.20704 16.3976C7.36713 16.4979 7.5024 16.6331 7.60269 16.7932L8.58257 18.3573C8.86524 18.8085 9.4027 19.0311 9.92162 18.912L11.7205 18.4989C11.9046 18.4566 12.0959 18.4566 12.28 18.4989L14.0788 18.912C14.5978 19.0311 15.1352 18.8085 15.4179 18.3573L16.3978 16.7932C16.4981 16.6332 16.6333 16.4979 16.7934 16.3976L18.3575 15.4177C18.8087 15.135 19.0313 14.5976 18.9121 14.0787L18.4991 12.2798C18.4568 12.0957 18.4568 11.9044 18.4991 11.7203L18.9121 9.92144C19.0313 9.40251 18.8087 8.86506 18.3575 8.58238L16.7934 7.60251C16.6333 7.50221 16.4981 7.36694 16.3978 7.20685L15.4179 5.64279ZM14.9152 9.76963C15.0556 9.53186 14.9767 9.22527 14.7389 9.08485C14.5011 8.94443 14.1945 9.02335 14.0541 9.26113L11.4402 13.6872L9.86121 12.1751C9.66177 11.9841 9.34526 11.9909 9.15426 12.1903C8.96327 12.3898 8.97012 12.7063 9.16956 12.8973L11.2042 14.8457C11.3144 14.9514 11.4669 15.0008 11.6182 14.98C11.7694 14.9591 11.9029 14.8704 11.9805 14.7389L14.9152 9.76963Z"
                                                        fill=""
                                                    />
                                                </svg>
                                                <p>Payment Verified</p>
                                            </div>
                                            <div class="font-medium">
                                                <p></p>
                                                <p>5 Star</p>
                                            </div>
                                            <div class="font-medium">
                                                <p></p>
                                                <p>$200+ Spent</p>
                                            </div>
                                            <div class="flex gap-1 font-medium">
                                                <svg
                                                    class="fill-current"
                                                    width="18"
                                                    height="18"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        d="M12 2c-4.4 0-8 3.6-8 8 0 5.4 7 11.5 7.3 11.8.2.1.5.2.7.2.2 0 .5-.1.7-.2.3-.3 7.3-6.4 7.3-11.8 0-4.4-3.6-8-8-8zm0 17.7c-2.1-2-6-6.3-6-9.7 0-3.3 2.7-6 6-6s6 2.7 6 6-3.9 7.7-6 9.7zM12 6c-2.2 0-4 1.8-4 4s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                                                        fill=""
                                                    />
                                                </svg>
                                                <p>India</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <p class="text-sm font-medium">
                                        Proposal less than 5
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
