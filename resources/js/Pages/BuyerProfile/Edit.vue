<template>
    <div class="container">
        <BuyerNavbar/>

        <!-- BreadCrumbs -->
        <div class="text-sm leading-none mb-4">
            <a href="/"><span>Home /</span></a>   
            <a href="/buyer-profile"><span> Profile /</span></a>
            <span class="text-gray-600"> Edit Profile</span>
        </div>
        
        <!-- Categories and Subcategories Dropdown -->
        <CategoryTile />

        <!-- Edit Profile Form -->
        <div class="mt-5 mb-5 bg-white rounded-lg shadow-lg p-8">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl font-bold text-black mb-8">Edit Your Profile</h1>
                
                <!-- Success Message -->
                <div v-if="($page.props.flash as any)?.status" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ ($page.props.flash as any)?.status }}
                </div>

                <form @submit.prevent="submitForm" class="space-y-8">
                    <!-- Personal Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h2 class="text-xl font-semibold text-black mb-4">Personal Information</h2>
                        
                        <!-- Profile Image Upload -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Profile Image
                            </label>
                            <div class="flex items-center space-x-4">
                                <!-- Current Image Preview -->
                                <div class="flex-shrink-0">
                                    <img
                                        :src="imagePreview || (user.profile_image ? `/${user.profile_image}` : 'https://via.placeholder.com/100')"
                                        alt="Profile Preview"
                                        class="w-20 h-20 rounded-full object-cover border border-gray-300"
                                    />
                                </div>
                                
                                <!-- Upload Controls -->
                                <div class="flex-grow">
                                    <input
                                        type="file"
                                        id="profile_image"
                                        ref="fileInput"
                                        @change="handleImageUpload"
                                        accept="image/jpeg,image/png,image/jpg,image/gif"
                                        class="hidden"
                                    />
                                    <button
                                        type="button"
                                        @click="fileInput?.click()"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200"
                                    >
                                        Choose Image
                                    </button>
                                    <button
                                        type="button"
                                        @click="removeImage"
                                        v-if="imagePreview || user.profile_image"
                                        class="ml-2 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200"
                                    >
                                        Remove
                                    </button>
                                    <p class="text-sm text-gray-500 mt-1">
                                        JPG, PNG, GIF up to 2MB
                                    </p>
                                </div>
                            </div>
                            <div v-if="errors.profile_image" class="text-red-500 text-sm mt-1">{{ errors.profile_image }}</div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Full Name *
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    v-model="form.name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Enter your full name"
                                    required
                                />
                                <div v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name }}</div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Address *
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    v-model="form.email"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Enter your email"
                                    required
                                />
                                <div v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</div>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Phone Number
                                </label>
                                <input
                                    type="tel"
                                    id="phone"
                                    v-model="form.phone"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Enter your phone number"
                                />
                                <div v-if="errors.phone" class="text-red-500 text-sm mt-1">{{ errors.phone }}</div>
                            </div>

                            <!-- Location -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                                    Location
                                </label>
                                <input
                                    type="text"
                                    id="location"
                                    v-model="form.location"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Enter your location"
                                />
                                <div v-if="errors.location" class="text-red-500 text-sm mt-1">{{ errors.location }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h2 class="text-xl font-semibold text-black mb-4">Business Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Website -->
                            <div>
                                <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                                    Website
                                </label>
                                <input
                                    type="url"
                                    id="website"
                                    v-model="form.website"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="https://your-website.com"
                                />
                                <div v-if="errors.website" class="text-red-500 text-sm mt-1">{{ errors.website }}</div>
                            </div>

                            <!-- Company Size -->
                            <div>
                                <label for="company_size" class="block text-sm font-medium text-gray-700 mb-2">
                                    Company Size
                                </label>
                                <select
                                    id="company_size"
                                    v-model="form.company_size"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                                    <option value="">Select company size</option>
                                    <option value="Just me">Just me</option>
                                    <option value="2-9 employees">2-9 employees</option>
                                    <option value="10-99 employees">10-99 employees</option>
                                    <option value="100-1000 employees">100-1000 employees</option>
                                    <option value="1000+ employees">1000+ employees</option>
                                </select>
                                <div v-if="errors.company_size" class="text-red-500 text-sm mt-1">{{ errors.company_size }}</div>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Interested Categories
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 max-h-40 overflow-y-auto border border-gray-300 rounded-md p-4">
                                <div
                                    v-for="category in categories"
                                    :key="category.id"
                                    class="flex items-center"
                                >
                                    <input
                                        type="checkbox"
                                        :id="`category_${category.id}`"
                                        :value="category.id"
                                        v-model="form.categories"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    />
                                    <label
                                        :for="`category_${category.id}`"
                                        class="ml-2 text-sm text-gray-700 cursor-pointer"
                                    >
                                        {{ category.name }}
                                    </label>
                                </div>
                            </div>
                            <div v-if="errors.categories" class="text-red-500 text-sm mt-1">{{ errors.categories }}</div>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h2 class="text-xl font-semibold text-black mb-4">Social Links</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Twitter -->
                            <div>
                                <label for="twitter" class="block text-sm font-medium text-gray-700 mb-2">
                                    Twitter Profile
                                </label>
                                <input
                                    type="url"
                                    id="twitter"
                                    v-model="form.social_links.twitter"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="https://twitter.com/username"
                                />
                                <div v-if="errors.twitter" class="text-red-500 text-sm mt-1">{{ errors.twitter }}</div>
                            </div>

                            <!-- LinkedIn -->
                            <div>
                                <label for="linkedin" class="block text-sm font-medium text-gray-700 mb-2">
                                    LinkedIn Profile
                                </label>
                                <input
                                    type="url"
                                    id="linkedin"
                                    v-model="form.social_links.linkedin"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="https://linkedin.com/in/username"
                                />
                                <div v-if="errors.linkedin" class="text-red-500 text-sm mt-1">{{ errors.linkedin }}</div>
                            </div>

                            <!-- Facebook -->
                            <div>
                                <label for="facebook" class="block text-sm font-medium text-gray-700 mb-2">
                                    Facebook Profile
                                </label>
                                <input
                                    type="url"
                                    id="facebook"
                                    v-model="form.social_links.facebook"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="https://facebook.com/username"
                                />
                                <div v-if="errors.facebook" class="text-red-500 text-sm mt-1">{{ errors.facebook }}</div>
                            </div>

                            <!-- Instagram -->
                            <div>
                                <label for="instagram" class="block text-sm font-medium text-gray-700 mb-2">
                                    Instagram Profile
                                </label>
                                <input
                                    type="url"
                                    id="instagram"
                                    v-model="form.social_links.instagram"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="https://instagram.com/username"
                                />
                                <div v-if="errors.instagram" class="text-red-500 text-sm mt-1">{{ errors.instagram }}</div>
                            </div>

                            <!-- GitHub -->
                            <div>
                                <label for="github" class="block text-sm font-medium text-gray-700 mb-2">
                                    GitHub Profile
                                </label>
                                <input
                                    type="url"
                                    id="github"
                                    v-model="form.social_links.github"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="https://github.com/username"
                                />
                                <div v-if="errors.github" class="text-red-500 text-sm mt-1">{{ errors.github }}</div>
                            </div>

                            <!-- YouTube -->
                            <div>
                                <label for="youtube" class="block text-sm font-medium text-gray-700 mb-2">
                                    YouTube Channel
                                </label>
                                <input
                                    type="url"
                                    id="youtube"
                                    v-model="form.social_links.youtube"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="https://youtube.com/channel/..."
                                />
                                <div v-if="errors.youtube" class="text-red-500 text-sm mt-1">{{ errors.youtube }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-between items-center">
                        <a
                            :href="route('buyer-profile')"
                            class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200"
                        >
                            Cancel
                        </a>
                        
                        <div class="flex space-x-4">
                            <button
                                type="submit"
                                :disabled="processing"
                                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition duration-200"
                            >
                                <span v-if="processing">Updating...</span>
                                <span v-else>Update Profile</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <Footer/>
    </div>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import BuyerNavbar from '../BuyerNavbar.vue'
import CategoryTile from './CategoryTile.vue'
import Footer from '@/Components/LandingPage/Footer.vue'

interface User {
    name: string
    email: string
    phone: string | null
    website: string | null
    company_size: string | null
    location: string | null
    categories: number[]
    profile_image: string | null
    social_links: {
        twitter: string
        linkedin: string
        facebook: string
        instagram: string
        github: string
        youtube: string
    }
}

interface Category {
    id: number
    name: string
}

interface Props {
    user: User
    categories: Category[]
    errors?: Record<string, string>
}

const props = defineProps<Props>()

const processing = ref(false)
const imagePreview = ref<string | null>(null)
const selectedImageFile = ref<File | null>(null)
const fileInput = ref<HTMLInputElement | null>(null)

const form = reactive({
    name: props.user.name || '',
    email: props.user.email || '',
    phone: props.user.phone || '',
    website: props.user.website || '',
    company_size: props.user.company_size || '',
    location: props.user.location || '',
    categories: props.user.categories || [],
    social_links: {
        twitter: props.user.social_links?.twitter || '',
        linkedin: props.user.social_links?.linkedin || '',
        facebook: props.user.social_links?.facebook || '',
        instagram: props.user.social_links?.instagram || '',
        github: props.user.social_links?.github || '',
        youtube: props.user.social_links?.youtube || ''
    }
})

const errors = ref(props.errors || {})

// Image handling functions
const handleImageUpload = (event: Event) => {
    const target = event.target as HTMLInputElement
    const file = target.files?.[0]
    
    if (file) {
        selectedImageFile.value = file
        const reader = new FileReader()
        reader.onload = (e) => {
            imagePreview.value = e.target?.result as string
        }
        reader.readAsDataURL(file)
    }
}

const removeImage = () => {
    imagePreview.value = null
    selectedImageFile.value = null
    if (fileInput.value) {
        fileInput.value.value = ''
    }
}

const submitForm = () => {
    processing.value = true
    errors.value = {}

    // Create FormData for file upload support
    const formData = new FormData()
    formData.append('name', form.name)
    formData.append('email', form.email)
    formData.append('phone', form.phone || '')
    formData.append('website', form.website || '')
    formData.append('company_size', form.company_size || '')
    formData.append('location', form.location || '')
    
    // Handle categories
    form.categories.forEach((categoryId, index) => {
        formData.append(`categories[${index}]`, categoryId.toString())
    })
    
    // Handle social links
    formData.append('twitter', form.social_links.twitter)
    formData.append('linkedin', form.social_links.linkedin)
    formData.append('facebook', form.social_links.facebook)
    formData.append('instagram', form.social_links.instagram)
    formData.append('github', form.social_links.github)
    formData.append('youtube', form.social_links.youtube)
    
    // Handle profile image
    if (selectedImageFile.value) {
        formData.append('profile_image', selectedImageFile.value)
    }
    
    // Add method for PUT request
    formData.append('_method', 'PUT')

    router.post(route('buyer-profile.update'), formData, {
        onSuccess: () => {
            processing.value = false
        },
        onError: (errs) => {
            processing.value = false
            errors.value = errs
        }
    })
}
</script>
