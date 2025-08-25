<template>
    <div class="container">
      <BuyerNavbar/>

    <!-- BreadCrumbs                 <h1 class="text-2xl text-black font-semibold leading-none sm:text-[32px]  md:text-[32px] lg:text-[32px] xl:text-[32px] 2xl:text-[32px] ">
                Hi 👋 {{ props.user.name }}, let's help freelancers get to know you
                </h1>
    <div class="text-sm leading-none">
        <a href="/"><span>Home /</span>   </a>   
       <a href="/buyer-profile"> <span> Profile </span></a>
      </div>
     
    <!-- Categories and Subcategories Dropdown -->
    <CategoryTile />

    <!-- Hero section starts -->

    <div class="mt-5 mb-5 bg-white rounded-lg shadow-lg p-14">
    <!-- Left Sidebar -->
        <div class="flex flex-col gap-6 md:flex-row">
            <div class="flex-shrink-0 w-full md:w-1/3">
                <div class="text-center">
                <!-- Profile Picture -->
                <img
                    class="w-24 h-24 mx-auto rounded-full object-cover"
                    :src="props.user.profile_image ? `/${props.user.profile_image}` : 'https://via.placeholder.com/150'"
                    alt="Profile Picture"
                />
                <h2 class="mt-4 leading-none sm:text-[18px] md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px] text-black">{{ props.user.name }}</h2>
                <p class="text-black">@username</p>
                </div>

                <!-- Location, Joined Date, Languages -->
                <div class="mt-6 space-y-3 text-sm text-black leading-none sm:text-[18px] md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px]">
                <div class="flex items-center gap-2" v-if="props.user.location">
                    <span class="material-icons">location_on</span>
                    <p>Located in {{ props.user.location }}</p>
                </div>
                <div class="flex items-center gap-2" v-else>
                    <span class="material-icons">location_on</span>
                    <p>Location not set</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-icons">calendar_today</span>
                    <p>Joined in {{ formatJoinDate(props.user.created_at) }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-icons">language</span>
                    <p>English (Fluent), Hindi (Native/Bilingual)</p>
                </div>
                <div class="flex items-center gap-2" v-if="props.user.phone">
                    <span class="material-icons">phone</span>
                    <p>{{ props.user.phone }}</p>
                </div>
                <div class="flex items-center gap-2" v-if="props.user.website">
                    <span class="material-icons">web</span>
                    <a :href="props.user.website" target="_blank" class="text-blue-600 hover:underline">{{ props.user.website }}</a>
                </div>
                </div>

                <!-- Interested Categories -->
                <div v-if="props.userCategories && props.userCategories.length > 0" class="mt-6">
                <h3 class="text-sm font-semibold text-black mb-3">Interested Categories</h3>
                <div class="flex flex-wrap gap-2">
                    <span
                    v-for="category in props.userCategories"
                    :key="category.id"
                    class="inline-block px-3 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full"
                    >
                    {{ category.name }}
                    </span>
                </div>
                </div>

                <!-- Buttons -->
                <div class="mt-8">
                <a
                    href="/buyer-profile/edit"
                    class="block w-full px-4 py-2 text-sm font-semibold text-center text-white bg-blue-600 rounded-2xl hover:bg-blue-700 transition duration-200"
                >
                    ✏️ Edit Profile
                </a>
                </div>

                <!-- Seller Mode -->
                <p class="mt-8 text-black text-left leading-none sm:text-[18px]  md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px] ">
                You’re currently on your buyer profile. To access your freelancer profile, switch to seller mode.
                </p>
            </div>

            <!-- Right Sidebar -->
            <div class="flex-grow space-y-6">
                <h1 class="text-2xl text-black font-semibold leading-none sm:text-[32px]  md:text-[32px] lg:text-[32px] xl:text-[32px] 2xl:text-[32px] ">
                Hi 👋 Let’s help freelancers get to know you
                </h1>
                <p class=" sm:text-[20px]  md:text-[20px] lg:text-[20px] xl:text-[20px] 2xl:text-[20px] text-left text-black">
                Get the most out of Fiverr by sharing a bit more about yourself and how you prefer to work with freelancers.
                </p>

                <!-- Profile Checklist -->
                <div class="p-6 space-y-4 bg-gray-100 rounded-lg">
                <div class="flex items-center justify-between">
                    <p class="text-black leading-none sm:text-[16px]  md:text-[16px] lg:text-[16px] xl:text-[16px] 2xl:text-[16px]">Profile checklist</p>
                    <span>67%</span>
                </div>
                <div class="relative w-full h-2 rounded-full">
                    <div class="absolute top-0 h-2 bg-blue-600 rounded-full" style="width: 67%;"></div>
                </div>

                <div class="space-y-4">
                    <!-- Profile checklist items removed as requested -->
                </div>
                </div>

                <!-- Reviews from freelancers -->
                <div class="space-y-4">
                <h2 class="text-black font-bold leading-none sm:text-[20px]  md:text-[20px] lg:text-[20px] xl:text-[20px] 2xl:text-[20px] ">Reviews from freelancers</h2>
                <div class="p-6 text-center text-black leading-none sm:text-[16px]  md:text-[16px] lg:text-[16px] xl:text-[16px] 2xl:text-[16px] rounded-lg bg-gray-50">
                    <p>{{ props.user.name }} doesn't have any reviews yet.</p>
                </div>
                </div>
            </div>
        </div>
  </div>
    
    <!-- Hero section ends -->
<Footer/>
</div>
</template>

<script setup lang="ts">
import DropdownHeart from '@/Components/Header/DropdownHeart.vue';
import DropdownMessage from '@/Components/Header/DropdownMessage.vue';
import DropdownNotification from '@/Components/Header/DropdownNotification.vue';
import DropdownUserTwo from '@/Components/Header/DropdownUserTwo.vue';
import Footer from '@/Components/LandingPage/Footer.vue';
import CategoryTile from './CategoryTile.vue';
import BuyerNavbar from '../BuyerNavbar.vue';

interface User {
    id: number
    name: string
    email: string
    phone?: string
    website?: string
    company_size?: string
    location?: string
    profile_image?: string
    created_at: string
    [key: string]: any
}

interface Category {
    id: number
    name: string
}

interface Props {
    user: User
    userCategories?: Category[]
}

const props = defineProps<Props>()

const formatJoinDate = (dateString: string) => {
    const date = new Date(dateString)
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'long' 
    })
}

</script>