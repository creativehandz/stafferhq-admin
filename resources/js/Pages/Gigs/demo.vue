<script setup lang="ts">
import { ref, onMounted, defineComponent } from "vue";
import { useForm } from "@inertiajs/vue3";
import { required, minLength, numeric, maxLength } from "@vuelidate/validators"; // Import required validators
import useVuelidate from "@vuelidate/core"; // Import Vuelidate core
import axios from "axios";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import DefaultCard from "@/Components/Forms/DefaultCard.vue";
import Modal from "@/Components/Modal.vue";

// Form state using Inertia's useForm
const gigForm = useForm({
    gig_title: "",
    category_id: null,
    subcategory_id: null,
    certificate: null,
    gig_description: "",
    positive_keywords: [], // Array for tags
    images: [], // Array for images
    requirements: [""],
    faqs: [{ question: "", answer: "" }],
    pricing: {
        basic: {
            name: "",
            description: "",
            delivery_time: "",
            // revisions: '',
            price: "",
        },
        standard: {
            name: "",
            description: "",
            delivery_time: "",
            // revisions: '',
            price: "",
        },
        premium: {
            name: "",
            description: "",
            delivery_time: "",
            // revisions: '',
            price: "",
        },
    },
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

    faqs: [
        {
            question: { required },
            answer: { required },
        },
    ],

    // Pricing section validation
    pricing: {
        basic: {
            name: { required },
            description: { required },
            delivery_time: { required },
            // revisions: { required },
            price: { required, numeric },
        },
        standard: {
            name: { required },
            description: { required },
            delivery_time: { required },
            // revisions: { required },
            price: { required, numeric },
        },
        premium: {
            name: { required },
            description: { required },
            delivery_time: { required },
            // revisions: { required },
            price: { required, numeric },
        },
    },
};

// the initail value for each fields validation
const formValidation = {
    gig_title: true,
    category_id: true,
    subcategory_id: true,
    certificate: true,
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
            // revisions: true,
            price: true,
        },
        standard: {
            name: true,
            description: true,
            delivery_time: true,
            // revisions: true,
            price: true,
        },
        premium: {
            name: true,
            description: true,
            delivery_time: true,
            // revisions: true,
            price: true,
        },
    },
    message: [],
};

// Initialize Vuelidate with rules
const v$ = useVuelidate(rules, gigForm);

// State for positive keywords and new keyword input
const positiveKeywords = ref<string[]>([]); // Array to store the added tags
const newKeyword = ref<string>(""); // Model for the input field

// Method to add a tag
const addTag = () => {
    const keyword = newKeyword.value.trim();
    const isValidKeyword = /^[a-zA-Z0-9]+$/.test(keyword); // Check if keyword is valid (letters and numbers only)

    if (keyword && isValidKeyword && positiveKeywords.value.length < 5) {
        positiveKeywords.value.push(keyword); // Add the new tag
        newKeyword.value = ""; // Clear the input field
    }
};

// Method to remove a tag by index
const removeTag = (index: number) => {
    positiveKeywords.value.splice(index, 1); // Remove tag by index
};

// Add or remove requirement functionality
const requirements = ref<string[]>([""]); // Initialize with one empty requirement input
const addRequirement = () => requirements.value.push(""); // Add a new empty requirement input
const removeRequirement = (index: number) =>
    requirements.value.splice(index, 1); // Remove the requirement at the specified index

// Fetch categories from backend on mount
const categories = ref([]);
const subcategories = ref([]);
const errorMessage = ref("");
const isModalOpen = ref(false); // Control modal visibility

onMounted(() => {
    axios
        .get("/categoriesandsub")
        .then((response) => {
            categories.value = response.data;
        })
        .catch((error) => {
            console.error("Error fetching categories:", error);
        });
});

// Handle category change to populate subcategories
const handleCategoryChange = () => {
    const selected = categories.value.find(
        (category) => category["id"] === gigForm.category_id
    );
    subcategories.value = selected ? selected["sub_categories"] : [];
};

// Navigation between steps
const currentStep = ref(1);
const steps = [
    { number: 1, name: "Overview" },
    { number: 2, name: "Pricing" },
    { number: 3, name: "Description & FAQ" },
    { number: 4, name: "Requirements" },
    { number: 5, name: "Gallery" },
    { number: 6, name: "Publish" },
];

const goToStep = (step: number) => {
    gigForm.requirements = requirements.value;
    gigForm.positive_keywords = positiveKeywords.value.join(",");

    const validation = validateGigForm(step - 1);
    console.log(validation);
    if (validation.isValid) {
        currentStep.value = step;
    } else {
        errorMessage.value = formValidation.message[step - 1];
        isModalOpen.value = true; // Open modal
        console.error("Form validation failed: ", errorMessage.value);
    }
};

// Function to add more FAQs
const addMoreFAQs = () => {
    gigForm.faqs.push({ question: "", answer: "" }); // Add a new FAQ object
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

const pageTitle = ref("Create A Gig");

const handleCertificateUpload = (event) => {
    const file = event.target.files[0]; // Get the first uploaded file

    // Replace the existing certificate with the new one
    if (file) {
        gigForm.certificate = file;
    }

    console.log(gigForm.certificate); // To see the uploaded certificate in the console
};

const validateGigForm = (step = 0) => {
    let enable = true;

    if (step === 1) {
        formValidation.message[step] = "";
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

        if (!gigForm.certificate) {
            enable = false;
            formValidation.certificate = false;
            formValidation.message[step] += "Certificate file is required.<br>";
        }

        return { isValid: enable };
    } else if (step === 2) {
        formValidation.message[step] = "";
        for (const plan in gigForm.pricing) {
            console.log("Plan is : ", plan);
            if (!gigForm.pricing[plan].name) {
                enable = false;
                formValidation.pricing[plan].name = false;
                formValidation.message[
                    step
                ] += `The name of the ${plan} package is required.<br>`;
            }

            if (!gigForm.pricing[plan].description) {
                enable = false;
                formValidation.pricing[plan].description = false;
                formValidation.message[
                    step
                ] += `The description of the ${plan} package is required.<br>`;
            }

            if (!gigForm.pricing[plan].delivery_time) {
                enable = false;
                formValidation.pricing[plan].delivery_time = false;
                formValidation.message[
                    step
                ] += `Delivery time of the ${plan} package is required.<br>`;
            }

            // if (!gigForm.pricing[plan].revisions) {
            //   enable = false;
            //   formValidation.pricing[plan].revisions = false;
            //   formValidation.message[step] += `Revisions for the ${plan} package is required.<br>`;
            // }

            if (!gigForm.pricing[plan].price) {
                enable = false;
                formValidation.pricing[plan].price = false;
                formValidation.message[
                    step
                ] += `Price for the ${plan} package is required.<br>`;
            }
        }

        return { isValid: enable };
    } else if (step === 3) {
        formValidation.message[step] = "";
        if (!gigForm.gig_description) {
            enable = false;
            formValidation.gig_description = false;
            formValidation.message[step] += `Gig Description is required.<br>`;
        }

        if (
            gigForm.faqs.length > 0 &&
            gigForm.faqs.some((faq) => !faq.question || !faq.answer)
        ) {
            enable = false;
            formValidation.faqs = false;
            formValidation.message[
                step
            ] += `All FAQs must have both a question and an answer.<br>`;
        }

        return { isValid: enable };
    } else if (step === 4) {
        formValidation.message[step] = "";
        if (
            gigForm.requirements.length === 0 ||
            gigForm.requirements.some((req) => !req)
        ) {
            enable = false;
            formValidation.requirements = false;
            formValidation.message[
                step
            ] += `At least one requirement is required.<br>`;
        }

        return { isValid: enable };
    } else if (step === 5) {
        formValidation.message[step] = "";
        if (gigForm.images.length === 0) {
            enable = false;
            formValidation.images = false;
            formValidation.message[
                step
            ] += `At least one image is required.<br>`;
        }
        return { isValid: enable };
    } else {
        return { isValid: enable };
    }
};

const closeModal = () => {
    errorMessage.value = "";
    isModalOpen.value = null;
};

// Submit form to the backend
const handleSubmit = async () => {
    gigForm.requirements = requirements.value;
    gigForm.positive_keywords = positiveKeywords.value.join(",");

    gigForm.post("/create-gig", {
        onSuccess: () => {
            console.log("A new gig has been successfully saved.");
        },
    });
};
</script>

<template>
    <Head title="Create a New Gig" />
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Create a New Gig
            </h2>
        </template>

        <BreadcrumbDefault :pageTitle="pageTitle" />

        <!-- Error Modal -->
        <div
            v-if="isModalOpen"
            @close="closeModal"
            class="fixed z-50 left-[50%] top-[50%] translate-x-[-50%] translate-y-[-50%] mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto sm:max-w-2xl"
        >
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900 dark:text-gray-100"
                >
                    Validation Error
                </h2>

                <div
                    v-html="errorMessage"
                    class="flex items-center justify-center mt-1 text-sm text-gray-600 dark:text-gray-400"
                ></div>

                <div class="flex justify-end mt-6">
                    <SecondaryButton @click="closeModal"> OK </SecondaryButton>
                </div>
            </div>
        </div>

        <!-- Step indicators -->
        <div class="">
            <div class="bg-white shadow-md p-4 border border-slate-200 w-full bg-slate-200">
                <div class="flex gap-5 flex-nowrap">
                    <div
                        v-for="(step, index) in steps"
                        :key="step.number"
                        class="flex items-center justify-start"
                    >
                        <!-- Step Circle -->
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-full text-sm font-semibold transition-all duration-300"
                            :class="
                                currentStep === step.number
                                    ? 'bg-orange-500 text-white shadow-md'
                                    : 'bg-slate-200 text-gray-500'
                            "
                        >
                            {{ step.number }}
                        </div>

                        <!-- Step Name -->
                        <span
                            class="ml-2 text-base font-medium transition-all duration-300 whitespace-nowrap"
                            :class="
                                currentStep === step.number
                                    ? 'text-orange-500 font-semibold'
                                    : 'text-gray-600'
                            "
                        >
                            {{ step.name }}
                        </span>

                        <!-- Connecting Line (Expands to Fit) -->
                        <div
                            v-if="index !== steps.length - 1"
                            class="h-0.5 flex-grow mx-2 bg-gray-300"
                            :class="{
                                'bg-orange-500': currentStep > step.number,
                                'bg-gray-300': currentStep <= step.number,
                            }"
                        ></div>
                    </div>
                </div>
            </div>

            <!-- Dynamic Step Content -->
            <div class="pt-10 bg-white rounded-lg step-content">
                <form
                    @submit.prevent="
                        currentStep === 6
                            ? handleSubmit()
                            : goToStep(currentStep + 1)
                    "
                >
                    <div class="grid grid-cols-6 gap-6">
                        <!-- Step 1: Overview -->
                        <div v-if="currentStep === 1" class="col-span-6">
                            <div class="w-full">
                                <!-- Gig Title Header -->
                                <h3
                                    class="text-2xl font-semibold text-black mb-4"
                                    style="font-family: 'Crimson Pro', serif"
                                >
                                    Gig Title
                                </h3>

                                <!-- Gig Title Input -->
                                <label
                                    for="gig-title"
                                    class="block text-sm font-semibold text-gray-700"
                                    style="
                                        font-family: 'Neue Montreal', sans-serif;
                                    "
                                >
                                    Gig Title
                                </label>
                                <input
                                    v-model="gigForm.gig_title"
                                    type="text"
                                    id="gig-title"
                                    placeholder="I will do something I'm really good at"
                                    class="block w-full mt-1 border-b border-gray-300 px-2 py-2 text-gray-900 sm:text-sm focus:outline-none"
                                    @input="v$.gig_title.$touch()"
                                    :class="{
                                        'border-red-500': v$.gig_title.$error,
                                    }"
                                    style="
                                        font-family: 'Neue Montreal', sans-serif;
                                    "
                                />
                                <span
                                    v-if="v$.gig_title.$error"
                                    class="text-sm text-red-500"
                                    >Title is required (min 3 characters).</span
                                >

                                <!-- Category Select -->
                                <label
                                    for="category"
                                    class="block mt-4 text-sm font-semibold text-gray-700"
                                    style="
                                        font-family: 'Neue Montreal', sans-serif;
                                    "
                                >
                                    Select Category
                                </label>
                                <select
                                    v-model="gigForm.category_id"
                                    @change="
                                        v$.category_id.$touch();
                                        handleCategoryChange();
                                    "
                                    id="category"
                                    class="block w-full mt-1 border-b border-gray-300 px-2 py-2 text-gray-900 sm:text-sm focus:outline-none"
                                    :class="{
                                        'border-red-500': v$.category_id.$error,
                                    }"
                                    style="
                                        font-family: 'Neue Montreal', sans-serif;
                                    "
                                >
                                    <option disabled value="">
                                        Please select one
                                    </option>
                                    <option
                                        v-for="category in categories"
                                        :key="category.id"
                                        :value="category.id"
                                    >
                                        {{ category.name }}
                                    </option>
                                </select>
                                <span
                                    v-if="v$.category_id.$error"
                                    class="text-sm text-red-500"
                                    >Category is required.</span
                                >

                                <!-- Subcategory Select -->
                                <label
                                    for="subcategory"
                                    class="block mt-4 text-sm font-semibold text-gray-700"
                                    style="
                                        font-family: 'Neue Montreal', sans-serif;
                                    "
                                >
                                    Select Subcategory
                                </label>
                                <select
                                    v-model="gigForm.subcategory_id"
                                    @change="v$.subcategory_id.$touch()"
                                    id="subcategory"
                                    class="block w-full mt-1 border-b border-gray-300 px-2 py-2 text-gray-900 sm:text-sm focus:outline-none"
                                    :class="{
                                        'border-red-500':
                                            v$.subcategory_id.$error,
                                    }"
                                    style="
                                        font-family: 'Neue Montreal', sans-serif;
                                    "
                                >
                                    <option disabled value="">
                                        Please select one
                                    </option>
                                    <option
                                        v-for="subcategory in subcategories"
                                        :key="subcategory.id"
                                        :value="subcategory.id"
                                    >
                                        {{ subcategory.name }}
                                    </option>
                                </select>
                                <span
                                    v-if="v$.subcategory_id.$error"
                                    class="text-sm text-red-500"
                                    >Subcategory is required.</span
                                >

                                <!-- Positive Keywords -->
                                <label
                                    for="positive-keywords"
                                    class="block mt-4 text-sm font-semibold text-gray-700"
                                    style="
                                        font-family: 'Neue Montreal', sans-serif;
                                    "
                                >
                                    Positive Keywords
                                </label>
                                <div class="relative">
                                    <!-- Input Field -->
                                    <input
                                        v-model="newKeyword"
                                        @keydown.enter.prevent="addTag"
                                        @keydown.comma.prevent="addTag"
                                        type="text"
                                        id="positive-keywords"
                                        :placeholder="
                                            positiveKeywords.length === 0
                                                ? 'Enter up to 5 tags'
                                                : ''
                                        "
                                        class="block w-full mt-1 border-b border-gray-300 px-2 py-2 text-gray-900 sm:text-sm focus:outline-none placeholder-gray-400"
                                        :disabled="positiveKeywords.length >= 5"
                                        style="
                                            font-family: 'Neue Montreal',
                                                sans-serif;
                                        "
                                    />

                                    <!-- Tags (Properly Aligned & Inside the Input Box) -->
                                    <div
                                        class="absolute top-1/2 left-2 transform -translate-y-1/2 flex flex-wrap items-center space-x-2"
                                    >
                                        <span
                                            v-for="(
                                                tag, index
                                            ) in positiveKeywords"
                                            :key="index"
                                            class="inline-flex items-center bg-orange-200 text-orange-800 text-xs font-semibold px-2.5 py-1 rounded"
                                        >
                                            {{ tag }}
                                            <span
                                                @click="removeTag(index)"
                                                class="ml-1 cursor-pointer"
                                                >x</span
                                            >
                                        </span>
                                    </div>
                                </div>

                                <!-- Instruction (Only Show When No Tags Exist) -->
                                <p
                                    v-if="positiveKeywords.length === 0"
                                    class="mt-2 text-sm text-gray-500"
                                >
                                    5 tags maximum. Use letters and numbers
                                    only.
                                </p>

                                <!-- Add Certificate -->
                                <div class="mt-4">
                                    <label
                                        class="block text-sm font-semibold text-gray-700"
                                        style="
                                            font-family: 'Neue Montreal',
                                                sans-serif;
                                        "
                                    >
                                        Add Certificate
                                    </label>
                                    <input
                                        type="file"
                                        name="certificate"
                                        @change="handleCertificateUpload"
                                        class="block w-full mt-1 text-gray-900 sm:text-sm"
                                        style="
                                            font-family: 'Neue Montreal',
                                                sans-serif;
                                        "
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Pricing -->
                        <div v-if="currentStep === 2" class="col-span-6">
                            <div
                                class="w-full overflow-hidden"
                            >
                                <table class="min-w-full table-auto">
                                    <thead>
                                        <tr class="text-black bg-gray-100">
                                            <th
                                                class="p-4 text-xl font-semibold text-gray-700 font-crimson"
                                            >
                                                Basic
                                            </th>
                                            <th
                                                class="p-4 text-xl font-semibold text-gray-700 font-crimson"
                                            >
                                                Standard
                                            </th>
                                            <th
                                                class="p-4 text-xl font-semibold text-gray-700 font-crimson"
                                            >
                                                Premium
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Package Name Row -->
                                        <tr>
                                            <td class="px-4 py-2">
                                                <input
                                                    v-model="
                                                        gigForm.pricing.basic
                                                            .name
                                                    "
                                                    @input="
                                                        v$.pricing.basic.name.$touch()
                                                    "
                                                    type="text"
                                                    placeholder="Name your package"
                                                    :class="{
                                                        'border-red-500':
                                                            v$.pricing.basic
                                                                .name.$error,
                                                        'border-gray-300':
                                                            !v$.pricing.basic
                                                                .name.$error,
                                                    }"
                                                    class="w-full px-3 py-2 border-b focus:outline-none"
                                                />
                                                <span
                                                    v-if="
                                                        v$.pricing.basic.name
                                                            .$error
                                                    "
                                                    class="text-sm text-red-500"
                                                    >Please enter a valid name
                                                    (min 3 characters).</span
                                                >
                                            </td>
                                            <td class="px-4 py-2">
                                                <input
                                                    v-model="
                                                        gigForm.pricing.standard
                                                            .name
                                                    "
                                                    @input="
                                                        v$.pricing.standard.name.$touch()
                                                    "
                                                    type="text"
                                                    placeholder="Name your package"
                                                    :class="{
                                                        'border-red-500':
                                                            v$.pricing.standard
                                                                .name.$error,
                                                        'border-gray-300':
                                                            !v$.pricing.standard
                                                                .name.$error,
                                                    }"
                                                    class="w-full px-3 py-2 border-b focus:outline-none"
                                                />
                                                <span
                                                    v-if="
                                                        v$.pricing.standard.name
                                                            .$error
                                                    "
                                                    class="text-sm text-red-500"
                                                    >Please enter a valid name
                                                    (min 3 characters).</span
                                                >
                                            </td>
                                            <td class="px-4 py-2">
                                                <input
                                                    v-model="
                                                        gigForm.pricing.premium
                                                            .name
                                                    "
                                                    @input="
                                                        v$.pricing.premium.name.$touch()
                                                    "
                                                    type="text"
                                                    placeholder="Name your package"
                                                    :class="{
                                                        'border-red-500':
                                                            v$.pricing.premium
                                                                .name.$error,
                                                        'border-gray-300':
                                                            !v$.pricing.premium
                                                                .name.$error,
                                                    }"
                                                    class="w-full px-3 py-2 border-b focus:outline-none"
                                                />
                                                <span
                                                    v-if="
                                                        v$.pricing.premium.name
                                                            .$error
                                                    "
                                                    class="text-sm text-red-500"
                                                    >Please enter a valid name
                                                    (min 3 characters).</span
                                                >
                                            </td>
                                        </tr>

                                        <!-- Package Description Row -->
                                        <tr>
                                            <td class="px-4 py-2">
                                                <input
                                                    v-model="
                                                        gigForm.pricing.basic
                                                            .description
                                                    "
                                                    @input="
                                                        v$.pricing.basic.description.$touch()
                                                    "
                                                    placeholder="Describe the details of your offering."
                                                    :class="{
                                                        'border-red-500':
                                                            v$.pricing.basic
                                                                .description
                                                                .$error,
                                                        'border-gray-300':
                                                            !v$.pricing.basic
                                                                .description
                                                                .$error,
                                                    }"
                                                    class="w-full px-3 py-2 border-b focus:outline-none"
                                                />
                                                <span
                                                    v-if="
                                                        v$.pricing.basic
                                                            .description.$error
                                                    "
                                                    class="text-sm text-red-500"
                                                    >Description is required
                                                    (min 10 characters).</span
                                                >
                                            </td>
                                            <td class="px-4 py-2">
                                                <input
                                                    v-model="
                                                        gigForm.pricing.standard
                                                            .description
                                                    "
                                                    @input="
                                                        v$.pricing.standard.description.$touch()
                                                    "
                                                    placeholder="Describe the details of your offering."
                                                    :class="{
                                                        'border-red-500':
                                                            v$.pricing.standard
                                                                .description
                                                                .$error,
                                                        'border-gray-300':
                                                            !v$.pricing.standard
                                                                .description
                                                                .$error,
                                                    }"
                                                    class="w-full px-3 py-2 border-b focus:outline-none"
                                                />
                                                <span
                                                    v-if="
                                                        v$.pricing.standard
                                                            .description.$error
                                                    "
                                                    class="text-sm text-red-500"
                                                    >Description is required
                                                    (min 10 characters).</span
                                                >
                                            </td>
                                            <td class="px-4 py-2">
                                                <input
                                                    v-model="
                                                        gigForm.pricing.premium
                                                            .description
                                                    "
                                                    @input="
                                                        v$.pricing.premium.description.$touch()
                                                    "
                                                    placeholder="Describe the details of your offering."
                                                    :class="{
                                                        'border-red-500':
                                                            v$.pricing.premium
                                                                .description
                                                                .$error,
                                                        'border-gray-300':
                                                            !v$.pricing.premium
                                                                .description
                                                                .$error,
                                                    }"
                                                    class="w-full px-3 py-2 border-b focus:outline-none"
                                                />
                                                <span
                                                    v-if="
                                                        v$.pricing.premium
                                                            .description.$error
                                                    "
                                                    class="text-sm text-red-500"
                                                    >Description is required
                                                    (min 10 characters).</span
                                                >
                                            </td>
                                        </tr>

                                        <!-- Delivery Time Row -->
                                        <tr>
                                            <td class="px-4 py-2">
                                                <select
                                                    v-model="
                                                        gigForm.pricing.basic
                                                            .delivery_time
                                                    "
                                                    @change="
                                                        v$.pricing.basic.delivery_time.$touch()
                                                    "
                                                    :class="{
                                                        'border-red-500':
                                                            v$.pricing.basic
                                                                .delivery_time
                                                                .$error,
                                                        'border-gray-300':
                                                            !v$.pricing.basic
                                                                .delivery_time
                                                                .$error,
                                                    }"
                                                    class="w-full px-3 py-2 border-b focus:outline-none"
                                                >
                                                    <option value="" disabled>
                                                        Delivery Time
                                                    </option>
                                                    <option value="1 day">
                                                        1 Day
                                                    </option>
                                                    <option value="3 days">
                                                        3 Days
                                                    </option>
                                                    <option value="7 days">
                                                        7 Days
                                                    </option>
                                                    <option value="14 days">
                                                        14 Days
                                                    </option>
                                                    <option value="30 days">
                                                        30 Days
                                                    </option>
                                                </select>
                                                <span
                                                    v-if="
                                                        v$.pricing.basic
                                                            .delivery_time
                                                            .$error
                                                    "
                                                    class="text-sm text-red-500"
                                                    >Delivery time is
                                                    required.</span
                                                >
                                            </td>
                                            <td class="px-4 py-2">
                                                <select
                                                    v-model="
                                                        gigForm.pricing.standard
                                                            .delivery_time
                                                    "
                                                    @change="
                                                        v$.pricing.standard.delivery_time.$touch()
                                                    "
                                                    :class="{
                                                        'border-red-500':
                                                            v$.pricing.standard
                                                                .delivery_time
                                                                .$error,
                                                        'border-gray-300':
                                                            !v$.pricing.standard
                                                                .delivery_time
                                                                .$error,
                                                    }"
                                                    class="w-full px-3 py-2 border-b focus:outline-none"
                                                >
                                                    <option value="" disabled>
                                                        Delivery Time
                                                    </option>
                                                    <option value="1 day">
                                                        1 Day
                                                    </option>
                                                    <option value="3 days">
                                                        3 Days
                                                    </option>
                                                    <option value="7 days">
                                                        7 Days
                                                    </option>
                                                    <option value="14 days">
                                                        14 Days
                                                    </option>
                                                    <option value="30 days">
                                                        30 Days
                                                    </option>
                                                </select>
                                                <span
                                                    v-if="
                                                        v$.pricing.standard
                                                            .delivery_time
                                                            .$error
                                                    "
                                                    class="text-sm text-red-500"
                                                    >Delivery time is
                                                    required.</span
                                                >
                                            </td>
                                            <td class="px-4 py-2">
                                                <select
                                                    v-model="
                                                        gigForm.pricing.premium
                                                            .delivery_time
                                                    "
                                                    @change="
                                                        v$.pricing.premium.delivery_time.$touch()
                                                    "
                                                    :class="{
                                                        'border-red-500':
                                                            v$.pricing.premium
                                                                .delivery_time
                                                                .$error,
                                                        'border-gray-300':
                                                            !v$.pricing.premium
                                                                .delivery_time
                                                                .$error,
                                                    }"
                                                    class="w-full px-3 py-2 border-b focus:outline-none"
                                                >
                                                    <option value="" disabled>
                                                        Delivery Time
                                                    </option>
                                                    <option value="1 day">
                                                        1 Day
                                                    </option>
                                                    <option value="3 days">
                                                        3 Days
                                                    </option>
                                                    <option value="7 days">
                                                        7 Days
                                                    </option>
                                                    <option value="14 days">
                                                        14 Days
                                                    </option>
                                                    <option value="30 days">
                                                        30 Days
                                                    </option>
                                                </select>
                                                <span
                                                    v-if="
                                                        v$.pricing.premium
                                                            .delivery_time
                                                            .$error
                                                    "
                                                    class="text-sm text-red-500"
                                                    >Delivery time is
                                                    required.</span
                                                >
                                            </td>
                                        </tr>

                                        <!-- Price Row -->
                                        <tr>
                                            <td class="px-4 py-2">
                                                <input
                                                    v-model="
                                                        gigForm.pricing.basic
                                                            .price
                                                    "
                                                    @input="
                                                        v$.pricing.basic.price.$touch()
                                                    "
                                                    type="number"
                                                    placeholder="Price"
                                                    min="0"
                                                    :class="{
                                                        'border-red-500':
                                                            v$.pricing.basic
                                                                .price.$error,
                                                        'border-gray-300':
                                                            !v$.pricing.basic
                                                                .price.$error,
                                                    }"
                                                    class="w-full px-3 py-2 border-b focus:outline-none"
                                                />
                                                <span
                                                    v-if="
                                                        v$.pricing.basic.price
                                                            .$error
                                                    "
                                                    class="text-sm text-red-500"
                                                    >Price is required and must
                                                    be numeric.</span
                                                >
                                            </td>
                                            <td class="px-4 py-2">
                                                <input
                                                    v-model="
                                                        gigForm.pricing.standard
                                                            .price
                                                    "
                                                    @input="
                                                        v$.pricing.standard.price.$touch()
                                                    "
                                                    type="number"
                                                    placeholder="Price"
                                                    min="0"
                                                    :class="{
                                                        'border-red-500':
                                                            v$.pricing.standard
                                                                .price.$error,
                                                        'border-gray-300':
                                                            !v$.pricing.standard
                                                                .price.$error,
                                                    }"
                                                    class="w-full px-3 py-2 border-b focus:outline-none"
                                                />
                                                <span
                                                    v-if="
                                                        v$.pricing.standard
                                                            .price.$error
                                                    "
                                                    class="text-sm text-red-500"
                                                    >Price is required and must
                                                    be numeric.</span
                                                >
                                            </td>
                                            <td class="px-4 py-2">
                                                <input
                                                    v-model="
                                                        gigForm.pricing.premium
                                                            .price
                                                    "
                                                    @input="
                                                        v$.pricing.premium.price.$touch()
                                                    "
                                                    type="number"
                                                    placeholder="Price"
                                                    min="0"
                                                    :class="{
                                                        'border-red-500':
                                                            v$.pricing.premium
                                                                .price.$error,
                                                        'border-gray-300':
                                                            !v$.pricing.premium
                                                                .price.$error,
                                                    }"
                                                    class="w-full px-3 py-2 border-b focus:outline-none"
                                                />
                                                <span
                                                    v-if="
                                                        v$.pricing.premium.price
                                                            .$error
                                                    "
                                                    class="text-sm text-red-500"
                                                    >Price is required and must
                                                    be numeric.</span
                                                >
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Step 3: Description & FAQ -->
                        <div v-if="currentStep === 3" class="col-span-6">
                            <!-- Description -->
                            <div class="w-full">
                                <h3
                                    class="text-2xl font-semibold text-black mb-4"
                                    style="font-family: 'Crimson Pro', serif"
                                >
                                    Description
                                </h3>

                                <label
                                    for="gig-description"
                                    class="block text-sm font-semibold text-gray-700"
                                    style="
                                        font-family: 'Neue Montreal', sans-serif;
                                    "
                                >
                                    Briefly Describe Your Gig
                                </label>
                                <textarea
                                    v-model="gigForm.gig_description"
                                    @input="v$.gig_description.$touch()"
                                    id="gig-description"
                                    rows="4"
                                    placeholder="Briefly Describe Your Gig"
                                    class="block w-full px-3 py-2 border-b focus:outline-none placeholder-opacity-50 placeholder-gray-400 text-black sm:text-sm"
                                    :class="{
                                        'border-red-500':
                                            v$.gig_description.$error,
                                        'border-gray-300':
                                            !v$.gig_description.$error,
                                    }"
                                    style="
                                        font-family: 'Neue Montreal', sans-serif;
                                    "
                                ></textarea>
                                <span
                                    v-if="v$.gig_description.$error"
                                    class="text-sm text-red-500"
                                >
                                    Description is required (min 10 characters).
                                </span>
                            </div>

                            <!-- FAQ Section -->
                            <div class="w-full mt-10">
                                <h3
                                    class="text-2xl font-semibold text-black mb-4"
                                    style="font-family: 'Crimson Pro', serif"
                                >
                                    Frequently Asked Questions (FAQ)
                                </h3>

                                <div
                                    v-for="(faq, index) in gigForm.faqs"
                                    :key="index"
                                    class="mb-4"
                                >
                                    <label
                                        for="question"
                                        class="block text-sm font-semibold text-gray-700"
                                        style="
                                            font-family: 'Neue Montreal',
                                                sans-serif;
                                        "
                                    >
                                        Enter Question
                                    </label>
                                    <input
                                        v-model="faq.question"
                                        @input="
                                            v$.faqs[index].question.$touch()
                                        "
                                        type="text"
                                        placeholder="Enter question"
                                        class="block w-full mt-1 px-3 py-2 border-b focus:outline-none placeholder-opacity-50 placeholder-gray-400 sm:text-sm"
                                        :class="{
                                            'border-red-500':
                                                v$.faqs[index].question.$error,
                                            'border-gray-300':
                                                !v$.faqs[index].question.$error,
                                        }"
                                        style="
                                            font-family: 'Neue Montreal',
                                                sans-serif;
                                        "
                                    />

                                    <label
                                        for="answer"
                                        class="block text-sm font-semibold text-gray-700 mt-4"
                                        style="
                                            font-family: 'Neue Montreal',
                                                sans-serif;
                                        "
                                    >
                                        Enter Answer
                                    </label>
                                    <textarea
                                        v-model="faq.answer"
                                        @input="v$.faqs[index].answer.$touch()"
                                        rows="4"
                                        placeholder="Enter the answer to your question"
                                        class="block w-full mt-1 px-3 py-2 border-b focus:outline-none placeholder-opacity-50 placeholder-gray-400 sm:text-sm"
                                        :class="{
                                            'border-red-500':
                                                v$.faqs[index].answer.$error,
                                            'border-gray-300':
                                                !v$.faqs[index].answer.$error,
                                        }"
                                        style="
                                            font-family: 'Neue Montreal',
                                                sans-serif;
                                        "
                                    ></textarea>
                                </div>

                                <!-- Add More FAQ Button -->
                                <button
                                    type="button"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md flex items-center"
                                    @click="addMoreFAQs"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 mr-2"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 4v16m8-8H4"
                                        />
                                    </svg>
                                    Add More FAQ
                                </button>
                            </div>
                        </div>

                        <!-- Step 4: Requirements (Placeholder for future logic) -->
                        <div v-if="currentStep === 4" class="col-span-6">
                            <!-- Add Requirements fields here in the future -->
                            <h3 class="text-2xl font-semibold text-black mb-4">
                                Add A Requirement
                            </h3>
                            <div class="col-span-6">
                                <div
                                    v-for="(requirement, index) in requirements"
                                    :key="index"
                                    class="mt-4"
                                >
                                    <!-- Requirement Input -->
                                    <input
                                        type="text"
                                        :name="'requirement_' + index"
                                        v-model="requirements[index]"
                                        @input="v$.requirements.$touch()"
                                        placeholder="Specify requirements like dimensions, materials, etc."
                                        class="block w-full mt-1 px-3 py-2 border-b focus:outline-none placeholder-opacity-50 placeholder-gray-400 text-black sm:text-sm"
                                        :class="{
                                            'border-red-500':
                                                v$.requirements.$error,
                                            'border-gray-300':
                                                !v$.requirements.$error,
                                        }"
                                    />
                                    <!-- Cancel Button for the extra field -->
                                    <button
                                        v-if="
                                            requirements.length > 1 &&
                                            index >= 1
                                        "
                                        type="button"
                                        @click="removeRequirement(index)"
                                        class="inline-flex justify-center px-2 py-1 ml-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    >
                                        Remove
                                    </button>
                                </div>
                                <!-- Add More Requirement Button -->
                                <div class="mt-4">
                                    <button
                                        type="button"
                                        @click="addRequirement"
                                        class="inline-flex justify-center items-center px-4 py-2 text-sm font-medium bg-blue-600 text-white border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    >
                                        <svg
                                            class="w-5 h-5 mr-2"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 4v16m8-8H4"
                                            />
                                        </svg>
                                        Add More Requirement
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 5: Gallery (Placeholder for future logic) -->
                        <!-- Step 5: Gallery (Placeholder for future logic) -->
                        <div v-if="currentStep === 5" class="col-span-6">
                            <!-- Add Gallery fields here in the future -->
                            <h3
                                class="text-2xl font-semibold text-black mb-4"
                                style="font-family: 'Crimson Pro', serif"
                            >
                                File Upload
                            </h3>
                            <div class="flex flex-col gap-5.5 p-6.5">
                                <div>
                                    <label
                                        for="file-upload"
                                        class="block mb-3 text-sm font-semibold text-gray-700"
                                        style="
                                            font-family: 'Neue Montreal',
                                                sans-serif;
                                        "
                                    >
                                        Attach file
                                    </label>
                                    <input
                                        type="file"
                                        id="file-upload"
                                        name="file_path[]"
                                        @change="handleFileUpload"
                                        class="w-full px-3 py-2 border focus:outline-none placeholder-opacity-50 placeholder-gray-400 text-black sm:text-sm"
                                        multiple
                                        style="
                                            font-family: 'Neue Montreal',
                                                sans-serif;
                                        "
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Step 6: Publish (Placeholder for future logic) -->
                        <div v-if="currentStep === 6" class="col-span-6">
                            <!-- Add Publish fields here in the future -->
                            <h3
                                class="text-2xl font-semibold text-black mb-4"
                                style="font-family: 'Crimson Pro', serif"
                            >
                                Publish Your Gig
                            </h3>
                            <!-- Description -->
                            <p
                                class="text-gray-600 mb-8 w-full text-left"
                                style="font-family: 'Neue Montreal', sans-serif"
                            >
                                Congratulations! You’re almost done. Click
                                "Publish Your Gig" to make your gig live and
                                start getting noticed.
                            </p>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex justify-between col-span-6">
                            <button
                                v-if="currentStep > 1"
                                type="button"
                                @click="goToStep(currentStep - 1)"
                                class="px-4 py-2 text-sm font-medium text-black bg-[#A4FCFF] rounded-md"
                            >
                                Back
                            </button>
                            <button
                                type="submit"
                                class="px-4 py-2 text-sm font-medium bg-orange-500 text-white border border-transparent rounded-md"
                            >
                                {{
                                    currentStep === 6
                                        ? "Publish your Gig"
                                        : "Save & Continue"
                                }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
