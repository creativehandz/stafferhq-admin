<template>

    <div class="p-6 mx-auto bg-white rounded-md shadow-md w-100">
      <!-- Invite friends through email -->
      <div class="mb-6 text-black">
        <label class="block mb-2 font-semibold ">Invite friends through email</label>
        <div class="flex items-center space-x-2">
          <input
            type="text"
            v-model="email"
            placeholder="Add Email addresses"
            class="flex-grow p-2 border rounded-lg"
          />
          <button
            @click="sendEmail"
            class="px-4 py-2 font-semibold text-white bg-black rounded-lg"
          >
            Send
          </button>
        </div>
        <p class="mt-2 text-sm text-gray-500">Separate emails with commas</p>
        <a href="#" class="text-sm text-gray-500 underline">Preview Email</a>
      </div>
  
      <!-- Share personal referral link -->
      <div>
        <label class="block mb-2 font-semibold text-black">
          Or share your personal referral link
        </label>
        <div class="flex items-center mb-4 space-x-2">
          <input
            type="text"
            v-model="referralLink"
            readonly
            class="flex-grow p-2 border rounded-lg"
          />
          <button
            @click="copyLink"
            class="px-4 py-2 text-sm font-semibold text-black bg-gray-200 rounded-lg"
          >
            Copy
          </button>
        </div>
  
        <!-- Social Media Sharing Buttons -->
        <div class="flex space-x-4">
          <a href="#" class="flex items-center p-2 text-white bg-blue-600 rounded-lg">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#" class="flex items-center p-2 text-white bg-black rounded-lg">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#" class="flex items-center p-2 text-white bg-green-500 rounded-lg">
            <i class="fab fa-whatsapp"></i>
          </a>
          <a href="#" class="flex items-center p-2 text-white bg-blue-700 rounded-lg">
            <i class="fab fa-linkedin-in"></i>
          </a>
        </div>
      </div>
    </div>

  </template>
  
  <script setup lang="ts">
  import { ref } from 'vue';
  
  const email = ref('');
  const referralLink = ref('https://www.fiverr.com/pe/your-referral-link');
  
  const sendEmail = () => {
    alert(`Sending referral to: ${email.value}`);
  };
  
  const copyLink = () => {
    navigator.clipboard.writeText(referralLink.value);
    alert('Referral link copied to clipboard');
  };
  </script>
  
  <style scoped>
  /* Add icons from Font Awesome or similar for the social media icons */
  @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
  </style>
  