<script lang="ts" setup>
import { ref } from "vue";

import { useColorMode } from "@vueuse/core";
// const mode = useColorMode();
// mode.value = "dark";

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

import { ChevronsDown, Menu } from "lucide-vue-next";
import GithubIcon from "@/Components/LandingPage/icons/GithubIcon.vue";
import ToggleTheme from "./ToggleTheme.vue";
import { Link } from "@inertiajs/vue3";
import DropdownNotification from "../Header/DropdownNotification.vue";
import DropdownMessage from "../Header/DropdownMessage.vue";
import DropdownUser from "../Header/DropdownUser.vue";
import DropdownUserTwo from "../Header/DropdownUserTwo.vue";
import DropdownHeart from "../Header/DropdownHeart.vue";

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
    <header
        :class="{            
            'container top-5 mx-auto py-4 z-40  flex justify-between items-center': true,
        }"
    >
        <a href="/" class="flex items-center text-lg font-bold">
            <img
                src="../../../img/toworkLogo.svg"
                alt="Logo"
                class="mr-2 text-white rounded-lg w-180px h-53 g-gradient-to-tr from-primary via-primary/70 to-primary"
            />

            </a
        >
        <!-- Mobile -->
        <div class="lg:hidden">
            <Sheet v-model:open="isOpen">
                <SheetTrigger as-child>
                    <Menu @click="isOpen = true" class="cursor-pointer" />
                </SheetTrigger>

                <SheetContent
                    side="left"
                    class="top-0 flex flex-col justify-between rounded-tr-2xl rounded-br-2xl bg-card"
                >
                    <div>
                        <SheetHeader class="mb-4 ml-4">
                            <SheetTitle class="flex items-center">
                                <a href="/" class="flex items-center">
                                    <img
                                        src=""
                                        alt="Logo"
                                        class="mr-2 text-white rounded-lg g-gradient-to-tr from-primary via-primary/70 to-primary w-9 h-9"
                                    />

                                    StafferHQ
                                </a>
                            </SheetTitle>
                        </SheetHeader>

                        <div class="flex flex-col gap-2">
                            <Button
                                v-for="{ href, label } in routeList"
                                :key="label"
                                as-child
                                variant="ghost"
                                class="justify-start text-base"
                            >
                                <a @click="isOpen = false" :href="href">
                                    {{ label }}
                                </a>
                            </Button>
                        </div>
                    </div>

                    <SheetFooter
                        class="flex-col items-start justify-start sm:flex-col"
                    >
                        <Separator class="mb-2" />

                        <!-- <ToggleTheme /> -->
                    </SheetFooter>
                </SheetContent>
            </Sheet>
        </div>

        

        <div class="hidden lg:flex">

        </div>
        <div v-if="canLogin" class="hidden lg:flex">
            <div
                v-if="$page.props.auth.user"
                class="flex items-center gap-3 2xsm:gap-7"
            >
                <ul class="flex items-center gap-2 2xsm:gap-4">
                    <!-- Notification Menu Area -->
                    <DropdownNotification />
                    <!-- Notification Menu Area -->

                    <!-- Chat Notification Area -->
                    <DropdownMessage />
                    <!-- Chat Notification Area -->

                    <DropdownHeart />

                    <Button as-child size="sm" variant="secondary">
                        <div
                            class="rounded-md text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]  dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Orders
                        </div>
                    </Button>

                    <Button as-child size="sm" variant="outline">
                        <div
                            class="rounded-md text-black ring-1 ring-transparent transition hover:text-black focus:outline-none focus-visible:ring-[#FF2D20]  dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Switch to Selling
                        </div>
                    </Button>

                    <!-- User Area -->
                    <DropdownUserTwo />
                    <!-- User Area -->
                </ul>
            </div>

            <template v-else>
                <div class="flex items-center justify-center gap-10">
                    <button><Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-md px-3 py-2 leading-none sm:text-[18px]  md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px] text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]  dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                    <div class="flex display-inline"> Premium &nbsp; <img src="../../../img/crown.svg" class="w-5"/></div> 
                    </Link></button>
                    <button>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-md px-3 py-2 leading-none sm:text-[18px]  md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px] text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]  dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Find work
                    </Link></button>
                    <button>
                    <Link :href="route('become-a-seller')">
                            <div
                                class="rounded-md leading-none sm:text-[18px]  md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px] text-black ring-1 ring-transparent transition hover:text-black focus:outline-none focus-visible:ring-[#FF2D20]  dark:hover:text-white/80 dark:focus-visible:ring-white cursor-pointer"
                            >
                                Become a Seller
                            </div>                        
                    </Link>
                    </button>
                    <button>
                        <Link
                            :href="route('login')"
                            class="rounded-full leading-none sm:text-[18px]  md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px] text-black bg-[#A4FCFF] shadow px-6 py-2 cursor-pointer hover:shadow-lg"
                        >
                            Log in
                        </Link>
                    </button>
                   
                    <button>
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="rounded-full text-black bg-[#A4FCFF] shadow px-6 py-2 cursor-pointer hover:shadow-lg leading-none sm:text-[18px]  md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px]"
                        >
                            Register
                        </Link>
                    </button>
                    
                </div>
               
            </template>
        </div>
    </header>
</template>

<style scoped>
.shadow-light {
    box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.085);
}

.shadow-dark {
    box-shadow: inset 0 0 5px rgba(255, 255, 255, 0.141);
}
button {
    font-family: "Neue Montreal regular";
        
}
</style>
