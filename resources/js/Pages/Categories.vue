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

        <section id="categories" class="container py-24 sm:py-32">
            <h1 class="text-title-lg">Categories and Subcategories</h1>

            <div v-if="categories.length">
                <div v-for="category in categories" :key="category.id">
                    <div class="flex gap-2">
                        <h2 class="text-title-md">{{ category.id }}.</h2>
                        <Link :href="route('category.detail', { id: category.id })">
                        <h2 class="text-title-md">{{ category.name }}</h2>
                    </Link>
                    </div>
                    <!-- <ul v-if="category.sub_categories.length">
                        <li
                            v-for="subCategory in category.sub_categories"
                            :key="subCategory.id"
                        >
                            {{ subCategory.name }}
                        </li>
                    </ul> -->
                </div>
            </div>
        </section>
        <Footer />
    </div>
</template>
