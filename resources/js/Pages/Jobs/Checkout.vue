<script setup lang="ts">
import Footer from '@/Components/LandingPage/Footer.vue';
import axios from 'axios';
import { ref, computed, onMounted, reactive } from 'vue';
import BuyerNavbar from '../BuyerNavbar.vue';

const buyerCheckoutIdGlobal = ref<number | null>(null); // Global variable to store buyerCheckoutId

// Props passed from the backend via Inertia
const props = defineProps<{
  package: {
    packageName: string;
    packageDescription: string;
    packagePrice: number;
    deliveryTime: string;
    revisions: number;
    gigId: number;
    billingDetails: string;
  };
}>();
// Define form data as a reactive object
const form = reactive({
  fullName: '',
  companyName: '',
  country: '',
  state: '',
  address: '',
  city: '',
  postalCode: '',
  isCitizen: '',
  taxCategory: '',
  wantInvoices: false
});
// Flag to track if payment is completed
const paymentComplete = ref(false);
const formSubmitted = ref(false);
const completeCheckout = async () => {
  formSubmitted.value = true;

  if (!form.fullName || !form.state || !form.country || !form.isCitizen || !form.taxCategory || !form.postalCode || !form.address || !form.city ) {
    console.log('Please fill all mandatory billing information.');
    return;
  }

  const billingDetails = `
    Full Name: ${form.fullName}
    Company Name: ${form.companyName}
    Country: ${form.country}
    State: ${form.state}
    Address: ${form.address}
    City: ${form.city}
    Postal Code: ${form.postalCode}
    Citizen/Resident: ${form.isCitizen}
    Tax Category: ${form.taxCategory}
    Want Invoices: ${form.wantInvoices ? 'Yes' : 'No'}
  `;

  const payload = {
    ...props.package,  
    billingDetails,    
    ...form            
  };

  try {
    // Get buyer_checkout_id from response
    const response = await axios.post('/checkout', payload);

    // Pass buyer_checkout_id to submitBillingDetails
    const buyerCheckoutId = response.data.buyer_checkout_id;
    paymentComplete.value = true;
    step.value = 3;
    buyerCheckoutIdGlobal.value = response.data.buyer_checkout_id;

    // Call submitBillingDetails and pass buyer_checkout_id
    await submitBillingDetails(buyerCheckoutId);
  } catch (error) {
    console.error('Error completing checkout: ', error);
  }
};

// Add TypeScript type for `buyerCheckoutId`
const submitBillingDetails = async (buyerCheckoutId: number) => {
  try {
    const payload = {
      buyer_checkout_id: buyerCheckoutId,  // Attach checkout ID
      full_name: form.fullName,
      company_name: form.companyName,
      country: form.country,
      state: form.state,
      address: form.address,
      city: form.city,
      postal_code: form.postalCode,
      is_citizen: form.isCitizen,
      tax_category: form.taxCategory,
      want_invoices: form.wantInvoices,
    };

    await axios.post('/billing-details', payload);
    console.log('Billing details submitted successfully!');
  } catch (error) {
    console.error('Error submitting billing details:', error);
  }
};


// State for gig quantity
const quantity = ref(1);
const step = ref(2); // Track the current step

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
const goBack = () => {
  window.history.back();
};

// Define the form data structure
interface FormData {
  requirements: string;
  file: File | null;
  confirmation: boolean;
}

// Form data for the second form
const formData = ref<FormData>({
  requirements: '',
  file: null,
  confirmation: false, // checkbox
});

// Handle file upload
const handleFileUpload = (event: Event) => {
  const target = event.target as HTMLInputElement;
  const files = target.files;
  if (files && files.length > 0) {
    formData.value.file = files[0];
  }
};

const submitRequirements = async (event: Event) => {
  event.preventDefault();

  if (!formData.value.confirmation) {
    alert('Please confirm that the information is accurate.');
    return;
  }

  const formDataToSend = new FormData();
  formDataToSend.append('requirements', formData.value.requirements);

  if (formData.value.file) {
    formDataToSend.append('file', formData.value.file);
  }

  // Use the global buyerCheckoutIdGlobal
  if (buyerCheckoutIdGlobal.value) {
    formDataToSend.append('buyer_checkout_id', buyerCheckoutIdGlobal.value.toString());
  } else {
    console.error('Buyer Checkout ID is not available.');
    return;
  }

  try {
    const response = await axios.post('/submit-requirements', formDataToSend, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });
    alert('Requirements submitted successfully.');
  } catch (error) {
    console.error('Error submitting requirements:', error);
    alert('There was an error submitting your requirements.');
  }
};


const isOrderStartable = false;
</script>


<template>
  <div class="container flex flex-col justify-center">
    <BuyerNavbar/>        
      <div class="p-4">
        <!-- Step Navigation -->
        <div class="flex mb-4 space-x-2">
          <button :class="step === 1 ? 'font-bold' : ''" @click="goBack">Order Details</button>
          <button :class="step === 2 ? 'font-bold' : ''" @click="step = 2">> Confirm & Pay</button>
          <button :class="step === 3 ? 'font-bold' : ''" @click="">> Submit Requirements</button>
        </div>
      <hr/>

  
        <!-- Step 1: Gig Selection -->
        <div v-if="step === 1">
          <!-- job description page -->
        </div>
  
      <!-- Step 2: Payment Details and Billing Information -->
      <div v-if="step === 2" class="space-y-4 mt-10">
        <div class="w-full ">
          <div class="grid grid-cols-3">
            
            <div class="col-span-2"> 
               <!-- Billing Information Section -->
            <div class="pb-4 mb-6 ">
              <h2 class="mb-2 text-xl font-semibold">Billing Information</h2>
              <p class="mb-4 text-gray-500">Your invoice will be issued according to the details listed here.</p>
              <div class="mb-4">        
            <div  class="w-10/12 ">                      
              <form @submit.prevent="completeCheckout">
    <!-- Form Fields -->
    <div class="mb-4 w-full">
      <!-- Full Name -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">Full name <span class="text-red">*</span></label>
        <input
          v-model="form.fullName"
          type="text"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg"
          required
          placeholder="Full Name"
        />
        <p v-if="!form.fullName && formSubmitted" class="text-pink-600">Please provide your full name.</p>
      </div>

      <!-- Company Name -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">Company name</label>
        <input
          v-model="form.companyName"
          type="text"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg"
          placeholder="Company name"
        />
      </div>

      <!-- Country -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">Country</label>
        <select v-model="form.country" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
          <option value="" disabled>Select your country</option>
          <option value="Malaysia">Malaysia</option>
          <!-- Add more options if needed -->
        </select>
        <p v-if="!form.country && formSubmitted" class="text-pink-600">Please select your country.</p>
      </div>

      <!-- State -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">State/Union territory (mandatory)</label>
        <select v-model="form.state" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
          <option value="" disabled>Select your state</option>
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
        </select>
        <p v-if="!form.state && formSubmitted" class="text-pink-600">Please select your state.</p>
      </div>

      <!-- Address -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">Address</label>
        <input
          v-model="form.address"
          type="text"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg"
          placeholder="Street or POB"
        />
        <p v-if="!form.fullName && formSubmitted" class="text-pink-600">Please provide your Address.</p>
      </div>

      <!-- City -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">City</label>
        <input
          v-model="form.city"
          type="text"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg"
          placeholder="City"
        />
        <p v-if="!form.city && formSubmitted" class="text-pink-600">Please provide your city.</p>
      </div>

      <!-- Postal Code -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">Postal code</label>
        <input
          v-model="form.postalCode"
          type="text"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg"
          placeholder="Postal code"
        />
        <p v-if="!form.postalCode && formSubmitted" class="text-pink-600">Please provide postal code.</p>
      </div>

      <!-- Citizen/Resident of Malaysia -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">Are you a citizen/resident of Malaysia? (mandatory)</label>
        <div class="flex items-center">
          <input v-model="form.isCitizen" type="radio" value="yes" class="mr-2" /> Yes
          <input v-model="form.isCitizen" type="radio" value="no" class="ml-6 mr-2" /> No
        </div>
        <p v-if="!form.isCitizen && formSubmitted" class="text-pink-600">Please select if you are a citizen/resident.</p>
      </div>

      <!-- TCS Under GST Tax Category -->
      <div class="mb-4">
        <label class="block font-medium text-gray-700">What is your tax category? (mandatory)</label>
        <select v-model="form.taxCategory" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
          <option value="" disabled>Select your tax category</option>
          <option value="Taxable">Taxable</option>
          <!-- Add more options if needed -->
        </select>
        <p v-if="!form.taxCategory && formSubmitted" class="text-pink-600">Please select your tax category.</p>
      </div>

      <!-- Invoices -->
      <div class="flex items-center mb-4">
        <input v-model="form.wantInvoices" type="checkbox" class="mr-2" />
        <label class="text-gray-700">I want to get invoices via email as well.</label>
      </div>
    </div>
  </form>
      </div>
    </div>
  </div>
</div>

      
        <div class="" >
                <!-- Order Summary Section -->
                <div class="p-5 pb-4 mb-6 bg-slate-100">
                  <h2 class="mb-4 text-xl font-semibold">Order Summary</h2>
                  <div class="flex items-center justify-between mb-3">
                    <div>
                      <p class="font-semibold"></p>
                      <h2 class="mb-2 text-2xl font-bold">Selected Package: </h2>
                    </div>
                    <p class="text-right">{{ package.packageName }} </p>
                  </div>
            
                  <ul class="mb-4 text-gray-500">
                    <li>Description: {{ package.packageDescription }}</li>
                    <li>Price: ${{ package.packagePrice }}</li>
                    <li>Delivery Time: {{ package.deliveryTime }}</li>
                    <!-- <li>Revisions: {{ package.revisions }}</li> -->
                  </ul>    
                  <div class="flex items-center justify-between pt-3 mb-3 border-t">
                    <p class="font-semibold">Service fee</p>
                    <p>$100</p>
                  </div>
            
                  <div class="flex items-center justify-between pt-3 border-t">
                    <p class="text-lg font-bold">Total</p>
                    <p class="text-lg font-bold">{{package.packagePrice}}</p>
                  </div>
            
                  <p class="text-sm text-gray-500">Total delivery time: {{ package.deliveryTime }}</p>
                </div>
                <!-- Payment Button Section -->
                <div class="mt-6 text-center">
                  <button class="px-16 py-3 font-bold text-black transition-all duration-300 bg-[#F5F535] rounded-full shadow-lg hover:bg-yellow-500 button-get-started sm:text-[24px] md:text-[24px] lg:text-[24px] xl:text-[24px] 2xl:text-[24px]" @click="completeCheckout">
                    Confirm & Pay
                  </button>
                  <p class="mt-2 text-sm text-gray-500">You will be charged {{package.packagePrice}} Total amount includes currency conversion fees.</p>
                </div>
              </div>
              <div class="col-span-full" >  
              <!-- Payment Options Section -->
              <div class="p-4 bg-slate-300">
              <h2 class="mb-2 text-xl font-semibold">Payment Options</h2>
              <label class="inline-flex items-center">
                <input type="radio" name="payment-method" checked class="w-5 h-5 text-blue-600 form-radio" />
                <span class="ml-2 text-gray-700">Cash on Delivery</span>
              </label>
            </div>
          </div>
        </div>
      <div>
    </div>
  </div>
</div>
    
          <!-- Step 3: Confirmation -->
          <div v-if="step === 3">
            <div class="max-w-4xl p-6 mx-auto mt-10 bg-white rounded-md shadow-md">
          <!-- Thank You Message -->
          <div class="p-4 mb-6 text-green-700 bg-green-100 rounded-md">
            <h2 class="text-2xl font-bold">Thank You for Your Purchase</h2>
            <p class="text-gray-600">A receipt was sent to your email address</p>
          </div>
          <form @submit.prevent="submitRequirements">
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
                v-model="formData.requirements"
              ></textarea>

              <!-- File Attachment Option -->
              <div class="mt-3">
                <input type="file" @change="handleFileUpload" />
              </div>
            </div>

            <!-- Confirmation Checkbox -->
            <div class="mb-6">
              <label class="flex items-start">
                <input
                  type="checkbox"
                  class="w-5 h-5 mr-2 text-blue-600 form-checkbox"
                  v-model="formData.confirmation"
                />
                <span class="text-gray-700">
                  The information I provided is <strong>accurate and complete</strong>. Any changes will require the seller's approval and may be subject to additional costs.
                </span>
              </label>
            </div>

            <!-- Submit Button -->
            <button
              type="submit"
              class="px-6 py-2 font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700"
            >
              Start Order
            </button>
          </form>
        </div>     
      </div>
    </div>
  <Footer/>
</div>
</template>
  