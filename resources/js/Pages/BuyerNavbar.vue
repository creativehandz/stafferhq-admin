<script lang="ts" setup>
import { ref } from "vue";
import {
    Sheet,
    SheetContent,
    SheetFooter,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from "@/Components/LandingPage/ui/sheet";

import { Button } from "@/Components/LandingPage/ui/button";
import { Separator } from "@/Components/LandingPage/ui/separator";
import { Link } from "@inertiajs/vue3";
import DropdownNotification from "@/Components//Header/DropdownNotification.vue";
import DropdownMessage from "@/Components/Header/DropdownMessage.vue";
import DropdownUser from "@/Components/Header/DropdownUser.vue";
import DropdownUserTwo from "@/Components/Header/DropdownUserTwo.vue";
import DropdownHeart from "@/Components/Header/DropdownHeart.vue";
import toWorkLogo from '@/assets/toworkLogo.svg';
import crown from '@/assets/crown.svg';
import magGlass from '@/assets/mag-glass.png';

interface RouteProps {
    href: string;
    label: string;
}

interface FeatureProps {
    title: string;
    description: string;
}

const routeList: RouteProps[] = [
    {
        href: "#testimonials",
        label: "Testimonials",
    },
];

const featureList: FeatureProps[] = [
    {
        title: "Showcase Your Value ",
        description: "Highlight how your product solves user problems.",
    },
    {
        title: "Build Trust",
        description:
            "Leverages social proof elements to establish trust and credibility.",
    },
    {
        title: "Capture Leads",
        description:
            "Make your lead capture form visually appealing and strategically.",
    },
];

const isOpen = ref<boolean>(false);

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
}>();
</script>

<template>
<div class="">
    <!-- Navbar starts -->
    <div class="flex items-center justify-between py-5">
    <!-- Logo Button -->
    <button>
        <a href="/"> <img :src="toWorkLogo" alt="Logo" /></a>
    </button>
    
    <!-- Right side content -->
    <div v-if="$page.props.auth.user" class="flex items-center gap-10">
        <!-- Search box -->
        <div class="flex px-3 py-2 bg-transparent border rounded-full w-96">
            <input
                type="text"
                placeholder="Search for a service"
                class="w-full text-sm text-black border-none outline-none"
            />
            <button type="submit">
                <img :src="magGlass" alt="search" class="w-5 h-5" />
            </button>
        </div>

        <!-- Right side buttons and dropdowns -->
        <ul class="flex items-center gap-6">
            <!-- Notification Menu Area -->
            <DropdownNotification />
            <!-- Chat Notification Area -->
            <DropdownMessage />
            <!-- Favorites/Heart -->
            <DropdownHeart />

            <!-- Orders Button -->
            <button class="text-sm text-black">Orders</button>

            <!-- Switch to Selling Button -->
            <button class="text-sm text-black">Switch to Selling</button>

            <!-- User Dropdown Area -->
            <DropdownUserTwo />
        </ul>
    </div>
</div>
<!-- Navbar ends -->
</div>
</template>