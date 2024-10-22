<template>
    <div class="container">
        <BuyerNavbar/>
         <!-- BreadCrumbs -->
    <div class="text-sm leading-none">
        <a href="/"><span>Home /</span>   </a>   
       <a href="/referral"> <span> Referral </span></a>
      </div>
    
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
import BuyerNavbar from '../BuyerNavbar.vue';
</script>