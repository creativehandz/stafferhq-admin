<script setup lang="ts">
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import DefaultCard from "@/Components/Forms/DefaultCard.vue"; 
import axios from 'axios';
import { ref, onMounted } from 'vue';

const pageTitle = ref('Create a New Gig');
const currentStep = ref(1);

type Categories = {
  id: number;
  name: string;
};

type subcategories = {
  id: number;
  name: string;
};

type Props = {
    categories: Categories[];
};

const steps = [
  { number: 1, name: 'Overview' },
  { number: 2, name: 'Pricing' },
  { number: 3, name: 'Description & FAQ' },
  { number: 4, name: 'Requirements' },
  { number: 5, name: 'Gallery' },
  { number: 6, name: 'Publish' }
];

// Navigation between steps
const goToStep = (step: number) => {
  currentStep.value = step;
};

// Get the component to render for the current step
const getCurrentStepComponent = () => {
  switch (currentStep.value) {
    case 1: return 'OverviewComponent'; // Step 1: Overview
    case 2: return 'PricingComponent'; // Step 2: Pricing
    case 3: return 'DescriptionFAQComponent'; // Step 3: Description & FAQ
    case 4: return 'RequirementsComponent'; // Step 4: Requirements
    case 5: return 'GalleryComponent'; // Step 5: Gallery
    case 6: return 'PublishComponent'; // Step 6: Publish
    default: return 'OverviewComponent';
  }
};

// States for categories and subcategories
const categories = ref([]);
const subcategories = ref([]);
const selectedCategory = ref(null);
const selectedSubcategory = ref(null);

// Fetch categories and subcategories from backend
onMounted(() => {
  axios.get('/categories').then(response => {
    categories.value = response.data; // assuming response contains categories with subcategories
  }).catch(error => {
    console.error('Error fetching categories:', error);
  });
});

// Handle category change to filter subcategories
function handleCategoryChange() {
  const selected = categories.value.find(category => category.id === selectedCategory.value);
  subcategories.value = selected ? selected.subcategories : [];
}
</script>

<template>
  <Head title="Create a New Gig" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Create a New Gig
      </h2>
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
        <component :is="getCurrentStepComponent()">
          <div class="px-4 py-5 bg-white sm:p-6">
            <form method="POST">
              <!-- Form fields for each step -->
              <div class="grid grid-cols-6 gap-6">
                <!-- Step 1: Overview -->
                <div v-if="currentStep === 1" class="col-span-6">
                  <!-- Gig title -->
                   <DefaultCard cardTitle="Gig Title">
                  <label for="gig-title" class="block text-sm font-medium text-gray-700">Gig Title</label>
                  <input type="text" name="gig_title" id="gig-title" autocomplete="gig-title" placeholder="I will do something I'm really good at" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />




                                  <!-- Categories and Subcategories -->
                      <div class="col-span-6 sm:col-span-3">
                        <label for="category" class="block text-sm font-medium text-gray-700">Select Category</label>
                        <select v-model="selectedCategory" @change="handleCategoryChange" id="category" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                          <option disabled value="">Please select one</option>
                          <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                          </option>
                        </select>
                      </div>

                      <div class="col-span-6 sm:col-span-3">
                        <label for="subcategory" class="block text-sm font-medium text-gray-700">Select Subcategory</label>
                        <select v-model="selectedSubcategory" id="subcategory" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                          <option disabled value="">Please select one</option>
                          <option v-for="subcategory in subcategories" :key="subcategory.id" :value="subcategory.id">
                            {{ subcategory.name }}
                          </option>
                        </select>
                      </div>

                 <!-- Positive Keywords Field -->
                 <div class="col-span-6">
                  <label for="positive-keywords" class="block text-sm font-medium text-gray-700">Positive Keywords</label>
                  <input type="text" name="positive_keywords" id="positive-keywords" placeholder="Enter up to 5 tags" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                  <p class="mt-2 text-sm text-gray-500">5 tags maximum. Use letters and numbers only.</p>
                </div> 
              </DefaultCard>
              
                </div>
             

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
                          <th class="p-4 border border-stroke"><input placeholder="Name your package"/></th>
                          <th class="p-4 border border-stroke"><input placeholder="Name your package"/></th>
                          <th class="p-4 border border-stroke"><input placeholder="Name your package"/></th>
                          
                          <!-- <th class="p-4 border border-stroke">Price</th> -->
                        </tr>
                        <tr class="text-black bg-gray-200 dark:text-white">
                          <th class="p-4 border border-stroke"><input placeholder="Describe the details of your offering."/></th>
                          <th class="p-4 border border-stroke"><input placeholder="Describe the details of your offering."/></th>
                          <th class="p-4 border border-stroke"><input placeholder="Describe the details of your offering."/></th>
                          <!-- <th class="p-4 border border-stroke">Price</th> -->
                        </tr>
                            <tr class="text-black bg-gray-200 dark:text-white">
                              <th class="p-4 border border-stroke">
                                <select class="relative z-20 w-full px-12 py-3 transition bg-transparent border rounded outline-none appearance-none border-stroke focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input" >
                                      <option value="" disabled selected>Delivery Time</option>
                                      <option value="USA" class="text-body dark:text-bodydark">USA</option>
                                      <option value="UK" class="text-body dark:text-bodydark">UK</option>
                                      <option value="Canada" class="text-body dark:text-bodydark">Canada</option>
                                    </select>
                              </th>
                              <th class="p-4 border border-stroke">
                                <select class="relative z-20 w-full px-12 py-3 transition bg-transparent border rounded outline-none appearance-none border-stroke focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input" >
                                      <option value="" disabled selected>Delivery Time</option>
                                      <option value="USA" class="text-body dark:text-bodydark">USA</option>
                                      <option value="UK" class="text-body dark:text-bodydark">UK</option>
                                      <option value="Canada" class="text-body dark:text-bodydark">Canada</option>
                                    </select>
                              </th>
                              <th class="p-4 border border-stroke">
                                <select class="relative z-20 w-full px-12 py-3 transition bg-transparent border rounded outline-none appearance-none border-stroke focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input" >
                                      <option value="" disabled selected>Delivery Time</option>
                                      <option value="USA" class="text-body dark:text-bodydark">USA</option>
                                      <option value="UK" class="text-body dark:text-bodydark">UK</option>
                                      <option value="Canada" class="text-body dark:text-bodydark">Canada</option>
                                    </select>
                              </th>
                            </tr>

                            <!--  -->
                            <tr class="text-black bg-gray-200 dark:text-white">
                              <th class="p-4 border border-stroke">
                                <select class="relative z-20 w-full px-12 py-3 transition bg-transparent border rounded outline-none appearance-none border-stroke focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input" >
                                      <option value="" disabled selected>Revisions</option>
                                      <option value="0" class="text-body dark:text-bodydark">0</option>
                                      <option value="1" class="text-body dark:text-bodydark">1</option>
                                      <option value="2" class="text-body dark:text-bodydark">2</option>
                                      <option value="3" class="text-body dark:text-bodydark">3</option>
                                      <option value="Unlimited" class="text-body dark:text-bodydark">Unlimited</option>
                                    </select>
                              </th>
                              <th class="p-4 border border-stroke">
                                <select class="relative z-20 w-full px-12 py-3 transition bg-transparent border rounded outline-none appearance-none border-stroke focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input" >
                                      <option value="" disabled selected>Revisions</option>
                                      <option value="0" class="text-body dark:text-bodydark">0</option>
                                      <option value="1" class="text-body dark:text-bodydark">1</option>
                                      <option value="2" class="text-body dark:text-bodydark">2</option>
                                      <option value="3" class="text-body dark:text-bodydark">3</option>
                                      <option value="Unlimited" class="text-body dark:text-bodydark">Unlimited</option>
                                    </select>
                              </th>
                              <th class="p-4 border border-stroke">
                                <select class="relative z-20 w-full px-12 py-3 transition bg-transparent border rounded outline-none appearance-none border-stroke focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input" >
                                      <option value="" disabled selected>Revisions</option>
                                      <option value="0" class="text-body dark:text-bodydark">0</option>
                                      <option value="1" class="text-body dark:text-bodydark">1</option>
                                      <option value="2" class="text-body dark:text-bodydark">2</option>
                                      <option value="3" class="text-body dark:text-bodydark">3</option>
                                      <option value="Unlimited" class="text-body dark:text-bodydark">Unlimited</option>
                                    </select>
                              </th>
                            </tr>
                            <tr class="text-black bg-gray-200 dark:text-white">
                              <th class="p-4 border border-stroke"><input placeholder="Price"/></th>
                              <th class="p-4 border border-stroke"><input placeholder="Price"/></th>
                              <th class="p-4 border border-stroke"><input class="" placeholder="Price"/></th>
                              <!-- <th class="p-4 border border-stroke">Price</th> -->
                             </tr>
                           </thead>
                          <tbody>
        
                         </tbody>
                        </table>

                    <!-- Button to Add Row -->

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
                          placeholder="Briefly Describe Your Gig"
                          class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                        ></textarea>
                      </div>

                      <div>
                        <label class="block mb-3 text-sm font-medium text-black dark:text-white">
                          Active textarea
                        </label>
                        <textarea
                          rows="6"
                          placeholder="Active textarea"
                          class="w-full rounded-lg border-[1.5px] text-black border-primary bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:bg-form-input"
                        ></textarea>
                      </div>

                      <div>
                        <label class="block mb-3 text-sm font-medium text-black dark:text-white">
                          Disabled textarea
                        </label>
                        <textarea
                          rows="6"
                          disabled
                          placeholder="Disabled textarea"
                          class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary dark:disabled:bg-black"
                        ></textarea>
                      </div>
                      
                    </div>
                 </DefaultCard>
                  
                </div>

                <!-- Step 4: Requirements (Placeholder for future logic) -->
                <div v-if="currentStep === 4" class="col-span-6">
                  <!-- Add Requirements fields here in the future -->
                   <DefaultCard cardTitle="">


                    
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
                    <button type="button" class="px-6 py-2 text-white bg-orange-500 rounded-md">
                        Publish Your Gig
                    </button>                    
                   </DefaultCard>
                </div>
              </div>

              <!-- Step form buttons -->
              <div class="flex justify-end px-4 py-3 text-right bg-gray-50 sm:px-6">
                <button type="button" class="px-6 py-2 mr-2 text-gray-700 bg-gray-300 rounded-md" @click="goToStep(currentStep - 1)" :disabled="currentStep === 1">
                  Back
                </button>
                <button type="button" class="px-6 py-2 text-white bg-orange-500 rounded-md" @click="goToStep(currentStep + 1)" :disabled="currentStep === steps.length">
                  Save & Continue
                </button>
              </div>
            </form>
          </div>
        </component>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
