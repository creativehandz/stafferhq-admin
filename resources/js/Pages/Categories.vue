<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";

import Navbar from "@/Components/LandingPage/Navbar.vue";
import Footer from "@/Components/LandingPage/Footer.vue";

// Define interfaces for Category and SubCategory
interface SubCategory {
    id: number;
    name: string;
    category_id: number;
}

interface Category {
    id: number;
    name: string;
    sub_categories: SubCategory[]; // Define subCategories as an array of SubCategory objects
}

const props = defineProps<{
    categories: Category[];
    canLogin?: boolean;
    canRegister?: boolean;
}>();

function handleImageError() {
    document.getElementById("screenshot-container")?.classList.add("!hidden");
    document.getElementById("docs-card")?.classList.add("!row-span-1");
    document.getElementById("docs-card-content")?.classList.add("!flex-row");
    document.getElementById("background")?.classList.add("!hidden");
}
</script>

<template>
    <Head title="Categories" />
    <div class="bg-white text-black dark:bg-black-2 dark:text-white">
        <Navbar :can-login="canLogin" :can-register="canRegister" />

        <section id="categories" class="container w-[75%] py-12 sm:py-16">
            <div class="mb-10">
                <h1 class="text-title-xl2 font-bold">
                    StafferHQ Gigs® Directory
                </h1>
                <h2 class="text-title-md font-normal">
                    One stop shop for all your needs
                </h2>
            </div>

            <div v-if="categories.length">
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8"
                >
                    <div v-for="category in categories" :key="category.id">
                        <Link
                            :href="
                                route('category.detail', { id: category.id })
                            "
                        >
                            <h2
                                class="text-title-sm font-semibold hover:text-primary"
                            >
                                {{ category.name }}
                            </h2>
                        </Link>

                        <ul v-if="category.sub_categories.length" class="mt-5">
                            <li
                                v-for="subCategory in category.sub_categories"
                                :key="subCategory.id"
                                class="text-title-xs font-normal"
                            >
                                {{ subCategory.name }}
                            </li>
                        </ul>
                        <p v-else>No subcategories available.</p>
                    </div>
                </div>
            </div>
        </section>
        <Footer />
    </div>
</template>
