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

    <div class="flex">
        <!-- Sidebar -->
        <div class="flex flex-col items-center w-1/4 bg-gray-50">
        <!-- All Messages Dropdown -->
        <div class="flex w-full gap-3">
            <button class="flex items-center justify-between w-full px-4 py-2 text-black bg-orange-100 border rounded-full shadow-md">
                <span>All messages</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
            <button type="submit">
                    <img src="../../../img/mag-glass.png" alt="search" class="w-5 h-5" />
            </button>
        </div>

        <!-- No Messages -->
        <div class="w-full mt-8 text-center border p-18 rounded-3xl h-80">
            <p class="text-gray-500">No messages.</p>
            <div class="mt-2 mb-2 pl-15" ><img :src="chatBubble" alt=""  ></div>
            <a href="#" class="text-orange-500 underline">View all</a>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex items-center justify-center w-3/4 p-6 ml-2 bg-white border rounded-3xl">
      <div class="flex flex-col items-center">
        <!-- Inbox Image -->
        <img :src="inbox" alt="Inbox" class="h-48 mb-6" />
        <p class="text-center text-gray-500 w-55">When you start conversations with other users, you'll be able to access them here.</p>
      </div>
    </div>
  </div>
<!-- <ChatHomewithMessages/> -->
     <Footer/>
    </div>    
</template>


<script setup lang="ts">
import inbox from '@/assets/inbox.png';
import bigIcon from '@/assets/big-profile.png';
import Navbar from '@/Components/LandingPage/Navbar.vue';
import chatBubble from '@/assets/chat-bubble-vector.svg';
import DropdownUserTwo from '@/Components/Header/DropdownUserTwo.vue';
import DropdownHeart from '@/Components/Header/DropdownHeart.vue';
import DropdownMessage from '@/Components/Header/DropdownMessage.vue';
import DropdownNotification from '@/Components/Header/DropdownNotification.vue';
import Footer from '@/Components/LandingPage/Footer.vue';
import ChatHomewithMessages from './ChatHomewithMessages.vue';
</script>