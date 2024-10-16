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
    
    <CategoryTile/>
    <ReferralHero/>
    <ReferralMail/>
    <Rewards/>
    <Footer/>
    </div>

</template>

<script setup lang="ts">
import Footer from '@/Components/LandingPage/Footer.vue';
import CategoryTile from '../BuyerProfile/CategoryTile.vue';
import DropdownNotification from '@/Components/Header/DropdownNotification.vue';
import DropdownMessage from '@/Components/Header/DropdownMessage.vue';
import DropdownHeart from '@/Components/Header/DropdownHeart.vue';
import DropdownUserTwo from '@/Components/Header/DropdownUserTwo.vue';
import Rewards from './Rewards.vue';
import ReferralHero from './ReferralHero.vue';
import ReferralMail from './ReferralMail.vue';
</script>