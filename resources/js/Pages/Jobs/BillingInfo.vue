<template>
    <div class="fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50">
      <div class="w-full max-w-lg p-8 bg-white rounded-lg shadow-lg">
        <h2 class="mb-6 text-xl font-bold">Billing Information</h2>
        
        <!-- Full Name -->
        <div class="mb-4">
          <label class="block font-light text-gray-700">Full name (mandatory)</label>
          <input
            v-model="form.fullName"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-500"
            placeholder="Full name"
          />
        </div>
  
        <!-- Company Name -->
        <div class="mb-4">
          <label class="block font-medium text-gray-700">Company name</label>
          <input
            v-model="form.companyName"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-500"
            placeholder="Company name"
          />
        </div>
  
        <!-- Country -->
        <div class="mb-4">
          <label class="block font-medium text-gray-700">Country</label>
          <select
            v-model="form.country"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-500"
          >
            <option value="India">India</option>
            <!-- Add more options if needed -->
          </select>
        </div>
  
        <!-- State -->
        <div class="mb-4">
          <label class="block font-medium text-gray-700">State/Union territory (mandatory)</label>
          <select
            v-model="form.state"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-500"
          >
            <option value="Rajasthan">Rajasthan</option>
            <!-- Add more states if needed -->
          </select>
        </div>
  
        <!-- Address -->
        <div class="mb-4">
          <label class="block font-medium text-gray-700">Address</label>
          <input
            v-model="form.address"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-500"
            placeholder="Street or POB"
          />
        </div>
  
        <!-- City and Postal Code -->
        <div class="flex mb-4">
          <div class="w-1/2 pr-2">
            <label class="block font-medium text-gray-700">City</label>
            <input
              v-model="form.city"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-500"
              placeholder="City"
            />
          </div>
          <div class="w-1/2 pl-2">
            <label class="block font-medium text-gray-700">Postal code</label>
            <input
              v-model="form.postalCode"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-500"
              placeholder="Postal code"
            />
          </div>
        </div>
  
        <!-- Citizen/Resident of India -->
        <div class="mb-4">
          <label class="block font-medium text-gray-700">Are you a citizen/resident of India? (mandatory)</label>
          <div class="flex items-center">
            <input
              v-model="form.isCitizen"
              type="radio"
              value="yes"
              class="mr-2"
            /> Yes
            <input
              v-model="form.isCitizen"
              type="radio"
              value="no"
              class="ml-6 mr-2"
            /> No
          </div>
        </div>
  
        <!-- Registered for GST -->
        <div class="mb-4">
          <label class="block font-medium text-gray-700">Are you registered for India GST? (mandatory)</label>
          <div class="flex items-center">
            <input
              v-model="form.isGstRegistered"
              type="radio"
              value="yes"
              class="mr-2"
            /> Yes
            <input
              v-model="form.isGstRegistered"
              type="radio"
              value="no"
              class="ml-6 mr-2"
            /> No
          </div>
        </div>
  
        <!-- GSTIN Number -->
        <div class="mb-4">
          <label class="block font-medium text-gray-700">GSTIN number</label>
          <input
            v-model="form.gstinNumber"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-500"
            placeholder="GSTIN number"
          />
        </div>
  
        <!-- TCS Under GST Tax Category -->
        <div class="mb-4">
          <label class="block font-medium text-gray-700">What is your ‘TCS under GST’ tax category? (mandatory)</label>
          <select
            v-model="form.taxCategory"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-500"
          >
            <option value="Taxable">Taxable</option>
            <!-- Add more options if needed -->
          </select>
        </div>
  
        <!-- Invoices -->
        <div class="flex items-center mb-4">
          <input
            v-model="form.wantInvoices"
            type="checkbox"
            class="mr-2"
          />
          <label class="text-gray-700">I want to get invoices via email as well.</label>
        </div>
  
        <!-- Buttons -->
        <div class="flex justify-end">
          <button
            @click="cancel"
            class="px-4 py-2 mr-2 text-white bg-gray-400 rounded-lg hover:bg-gray-500"
          >Cancel</button>
          <button
            @click="save"
            class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700"
          >Save</button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import { reactive } from 'vue';
  
  const form = reactive({
    fullName: '',
    companyName: '',
    country: 'India',
    state: 'Rajasthan',
    address: '',
    city: '',
    postalCode: '',
    isCitizen: 'yes',
    isGstRegistered: 'no',
    gstinNumber: '',
    taxCategory: 'Taxable',
    wantInvoices: false
  });
  
  const cancel = () => {
    // Logic to handle cancel action
    console.log('Form canceled');
  };
  
  const save = () => {
    // Logic to handle save action
    console.log('Form data saved:', form);
  };
  </script>
  
  <style scoped>
  /* Additional styling, if needed */
  </style>
  