<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";

import Navbar from "@/Components/LandingPage/Navbar.vue";
import Footer from "@/Components/LandingPage/Footer.vue";


const props = defineProps<{
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
    <Head title="Sellers" />
    <div class="bg-white text-black dark:bg-black-2 dark:text-white">
        <Navbar :can-login="canLogin" :can-register="canRegister" />

      
        <section id="categories" class="container w-[75%] py-12 sm:py-16">
            <div class="mb-10">
                <h1 class="text-title-xl2 font-bold">
                    SubCategory Name
                </h1>
                <h2 class="text-title-md font-normal">
                    Short Description
                </h2>
            </div>
        </section>
        <Footer />
    </div>
</template>
