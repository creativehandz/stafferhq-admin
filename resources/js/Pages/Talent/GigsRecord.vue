<script setup lang="ts">
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from 'vue'

const pageTitle = ref('Gigs')
const activeTab = ref("activeGigs");
type Gig = {
    id: number;
    gig: string;
    impressions: number;
    clicks: number;
    orders: number;
    cancellations: number;
};

// Define the type for the props
type Props = {
    gigs: Gig[];
};

// Receive the jobs data passed from the backend with correct type
const props = defineProps<Props>();
</script>

<template>
    <Head title="Design" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Design
            </h2>
        </template>

        <!-- Breadcrumb Start -->
    <BreadcrumbDefault :pageTitle="pageTitle" />
    <!-- Breadcrumb End -->

    <!-- Main Content Start -->
    <div class="mb-14 w-full p-7.5">
            <!-- Tabs for Order Status -->
            <div
                class="flex flex-wrap gap-3 pb-5 border-b border-stroke dark:border-strokedark"
            >
                <!-- Tab Buttons -->
                <button
                    @click="activeTab = 'activeGigs'"
                    :class="[
                        activeTab === 'activeGigs'
                            ? 'bg-primary text-white'
                            : 'bg-gray dark:bg-meta-4 text-black dark:text-white',
                        'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6',
                    ]"
                >
                    Active
                </button>

                <button
                    @click="activeTab = 'pendingApproval'"
                    :class="[
                        activeTab === 'pendingApproval'
                            ? 'bg-primary text-white'
                            : 'bg-gray dark:bg-meta-4 text-black dark:text-white',
                        'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6',
                    ]"
                >
                    Pending Approval
                </button>

                <button
                    @click="activeTab = 'requiresModification'"
                    :class="[
                        activeTab === 'requiresModification'
                            ? 'bg-primary text-white'
                            : 'bg-gray dark:bg-meta-4 text-black dark:text-white',
                        'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6',
                    ]"
                >
                    Requires Modification
                </button>

                <button
                    @click="activeTab = 'draftGigs'"
                    :class="[
                        activeTab === 'draftGigs'
                            ? 'bg-primary text-white'
                            : 'bg-gray dark:bg-meta-4 text-black dark:text-white',
                        'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6',
                    ]"
                >
                    Draft
                </button>

                <button
                    @click="activeTab = 'deniedGigs'"
                    :class="[
                        activeTab === 'deniedGigs'
                            ? 'bg-primary text-white'
                            : 'bg-gray dark:bg-meta-4 text-black dark:text-white',
                        'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6',
                    ]"
                >
                    Denied
                </button>

                <button
                    @click="activeTab = 'pausedGigs'"
                    :class="[
                        activeTab === 'pausedGigs'
                            ? 'bg-primary text-white'
                            : 'bg-gray dark:bg-meta-4 text-black dark:text-white',
                        'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6',
                    ]"
                >
                    Paused
                </button> 
                <button class="px-6 py-3 ml-2 text-white bg-green-500 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-755">
                    CREATE A NEW GIG
                </button>               
            </div>
           
            

            <!-- Orders Display -->
            <div class="mt-5">
                <div
                    v-for="gig in props.gigs"
                    :key="gig.id"
                    class="p-4 mb-3 bg-white border rounded-sm border-stroke shadow-default dark:border-strokedark dark:bg-boxdark"
                >
                    <p><strong>Gig:</strong> {{ gig.gig }}</p> <!-- Display Gig title -->
                    <p><strong>Impressions:</strong> {{ gig.impressions }}</p> <!-- Display Impressions -->
                    <p><strong>Clicks:</strong> {{ gig.clicks }}</p> <!-- Display Clicks -->
                    <p><strong>Orders:</strong> {{ gig.orders }}</p> <!-- Display Orders -->
                    <p><strong>Cancellations:</strong> {{ gig.cancellations }}</p> <!-- Display Cancellations -->
                </div>
            </div>
        </div>
        <!-- Main Content End -->
    </AuthenticatedLayout>
</template>
