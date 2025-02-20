
<script setup lang="ts">
import axios from 'axios';
import { computed, ref, reactive } from 'vue';

// Define props
const props = defineProps({
  userId: Number,
  gigId: Number,
  selectedPrice: String,
  gigTitle: String,
  revisions: String,
  package: String,
  description: String,
  deliveryTime: Number,
});

// Reactive state for current step
const currentStep = ref(1);

// Function to move to the next step
const nextStep = () => {
  if (currentStep.value < 3) {
    currentStep.value++;
  }
};

// Function to move to the previous step
const previousStep = () => {
  if (currentStep.value > 1) {
    currentStep.value--;
  }
};

// Reactive form data for billing information
const form = reactive({
  fullName: '',
  companyName: '',
  country: 'Malaysia',
  state: 'Johor',
  address: '',
  city: '',
  postalCode: '',
  isCitizen: 'yes',
  isGstRegistered: 'no',
  gstinNumber: '',
  taxCategory: 'Taxable',
  wantInvoices: false,
});

// Function to handle back action
const goBack = () => {
if (currentStep.value > 1) {
  currentStep.value--;
}
};

// Function to save billing information and proceed to payment options
// Function to handle save action and send data to backend
const save = async () => {
const checkoutData = {
  user_id: props.userId,
  gig_id: props.gigId,
  order_details: {
    gigTitle: props.gigTitle,
    package: props.package,
    revisions: props.revisions,
    deliveryTime: props.deliveryTime,
    description: props.description,
  },
  package_selected: props.package,
  total_price: Number(props.selectedPrice) + 100,
};

try {
  const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

  const response = await fetch('/buyer_checkout', {
    method: 'POST',
    body: JSON.stringify(checkoutData),
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': token,
    },
  });

  if (!response.ok) {
    // Check if the response is HTML instead of JSON
    const contentType = response.headers.get('content-type');
    if (contentType && contentType.includes('application/json')) {
      const errorData = await response.json();
      throw new Error(errorData.message || 'Error saving checkout data');
    } else {
      throw new Error('Server returned an HTML page instead of JSON');
    }
  }

  const data = await response.json(); // Parse successful response
  console.log('Checkout saved successfully:', data);

  currentStep.value++;
} catch (error) {
  console.error('Error saving checkout data:', error);
}
};


// Function to confirm payment
const confirmPayment = () => {
  console.log('Payment confirmed. Total amount:', (Number(props.selectedPrice) + 100).toFixed(2));
};

// Split the description by " + " to display as separate list items
const splitDescription = computed(() => {
  return (props.description ?? '').split(' + ') || [];
});


</script>


<template>
  <div class="container">
    <div class="flex justify-center">
    <!-- Step 1: Confirmation of Total -->
    <div v-if="currentStep === 1" class="w-full max-w-sm p-6 bg-white border rounded-lg shadow-lg">
      <div class="flex items-center mb-4">
        <img src="https://via.placeholder.com/80" alt="Service logo" class="w-12 h-12 mr-3 rounded" />
        <div>
          <h2 class="text-sm font-bold">{{ gigTitle }}</h2>
        </div>
      </div>
      
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold">{{ package }}</h3>
        <p>${{ selectedPrice }}</p>
      </div>

      <ul class="space-y-2 text-gray-600 list-disc list-inside">
        <li>Revisions: {{ revisions }}</li>        
        <li v-for="(desc, index) in splitDescription" :key="index">{{ desc }}</li>
      </ul>

      <div class="flex items-center justify-between mt-4 text-gray-600">
        <p>Service fee</p>
        <p>$100</p>
      </div>

      <div class="flex items-center justify-between mt-2 text-xl font-bold">
        <p>Total</p>
        <p>{{ (Number(selectedPrice) + 100).toFixed(2) }}</p>
      </div>

      <div class="flex items-center justify-between mt-2 text-sm text-gray-600">
        <p>Total delivery time</p>
        <p>{{ deliveryTime }}</p>
      </div>

      <button
        @click="nextStep"
        class="w-full py-3 mt-4 font-bold text-white transition bg-black rounded-lg hover:bg-gray-800"
      >
        Continue to Billing Info
      </button>
    </div>

    <!-- Step 2: Billing Information -->
    <div v-if="currentStep === 2" class="w-full max-w-lg p-8 bg-white rounded-lg shadow-lg">
      <h2 class="mb-6 text-xl font-bold">Billing Information</h2>
      <!-- Full Name -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">Full name (mandatory)</label>
        <input v-model="form.fullName" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Full name" />
      </div>

      <!-- Company Name -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">Company name</label>
        <input v-model="form.companyName" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Company name" />
      </div>

      <!-- Country -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">Country</label>
        <select v-model="form.country" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
          <option value="Malaysia">Malaysia</option>
          <!-- Add more options if needed -->
        </select>
      </div>

      <!-- State -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">State/Union territory (mandatory)</label>
        <select v-model="form.state" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
          <option value="Johor">Johor</option>
          <option value="Kedah">Kedah</option>
          <option value="Kelantan">Kelantan</option>
          <option value="Malacca">Malacca</option>
          <option value="Negeri Sembilan">Negeri Sembilan</option>
          <option value="Pahang">Pahang</option>
          <option value="Penang">Penang</option>
          <option value="Perak">Perak</option>
          <option value="Perlis">Perlis</option>
          <option value="Sabah">Sabah</option>
          <option value="Sarawak">Sarawak</option>
          <option value="Selangor">Selangor</option>
          <option value="Terengganu">Terengganu</option>
          <option value="Kuala Lumpur">Kuala Lumpur (Federal Territory)</option>
          <option value="Labuan">Labuan (Federal Territory)</option>
          <option value="Putrajaya">Putrajaya (Federal Territory)</option>

          <!-- Add more states if needed -->
        </select>
      </div>

      <!-- Address -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">Address</label>
        <input v-model="form.address" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Street or POB" />
      </div>

      <!-- City -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">City</label>
        <input v-model="form.city" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="City" />
      </div>

      <!-- Postal Code -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">Postal code</label>
        <input v-model="form.postalCode" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Postal code" />
      </div>

      <!-- Citizen/Resident of India -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">Are you a citizen/resident of India? (mandatory)</label>
        <div class="flex items-center">
          <input v-model="form.isCitizen" type="radio" value="yes" class="mr-2" /> Yes
          <input v-model="form.isCitizen" type="radio" value="no" class="ml-6 mr-2" /> No
        </div>
      </div>

      <!-- Registered for GST -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">Are you registered for India GST? (mandatory)</label>
        <div class="flex items-center">
          <input v-model="form.isGstRegistered" type="radio" value="yes" class="mr-2" /> Yes
          <input v-model="form.isGstRegistered" type="radio" value="no" class="ml-6 mr-2" /> No
        </div>
      </div>

      <!-- GSTIN Number -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">GSTIN number{{userId}}</label>
        <input v-model="form.gstinNumber" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="GSTIN number" />
      </div>

      <!-- TCS Under GST Tax Category -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">What is your ‘TCS under GST’ tax category? (mandatory)</label>
        <select v-model="form.taxCategory" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
          <option value="Taxable">Taxable</option>
          <!-- Add more options if needed -->
        </select>
      </div>

      <!-- Invoices -->
      <div class="flex items-center mb-4">
        <input v-model="form.wantInvoices" type="checkbox" class="mr-2" />
        <label class="text-gray-700">I want to get invoices via email as well.</label>
      </div>

      <!-- Buttons -->
      <div class="flex justify-between">
        <button
          @click="previousStep"
          class="px-4 py-2 text-black bg-gray-400 rounded-lg hover:bg-gray-500"
        >
          Back
        </button>
        <button
          @click="save"
          class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700"
        >
          Complete Checkout 
        </button>
      </div>
    </div>

    <!-- Step 3: Payment Options -->
    <div v-if="currentStep === 3" class="w-full max-w-lg p-8 bg-white rounded-lg shadow-lg">
      <h2 class="mb-6 text-xl font-bold">Payment Options</h2>
      <!-- Add your payment options UI here -->
      <p>Please select your payment method:</p>
      <div class="mb-4">
        <input type="radio" id="creditCard" value="credit" class="mr-2" />
        <label for="creditCard">Credit Card</label>
      </div>
      <div class="mb-4">
        <input type="radio" id="paypal" value="paypal" class="mr-2" />
        <label for="paypal">PayPal</label>
      </div>
      <!-- Back Button -->
      <div class="flex justify-between">
        <button
          @click="previousStep"
          class="px-4 py-2 text-black bg-gray-400 rounded-lg hover:bg-gray-500"
        >
          Back
        </button>
        <button
          @click="confirmPayment"
          class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700"
        >
          Complete Checkout
        </button>
      </div>
    </div>
  </div>
  </div>
</template>


<style scoped>
/* Add any custom styles if needed */
</style>
