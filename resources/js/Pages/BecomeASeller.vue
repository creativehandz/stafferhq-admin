<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

import Benefits from "@/Components/LandingPage/Benefits.vue";
import Community from "@/Components/LandingPage/Community.vue";
import Contact from "@/Components/LandingPage/Contact.vue";
import FAQ from "@/Components/LandingPage/FAQ.vue";
import Features from "@/Components/LandingPage/Features.vue";
import Footer from "@/Components/LandingPage/Footer.vue";
import Hero from "@/Components/LandingPage/Hero.vue";
import HowItWorks from "@/Components/LandingPage/HowItWorks.vue";
import Navbar from "@/Components/LandingPage/Navbar.vue";
import Pricing from "@/Components/LandingPage/Pricing.vue";
import Services from "@/Components/LandingPage/Services.vue";
import Sponsors from "@/Components/LandingPage/Sponsors.vue";
import Team from "@/Components/LandingPage/Team.vue";
import Testimonials from "@/Components/LandingPage/Testimonials.vue";


defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    laravelVersion: string;
    phpVersion: string;
}>();

function handleImageError() {
    document.getElementById("screenshot-container")?.classList.add("!hidden");
    document.getElementById("docs-card")?.classList.add("!row-span-1");
    document.getElementById("docs-card-content")?.classList.add("!flex-row");
    document.getElementById("background")?.classList.add("!hidden");
}

const pageTitle = ref("Become a seller");
</script>

<template>
    <Head title="Become a seller" />
    <div class="bg-white text-black dark:bg-black-2 dark:text-white">
        <Navbar :can-login="canLogin" :can-register="canRegister" />
        <Hero />
        <Sponsors />
        <Benefits />
        <Features />
        <Services />
        <HowItWorks />
        <Testimonials />
        <Team />
        <Community />
        <Pricing />
        <Contact />
        <FAQ />
        <Footer />

       
    </div>
        
    
</template>
