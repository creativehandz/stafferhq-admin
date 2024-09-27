<script setup lang="ts">
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
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

const goToStep = (step: number) => {
  currentStep.value = step;
};

const getCurrentStepComponent = () => {
  switch (currentStep.value) {
    case 1: return 'OverviewComponent';
    case 2: return 'PricingComponent';
    case 3: return 'DescriptionFAQComponent';
    case 4: return 'RequirementsComponent';
    case 5: return 'GalleryComponent';
    case 6: return 'PublishComponent';
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

      <div class="p-6 bg-white border rounded-lg shadow-md step-content">
        <component :is="getCurrentStepComponent()">
          <div class="px-4 py-5 bg-white sm:p-6">
            <form method="POST">
              <div class="grid grid-cols-6 gap-6">
                <!-- Gig title -->
                <div class="col-span-6">
                  <label for="gig-title" class="block text-sm font-medium text-gray-700">Gig Title</label>
                  <input type="text" name="gig_title" id="gig-title" autocomplete="gig-title" placeholder="I will do something I'm really good at" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>

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
              </div>

              <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-500 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  Save & Continue
                </button>
              </div>
            </form>
          </div>
        </component>
      </div>
    </div>

    <div class="flex justify-end p-4 space-x-4 bg-gray-50">
      <button class="px-6 py-2 text-gray-700 bg-gray-300 rounded-md" @click="goToStep(currentStep - 1)" :disabled="currentStep === 1">
        Back
      </button>
      <button class="px-6 py-2 text-white bg-orange-500 rounded-md" @click="goToStep(currentStep + 1)" :disabled="currentStep === steps.length">
        Next
      </button>
    </div>
  </AuthenticatedLayout>
</template>
