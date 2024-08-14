<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";

import ProductOne from "../../img/product/product-01.png";
import ProductTwo from "../../img/product/product-02.png";
import ProductThree from "../../img/product/product-03.png";
import ProductFour from "../../img/product/product-04.png";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";

const pageTitle = ref("Users");

const products = ref([
    {
        id: 1,
        name: "Apple",
        category: "Electronics",
        price: 269,
        sold: 22,
        profit: 45,
        imageSrc: ProductOne,
        status: "Active",
    },
    {
        id: 2,
        name: "Meta",
        category: "Electronics",
        price: 546,
        sold: 34,
        profit: 125,
        imageSrc: ProductTwo,
        status: "Active",
    },
    {
        id: 3,
        name: "Dell",
        category: "Electronics",
        price: 443,
        sold: 64,
        profit: 247,
        imageSrc: ProductThree,
        status: "Active",
    },
    {
        id: 4,
        name: "HP",
        category: "Electronics",
        price: 499,
        sold: 72,
        profit: 103,
        imageSrc: ProductFour,
        status: "Active",
    },
]);
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Users
            </h2>
        </template>

        <BreadcrumbDefault :pageTitle="pageTitle"/>

        <div class="flex flex-col">
            <div
                class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"
            >
                <div class="py-6 px-4 md:px-6 xl:px-7.5">
                    <h4 class="text-xl font-bold text-black dark:text-white">
                        Users List
                    </h4>
                </div>

                <!-- Table Header -->
                <div
                    class="grid grid-cols-7 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5"
                >
                    <div class="col-span-2 flex items-center">
                        <p class="font-medium">Company Name</p>
                    </div>
                    <div class="col-span-2 hidden items-center sm:flex">
                        <p class="font-medium">Total Job Posted</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Comp Login</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">View Details</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Action</p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="font-medium">Status</p>
                    </div>
                </div>

                <!-- Table Rows -->
                <div
                    v-for="product in products"
                    :key="product.id"
                    class="grid grid-cols-6 border-t border-stroke py-4.5 px-4 dark:border-strokedark sm:grid-cols-8 md:px-6 2xl:px-7.5"
                >
                    <div class="col-span-2 flex items-center">
                        <div
                            class="flex flex-col gap-4 sm:flex-row sm:items-center"
                        >
                            <div class="h-12.5 w-15 rounded-md">
                                <img
                                    :src="product.imageSrc"
                                    :alt="`Product: ${product.name}`"
                                />
                            </div>
                            <p
                                class="text-sm font-medium text-black dark:text-white"
                            >
                                {{ product.name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-span-2 hidden items-center sm:flex">
                        <p
                            class="text-sm font-medium text-black dark:text-white"
                        >
                            {{ product.category }}
                        </p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p
                            class="text-sm font-medium text-black dark:text-white"
                        >
                            ${{ product.price }}
                        </p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p
                            class="text-sm font-medium text-black dark:text-white"
                        >
                            {{ product.sold }}
                        </p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="text-sm font-medium text-meta-3">
                            ${{ product.profit }}
                        </p>
                    </div>
                    <div class="col-span-1 flex items-center">
                        <p class="text-sm font-medium text-amber-500">
                            {{ product.status }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
