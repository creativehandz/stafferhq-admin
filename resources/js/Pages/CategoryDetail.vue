<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";

import Navbar from "@/Components/LandingPage/Navbar.vue";
import Footer from "@/Components/LandingPage/Footer.vue";
import FAQTwo from "@/Components/LandingPage/FAQTwo.vue";
import Tags from "@/Components/LandingPage/Tags.vue";
import SlidingCard from "@/Components/LandingPage/SlidingCard.vue";
import CategoryHeader from "@/Components/LandingPage/CategoryHeader.vue";
import FlexCard from "@/Components/LandingPage/FlexCard.vue";
import {
    Avatar,
    AvatarFallback,
    AvatarImage,
} from "@/Components/LandingPage/ui/avatar";

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
    category: Category;
    canLogin?: boolean;
    canRegister?: boolean;
}>();

interface FAQProps {
    question: string;
    answer: string;
    value: string;
}

const FAQList: FAQProps[] = [
    {
        question: "Is this template free?",
        answer: "Yes. It is a free Shadcn/Vue template.",
        value: "item-1",
    },
    {
        question: "Duis aute irure dolor in reprehenderit in voluptate velit?",
        answer: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint labore quidem quam consectetur sapiente, iste rerum reiciendis animi nihil nostrum sit quo, modi quod.",
        value: "item-2",
    },
    {
        question:
            "Lorem ipsum dolor sit amet Consectetur natus dolor minus quibusdam?",
        answer: "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Labore qui nostrum reiciendis veritatis.",
        value: "item-3",
    },
    {
        question: "Excepteur sint occaecat cupidata non proident sunt?",
        answer: "Lorem ipsum dolor sit amet consectetur, adipisicing elit.",
        value: "item-4",
    },
    {
        question:
            "Enim ad minim veniam, quis nostrud exercitation ullamco laboris?",
        answer: "consectetur adipisicing elit. Sint labore.",
        value: "item-5",
    },
];

interface TagProps {
    title: string;
}

const tagList: TagProps[] = [
    {
        title: "Custom Domain Integration",
    },
    {
        title: "Social Media Integrations",
    },
    {
        title: "Email Marketing Integrations",
    },
    {
        title: "SEO Optimization",
    },
    {
        title: "Custom Domain Integration",
    },
    {
        title: "Social Media Integrations",
    },
    {
        title: "Email Marketing Integrations",
    },
    {
        title: "SEO Optimization",
    },
];

interface PopularSubCategoryProps {
    image: string;
    name: string;
}

const popularSubCategoryList: PopularSubCategoryProps[] =
    props.category.sub_categories.map((subCategory) => ({
        image: "https://github.com/shadcn.png",
        name: subCategory.name,
    }));

function handleImageError() {
    document.getElementById("screenshot-container")?.classList.add("!hidden");
    document.getElementById("docs-card")?.classList.add("!row-span-1");
    document.getElementById("docs-card-content")?.classList.add("!flex-row");
    document.getElementById("background")?.classList.add("!hidden");
}
</script>

<template>
    <Head title="Category Detail" />
    <div class="bg-white text-black dark:bg-black-2 dark:text-white">
        <Navbar :can-login="canLogin" :can-register="canRegister" />

        <CategoryHeader :category="category.name" />

        <SlidingCard :popularSubCategoryList="popularSubCategoryList" />

        <FlexCard :category="props.category.name" />

        <section id="categories" class="container">
            <h1 class="text-title-lg font-semibold mb-5">
                Explore {{ category.name }}
            </h1>
            <ul v-if="category.sub_categories.length">
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-8"
                >
                    <li
                        v-for="subCategory in category.sub_categories"
                        :key="subCategory.id"
                    >
                        <div class="flex-col">
                            <div
                                class="h-full overflow-hidden rounded-lg border bg-card"
                            >
                                <img
                                    src="https://fiverr-res.cloudinary.com/image/upload/attachments/generic_asset/asset/c276d6e9b4859d7963688ee17dc23713-1715072487616/Blockchain%20_%20Cryptocurrency.png"
                                    alt=""
                                    class="w-full aspect-video object-cover"
                                />
                            </div>
                            <Link
                                :href="route('sellers', { id: subCategory.id })"
                            >
                                <h2
                                    class="text-title-xsm font-medium hover:text-primary mt-5"
                                >
                                    {{ subCategory.name }}
                                </h2>
                            </Link>
                        </div>
                    </li>
                </div>
            </ul>
            <p v-else>No subcategories available.</p>
        </section>

        <Tags :tagList="tagList" />
        <FAQTwo :FAQList="FAQList" />
        <Footer />
    </div>
</template>
