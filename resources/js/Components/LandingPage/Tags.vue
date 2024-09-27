<script setup lang="ts">
import { Badge } from "@/Components/LandingPage/ui/badge";


interface TagProps {
    title: string;
}

defineProps<{
    tagList: TagProps[]
}>();


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
</script>

<template>
    <section id="services" class="container py-24 sm:py-32">
        <h2 class="text-lg text-primary text-center mb-2 tracking-wider">
            Tags
        </h2>

        <h2 class="text-3xl md:text-4xl text-center font-bold mb-10">
            You might be interested in
        </h2>

        <div class="flex flex-wrap gap-4 w-full mx-auto">
            <div v-for="{ title } in tagList" :key="title">
                <Badge variant="secondary" class="">{{ title }}</Badge>
            </div>
        </div>
    </section>
</template>
