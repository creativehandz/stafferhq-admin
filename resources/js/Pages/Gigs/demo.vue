<script setup lang="ts">
import { ref, onMounted, defineComponent } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import DefaultCard from "@/Components/Forms/DefaultCard.vue";
import axios from 'axios';

const pageTitle = ref('Create a New Gig');
const currentStep = ref(1);
const requirements = ref<string[]>(['']); // Initialize with one empty requirement input


// Function to add more requirements
const addRequirement = () => {
  requirements.value.push(''); // Add a new empty requirement input
};

// Function to remove a requirement
const removeRequirement = (index: number) => {
  requirements.value.splice(index, 1); // Remove the requirement at the specified index
};

// Define the RequirementsSection component
const RequirementsSection = defineComponent({
  setup() {
    const requirements = ref<string[]>(['']); // Initialize with one empty requirement input

    const addRequirement = () => {
      requirements.value.push(''); // Add a new empty requirement input
    };

    const removeRequirement = (index: number) => {
      if (requirements.value.length > 1) {
        requirements.value.splice(index, 1); // Remove the requirement at the specified index
      }
    };

    return { requirements, addRequirement, removeRequirement };
  }
});

// Form state using Inertia's useForm
const gigForm = useForm({
  gig_title: '',
  category_id: null,
  gig_description: '',
  subcategory_id: null,
  positive_keywords: '',
  requirements: [''],
  faqs: [{ question: '', answer: '' }], // Initialize with one FAQ


    // Add Pricing section fields
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

// Categories and subcategories data
const categories = ref([]);
const subcategories = ref([]);

// Fetch categories from backend on mount
onMounted(() => {
  axios.get('/categories')
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
  subcategories.value = selected ? selected['subcategories'] : [];
};

// Navigation between steps
const steps = [
  { number: 1, name: 'Overview' },
  { number: 2, name: 'Pricing' },
  { number: 3, name: 'Description & FAQ' },
  { number: 4, name: 'Requirements' },
  { number: 5, name: 'Gallery' },
  { number: 6, name: 'Publish' }
];

const goToStep = (step: number) => {
  currentStep.value = step;
};

// Function to add more FAQs
const addMoreFAQs = () => {
  gigForm.faqs.push({ question: '', answer: '' }); // Add a new FAQ object
};

// Submit form to the backend when the last step is reached
const handleSubmit = () => {
  gigForm.requirements = requirements.value; 
  gigForm.post('/create-gig', {
    onSuccess: () => {
      router.visit('/create-gig');
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
                  <input v-model="gigForm.gig_title" type="text" name="gig_title" id="gig-title" autocomplete="gig-title" placeholder="I will do something I'm really good at" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm sm:text-sm" />
  
                  <!-- Categories -->
                  <label for="category" class="block text-sm font-medium text-gray-700">Select Category</label>
                  <select v-model="gigForm.category_id" @change="handleCategoryChange" id="category" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm sm:text-sm">
                    <option disabled value="">Please select one</option>
                    <option v-for="category in categories" :key="category['id']" :value="category['id']">{{ category['name'] }}</option>
                  </select>
  
                  <!-- Subcategories -->
                  <label for="subcategory" class="block text-sm font-medium text-gray-700">Select Subcategory</label>
                  <select v-model="gigForm.subcategory_id" id="subcategory" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm sm:text-sm">
                    <option disabled value="">Please select one</option>
                    <option v-for="subcategory in subcategories" :key="subcategory['id']" :value="subcategory['id']">{{ subcategory['name'] }}</option>
                  </select>
  
                  <!-- Positive Keywords -->
                  <label for="positive-keywords" class="block text-sm font-medium text-gray-700">Positive Keywords</label>
                  <input v-model="gigForm.positive_keywords" type="text" name="positive_keywords" id="positive-keywords" placeholder="Enter up to 5 tags" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm sm:text-sm" />
                  <p class="mt-2 text-sm text-gray-500">5 tags maximum. Use letters and numbers only.</p>
                </DefaultCard>
              </div>
  
              <!-- Step 2: Pricing -->
              <div v-if="currentStep === 2" class="col-span-6">
                <!-- Pricing fields (placeholders for future logic) -->
              </div>
  
              <!-- Other steps... -->

                <!-- Step 2: Pricing (Placeholder for future logic) -->
                <div v-if="currentStep === 2" class="col-span-6">
                  <!-- Add Pricing fields here in the future -->
                  <div class="flex flex-col gap-5.5 p-6.5">
                    <table class="min-w-full border border-collapse table-auto border-stroke">
                      <thead>
                        <tr class="text-black bg-gray-200 dark:text-white">
                          <th class="p-4 border bg-gray border-stroke">Basic</th>
                          <th class="p-4 border bg-gray border-stroke">Standard</th>
                          <th class="p-4 border bg-gray border-stroke">Premium</th>                          
                        </tr>
                        <tr class="text-black bg-gray-200 dark:text-white">
                            <th class="p-4 border border-stroke">
                                <input v-model="gigForm.pricing.basic.name" placeholder="Name your package"/>
                            </th>
                            <th class="p-4 border border-stroke">
                                <input v-model="gigForm.pricing.standard.name" placeholder="Name your package"/>
                            </th>
                            <th class="p-4 border border-stroke">
                                <input v-model="gigForm.pricing.premium.name" placeholder="Name your package"/>
                            </th>
                            </tr>
                            <tr class="text-black bg-gray-200 dark:text-white">
                            <th class="p-4 border border-stroke">
                                <input v-model="gigForm.pricing.basic.description" placeholder="Describe the details of your offering."/>
                            </th>
                            <th class="p-4 border border-stroke">
                                <input v-model="gigForm.pricing.standard.description" placeholder="Describe the details of your offering."/>
                            </th>
                            <th class="p-4 border border-stroke">
                                <input v-model="gigForm.pricing.premium.description" placeholder="Describe the details of your offering."/>
                            </th>
                            </tr>
                            <tr class="text-black bg-gray-200 dark:text-white">
                            <th class="p-4 border border-stroke">
                                <select v-model="gigForm.pricing.basic.delivery_time">
                                <option value="" disabled selected>Delivery Time</option>
                                <option value="1 day">1 Day</option>
                                <option value="3 days">3 Days</option>
                                <option value="7 days">7 Days</option>
                                <option value="14 days">14 Days</option>
                                <option value="30 days">30 Days</option>
                                </select>
                            </th>
                            <th class="p-4 border border-stroke">
                                <select v-model="gigForm.pricing.standard.delivery_time">
                                <option value="" disabled selected>Delivery Time</option>
                                <option value="1 day">1 Day</option>
                                <option value="3 days">3 Days</option>
                                <option value="7 days">7 Days</option>
                                <option value="14 days">14 Days</option>
                                <option value="30 days">30 Days</option>
                                </select>
                            </th>
                            <th class="p-4 border border-stroke">
                                <select v-model="gigForm.pricing.premium.delivery_time">
                                <option value="" disabled selected>Delivery Time</option>
                                <option value="1 day">1 Day</option>
                                <option value="3 days">3 Days</option>
                                <option value="7 days">7 Days</option>
                                <option value="14 days">14 Days</option>
                                <option value="30 days">30 Days</option>
                                </select>
                            </th>
                            </tr>
                            <tr class="text-black bg-gray-200 dark:text-white">
                            <th class="p-4 border border-stroke">
                                <select v-model="gigForm.pricing.basic.revisions">
                                <option value="" disabled selected>Revisions</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="unlimited">Unlimited</option>
                                </select>
                            </th>
                            <th class="p-4 border border-stroke">
                                <select v-model="gigForm.pricing.standard.revisions">
                                <option value="" disabled selected>Revisions</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="unlimited">Unlimited</option>
                                </select>
                            </th>
                            <th class="p-4 border border-stroke">
                                <select v-model="gigForm.pricing.premium.revisions">
                                <option value="" disabled selected>Revisions</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="unlimited">Unlimited</option>
                                </select>
                            </th>
                            </tr>
                            <tr class="text-black bg-gray-200 dark:text-white">
                            <th class="p-4 border border-stroke">
                                <input v-model="gigForm.pricing.basic.price" placeholder="Price"/>
                            </th>
                            <th class="p-4 border border-stroke">
                                <input v-model="gigForm.pricing.standard.price" placeholder="Price"/>
                            </th>
                            <th class="p-4 border border-stroke">
                                <input v-model="gigForm.pricing.premium.price" placeholder="Price"/>
                            </th>
                            </tr>

                           </thead>
                          <tbody>
        
                         </tbody>
                        </table>
                      </div>
                      </div>



                <!-- Step 3: Description & FAQ (Placeholder for future logic) -->
                <div v-if="currentStep === 3" class="col-span-6">
                  <!-- Add Description & FAQ fields here in the future -->

                  <DefaultCard cardTitle="Description">
                    <div class="flex flex-col gap-5.5 p-6.5">
                        <div>
                        <label class="block mb-3 text-sm font-medium text-black dark:text-white">
                            Briefly Describe Your Gig
                        </label>
                        <textarea
                            rows="6"
                            v-model="gigForm.gig_description"
                            placeholder="Briefly Describe Your Gig"
                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                        ></textarea>
                        </div>

                        <div class="col-span-6">
                        <label for="faq" class="block text-sm font-medium text-gray-700">Frequently Asked Questions (FAQ)</label>

                        <!-- Dynamic FAQ Inputs -->
                        <div class="mt-2" v-for="(faq, index) in gigForm.faqs" :key="index">
                            <input
                            type="text"
                            v-model="faq.question"
                            placeholder="Enter your question"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />

                            <div class="mt-4">
                            <textarea
                                v-model="faq.answer"
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
                            @click="addMoreFAQs"
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                            Add More FAQ
                            </button>
                        </div>
                        </div>
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
                          class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter file:py-3 file:px-5 file:hover:bg-primary file:hover:bg-opacity-10 focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:file:bg-white/30 dark:file:text-white dark:focus:border-primary"
                        />
                      </div>

                      <div>
                        <label class="block mb-3 text-sm font-medium text-black dark:text-white">
                          Attach file
                        </label>
                        <input
                          type="file"
                          class="w-full rounded-md border border-stroke p-3 outline-none transition file:mr-4 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2.5 file:text-sm file:font-normal focus:border-primary file:focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-strokedark dark:file:bg-white/30 dark:file:text-white"
                        />
                      </div>
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
  