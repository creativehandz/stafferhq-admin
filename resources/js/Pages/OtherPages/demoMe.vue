<script setup lang="ts">
import DropdownHeart from '@/Components/Header/DropdownHeart.vue';
import DropdownMessage from '@/Components/Header/DropdownMessage.vue';
import DropdownNotification from '@/Components/Header/DropdownNotification.vue';
import DropdownUserTwo from '@/Components/Header/DropdownUserTwo.vue';
import Footer from '@/Components/LandingPage/Footer.vue';
import axios from 'axios';
import { ref, computed, onMounted } from 'vue';

// State for gig quantity
const quantity = ref(1);
const step = ref(1); // Track the current step

// State for extras
const extraFastDelivery = ref(false);
const includeSourceFile = ref(false);

// Billing information
const billingInfo = ref({
  name: '',
  email: '',
  address: '',
});

// Prices
const basePrice = 3972;
const extraFastPrice = 1324;
const includeSourcePrice = 1765;

// Computed property to calculate the total
const total = computed(() => {
  let totalAmount = basePrice * quantity.value;
  if (extraFastDelivery.value) totalAmount += extraFastPrice;
  if (includeSourceFile.value) totalAmount += includeSourcePrice;
  return totalAmount;
});

// Methods to increase/decrease quantity
const increaseQuantity = () => {
  quantity.value++;
};

const decreaseQuantity = () => {
  if (quantity.value > 1) {
    quantity.value--;
  }
};

// Reset the form when closed
const resetForm = () => {
  step.value = 1;
  quantity.value = 1;
  billingInfo.value = { name: '', email: '', address: '' };
};

// Simulate order submission
const submitOrder = () => {
  alert('Order confirmed!');
  resetForm();
};


// Define props
interface User {
id: number;
name: string;
}

interface PricingDetail {
price: number;
}

interface Pricing {
basic: PricingDetail;
standard: PricingDetail;
premium: PricingDetail;
}

interface Gig {
id: number;
gig_title: string;
gig_description: string;
pricing: Pricing;
user: User;
}
const gigs = ref<Gig[]>([]);

// Fetch gigs from the backend
const fetchGigs = async () => {
try {
  const response = await axios.get('/gigs');
  gigs.value = response.data;
} catch (error) {
  console.error('Error fetching gigs:', error);
}
};

// Fetch gigs on component mount
onMounted(() => {
fetchGigs();
});

const showPopup = ref(false); // Controls the visibility of the popup

// Method to toggle the popup visibility
const togglePopup = () => {
showPopup.value = !showPopup.value;
};

// Method to handle saving the form
const save = () => {
alert('Saved: ' + JSON.stringify(form.value));
showPopup.value = false; // Close the popup after saving
};

// Method to handle cancelling the form
const cancel = () => {
showPopup.value = false; // Close the popup without saving
};
const form = ref({
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


const isOrderStartable = false;
</script>


<template>
    <div class="container flex flex-col justify-center p-10">
              <!-- Navbar -->
      <div class="relative z-10 flex items-center justify-between py-5">
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
    <div class="p-4 border rounded-md shadow-md">
      <!-- Header with close button -->
      <div class="flex items-center justify-between pb-4 border-b">
        <h2 class="text-lg font-semibold">Order options{{  }}</h2>
        <button class="text-xl" @click="resetForm">&times;</button>
      </div>
  
      <!-- Step Navigation -->
      <div class="flex mb-4 space-x-2">
        <button :class="step === 1 ? 'font-bold' : ''" @click="step = 1">Order Details</button>
        <button :class="step === 2 ? 'font-bold' : ''" @click="step = 2">> Confirm & Pay</button>
        <button :class="step === 3 ? 'font-bold' : ''" @click="step = 3">> Submit Requirements</button>
      </div>
  
      <!-- Step 1: Gig Selection -->
      <div v-if="step === 1">
        <h3 class="font-bold text-md">Basic</h3>
        <p class="text-sm text-gray-500">
            <div v-for="gig in gigs" >
                {{gig.gig_title}} 
            </div>
         
        </p>
        <div class="text-lg font-semibold">₹3,972</div>
  
        <!-- Quantity selector -->
        <div class="flex items-center justify-between mt-4">
          <label class="text-sm text-gray-500">Gig Quantity</label>
          <div class="flex items-center space-x-2">
            <button @click="decreaseQuantity" class="px-2 py-1 border">-</button>
            <span>{{ quantity }}</span>
            <button @click="increaseQuantity" class="px-2 py-1 border">+</button>
          </div>
        </div>
  
        <!-- Proceed to Step 2 -->
        <button class="px-4 py-2 mt-4 text-white bg-blue-500 rounded" @click="step = 2">Proceed to Payment</button>
      </div>
  
      <!-- Step 2: Payment Details -->
      <div v-if="step === 2" class="space-y-4">
        <div class="p-6 bg-white rounded-md shadow-md ">
      <!-- Billing Information Section -->
      <div class="pb-4 mb-6 border-b">
        <h2 class="mb-2 text-xl font-semibold">Billing Information</h2>
        <p class="mb-4 text-gray-500">Your invoice will be issued according to the details listed here.</p>
        <div class="mb-4">
          <p class="font-semibold">{{$page.props.auth.user.name}}</p>
          <p>Rajasthan, India</p>
          <p>Tax ID: 08LGOPS4457C1ZR, LGOPS4457C</p>
        </div>
        <button class="text-blue-500 hover:underline">Edit</button>
      </div>
      <div>
    <!-- Button to toggle the popup -->
    <button 
      @click="togglePopup"
      class="text-blue-500 hover:underline"
    >
      Edit
    </button>

    <!-- Popup Box -->
    <div v-if="showPopup" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
      <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-lg">
        <h2 class="mb-4 text-xl font-bold">Billing Information</h2>
        
        <!-- Form Fields -->
        <div class="mb-4">
            <div class="w-full max-w-lg p-8 bg-white rounded-lg shadow-lg">
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
        <label class="block font-medium text-gray-700">GSTIN number </label>
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

    </div>
        </div>

        <!-- Add more form fields as necessary -->

        <!-- Buttons -->
        <div class="flex justify-between mt-4">
          <button 
            @click="save"
            class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700"
          >
            Save
          </button>
          <button 
            @click="cancel"
            class="px-4 py-2 text-black bg-gray-400 rounded-lg hover:bg-gray-500"
          >
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
  
      <!-- Payment Options Section -->
      <div class="pb-4 mb-6 border-b">
        <h2 class="mb-2 text-xl font-semibold">Payment Options</h2>
        <label class="inline-flex items-center">
          <input type="radio" name="payment-method" checked class="w-5 h-5 text-blue-600 form-radio" />
          <span class="ml-2 text-gray-700">Cash on Delivery</span>
        </label>
      </div>
  
      <!-- Order Summary Section -->
      <div class="pb-4 mb-6 border-b">
        <h2 class="mb-4 text-xl font-semibold">Order Summary</h2>
        <div class="flex items-center justify-between mb-3">
          <div>
            <p class="font-semibold">{{gigTitle}}</p>
            <p>{{package}}</p>
          </div>
          <p class="text-right">${{selectedPrice}}</p>
        </div>
  
        <ul class="mb-4 text-gray-500">
          <li>✔️ Unlimited revisions</li>
          <li>✔️ 2 concepts included</li>
          <li>✔️ Logo transparency</li>
          <li>✔️ Vector file</li>
          <li>✔️ Printable file</li>
          <li>✔️ Include 3D mockup</li>
          <li>✔️ Include source file</li>
        </ul>
  
        <div class="flex items-center justify-between mb-3">
          <p>Extra Fast 1 Day Delivery</p>
          <p>₹2,206.15</p>
        </div>
  
        <div class="flex items-center justify-between mb-3">
          <p>Stationery designs</p>
          <p>₹4,412.30</p>
        </div>
  
        <div class="flex items-center justify-between pt-3 mb-3 border-t">
          <p class="font-semibold">Service fee</p>
          <p>₹873.64</p>
        </div>
  
        <div class="flex items-center justify-between pt-3 border-t">
          <p class="text-lg font-bold">Total</p>
          <p class="text-lg font-bold">₹16,757.92</p>
        </div>
  
        <p class="text-sm text-gray-500">Total delivery time: 2 days</p>
      </div>
  
      <!-- Payment Button Section -->
      <div class="mt-6 text-center">
        <button class="w-full py-3 font-semibold text-white bg-blue-600 rounded-md shadow-md hover:bg-blue-700">
          Confirm & Pay
        </button>
        <p class="mt-2 text-sm text-gray-500">You will be charged ₹16,757.92. Total amount includes currency conversion fees.</p>
      </div>
    </div>

  
        <!-- Proceed to Step 3 -->
        <button class="px-4 py-2 mt-4 text-white bg-blue-500 rounded" @click="step = 3">Submit Requirements</button>
      </div>
  
      <!-- Step 3: Confirmation -->
      <div v-if="step === 3">
        <div class="max-w-4xl p-6 mx-auto mt-10 bg-white rounded-md shadow-md">
    <!-- Thank You Message -->
    <div class="p-4 mb-6 text-green-700 bg-green-100 rounded-md">
      <h2 class="text-2xl font-bold">Thank You for Your Purchase</h2>
      <p class="text-gray-600">A receipt was sent to your email address</p>
    </div>

    <!-- Submit Requirements Section -->
    <div class="pb-6 mb-6 border-b">
      <h2 class="mb-4 text-xl font-semibold">Submit Requirements to Start Your Order</h2>
      <p class="font-medium">The seller needs the following information to start working on your order:</p>
      <ol class="mb-4 list-decimal list-inside">
        <li>Article you want us to publish with 1 link only (For publishing only package)</li>
        <li>Your website's link and anchor text.</li>
        <li>Topic of the article.</li>
        <li>Any other details you want us to know. We’ll be happy to know.</li>
      </ol>

      <!-- Text Area for Requirements -->
      <textarea
        class="w-full p-4 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
        rows="6"
        maxlength="2500"
        placeholder="Enter your requirements here (max 2500 characters)"
      ></textarea>

      <!-- File Attachment Option -->
      <div class="mt-3">
        <button class="text-blue-600 hover:underline">Attach file</button>
      </div>
    </div>

    <!-- Confirmation Checkbox -->
    <div class="mb-6">
      <label class="flex items-start">
        <input type="checkbox" class="w-5 h-5 mr-2 text-blue-600 form-checkbox" />
        <span class="text-gray-700">
          The information I provided is <strong>accurate and complete</strong>. Any changes will require the seller's approval, and may be subject to additional costs.
        </span>
      </label>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center justify-between">
      <button class="text-gray-600 hover:underline">Remind Me Later</button>
      <button
        class="px-6 py-3 font-semibold text-white bg-green-600 rounded-md hover:bg-green-700"
        :disabled="!isOrderStartable"
      >
        Start Order
      </button>
    </div>
  </div>

  <!-- Order Details Sidebar -->
  <div class="max-w-sm p-6 mx-auto mt-10 bg-white rounded-md shadow-md">
    <div class="flex items-center mb-4">
      <img src="https://via.placeholder.com/100" alt="Order Image" class="object-cover w-20 h-20 rounded-md" />
      <div class="ml-4">
        <h2 class="text-lg font-semibold">I will guest post on DA 60 traffic news site with dofollow backlink</h2>
        <p class="text-sm font-semibold text-orange-600">INCOMPLETE</p>
      </div>
    </div>

    <!-- Order Info -->
    <div class="pt-4 mt-4 border-t">
      <p><strong>Order #:</strong> ###########</p>
      <p><strong>Order Date:</strong> Apr 18, 2022</p>
      <p><strong>Quantity:</strong> X 1</p>
      <p><strong>Price:</strong> $15</p>
    </div>

    <!-- Issue Resolution Link -->
    <div class="mt-6 text-sm">
      <p class="text-gray-600">Have an issue with your order?</p>
      <a href="#" class="text-blue-600 hover:underline">Go to the Resolution Center</a>
    </div>
  </div>
  
        <button class="px-4 py-2 mt-4 text-white bg-green-500 rounded" @click="submitOrder">Confirm Payment</button>
      </div>
    </div>
    <Footer/>
</div>
  </template>
  
