<template>
    <div class="container px-8 py-8 mx-auto">
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        
        <div
      v-for="category in categories"
      :key="category.id"
      class="flex items-center justify-between px-6 py-8 transition-shadow duration-200 rounded-lg shadow-md cursor-pointer hover:shadow-lg"
    >
        
          <div class="flex items-center">
            <!-- SVG icon as an image -->
           
            <span class="leading-none sm:text-[18px]  md:text-[18px] lg:text-[18px] xl:text-[18px] 2xl:text-[18px] button-items">    
            <button> <a :href="`/categories/${category.id}`" class="no-underline">
          {{ category.name }}
        </a>
      </button> </span>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import webIcon from '../../../img/logos/Layer_2.svg';
  import translationIcon from '../../../img/logos/translation-icon.svg';
  import animationIcon from '../../../img/logos/camRa.svg';
  import graphicsIcon from '../../../img/logos/amination-icon.svg';
  import inpersonIcon from '../../../img/logos/scissors_2.svg';
  import aiIcon from '../../../img/logos/ai-icon.svg';
  import musicIcon from '../../../img/logos/music-icon.svg';
  import businessIcon from '../../../img/logos/businessM.svg';
  
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router'; // Use vue-router for navigation
import axios from 'axios';

const categories = ref<Array<Category>>([]);
const hoveredCategory = ref<Category | null>(null);

// Fetch categories and subcategories from backend
onMounted(() => {
  axios.get('/categoriesandsub').then(response => {
    categories.value = response.data; // Assuming response contains categories with subcategories
  }).catch(error => {
    console.error('Error fetching categories:', error);
  });
});

// Handle mouse enter/leave events
const handleMouseEnter = (category: Category) => {
  hoveredCategory.value = category;
};

const handleMouseLeave = () => {
  hoveredCategory.value = null;
};

// Vue Router instance to programmatically navigate
const router = useRouter();

// Navigate to category page on category click
const navigateToCategory = (id: number) => {
  router.push(`/categories/${id}`);
};

// Navigate to subcategory page on subcategory click
const navigateToSubcategory = (category_id: number) => {
  router.push(`/categories/${category_id}/sellers`);
};

// Define types
type Category = {
  id: number;
  name: string;
  sub_categories: Array<Subcategory>;
};

type Subcategory = {
  id: number;
  name: string;
};
  </script>
  

  