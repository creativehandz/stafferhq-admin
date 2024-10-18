<script setup lang="ts">
import { ref, onMounted, defineComponent } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { required, minLength, numeric, maxLength } from '@vuelidate/validators'; // Import required validators
import useVuelidate from '@vuelidate/core'; // Import Vuelidate core
import axios from 'axios';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import DefaultCard from "@/Components/Forms/DefaultCard.vue";
import Modal from '@/Components/Modal.vue';

// Form state using Inertia's useForm
const gigForm = useForm({
  gig_title: '',
  category_id: null,
  subcategory_id: null,
  gig_description: '',
  positive_keywords: [], // Array for tags
  images: [], // Array for images
  requirements: [''],
  faqs: [{ question: '', answer: '' }],
  pricing: {
    basic: {
      name: '',
      description: '',
      delivery_time: '',
      revisions: '',
      price: ''
    },
    standard: {
      name: '',
      description: '',
      delivery_time: '',
      revisions: '',
      price: ''
    },
    premium: {
      name: '',
      description: '',
      delivery_time: '',
      revisions: '',
      price: ''
    }
  }
});

// Validation rules using Vuelidate
const rules = {
  gig_title: { required }, // Required and minimum length of 3
  category_id: { required },
  subcategory_id: { required },
  gig_description: { required }, // Required and minimum length of 10

  positive_keywords: {
    required,
  },

  // Requirements validation
  requirements: {
    required,
  },

  faqs: [{
    question: { required },
    answer: { required }
  }],

  // Pricing section validation
  pricing: {
    basic: {
      name: { required },
      description: { required },
      delivery_time: { required },
      revisions: { required },
      price: { required, numeric }
    },
    standard: {
      name: { required },
      description: { required },
      delivery_time: { required },
      revisions: { required },
      price: { required, numeric }
    },
    premium: {
      name: { required },
      description: { required },
      delivery_time: { required },
      revisions: { required },
      price: { required, numeric }
    }
  }
};

// the initail value for each fields validation
const formValidation = {
  gig_title: true,
  category_id: true,
  subcategory_id: true,
  gig_description: true,
  positive_keywords: true,
  images: true,
  requirements: true,
  faqs: true,
  pricing: {
    basic: {
      name: true,
      description: true,
      delivery_time: true,
      revisions: true,
      price: true
    },
    standard: {
      name: true,
      description: true,
      delivery_time: true,
      revisions: true,
      price: true
    },
    premium: {
      name: true,
      description: true,
      delivery_time: true,
      revisions: true,
      price: true
    }
  },
  message: []
}

// Initialize Vuelidate with rules
const v$ = useVuelidate(rules, gigForm);

// State for positive keywords and new keyword input
const positiveKeywords = ref<string[]>([]); // Array to store the added tags
const newKeyword = ref<string>(''); // Model for the input field

// Method to add a tag
const addTag = () => {
  const keyword = newKeyword.value.trim();
  const isValidKeyword = /^[a-zA-Z0-9]+$/.test(keyword); // Check if keyword is valid (letters and numbers only)

  if (keyword && isValidKeyword && positiveKeywords.value.length < 5) {
    positiveKeywords.value.push(keyword); // Add the new tag
    newKeyword.value = ''; // Clear the input field
  }
};

// Method to remove a tag by index
const removeTag = (index: number) => {
  positiveKeywords.value.splice(index, 1); // Remove tag by index
};

// Add or remove requirement functionality
const requirements = ref<string[]>(['']); // Initialize with one empty requirement input
const addRequirement = () => requirements.value.push(''); // Add a new empty requirement input
const removeRequirement = (index: number) => requirements.value.splice(index, 1); // Remove the requirement at the specified index

// Fetch categories from backend on mount
const categories = ref([]);
const subcategories = ref([]);
const errorMessage = ref('');
const isModalOpen = ref(false); // Control modal visibility

onMounted(() => {
  axios.get('/categoriesandsub')
    .then(response => {
      categories.value = response.data;
    })
    .catch(error => {
      console.error('Error fetching categories:', error);
    });
});

// Handle category change to populate subcategories
const handleCategoryChange = () => {
  const selected = categories.value.find(category => category['id'] === gigForm.category_id);
  subcategories.value = selected ? selected['sub_categories'] : [];
};

// Navigation between steps
const currentStep = ref(1);
const steps = [
  { number: 1, name: 'Overview' },
  { number: 2, name: 'Pricing' },
  { number: 3, name: 'Description & FAQ' },
  { number: 4, name: 'Requirements' },
  { number: 5, name: 'Gallery' },
  { number: 6, name: 'Publish' }
];

const goToStep = (step: number) => {

  gigForm.requirements = requirements.value;
  gigForm.positive_keywords = positiveKeywords.value.join(',');

  const validation = validateGigForm(step - 1);
  console.log(validation)
  if (validation.isValid) {
    currentStep.value = step;

  } else {
    errorMessage.value = formValidation.message[step-1];
    isModalOpen.value = true; // Open modal
    console.error('Form validation failed: ', errorMessage.value);
  }

};

// Function to add more FAQs
const addMoreFAQs = () => {
  gigForm.faqs.push({ question: '', answer: '' }); // Add a new FAQ object
};


const handleFileUpload = (event) => {
  const files = event.target.files;
  // Clear existing images before adding new ones
  gigForm.images = [];
  
  // Iterate over the files and push each to gigForm.images
  for (let i = 0; i < files.length; i++) {
    const file = files[i];
    gigForm.images.push(file); // Store the file object
  }

  console.log(gigForm.images); // To see the uploaded files in the console
};

const validateGigForm = (step = 0) => {

  let enable = true;

  if (step === 1) {
    formValidation.message[step] = ''
    if (!gigForm.gig_title) {
      enable = false;
      formValidation.gig_title = false;
      formValidation.message[step] += "Gig Title is required.<br>";
    }
    
    if (!gigForm.category_id) {
      enable = false;
      formValidation.category_id = false;
      formValidation.message[step] += "Category is required.<br>";
    }

    if (!gigForm.subcategory_id) {
      enable = false;
      formValidation.subcategory_id = false;
      formValidation.message[step] += "Subcategory is required.<br>";
    }

    if (gigForm.positive_keywords.length === 0) {
      enable = false;
      formValidation.positive_keywords = false;
      formValidation.message[step] += "At least one tag is required.<br>";
    }

    
    return { isValid: enable };

  } else if (step === 2) {
    formValidation.message[step] = ''
    for (const plan in gigForm.pricing) {
      console.log("Plan is : ", plan)
      if (!gigForm.pricing[plan].name) {
        enable = false;
        formValidation.pricing[plan].name = false;
        formValidation.message[step] += `The name of the ${plan} package is required.<br>`;
      }

      if (!gigForm.pricing[plan].description) {
        enable = false;
        formValidation.pricing[plan].description = false;
        formValidation.message[step] += `The description of the ${plan} package is required.<br>`;
      }

      if (!gigForm.pricing[plan].delivery_time) {
        enable = false;
        formValidation.pricing[plan].delivery_time = false;
        formValidation.message[step] += `Delivery time of the ${plan} package is required.<br>`;
      }

      if (!gigForm.pricing[plan].revisions) {
        enable = false;
        formValidation.pricing[plan].revisions = false;
        formValidation.message[step] += `Revisions for the ${plan} package is required.<br>`;
      }

      if (!gigForm.pricing[plan].price) {
        enable = false;
        formValidation.pricing[plan].price = false;
        formValidation.message[step] += `Price for the ${plan} package is required.<br>`;
      }

    }
    
    return { isValid: enable };

  } else if (step === 3 ){
    formValidation.message[step] = ''
    if (!gigForm.gig_description) {
      enable = false;
      formValidation.gig_description = false;
      formValidation.message[step] += `Gig Description is required.<br>`;
    }

    if (gigForm.faqs.length > 0 && gigForm.faqs.some(faq => !faq.question || !faq.answer)) {
      enable = false;
      formValidation.faqs = false;
      formValidation.message[step] += `All FAQs must have both a question and an answer.<br>`;
    }

    return { isValid: enable };

  } else if (step === 4){
    formValidation.message[step] = ''
    if (gigForm.requirements.length === 0 || gigForm.requirements.some(req => !req)) {
      enable = false;
      formValidation.requirements = false;
      formValidation.message[step] += `At least one requirement is required.<br>`;
    }

    return { isValid: enable };

  } else if (step === 5) {
    formValidation.message[step] = ''
    if (gigForm.images.length === 0) {
      enable = false;
      formValidation.images = false;
      formValidation.message[step] += `At least one image is required.<br>`;
    }
    return { isValid: enable };

  } else {
    return { isValid: enable };
  }
  
};

const closeModal = () => {
  errorMessage.value = '';
  isModalOpen.value = null;
}


// Submit form to the backend
const handleSubmit = async () => {
  gigForm.requirements = requirements.value;
  gigForm.positive_keywords = positiveKeywords.value.join(',');

  gigForm.post('/create-gig', {
    onSuccess: () => {
      console.log('A new gig has been successfully saved.')
    }
  });
};

</script>


<template>
    <Head title="Create a New Gig" />
    <AuthenticatedLayout>
      <template #header>
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">Create a New Gig</h2>
      </template>
  
      <BreadcrumbDefault :pageTitle="pageTitle" />
  
      <!-- Error Modal -->
      <div v-if="isModalOpen" @close="closeModal" class="fixed z-50 left-[50%] top-[50%] translate-x-[-50%] translate-y-[-50%] mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto sm:max-w-2xl" >
        <div class="p-6">
          <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Validation Error
          </h2>

          <div v-html="errorMessage" class="flex items-center justify-center mt-1 text-sm text-gray-600 dark:text-gray-400">
            
          </div>

          <div class="flex justify-end mt-6">
            <SecondaryButton @click="closeModal"> OK </SecondaryButton>

          </div>
        </div>
      </div>

      <!-- Step indicators -->
      <div class="p-4 my-6">
        <div class="flex items-center mb-6 space-x-4">
          <div v-for="(step, index) in steps" :key="step.number" class="flex items-center">
            <div
              class="flex items-center justify-center w-10 h-10 rounded-full"
              :class="currentStep === step.number ? 'bg-orange-500 text-white' : 'bg-gray-300 text-gray-500'"
            >
              {{ step.number }}
            </div>
            <p> &nbsp;</p>
            <span :class="currentStep === step.number ? 'text-orange-500 font-semibold' : 'text-gray-500 ml-2'">
              {{ step.name }}
            </span>
            <span v-if="index !== steps.length - 1" class="w-16 h-px mx-4 bg-gray-300"></span>
          </div>
        </div>
  
        <!-- Dynamic Step Content -->
        <div class="p-6 bg-white border rounded-lg shadow-md step-content">
          <form @submit.prevent="currentStep === 6 ? handleSubmit() : goToStep(currentStep + 1)">
            <div class="grid grid-cols-6 gap-6">
              <!-- Step 1: Overview -->
              <div v-if="currentStep === 1" class="col-span-6">
                <DefaultCard cardTitle="Gig Title">
                  <label for="gig-title" class="block text-sm font-medium text-gray-700">Gig Title</label>
                  <input
                    v-model="gigForm.gig_title"
                    type="text"
                    id="gig-title"
                    placeholder="I will do something I'm really good at"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm sm:text-sm"
                    @input="v$.gig_title.$touch()"
                    :class="{ 'border-red-500': v$.gig_title.$error }"
                  />
                  <span v-if="v$.gig_title.$error" class="text-sm text-red-500">Title is required (min 3 characters).</span>

                  <label for="category" class="block mt-4 text-sm font-medium text-gray-700">Select Category</label>
                  <select
                    v-model="gigForm.category_id"
                    @change="v$.category_id.$touch(); handleCategoryChange()"
                    id="category"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm sm:text-sm"
                    :class="{ 'border-red-500': v$.category_id.$error }"
                  >
                    <option disabled value="">Please select one</option>
                    <option v-for="category in categories" :key="category['id']" :value="category['id']">{{ category['name'] }}</option>
                  </select>
                  <span v-if="v$.category_id.$error" class="text-sm text-red-500">Category is required.</span>

                  <label for="subcategory" class="block mt-4 text-sm font-medium text-gray-700">Select Subcategory</label>
                  <select
                    v-model="gigForm.subcategory_id"
                    @change="v$.subcategory_id.$touch()"
                    id="subcategory"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm sm:text-sm"
                    :class="{ 'border-red-500': v$.subcategory_id.$error }"
                  >
                    <option disabled value="">Please select one</option>
                    <option v-for="subcategory in subcategories" :key="subcategory['id']" :value="subcategory['id']">{{ subcategory['name'] }}</option>
                  </select>
                  <span v-if="v$.subcategory_id.$error" class="text-sm text-red-500">Subcategory is required.</span>

                  <label for="positive-keywords" class="block mt-4 text-sm font-medium text-gray-700">Positive Keywords</label>
                  <div class="block w-full p-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm sm:text-sm">
                    <span v-for="(tag, index) in positiveKeywords" :key="index" class="inline-block bg-orange-200 text-orange-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                      {{ tag }}
                      <span @click="removeTag(index)" class="ml-1 cursor-pointer">x</span>
                    </span>
                    <input
                      v-model="newKeyword"
                      @keydown.enter.prevent="addTag"
                      @keydown.comma.prevent="addTag"
                      type="text"
                      id="positive-keywords"
                      placeholder="Enter up to 5 tags"
                      class="w-auto border-0 outline-none focus:ring-0"
                      :disabled="positiveKeywords.length >= 5"
                    />
                  </div>
                  <p class="mt-2 text-sm text-gray-500">5 tags maximum. Use letters and numbers only.</p>
                </DefaultCard>
              </div>
  
              <!-- Step 2: Pricing -->
              <div v-if="currentStep === 2" class="col-span-6">
                <div class="flex flex-col gap-5.5 p-6.5">
                  <table class="min-w-full border border-collapse table-auto border-stroke">
                    <thead>
                      <tr class="text-black bg-gray-200 dark:text-white">
                        <th class="p-4 border bg-gray border-stroke">Basic</th>
                        <th class="p-4 border bg-gray border-stroke">Standard</th>
                        <th class="p-4 border bg-gray border-stroke">Premium</th>                          
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Package Name Row -->
                      <tr class="text-black bg-gray-200 dark:text-white">
                        <th class="p-4 border border-stroke">
                          <input
                            v-model="gigForm.pricing.basic.name"
                            @input="v$.pricing.basic.name.$touch()"
                            type="text"
                            placeholder="Name your package"
                            :class="{ 'border-red-500': v$.pricing.basic.name.$error }"
                          />
                          <span v-if="v$.pricing.basic.name.$error" class="text-sm text-red-500">Please enter a valid name (min 3 characters).</span>
                        </th>
                        <th class="p-4 border border-stroke">
                          <input
                            v-model="gigForm.pricing.standard.name"
                            @input="v$.pricing.standard.name.$touch()"
                            type="text" 
                            placeholder="Name your package"
                            :class="{ 'border-red-500': v$.pricing.standard.name.$error }"
                          />
                          <span v-if="v$.pricing.standard.name.$error" class="text-sm text-red-500">Please enter a valid name (min 3 characters).</span>
                        </th>
                        <th class="p-4 border border-stroke">
                          <input
                            v-model="gigForm.pricing.premium.name"
                            @input="v$.pricing.premium.name.$touch()"
                            type="text"
                            placeholder="Name your package"
                            :class="{ 'border-red-500': v$.pricing.premium.name.$error }"
                          />
                          <span v-if="v$.pricing.premium.name.$error" class="text-sm text-red-500">Please enter a valid name (min 3 characters).</span>
                        </th>
                      </tr>
                      
                      <!-- Package Description Row -->
                      <tr class="text-black bg-gray-200 dark:text-white">
                        <th class="p-4 border border-stroke">
                          <input
                            v-model="gigForm.pricing.basic.description"
                            @input="v$.pricing.basic.description.$touch()"
                            placeholder="Describe the details of your offering."
                            :class="{ 'border-red-500': v$.pricing.basic.description.$error }"
                          />
                          <span v-if="v$.pricing.basic.description.$error" class="text-sm text-red-500">Description is required (min 10 characters).</span>
                        </th>
                        <th class="p-4 border border-stroke">
                          <input
                            v-model="gigForm.pricing.standard.description"
                            @input="v$.pricing.standard.description.$touch()"
                            placeholder="Describe the details of your offering."
                            :class="{ 'border-red-500': v$.pricing.standard.description.$error }"
                          />
                          <span v-if="v$.pricing.standard.description.$error" class="text-sm text-red-500">Description is required (min 10 characters).</span>
                        </th>
                        <th class="p-4 border border-stroke">
                          <input
                            v-model="gigForm.pricing.premium.description"
                            @input="v$.pricing.premium.description.$touch()"
                            placeholder="Describe the details of your offering."
                            :class="{ 'border-red-500': v$.pricing.premium.description.$error }"
                          />
                          <span v-if="v$.pricing.premium.description.$error" class="text-sm text-red-500">Description is required (min 10 characters).</span>
                        </th>
                      </tr>

                      <!-- Delivery Time Row -->
                      <tr class="text-black bg-gray-200 dark:text-white">
                        <th class="p-4 border border-stroke">
                          <select
                            v-model="gigForm.pricing.basic.delivery_time"
                            @change="v$.pricing.basic.delivery_time.$touch()"
                            :class="{ 'border-red-500': v$.pricing.basic.delivery_time.$error }"
                          >
                            <option value="" disabled>Delivery Time</option>
                            <option value="1 day">1 Day</option>
                            <option value="3 days">3 Days</option>
                            <option value="7 days">7 Days</option>
                            <option value="14 days">14 Days</option>
                            <option value="30 days">30 Days</option>
                          </select>
                          <span v-if="v$.pricing.basic.delivery_time.$error" class="text-sm text-red-500">Delivery time is required.</span>
                        </th>
                        <th class="p-4 border border-stroke">
                          <select
                            v-model="gigForm.pricing.standard.delivery_time"
                            @change="v$.pricing.standard.delivery_time.$touch()"
                            :class="{ 'border-red-500': v$.pricing.standard.delivery_time.$error }"
                          >
                            <option value="" disabled>Delivery Time</option>
                            <option value="1 day">1 Day</option>
                            <option value="3 days">3 Days</option>
                            <option value="7 days">7 Days</option>
                            <option value="14 days">14 Days</option>
                            <option value="30 days">30 Days</option>
                          </select>
                          <span v-if="v$.pricing.standard.delivery_time.$error" class="text-sm text-red-500">Delivery time is required.</span>
                        </th>
                        <th class="p-4 border border-stroke">
                          <select
                            v-model="gigForm.pricing.premium.delivery_time"
                            @change="v$.pricing.premium.delivery_time.$touch()"
                            :class="{ 'border-red-500': v$.pricing.premium.delivery_time.$error }"
                          >
                            <option value="" disabled>Delivery Time</option>
                            <option value="1 day">1 Day</option>
                            <option value="3 days">3 Days</option>
                            <option value="7 days">7 Days</option>
                            <option value="14 days">14 Days</option>
                            <option value="30 days">30 Days</option>
                          </select>
                          <span v-if="v$.pricing.premium.delivery_time.$error" class="text-sm text-red-500">Delivery time is required.</span>
                        </th>
                      </tr>

                      <!-- Revisions Row -->
                      <tr class="text-black bg-gray-200 dark:text-white">
                        <th class="p-4 border border-stroke">
                          <select
                            v-model="gigForm.pricing.basic.revisions"
                            @change="v$.pricing.basic.revisions.$touch()"
                            :class="{ 'border-red-500': v$.pricing.basic.revisions.$error }"
                          >
                            <option value="" disabled>Revisions</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="unlimited">Unlimited</option>
                          </select>
                          <span v-if="v$.pricing.basic.revisions.$error" class="text-sm text-red-500">Revisions are required.</span>
                        </th>
                        <th class="p-4 border border-stroke">
                          <select
                            v-model="gigForm.pricing.standard.revisions"
                            @change="v$.pricing.standard.revisions.$touch()"
                            :class="{ 'border-red-500': v$.pricing.standard.revisions.$error }"
                          >
                            <option value="" disabled>Revisions</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="unlimited">Unlimited</option>
                          </select>
                          <span v-if="v$.pricing.standard.revisions.$error" class="text-sm text-red-500">Revisions are required.</span>
                        </th>
                        <th class="p-4 border border-stroke">
                          <select
                            v-model="gigForm.pricing.premium.revisions"
                            @change="v$.pricing.premium.revisions.$touch()"
                            :class="{ 'border-red-500': v$.pricing.premium.revisions.$error }"
                          >
                            <option value="" disabled>Revisions</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="unlimited">Unlimited</option>
                          </select>
                          <span v-if="v$.pricing.premium.revisions.$error" class="text-sm text-red-500">Revisions are required.</span>
                        </th>
                      </tr>

                      <!-- Price Row -->
                      <tr class="text-black bg-gray-200 dark:text-white">
                        <th class="p-4 border border-stroke">
                          <input
                            v-model="gigForm.pricing.basic.price"
                            @input="v$.pricing.basic.price.$touch()"
                            type="number"
                            placeholder="Price"
                            :class="{ 'border-red-500': v$.pricing.basic.price.$error }"
                          />
                          <span v-if="v$.pricing.basic.price.$error" class="text-sm text-red-500">Price is required and must be numeric.</span>
                        </th>
                        <th class="p-4 border border-stroke">
                          <input
                            v-model="gigForm.pricing.standard.price"
                            @input="v$.pricing.standard.price.$touch()"
                            type="number"
                            placeholder="Price"
                            :class="{ 'border-red-500': v$.pricing.standard.price.$error }"
                          />
                          <span v-if="v$.pricing.standard.price.$error" class="text-sm text-red-500">Price is required and must be numeric.</span>
                        </th>
                        <th class="p-4 border border-stroke">
                          <input
                            v-model="gigForm.pricing.premium.price"
                            @input="v$.pricing.premium.price.$touch()"
                            type="number"
                            placeholder="Price"
                            :class="{ 'border-red-500': v$.pricing.premium.price.$error }"
                          />
                          <span v-if="v$.pricing.premium.price.$error" class="text-sm text-red-500">Price is required and must be numeric.</span>
                        </th>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- Step 3: Description & FAQ (Placeholder for future logic) -->
              <div v-if="currentStep === 3" class="col-span-6">
                <DefaultCard cardTitle="Description">
                  <label for="gig-description" class="block text-sm font-medium text-gray-700">Briefly Describe Your Gig</label>
                  <textarea
                    v-model="gigForm.gig_description"
                    @input="v$.gig_description.$touch()"
                    id="gig-description"
                    rows="4"
                    placeholder="Briefly Describe Your Gig"
                    class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                    :class="{ 'border-red-500': v$.gig_description.$error }"
                  ></textarea>
                  <span v-if="v$.gig_description.$error" class="text-sm text-red-500">Description is required (min 10 characters).</span>

                  <label for="faq" class="block text-sm font-medium text-gray-700">Frequently Asked Questions (FAQ)</label>
                  <!-- Dynamic FAQ Inputs -->
                  <div class="mt-2" v-for="(faq, index) in gigForm.faqs" :key="index">
                    <input
                      v-model="faq.question"
                      @input="v$.faqs[index].question.$touch()"
                      type="text"
                      placeholder="Enter question"
                      class="block w-full mt-1 border-gray-300 rounded-md shadow-sm sm:text-sm"
                    />
                    <div class="mt-4">
                      <textarea
                        v-model="faq.answer"
                        @input="v$.faqs[index].answer.$touch()"
                        rows="4"
                        placeholder="Enter the answer to your question"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      ></textarea>
                    </div>
                  </div>
                  <!-- Add More FAQs Button -->
                  <div class="mt-4">
                    <button
                      type="button"
                      class="px-4 py-2 mt-4 text-white bg-blue-600 rounded-md"
                      @click="addMoreFAQs"
                    >
                      Add More FAQ
                    </button>
                  </div>
                </DefaultCard>
              </div>


              <!-- Step 4: Requirements (Placeholder for future logic) -->
              <div v-if="currentStep === 4" class="col-span-6">
                <!-- Add Requirements fields here in the future -->
                <DefaultCard cardTitle="Add a Question">
                  <div class="col-span-6">
                  <div v-for="(requirement, index) in requirements" :key="index" class="mt-4">
                    <!-- Requirement Input -->
                    <input 
                      type="text" 
                      :name="'requirement_' + index" 
                      v-model="requirements[index]"
                      @input="v$.requirements.$touch()"
                      placeholder="Specify requirements like dimensions, materials, etc."
                      class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                    <!-- Cancel Button for the extra field -->
                    <button 
                      v-if="requirements.length > 1 && index >= 1" 
                      type="button" 
                      @click="removeRequirement(index)"
                      class="inline-flex justify-center px-2 py-1 ml-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-red hover:bg-red focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red"
                    >
                      Remove
                    </button>
                  </div>
                  <!-- Add More Requirement Button -->
                  <div class="mt-4">
                  <button
                    type="button"
                    @click="addRequirement"
                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                  >
                    Add More Requirement
                  </button>
                  </div>
                  </div>
                </DefaultCard>
              </div> 
              
              

              <!-- Step 5: Gallery (Placeholder for future logic) -->
              <div v-if="currentStep === 5" class="col-span-6">
                <!-- Add Gallery fields here in the future -->
                <DefaultCard cardTitle="File upload">
                  <div class="flex flex-col gap-5.5 p-6.5">
                    <div>
                      <label class="block mb-3 text-sm font-medium text-black dark:text-white">
                        Attach file
                      </label>
                      <input
                        type="file"
                        name="file_path[]"
                        @change="handleFileUpload"
                        class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter file:py-3 file:px-5 file:hover:bg-primary file:hover:bg-opacity-10 focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:file:bg-white/30 dark:file:text-white dark:focus:border-primary"
                        multiple
                      />
                    </div>

                    <!-- <div>
                      <label class="block mb-3 text-sm font-medium text-black dark:text-white">
                        Attach file
                      </label>
                      <input
                        type="file"
                        class="w-full rounded-md border border-stroke p-3 outline-none transition file:mr-4 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2.5 file:text-sm file:font-normal focus:border-primary file:focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-strokedark dark:file:bg-white/30 dark:file:text-white"
                      />
                    </div> -->
                  </div>
                </DefaultCard>
              </div>


              <!-- Step 6: Publish (Placeholder for future logic) -->
              <div v-if="currentStep === 6" class="col-span-6">
                <!-- Add Publish fields here in the future -->
                  <DefaultCard cardTitle="Publish Your Gig">
                  <div class="flex items-center justify-center">
                      <button type="submit" class="px-6 py-2 text-white bg-orange-500 rounded-md ">
                          Publish Your Gig
                      </button> 
                  </div>                   
                  </DefaultCard>
              </div>
  
              <!-- Navigation Buttons -->
              <div class="flex justify-between col-span-6">
                <button v-if="currentStep > 1" type="button" @click="goToStep(currentStep - 1)" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md">Back</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-orange-500 border border-transparent rounded-md">
                  {{ currentStep === 6 ? 'Publish your Gig' : 'Save & Continue' }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
