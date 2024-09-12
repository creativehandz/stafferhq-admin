<script setup lang="ts">
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
</template>
