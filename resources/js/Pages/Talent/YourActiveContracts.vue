<script setup lang="ts">
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from 'vue'

const pageTitle = ref('Manage Orders')
const activeTab = ref("priorityOrders");
type Order = {
    id: number;
    buyer: string;
    gig: string;
    due_on: number;
    total: number;
    note: string;
    status: string;
    created_at: string;
    // Add any other fields that are present in your job object
};

// Define the type for the props
type Props = {
    orders: Order[];
};

// Receive the jobs data passed from the backend with correct type
const props = defineProps<Props>();
</script>

<template>
    <Head title="Design" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
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
                class="flex flex-wrap gap-3 border-b border-stroke pb-5 dark:border-strokedark"
            >
                <!-- Tab Buttons -->
                <button
                    @click="activeTab = 'priorityOrders'"
                    :class="[
                        activeTab === 'priorityOrders'
                            ? 'bg-primary text-white'
                            : 'bg-gray dark:bg-meta-4 text-black dark:text-white',
                        'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6',
                    ]"
                >
                    Priority
                </button>

                <button
                    @click="activeTab = 'activeOrders'"
                    :class="[
                        activeTab === 'activeOrders'
                            ? 'bg-primary text-white'
                            : 'bg-gray dark:bg-meta-4 text-black dark:text-white',
                        'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6',
                    ]"
                >
                    Active
                </button>

                <button
                    @click="activeTab = 'lateOrders'"
                    :class="[
                        activeTab === 'lateOrders'
                            ? 'bg-primary text-white'
                            : 'bg-gray dark:bg-meta-4 text-black dark:text-white',
                        'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6',
                    ]"
                >
                    Late
                </button>

                <button
                    @click="activeTab = 'deliveredOrders'"
                    :class="[
                        activeTab === 'deliveredOrders'
                            ? 'bg-primary text-white'
                            : 'bg-gray dark:bg-meta-4 text-black dark:text-white',
                        'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6',
                    ]"
                >
                    Delivered
                </button>

                <button
                    @click="activeTab = 'completedOrders'"
                    :class="[
                        activeTab === 'completedOrders'
                            ? 'bg-primary text-white'
                            : 'bg-gray dark:bg-meta-4 text-black dark:text-white',
                        'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6',
                    ]"
                >
                    Completed
                </button>

                <button
                    @click="activeTab = 'cancelledOrders'"
                    :class="[
                        activeTab === 'cancelledOrders'
                            ? 'bg-primary text-white'
                            : 'bg-gray dark:bg-meta-4 text-black dark:text-white',
                        'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6',
                    ]"
                >
                    Cancelled
                </button>

                <button
                    @click="activeTab = 'starredOrders'"
                    :class="[
                        activeTab === 'starredOrders'
                            ? 'bg-primary text-white'
                            : 'bg-gray dark:bg-meta-4 text-black dark:text-white',
                        'rounded-md py-3 px-4 text-sm font-medium hover:bg-primary hover:text-white dark:hover:bg-primary md:text-base lg:px-6',
                    ]"
                >
                    Starred
                </button>
            </div>

            <!-- Orders Display -->
            <div class="mt-5">
                <div
                    v-for="order in props.orders"
                    :key="order.id"
                    class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark p-4 mb-3"
                >
                    <h3 class="text-lg font-semibold">{{ order.buyer }}</h3>
                    <p><strong>Gig:</strong> {{ order.gig }}</p>
                    <p><strong>Due on:</strong> {{ order.due_on }}</p>
                    <p><strong>Total:</strong> {{ order.total }}</p>
                    <p><strong>Status:</strong> {{ order.status }}</p>
                    <p><strong>Note:</strong> {{ order.note }}</p>
                </div>
            </div>
        </div>
        <!-- Main Content End -->
    </AuthenticatedLayout>
</template>
