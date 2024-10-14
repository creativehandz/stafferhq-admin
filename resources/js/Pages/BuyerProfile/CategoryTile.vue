<template>
  <div class="flex flex-wrap gap-4 py-4">
    <div
      v-for="category in categories"
      :key="category.id"
      class="relative group"
    >
      <!-- Category Button -->
      <button
        class="px-4 py-2 text-black border shadow-md rounded-3xl leading-none sm:text-[16px] md:text-[16px] lg:text-[16px] xl:text-[16px] 2xl:text-[16px] text-left"
        @mouseenter="handleMouseEnter(category)"
        @mouseleave="handleMouseLeave"
        
      >
      <a :href="`/categories/${category.id}`" class="no-underline">
          {{ category.name }}
        </a>
      </button>

      <!-- Subcategory Dropdown -->
      <div
        v-if="hoveredCategory && hoveredCategory.id === category.id"
        class="absolute left-0 z-10 w-48 mt-2 bg-white border rounded-md shadow-lg"
        @mouseenter="handleMouseEnter(category)" 
        @mouseleave="handleMouseLeave"
      >
        <div
          v-for="subcategory in category.sub_categories"
          :key="subcategory.id"
          class="px-4 py-2 text-black cursor-pointer"
         
        >
           <a :href="`/categories/${subcategory.id}/sellers`"> {{ subcategory.name }}</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
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

<style scoped>
/* Add any scoped styles here if needed */
</style>
