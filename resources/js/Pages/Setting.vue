<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import { ref } from "vue";
import ProfileCard from "@/Components/ProfileCard.vue";

const pageTitle = ref("Setting");

import { defineProps } from 'vue';


// Define the Resume interface
interface Resume {
  name: string;
  occupation: string;
  about: string;
  phone: string;
  email: string;
  social_links: string[]; // Assuming this is a JSON string or similar
  age: number;
  citizen: string;
  address: string;
  favorate_quote: string;
  expertise: string;
  what_i_do: string[];
  skills: string[];
  educations: string[];
  experiences: string[];
  projects: string[];
}

// Define props from Inertia
const props = defineProps<{
  resume: Resume;
}>();


</script>

<template>
    <Head title="Setting" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Setting
            </h2>
        </template>

        <BreadcrumbDefault :pageTitle="pageTitle" />

        <ProfileCard
            :name="props.resume.name"
            :occupation="props.resume.occupation"
            :about="props.resume.about"
            :phone="props.resume.phone"
            :email="props.resume.email"
            :social_links="props.resume.social_links"
            :age="props.resume.age"
            :citizen="props.resume.citizen"
            :address="props.resume.address"
            :favorate_quote="props.resume.favorate_quote"
            :expertise="props.resume.expertise"
            :what_i_do="props.resume.what_i_do"
            :skills="props.resume.skills"
            :educations="props.resume.skills"
            :experiences="props.resume.experiences"
            :projects="props.resume.projects"
        />


      
    </AuthenticatedLayout>
</template>
