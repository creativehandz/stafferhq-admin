<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import { Link } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref } from "vue";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.css";

defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
}>();

const user = usePage().props.auth.user;


const pageTitle = "Edit Profile";

const form = useForm({
    name: user.name,
    email: user.email,
    phone: "",
    website: "",
    foundedDate: "",
    companySize: "",
    categories: [] as Array<{ name: string }>,
    introVideoUrl: "",
    profileUrl: "",
    aboutCompany: "",
    profilePhotos: [],
    socialLinks: [
        { platform: "Facebook", url: "" },
        { platform: "Instagram", url: "" },
        { platform: "LinkedIn", url: "" },
        { platform: "YouTube", url: "" },
    ],
    location: "",
    friendlyAddress: "",
    mapLocation: "",
});

const availableCategories = ref([
    { name: "Tech" },
    { name: "Sales" },
    { name: "Design" },
    { name: "Creativity" },
    { name: "Media" },
    // Add more skills as needed
]);

const addCustomCategories = (newCategory: string) => {
    const category = { name: newCategory };
    availableCategories.value.push(category);
    form.categories.push(category);
};

// Functions to add or remove fields in form
const addSocialLink = () => {
    form.socialLinks.push({ platform: "", url: "" });
};

const removeSocialLink = (index: number) => {
    form.socialLinks.splice(index, 1);
};

const handleProfPhotoUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target?.files ? target.files[0] : null;
    if (file) {
        // form.profilePhotos = file;
    }
};
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Profile
            </h2>
        </template>

        <BreadcrumbDefault :pageTitle="pageTitle" />
        <form class="space-y-6">
            <div
                class="overflow-hidden rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"
            >
                <div class="relative z-20 h-35 md:h-65">
                    <img
                        src="../../../img/cover/cover-01.png"
                        alt="profile cover"
                        class="h-full w-full rounded-tl-sm rounded-tr-sm object-cover object-center"
                    />
                    <div
                        class="absolute flex gap-2 bottom-1 right-1 z-10 xsm:bottom-4 xsm:right-4"
                    >
                        <label
                            for="cover"
                            class="flex cursor-pointer items-center justify-center gap-2 rounded bg-primary py-1 px-2 text-sm font-medium text-white hover:bg-opacity-80 xsm:px-4"
                        >
                            <input
                                type="file"
                                name="cover"
                                id="cover"
                                class="sr-only"
                            />
                            <span>
                                <svg
                                    class="fill-current"
                                    width="14"
                                    height="14"
                                    viewBox="0 0 14 14"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M4.76464 1.42638C4.87283 1.2641 5.05496 1.16663 5.25 1.16663H8.75C8.94504 1.16663 9.12717 1.2641 9.23536 1.42638L10.2289 2.91663H12.25C12.7141 2.91663 13.1592 3.101 13.4874 3.42919C13.8156 3.75738 14 4.2025 14 4.66663V11.0833C14 11.5474 13.8156 11.9925 13.4874 12.3207C13.1592 12.6489 12.7141 12.8333 12.25 12.8333H1.75C1.28587 12.8333 0.840752 12.6489 0.512563 12.3207C0.184375 11.9925 0 11.5474 0 11.0833V4.66663C0 4.2025 0.184374 3.75738 0.512563 3.42919C0.840752 3.101 1.28587 2.91663 1.75 2.91663H3.77114L4.76464 1.42638ZM5.56219 2.33329L4.5687 3.82353C4.46051 3.98582 4.27837 4.08329 4.08333 4.08329H1.75C1.59529 4.08329 1.44692 4.14475 1.33752 4.25415C1.22812 4.36354 1.16667 4.51192 1.16667 4.66663V11.0833C1.16667 11.238 1.22812 11.3864 1.33752 11.4958C1.44692 11.6052 1.59529 11.6666 1.75 11.6666H12.25C12.4047 11.6666 12.5531 11.6052 12.6625 11.4958C12.7719 11.3864 12.8333 11.238 12.8333 11.0833V4.66663C12.8333 4.51192 12.7719 4.36354 12.6625 4.25415C12.5531 4.14475 12.4047 4.08329 12.25 4.08329H9.91667C9.72163 4.08329 9.53949 3.98582 9.4313 3.82353L8.43781 2.33329H5.56219Z"
                                        fill="white"
                                    />
                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M6.99992 5.83329C6.03342 5.83329 5.24992 6.61679 5.24992 7.58329C5.24992 8.54979 6.03342 9.33329 6.99992 9.33329C7.96642 9.33329 8.74992 8.54979 8.74992 7.58329C8.74992 6.61679 7.96642 5.83329 6.99992 5.83329ZM4.08325 7.58329C4.08325 5.97246 5.38909 4.66663 6.99992 4.66663C8.61075 4.66663 9.91659 5.97246 9.91659 7.58329C9.91659 9.19412 8.61075 10.5 6.99992 10.5C5.38909 10.5 4.08325 9.19412 4.08325 7.58329Z"
                                        fill="white"
                                    />
                                </svg>
                            </span>
                            <span>Edit</span>
                        </label>
                    </div>
                </div>
                <div class="px-4 pb-6 text-center lg:pb-8 xl:pb-11.5">
                    <div
                        class="relative z-30 mx-auto -mt-22 h-30 w-full max-w-30 rounded-full bg-white/20 p-1 backdrop-blur sm:h-44 sm:max-w-44 sm:p-3"
                    >
                        <div class="relative drop-shadow-2">
                            <img
                                src="../../../img/user/user-06.png"
                                alt="profile"
                            />
                            <label
                                for="profile"
                                class="absolute bottom-0 right-0 flex h-8.5 w-8.5 cursor-pointer items-center justify-center rounded-full bg-primary text-white hover:bg-opacity-90 sm:bottom-2 sm:right-2"
                            >
                                <svg
                                    class="fill-current"
                                    width="14"
                                    height="14"
                                    viewBox="0 0 14 14"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M4.76464 1.42638C4.87283 1.2641 5.05496 1.16663 5.25 1.16663H8.75C8.94504 1.16663 9.12717 1.2641 9.23536 1.42638L10.2289 2.91663H12.25C12.7141 2.91663 13.1592 3.101 13.4874 3.42919C13.8156 3.75738 14 4.2025 14 4.66663V11.0833C14 11.5474 13.8156 11.9925 13.4874 12.3207C13.1592 12.6489 12.7141 12.8333 12.25 12.8333H1.75C1.28587 12.8333 0.840752 12.6489 0.512563 12.3207C0.184375 11.9925 0 11.5474 0 11.0833V4.66663C0 4.2025 0.184374 3.75738 0.512563 3.42919C0.840752 3.101 1.28587 2.91663 1.75 2.91663H3.77114L4.76464 1.42638ZM5.56219 2.33329L4.5687 3.82353C4.46051 3.98582 4.27837 4.08329 4.08333 4.08329H1.75C1.59529 4.08329 1.44692 4.14475 1.33752 4.25415C1.22812 4.36354 1.16667 4.51192 1.16667 4.66663V11.0833C1.16667 11.238 1.22812 11.3864 1.33752 11.4958C1.44692 11.6052 1.59529 11.6666 1.75 11.6666H12.25C12.4047 11.6666 12.5531 11.6052 12.6625 11.4958C12.7719 11.3864 12.8333 11.238 12.8333 11.0833V4.66663C12.8333 4.51192 12.7719 4.36354 12.6625 4.25415C12.5531 4.14475 12.4047 4.08329 12.25 4.08329H9.91667C9.72163 4.08329 9.53949 3.98582 9.4313 3.82353L8.43781 2.33329H5.56219Z"
                                        fill=""
                                    />
                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M7.00004 5.83329C6.03354 5.83329 5.25004 6.61679 5.25004 7.58329C5.25004 8.54979 6.03354 9.33329 7.00004 9.33329C7.96654 9.33329 8.75004 8.54979 8.75004 7.58329C8.75004 6.61679 7.96654 5.83329 7.00004 5.83329ZM4.08337 7.58329C4.08337 5.97246 5.38921 4.66663 7.00004 4.66663C8.61087 4.66663 9.91671 5.97246 9.91671 7.58329C9.91671 9.19412 8.61087 10.5 7.00004 10.5C5.38921 10.5 4.08337 9.19412 4.08337 7.58329Z"
                                        fill=""
                                    />
                                </svg>
                                <input
                                    type="file"
                                    name="profile"
                                    id="profile"
                                    class="sr-only"
                                />
                            </label>
                        </div>
                    </div>
                </div>
                <div class="md:flex">
                    <div class="space-y-6 p-4 sm:p-8 w-full">
                        <div>
                            <InputLabel for="name" value="Employer Name" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                        </div>
                        <div>
                            <InputLabel for="phone" value="Phone" />

                            <TextInput
                                id="phone"
                                type="tel"
                                class="mt-1 block w-full"
                                v-model="form.phone"
                                required
                                autocomplete="phone"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.phone"
                            />
                        </div>
                        <div>
                            <InputLabel
                                for="foundedDate"
                                value="Founded Date"
                            />

                            <TextInput
                                id="foundedDate"
                                type="date"
                                class="mt-1 block w-full"
                                v-model="form.foundedDate"
                                required
                                autocomplete="url"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.foundedDate"
                            />
                        </div>

                        <div>
                            <InputLabel for="Categories" value="Categories" />

                            <multiselect
                                v-model="form.categories"
                                :options="availableCategories"
                                :multiple="true"
                                :close-on-select="false"
                                :taggable="true"
                                :allow-duplicate="false"
                                tag-placeholder="Add this as a new category"
                                placeholder="Select or add your category"
                                label="name"
                                track-by="name"
                                @tag="addCustomCategories"
                                class="mt-1"
                            >
                            </multiselect>

                            <InputError
                                class="mt-2"
                                :message="form.errors.categories"
                            />
                        </div>
                    </div>
                    <div class="space-y-6 p-4 sm:p-8 w-full">
                        <div>
                            <InputLabel for="email" value="Email" />

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                                autocomplete="username"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.email"
                            />
                        </div>
                        <div>
                            <InputLabel for="website" value="Website" />

                            <TextInput
                                id="website"
                                type="url"
                                class="mt-1 block w-full"
                                v-model="form.website"
                                required
                                autocomplete="url"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.website"
                            />
                        </div>
                        <div>
                            <InputLabel
                                for="companySize"
                                value="Company Size"
                            />

                            <TextInput
                                id="companySize"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.companySize"
                                required
                                autocomplete="url"
                                min="1"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.companySize"
                            />
                        </div>
                        <div>
                            <InputLabel
                                for="introVideoUrl"
                                value="Introduction Video Url"
                            />

                            <TextInput
                                id="IntroVideoUrl"
                                type="url"
                                class="mt-1 block w-full"
                                v-model="form.introVideoUrl"
                                required
                                autocomplete="url"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.introVideoUrl"
                            />
                        </div>
                    </div>
                </div>

                <div class="space-y-6 p-4 sm:p-8 w-full">
                    <div>
                        <InputLabel for="profileUrl" value="Profile Url" />

                        <TextInput
                            id="ProfileUrl"
                            type="url"
                            class="mt-1 block w-full"
                            v-model="form.profileUrl"
                            required
                            autocomplete="url"
                        />

                        <InputError
                            class="mt-2"
                            :message="form.errors.profileUrl"
                        />
                    </div>
                    <div>
                        <InputLabel for="aboutCompany" value="About Company" />

                        <textarea
                            rows="6"
                            id="AboutCompany"
                            type="text"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            v-model="form.aboutCompany"
                            required
                            autocomplete="url"
                        ></textarea>

                        <InputError
                            class="mt-2"
                            :message="form.errors.aboutCompany"
                        />
                    </div>
                </div>
            </div>

            <div
                class="p-4 sm:p-8 bg-white dark:bg-boxdark shadow sm:rounded-lg"
            >
                <div>
                    <InputLabel for="profilePhotos" value="Profile Photos" />

                    <!-- <TextInput
                            id="ProfilePhotos"
                            type="url"
                            class="mt-1 block w-full"
                            v-model="form.profilePhotos"
                            required
                            autocomplete="url"
                        /> -->
                    <input
                        type="file"
                        @change="handleProfPhotoUpload($event)"
                        class="mt-1 w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter file:py-3 file:px-5 file:hover:bg-primary file:hover:bg-opacity-10 focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:file:bg-white/30 dark:file:text-white dark:focus:border-primary"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.profilePhotos"
                    />
                </div>
            </div>

            <div
                class="p-4 sm:p-8 bg-white dark:bg-boxdark shadow sm:rounded-lg"
            >
                <div>
                    <h2 class="text-xl font-semibold mb-4">
                        Social Media Links
                    </h2>

                    <div
                        v-for="(link, index) in form.socialLinks"
                        :key="index"
                        class="space-y-4"
                    >
                        <div class="flex items-center space-x-4">
                            <div class="flex-1">
                                <label
                                    class="mb-1 block text-sm font-medium text-black dark:text-white"
                                >
                                    Platform
                                </label>
                                <input
                                    type="text"
                                    v-model="link.platform"
                                    placeholder="Platform"
                                    class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-2 px-4 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-white dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                />
                            </div>
                            <div class="flex-1">
                                <label
                                    class="mb-1 block text-sm font-medium text-black dark:text-white"
                                >
                                    URL
                                </label>
                                <input
                                    type="text"
                                    v-model="link.url"
                                    placeholder="URL"
                                    class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-2 px-4 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-white dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                />
                            </div>
                            <button
                                type="button"
                                @click="removeSocialLink(index)"
                                class="text-red-500 mt-6"
                            >
                                Remove
                            </button>
                        </div>
                    </div>
                    <button
                        type="button"
                        @click="addSocialLink"
                        class="mt-2 inline-block rounded bg-primary py-2 px-4 text-white"
                    >
                        Add Another Social Link
                    </button>
                </div>
            </div>

            <div
                class="p-4 sm:p-8 bg-white dark:bg-boxdark shadow sm:rounded-lg"
            >
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold mb-4">
                        Contact Information
                    </h2>
                    <div>
                        <InputLabel for="location" value="Location" />

                        <TextInput
                            id="Location"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.location"
                            required
                            autocomplete="url"
                        />

                        <InputError
                            class="mt-2"
                            :message="form.errors.location"
                        />
                    </div>

                    <div>
                        <InputLabel
                            for="friendlyAddress"
                            value="Friendly Address"
                        />

                        <TextInput
                            id="FriendlyAddress"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.friendlyAddress"
                            required
                            autocomplete="url"
                        />

                        <InputError
                            class="mt-2"
                            :message="form.errors.friendlyAddress"
                        />
                    </div>

                    <div>
                        <InputLabel
                            for="mapLocation"
                            value="Map Location Url"
                        />

                        <TextInput
                            id="MapLocation"
                            type="url"
                            class="mt-1 block w-full"
                            v-model="form.mapLocation"
                            required
                            autocomplete="url"
                        />

                        <InputError
                            class="mt-2"
                            :message="form.errors.mapLocation"
                        />
                    </div>
                </div>
                <div class="py-4 sm:py-8">
                    <PrimaryButton :disabled="form.processing"
                        >Update Profile</PrimaryButton
                    >

                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p
                            v-if="form.recentlySuccessful"
                            class="text-sm text-gray-600 dark:text-gray-400"
                        >
                            Saved.
                        </p>
                    </Transition>
                </div>
            </div>
        </form>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div
                    class="p-4 sm:p-8 bg-white dark:bg-boxdark shadow sm:rounded-lg"
                >
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div
                    class="p-4 sm:p-8 bg-white dark:bg-boxdark shadow sm:rounded-lg"
                >
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div
                    class="p-4 sm:p-8 bg-white dark:bg-boxdark shadow sm:rounded-lg"
                >
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
