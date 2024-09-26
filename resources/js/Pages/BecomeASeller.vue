<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

import Footer from "@/Components/LandingPage/Footer.vue";
import Navbar from "@/Components/LandingPage/Navbar.vue";
import HeroBecomeSeller from "@/Components/LandingPage/BecomeSeller/HeroBecomeSeller.vue";
import SponsorsBecomeSeller from "@/Components/LandingPage/BecomeSeller/SponsorsBecomeSeller.vue";
import BenefitsBecomeSeller from "@/Components/LandingPage/BecomeSeller/BenefitsBecomeSeller.vue";
import FeaturesBecomeSeller from "@/Components/LandingPage/BecomeSeller/FeaturesBecomeSeller.vue";
import ServicesBecomeSeller from "@/Components/LandingPage/BecomeSeller/ServicesBecomeSeller.vue";
import HowItWorksBecomeSeller from "@/Components/LandingPage/BecomeSeller/HowItWorksBecomeSeller.vue";
import TestimonialsBecomeSeller from "@/Components/LandingPage/BecomeSeller/TestimonialsBecomeSeller.vue";
import TeamBecomeSeller from "@/Components/LandingPage/BecomeSeller/TeamBecomeSeller.vue";
import CommunityBecomeSeller from "@/Components/LandingPage/BecomeSeller/CommunityBecomeSeller.vue";
import PricingBecomeSeller from "@/Components/LandingPage/BecomeSeller/PricingBecomeSeller.vue";
import ContactBecomeSeller from "@/Components/LandingPage/BecomeSeller/ContactBecomeSeller.vue";
import FAQBecomeSeller from "@/Components/LandingPage/BecomeSeller/FAQBecomeSeller.vue";

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
</script>

<template>
    <Head title="Become a seller" />
    <div class="bg-white text-black dark:bg-black-2 dark:text-white">
        <Navbar :can-login="canLogin" :can-register="canRegister" />
        <HeroBecomeSeller />
        <SponsorsBecomeSeller />
        <BenefitsBecomeSeller />
        <FeaturesBecomeSeller />
        <ServicesBecomeSeller />
        <HowItWorksBecomeSeller />
        <TestimonialsBecomeSeller />
        <TeamBecomeSeller />
        <CommunityBecomeSeller />
        <PricingBecomeSeller />
        <ContactBecomeSeller />
        <FAQBecomeSeller />
        <Footer />

       
    </div>
</template>
