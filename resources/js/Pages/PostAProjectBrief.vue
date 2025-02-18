<script setup lang="ts">
import { ref, onMounted, watch } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import BuyerNavbar from "./BuyerNavbar.vue";
import Footer from "@/Components/LandingPage/Footer.vue";
import axios from "axios";

// Define interfaces for categories and subcategories
interface SubCategory {
    id: number;
    category_id: number;
    name: string;
}

interface Category {
    id: number;
    name: string;
    sub_categories: SubCategory[];
}

const form = useForm({
    jobTitle: "",
    jobDescription: "",
    location: "",
    category_id: "",
    sub_category_id: "",
    budget: "",
    image: null as File | null,
});

const categories = ref<Category[]>([]);
const subCategories = ref<SubCategory[]>([]);

// Fetch categories and subcategories from API
onMounted(async () => {
    try {
        const response = await axios.get("/categoriesandsub");
        categories.value = response.data;
    } catch (error) {
        console.error("Error fetching categories:", error);
    }
});

// Watch for category selection change and update subcategories
watch(
    () => form.category_id,
    (newCategoryId) => {
        const selectedCategory = categories.value.find(
            (cat) => cat.id == Number(newCategoryId)
        );

        subCategories.value = selectedCategory?.sub_categories || [];
        form.sub_category_id = ""; // Reset subcategory when category changes
    }
);

// Handle file input change
const handleFileUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target?.files && target.files.length > 0) {
        form.image = target.files[0];
    }
};

const submitForm = async () => {
    try {
        const formData = new FormData();
        formData.append("jobTitle", form.jobTitle);
        formData.append("jobDescription", form.jobDescription);
        formData.append("location", form.location);
        formData.append("category_id", form.category_id);
        formData.append("sub_category_id", form.sub_category_id || "");
        formData.append("budget", form.budget.toString());

        if (form.image) {
            formData.append("image", form.image);
        }

        await axios.post("/buyer-jobs", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });

        alert("Project brief posted successfully!");

        form.jobTitle = "";
        form.jobDescription = "";
        form.location = "";
        form.category_id = "";
        form.sub_category_id = "";
        form.budget = "";
        form.image = null;

        subCategories.value = [];
        const fileInput = document.querySelector(
            "input[type='file']"
        ) as HTMLInputElement;
        if (fileInput) {
            fileInput.value = "";
        }
    } catch (error) {
        console.error("Error submitting form:", error);
        alert("An error occurred while submitting the form.");
    }
};
</script>

<template>
    <section class="container mx-auto px-6 py-12">
        <BuyerNavbar />

        <!-- Breadcrumbs -->
        <div class="mb-5 text-sm leading-none">
            <a href="/" class="text-gray-500">Home /</a>
            <a href="/buyer-dashboard" class="text-gray-500"> Dashboard</a>
        </div>

        <!-- Form Title -->
        <div class="px-6 py-12 text-white bg-orange-500 rounded-3xl">
            <div class="container flex">
                <!-- Text Section -->
                <!-- Right Content Section (Text Right Aligned and Single Line h1) -->
                <div
                    class="flex flex-col justify-center w-1/2 text-right space-y-9"
                >
                    <h1
                        class="font-bold text-left leading-none sm:text-[55px] md:text-[55px] lg:text-[55px] xl:text-[55px] 2xl:text-[55px]"
                    >
                        Post A Project Brief
                    </h1>
                </div>
                <div class="flex justify-center w-1/2">
                    <img src="../../img/womenRiding.png" alt="Working Lady" />
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="mt-10 bg-white p-6 rounded-lg max-w-4xl mx-auto">
            <form @submit.prevent="submitForm">
                <div
                    class="grid grid-cols-1 sm:grid-cols-3 gap-x-4 gap-y-3 items-center"
                >
                    <!-- Job Title -->
                    <label class="text-gray-700 font-semibold">Job Title</label>
                    <input
                        type="text"
                        v-model="form.jobTitle"
                        class="col-span-2 w-full p-2 border rounded focus:ring focus:ring-orange-200"
                        required
                    />

                    <!-- Job Description -->
                    <label class="text-gray-700 font-semibold"
                        >Job Description</label
                    >
                    <textarea
                        v-model="form.jobDescription"
                        class="col-span-2 w-full p-2 border rounded focus:ring focus:ring-orange-200"
                        required
                    ></textarea>

                    <!-- Location -->
                    <label class="text-gray-700 font-semibold">Location</label>
                    <select
                        v-model="form.location"
                        class="col-span-2 w-full p-2 border rounded focus:ring focus:ring-orange-200"
                    >
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
                        <option value="Kuala Lumpur">
                            Kuala Lumpur (Federal Territory)
                        </option>
                        <option value="Labuan">
                            Labuan (Federal Territory)
                        </option>
                        <option value="Putrajaya">
                            Putrajaya (Federal Territory)
                        </option>
                    </select>

                    <!-- Category -->
                    <label class="text-gray-700 font-semibold">Category</label>
                    <select
                        v-model="form.category_id"
                        class="col-span-2 w-full p-2 border rounded focus:ring focus:ring-orange-200"
                    >
                        <option value="">Select a category</option>
                        <option
                            v-for="category in categories"
                            :key="category.id"
                            :value="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </select>

                    <!-- Sub Category -->
                    <label class="text-gray-700 font-semibold"
                        >Sub Category</label
                    >
                    <select
                        v-model="form.sub_category_id"
                        class="col-span-2 w-full p-2 border rounded focus:ring focus:ring-orange-200"
                    >
                        <option value="">Select a subcategory</option>
                        <option
                            v-for="sub in subCategories"
                            :key="sub.id"
                            :value="sub.id"
                        >
                            {{ sub.name }}
                        </option>
                    </select>

                    <!-- Budget -->
                    <label class="text-gray-700 font-semibold">Budget</label>
                    <input
                        type="number"
                        v-model="form.budget"
                        class="col-span-2 w-full p-2 border rounded focus:ring focus:ring-orange-200"
                        required
                    />

                    <!-- Upload Image -->
                    <label class="text-gray-700 font-semibold"
                        >Upload Image</label
                    >
                    <input
                        type="file"
                        @change="handleFileUpload"
                        class="col-span-2 w-full p-2 border rounded focus:ring focus:ring-orange-200"
                    />
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button
                        type="submit"
                        class="w-full p-3 bg-orange-500 text-white rounded-full font-bold hover:bg-orange-600"
                    >
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </section>

    <Footer />
</template>

<style scoped>
.container {
    max-width: 900px;
}
</style>
