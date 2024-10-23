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

const props = defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    laravelVersion: string;
    phpVersion: string;
    categories: Category[];
}>();

interface Category {
    id: number;
    name: string;    
}

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
        <Navbar :can-login="canLogin" :can-register="canRegister" />
        <Hero />
        
        <!-- Category Buttons -->
        <div class="container px-8 py-8 mx-auto">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">        
                <div
                v-for="category in categories"
                :key="category.id"
                class="flex items-center justify-between px-6 py-8 transition-shadow duration-200 rounded-lg shadow-md cursor-pointer hover:shadow-lg"
                >
                
                <div class="flex items-center">
                    <!-- SVG icon as an image -->           
                    <span class="leading-none sm:text-[18px]  md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px] button-items">    
                        <button>
                            <a :href="`/categories/${category.id}`" class="no-underline">
                                {{ category.name }}
                            </a>
                        </button> 
                    </span>
                </div>
                </div>
            </div>
            </div>
        <!-- Category Buttons end -->
         
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
