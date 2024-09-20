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

        <!-- <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-boxdark overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        Design Page
                    </div>
                </div>
            </div>
        </div> -->
       
        <div class="mb-14 w-full p-7.5">
                <div
                    class="flex flex-wrap gap-3 border-b border-stroke pb-5 dark:border-strokedark"
                >

                <div
                    v-for="order in props.orders"
                    :key="order.id"
                    class=""
                >
                 <h1>{{ order.buyer }}  </h1>
                 <h1>{{ order.gig }}  </h1>
                 <h1>{{ order.due_on }}  </h1>
                 <h1>{{ order.total }}  </h1>
                 
                 <h1>{{ order.status }}  </h1>
                 <h1>{{ order.total }}  </h1>
                 </div>
                    <!-- Tab style 1 -->
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
                <!-- v-if logics and content -->
                <div
                    v-for="order in props.orders"
                    :key="order.id"
                    class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"
                >
                 <h1>{{  order.buyer  }}</h1>
                 </div>
                </div>
    </AuthenticatedLayout>
</template>
