<script setup lang="ts">
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

const pageTitle = ref("Error Page");
</script>

<template>
    <Head title="Error Page" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Error Page
            </h2>
        </template>

        <!-- Breadcrumb Start -->
        <BreadcrumbDefault :pageTitle="pageTitle" />
        <!-- Breadcrumb End -->
 
        <div
            class="rounded-sm border border-stroke bg-white px-5 py-10 shadow-default dark:border-strokedark dark:bg-boxdark sm:py-20"
        >
            <div class="mx-auto max-w-[410px]">
                <img
                class="mx-auto"
                    src="../../img/illustration/illustration-01.svg"
                    alt="illustration"
                />
                <div class="mt-7 text-center">
                    <h2
                        class="mb-3 text-2xl font-bold text-black dark:text-white"
                    >
                        Sorry, the page can’t be found
                    </h2>
                    <p class="font-medium">
                        The page you were looking for appears to have been
                        moved, deleted or does not exist.
                    </p>
                    <a
                        href="/"
                        class="mt-7 inline-flex items-center gap-2 rounded-md bg-primary py-3 px-6 font-medium text-white hover:bg-opacity-90"
                        ><svg
                            class="fill-current"
                            width="16"
                            height="14"
                            viewBox="0 0 16 14"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M14.7492 6.38125H2.73984L7.52109 1.51562C7.77422 1.2625 7.77422 0.86875 7.52109 0.615625C7.26797 0.3625 6.87422 0.3625 6.62109 0.615625L0.799219 6.52187C0.546094 6.775 0.546094 7.16875 0.799219 7.42188L6.62109 13.3281C6.73359 13.4406 6.90234 13.525 7.07109 13.525C7.23984 13.525 7.38047 13.4687 7.52109 13.3562C7.77422 13.1031 7.77422 12.7094 7.52109 12.4563L2.76797 7.64687H14.7492C15.0867 7.64687 15.368 7.36562 15.368 7.02812C15.368 6.6625 15.0867 6.38125 14.7492 6.38125Z"
                                fill=""
                            ></path></svg>
                            <span>Back to Home</span></a
                    >
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
