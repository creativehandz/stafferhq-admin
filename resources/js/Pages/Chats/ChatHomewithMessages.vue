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
    <div class="flex flex-col w-1/4 p-4 border-r bg-gray-50">
      <!-- Dropdown and Search -->
      <div class="flex items-center justify-between mb-6">
        <button class="flex items-center justify-between px-4 py-2 text-orange-700 bg-orange-100 border rounded-full">
          <span>Unread</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </button>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 11-5.8 0 .75.75 0 01.82-1.28A6.5 6.5 0 1017.5 9.75.75.75 0 0116 9V5.5a.75.75 0 011.5 0v4.25A7.98 7.98 0 0112.9 14.32zM9 12.75v1.5a.75.75 0 01-1.5 0v-1.5H6a.75.75 0 110-1.5H7.5V9.75a.75.75 0 011.5 0v1.5H9a.75.75 0 010 1.5z" />
        </svg>
      </div>

      <!-- Message List -->
      <ul class="space-y-4">
        <li v-for="message in messages" :key="message.id" class="flex items-center justify-between cursor-pointer">
          <div class="flex items-center space-x-3">
            <img :src="bigIcon" alt="User Avatar" class="w-10 h-10 rounded-full">
            <div>
              <p class="font-semibold">{{ message.username }}</p>
              <span class="text-sm text-gray-500">{{ message.status }}</span>
            </div>
          </div>
          <div class="text-right">
            <p class="text-sm text-gray-400">{{ message.timeAgo }}</p>
            <span v-if="message.unread" class="px-2 text-sm text-white bg-orange-500 rounded-full">{{ message.unread }}</span>
          </div>
        </li>
      </ul>
    </div>

    <!-- Conversation Area -->
    <div class="flex flex-col w-2/4 p-6 border-r">
      <div class="flex items-center justify-between pb-4 mb-4 border-b">
        <div>
          <h2 class="text-lg font-semibold">{{ selectedMessage.username }}</h2>
          <p class="text-sm text-gray-500">Last seen: {{ selectedMessage.lastSeen }}</p>
        </div>
        <div class="flex items-center space-x-3">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v2m0 8v2m-6-6h2m8 0h2" />
          </svg>
        </div>
      </div>

      <!-- Message Display -->
      <div class="flex-1 overflow-y-auto">
        <div v-for="msg in selectedMessage.conversation" :key="msg.id" class="mb-4">
          <p class="font-semibold">{{ msg.sender }}</p>
          <p class="text-gray-500">{{ msg.message }}</p>
        </div>
      </div>

      <!-- Message Input -->
      <div class="mt-4">
        <input type="text" placeholder="Send a message" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500">
        <button class="px-6 py-2 mt-2 text-white bg-orange-500 rounded-full hover:bg-orange-600">Send</button>
      </div>
    </div>

    <!-- User Profile -->
    <div class="flex flex-col items-center w-1/4 p-6">
      <img :src="bigIcon" alt="User Avatar" class="w-24 h-24 mb-4 rounded-full">
      <h3 class="text-xl font-semibold">{{ selectedMessage.username }}</h3>
      <p class="mt-2 text-gray-500">Joined {{ selectedMessage.joined }}</p>
      <p class="text-gray-500">{{ selectedMessage.projects }} completed projects</p>
    </div>
  </div>

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
import { ref } from 'vue';

// Mock Data for messages
const messages = ref([
  { id: 1, username: 'username4235', status: 'online', timeAgo: '1 day ago', unread: 3 },
  { id: 2, username: 'username4224682', status: 'online', timeAgo: '1 day ago', unread: 2 },
  { id: 3, username: 'username4436', status: 'online', timeAgo: '1 day ago', unread: null },
  { id: 4, username: 'username4b535', status: 'offline', timeAgo: '1 day ago', unread: 4 }
]);

const selectedMessage = ref({
  username: 'username4235',
  lastSeen: '12 September 2024',
  joined: '2013',
  projects: 44,
  conversation: [
    { id: 1, sender: 'username4235', message: 'Aenean nec gravida purus. Proin consectetur sit amet mauris.' },
    { id: 2, sender: 'username4235', message: 'Molestie cous non felis ultrices tempus.' },
    { id: 3, sender: 'username4235', message: 'Morbi ullamcorper dapibus tempor.' }
  ]
});
</script>