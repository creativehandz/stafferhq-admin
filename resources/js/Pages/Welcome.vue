<script setup lang="ts">
import Benefits from "@/Components/LandingPage/Benefits.vue";
import Buttons from "@/Components/LandingPage/Buttons.vue";
import Community from "@/Components/LandingPage/Community.vue";
import Contact from "@/Components/LandingPage/Contact.vue";
import FAQ from "@/Components/LandingPage/FAQ.vue";
import Features from "@/Components/LandingPage/Features.vue";
import Footer from "@/Components/LandingPage/Footer.vue";
import Hero from "@/Components/LandingPage/Hero.vue";
import HowItWorks from "@/Components/LandingPage/HowItWorks.vue";
import Individuals from "@/Components/LandingPage/Individuals.vue";
import Navbar from "@/Components/LandingPage/Navbar.vue";
import Premium from "@/Components/LandingPage/Premium.vue";
import Pricing from "@/Components/LandingPage/Pricing.vue";
import Services from "@/Components/LandingPage/Services.vue";
import Sponsors from "@/Components/LandingPage/Sponsors.vue";
import Team from "@/Components/LandingPage/Team.vue";
import Testimonials from "@/Components/LandingPage/Testimonials.vue";
import { Head, Link } from "@inertiajs/vue3";
import BuyerNavbar from "./BuyerNavbar.vue";

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
    <div class="container">
    <Head title="Welcome" />
    <div class="text-black bg-white ">
        <BuyerNavbar/>
        <Hero />
        <Buttons/>
        <Individuals/>
   <!-- <Sponsors />
        <Benefits />
        <Features />
        <Services />
        <HowItWorks /> -->
        <Premium/>
        <Testimonials />
        <Footer /> 
        <!-- <Team />
        <Community />
        <Pricing />
        <Contact />
        <FAQ /> -->
        

       </div>
    </div>

</template>
