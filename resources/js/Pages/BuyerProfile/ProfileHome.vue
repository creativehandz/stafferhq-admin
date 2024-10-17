<template>
    <div class="container">
        <!-- Navbar starts -->
        <div class="flex items-center justify-between py-5">
        <!-- Logo Button -->
        <button>
            <a href="/"> <img src="../../../img/toworkLogo.svg" alt="Logo" /></a>
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
                    <img src="../../../img/mag-glass.png" alt="search" class="w-5 h-5" />
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

    <!-- BreadCrumbs -->
    <div class="text-sm leading-none">
        <a href="/"><span>Home /</span>   </a>   
       <a href="/buyer-profile"> <span> Profile </span></a>
      </div>
     
    <!-- Categories and Subcategories Dropdown -->
    <CategoryTile />

    <!-- Hero section starts -->

    <div class="mt-5 mb-5 bg-white rounded-lg shadow-lg  p-14">
    <!-- Left Sidebar -->
        <div class="flex flex-col gap-6 md:flex-row">
            <div class="flex-shrink-0 w-full md:w-1/3">
                <div class="text-center">
                <!-- Profile Picture -->
                <img
                    class="w-24 h-24 mx-auto rounded-full"
                    src="https://via.placeholder.com/150"
                    alt="Profile Picture"
                />
                <h2 class="mt-4 leading-none sm:text-[18px] md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px] text-black">{{ $page.props.auth.user.name }}</h2>
                <p class="text-black">@username</p>
                </div>

                <!-- Location, Joined Date, Languages -->
                <div class="mt-6 space-y-3 text-sm text-black leading-none sm:text-[18px] md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px]">
                <div class="flex items-center gap-2">
                    <span class="material-icons">location_on</span>
                    <p>Located in India</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-icons">calendar_today</span>
                    <p>Joined in March 2024</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-icons">language</span>
                    <p>English (Fluent), Hindi (Native/Bilingual)</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-icons">schedule</span>
                    <p>Preferred working hours</p>
                </div>
                </div>

                <!-- Buttons -->
                <div class="mt-8">
                <button class="w-full px-4 py-2 text-sm font-semibold border rounded-2xl leading-none sm:text-[16px]  md:text-[16px] lg:text-[16px] xl:text-[16px] 2xl:text-[16px]">
                    👁️ Preview public profile
                </button>
                <button class="w-full px-4 py-2 mt-4 text-sm font-semibold text-blue-500 border border-blue-500 rounded-2xl hover:bg-blue-50">
                    Explore Fiverr ➡️
                </button>
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
                    <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-icons">check_circle</span>
                        <p class="text-black leading-none sm:text-[16px]  md:text-[16px] lg:text-[16px] xl:text-[16px] 2xl:text-[16px]" >Share how you plan to use Fiverr</p>
                    </div>
                    <span>✔️</span>
                    </div>
                    <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-icons">pending</span>
                        <p class="leading-none sm:text-[16px]  md:text-[16px] lg:text-[16px] xl:text-[16px] 2xl:text-[16px] text-black">Set your communication preferences</p>
                    </div>
                    <span>50%</span>
                    </div>
                </div>
                </div>

                <!-- Reviews from freelancers -->
                <div class="space-y-4">
                <h2 class="text-black font-bold leading-none sm:text-[20px]  md:text-[20px] lg:text-[20px] xl:text-[20px] 2xl:text-[20px] ">Reviews from freelancers</h2>
                <div class="p-6 text-center text-black leading-none sm:text-[16px]  md:text-[16px] lg:text-[16px] xl:text-[16px] 2xl:text-[16px] rounded-lg bg-gray-50">
                    <p>{{ $page.props.auth.user.name }} doesn't have any reviews yet.</p>
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

</script>