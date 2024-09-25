<script lang="ts" setup>
import { ref } from "vue";

import { useColorMode } from "@vueuse/core";
const mode = useColorMode();
mode.value = "dark";

import {
    NavigationMenu,
    NavigationMenuContent,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    NavigationMenuTrigger,
} from "@/Components/LandingPage/ui/navigation-menu";
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
    // {
    //     href: "#team",
    //     label: "Team",
    // },
    // {
    //   href: "#contact",
    //   label: "Contact",
    // },
    // {
    //   href: "#faq",
    //   label: "FAQ",
    // },
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
            'shadow-light': mode === 'light',
            'shadow-dark': mode === 'dark',
            'w-[90%] md:w-[70%] lg:w-[75%] lg:max-w-screen-xl top-5 mx-auto sticky border z-40 rounded-2xl flex justify-between items-center p-2 bg-card shadow-md': true,
        }"
    >
        <a href="/" class="font-bold text-lg flex items-center">
            <!-- <ChevronsDown
        class="bg-gradient-to-tr from-primary via-primary/70 to-primary rounded-lg w-9 h-9 mr-2 border text-white"
      /> -->
            <img
                src="../../../img/logo.png"
                alt="Logo"
                class="g-gradient-to-tr from-primary via-primary/70 to-primary rounded-lg w-9 h-9 mr-2 text-white"
            />

            StafferHQ</a
        >
        <!-- Mobile -->
        <div class=" lg:hidden">
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
                                    <!-- <ChevronsDown
                    class="bg-gradient-to-tr from-primary/70 via-primary to-primary/70 rounded-lg size-9 mr-2 border text-white"
                  /> -->
                                    <img
                                        src="../../../img/logo.png"
                                        alt="Logo"
                                        class="g-gradient-to-tr from-primary via-primary/70 to-primary rounded-lg w-9 h-9 mr-2 text-white"
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
                        class="flex-col sm:flex-col justify-start items-start"
                    >
                        <Separator class="mb-2" />

                        <ToggleTheme />
                    </SheetFooter>
                </SheetContent>
            </Sheet>
        </div>

        <!-- Desktop -->
        <!-- <NavigationMenu class="hidden lg:block">
            <NavigationMenuList>
                <NavigationMenuItem>
                    <NavigationMenuTrigger class="bg-card text-base">
                        Features
                    </NavigationMenuTrigger>
                    <NavigationMenuContent>
                        <div class="grid w-[600px] grid-cols-2 gap-5 p-4">
                            <img
                                src="https://www.radix-vue.com/logo.svg"
                                alt="Beach"
                                class="h-full w-full rounded-md object-cover"
                            />
                            <ul class="flex flex-col gap-2">
                                <li
                                    v-for="{
                                        title,
                                        description,
                                    } in featureList"
                                    :key="title"
                                    class="rounded-md p-3 text-sm hover:bg-muted"
                                >
                                    <p
                                        class="mb-1 font-semibold leading-none text-foreground"
                                    >
                                        {{ title }}
                                    </p>
                                    <p
                                        class="line-clamp-2 text-muted-foreground"
                                    >
                                        {{ description }}
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </NavigationMenuContent>
                </NavigationMenuItem>

                <NavigationMenuItem>
                    <NavigationMenuLink asChild>
                        <Button
                            v-for="{ href, label } in routeList"
                            :key="label"
                            as-child
                            variant="ghost"
                            class="justify-start text-base"
                        >
                            <a :href="href">
                                {{ label }}
                            </a>
                        </Button>
                    </NavigationMenuLink>
                </NavigationMenuItem>
            </NavigationMenuList>
        </NavigationMenu> -->

        <div class="hidden lg:block">
        <form action="" method="POST">
          <div class="relative">
            <button class="absolute top-1/2 left-0 -translate-y-1/2">
              <svg
                class="fill-body hover:fill-primary dark:fill-bodydark dark:hover:fill-primary"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M9.16666 3.33332C5.945 3.33332 3.33332 5.945 3.33332 9.16666C3.33332 12.3883 5.945 15 9.16666 15C12.3883 15 15 12.3883 15 9.16666C15 5.945 12.3883 3.33332 9.16666 3.33332ZM1.66666 9.16666C1.66666 5.02452 5.02452 1.66666 9.16666 1.66666C13.3088 1.66666 16.6667 5.02452 16.6667 9.16666C16.6667 13.3088 13.3088 16.6667 9.16666 16.6667C5.02452 16.6667 1.66666 13.3088 1.66666 9.16666Z"
                  fill=""
                />
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M13.2857 13.2857C13.6112 12.9603 14.1388 12.9603 14.4642 13.2857L18.0892 16.9107C18.4147 17.2362 18.4147 17.7638 18.0892 18.0892C17.7638 18.4147 17.2362 18.4147 16.9107 18.0892L13.2857 14.4642C12.9603 14.1388 12.9603 13.6112 13.2857 13.2857Z"
                  fill=""
                />
              </svg>
            </button>

            <input
              type="text"
              placeholder="Type to search..."
              class="w-full bg-transparent pr-4 pl-9 focus:outline-none border-transparent rounded-xl"
            />
          </div>
        </form>
      </div>

        <div class="hidden lg:flex">
            <!-- <ToggleTheme /> -->

            <!-- <Button
                as-child
                size="sm"
                variant="ghost"
                aria-label="View on GitHub"
            >
                <a
                    aria-label="View on GitHub"
                    href="https://github.com/leoMirandaa/shadcn-vue-landing-page.git"
                    target="_blank"
                >
                    <GithubIcon class="size-5" />
                </a>
            </Button> -->

           
        </div>
        <div v-if="canLogin" class="hidden lg:flex">
            <!-- <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Dashboard
                </Link> -->

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

                    <DropdownHeart/>

                    <Button as-child size="sm" variant="secondary">
                        <div
                            class="rounded-md text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Orders
                        </div>
                    </Button>

                    <Button as-child size="sm" variant="outline">
                        <div
                            class="rounded-md text-black ring-1 ring-transparent transition hover:text-black focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
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
                  <Link
                        :href="route('become-a-seller')">
                <Button as-child size="sm" variant="outline">
                        <div
                            class="rounded-md text-black ring-1 ring-transparent transition hover:text-black focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white cursor-pointer"
                        >
                            Become a Seller
                        </div>
                    </Button>
                </Link>
                <Button size="sm" variant="secondary">
                    <Link
                        :href="route('login')"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Log in
                    </Link>
                </Button>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Register
                </Link>
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
</style>
