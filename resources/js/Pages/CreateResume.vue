<script setup lang="ts">
import CheckboxFive from "@/Components/Forms/Checkboxes/CheckboxFive.vue";
import CheckboxFour from "@/Components/Forms/Checkboxes/CheckboxFour.vue";
import CheckboxOne from "@/Components/Forms/Checkboxes/CheckboxOne.vue";
import CheckboxThree from "@/Components/Forms/Checkboxes/CheckboxThree.vue";
import CheckboxTwo from "@/Components/Forms/Checkboxes/CheckboxTwo.vue";
import DatePickerOne from "@/Components/Forms/DatePicker/DatePickerOne.vue";
import DatePickerTwo from "@/Components/Forms/DatePicker/DatePickerTwo.vue";
import DefaultCard from "@/Components/Forms/DefaultCard.vue";
import SwitchFour from "@/Components/Forms/Switchers/SwitchFour.vue";
import SwitchOne from "@/Components/Forms/Switchers/SwitchOne.vue";
import SwitchThree from "@/Components/Forms/Switchers/SwitchThree.vue";
import SwitchTwo from "@/Components/Forms/Switchers/SwitchTwo.vue";
import MultiSelect from "@/Components/Forms/MultiSelect.vue";
import MultiSelectTwo from "@/Components/Forms/MultiSelectTwo.vue";
import SelectGroupOne from "@/Components/Forms/SelectGroup/SelectGroupOne.vue";
import SelectJobCategory from "@/Components/Forms/SelectGroup/SelectJobCategory.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import SelectBudget from "@/Components/Forms/SelectGroup/SelectBudget.vue";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const pageTitle = ref("Create Your Resume");

interface Project {
    title: string;
    description: string;
    link: string;
    image: File | null;
}

interface WhatIDo {
    skillset: string;
    details: string;
    icon: File | null;
}

const form = useForm({
    name: "",
    occupation: "",
    email: "",
    experience: "",
    phone: "",
    facebook: "",
    instagram: "",
    linkedin: "",
    youtube: "",
    address: "",
    about: "",
    age: "",
    citizen: "",
    favorate_quote: "",
    expertise: "",
    educations: [{ institution: "", degree: "", year: "" }],
    experiences: [{ company: "", role: "", duration: "" }],
    skills: [{ name: "" }],

    socialLinks: [
        { platform: "Facebook", url: "" },
        { platform: "Instagram", url: "" },
        { platform: "LinkedIn", url: "" },
        { platform: "YouTube", url: "" },
    ],
    projects: [
        { title: "", description: "", link: "", image: null },
    ] as Project[],
    whatIDo: [{ skillset: "", details: "", icon: null }] as WhatIDo[],

    description: "",
    attachment: null,
});

const addSocialLink = () => {
    form.socialLinks.push({ platform: "", url: "" });
};

const removeSocialLink = (index: number) => {
    form.socialLinks.splice(index, 1);
};

const addEducation = () => {
    form.educations.push({ institution: "", degree: "", year: "" });
};

const removeEducation = (index: number) => {
    form.educations.splice(index, 1);
};

const addExperience = () => {
    form.experiences.push({ company: "", role: "", duration: "" });
};

const removeExperience = (index: number) => {
    form.experiences.splice(index, 1);
};

const addSkill = () => {
    form.skills.push({ name: "" });
};

const removeSkill = (index: number) => {
    form.skills.splice(index, 1);
};

const addProject = () => {
    form.projects.push({ title: "", description: "", link: "", image: null });
};

const removeProject = (index: number) => {
    form.projects.splice(index, 1);
};

const handleFileUpload = (event: Event, index: number) => {
    const target = event.target as HTMLInputElement;
    const file = target?.files ? target.files[0] : null;
    if (file) {
        form.projects[index].image = file;
    }
};

const addWhatIDo = () => {
    form.whatIDo.push({ skillset: "", details: "", icon: null });
};

const removeWhatIDo = (index: number) => {
    form.whatIDo.splice(index, 1);
};

const handleIconUpload = (event: Event, index: number) => {
    const target = event.target as HTMLInputElement;
    const file = target?.files ? target.files[0] : null;
    if (file) {
        form.whatIDo[index].icon = file;
    }
};

const submit = () => {
    console.log(form);
    // form.post(route("post-a-job"), {
    //     onSuccess: () => {
    //         // Optional: Handle success, like showing a notification
    //         console.log("Success");
    //     },
    //     onError: () => {
    //         // Optional: Handle error, like showing a notification
    //         console.log("Error", form.errors);
    //     },
    // });
};
</script>

<template>
    <Head title="Create Your Resume" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Create Your Resume
            </h2>
        </template>

        <BreadcrumbDefault :pageTitle="pageTitle" />

        <div class="py-12">
            <div class="mx-auto max-w-screen-2xl">
                <!-- ====== Form Elements Section Start -->
                <div class="grid grid-cols-1 gap-9 sm:grid-cols-2">
                    <div class="flex flex-col gap-9">
                        <!-- Input Fields Start -->
                        <DefaultCard cardTitle="Create Resume">
                            <form @submit.prevent="submit">
                                <div class="flex flex-col gap-5 p-6">
                                    <div>
                                        <h2 class="text-xl font-semibold mb-4">
                                            Personal Information
                                        </h2>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Enter Your Full Name
                                        </label>
                                        <input
                                            type="text"
                                            v-model="form.name"
                                            placeholder="Enter Your Full Name"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        />
                                    </div>

                                    <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Enter Your Occupation
                                        </label>
                                        <input
                                            type="text"
                                            v-model="form.occupation"
                                            placeholder="Enter Your Occupation"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        />
                                    </div>

                                    <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            About you
                                        </label>
                                        <textarea
                                            rows="6"
                                            placeholder="Tell more about you"
                                            v-model="form.about"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        ></textarea>
                                    </div>

                                    <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Enter Your Phone
                                        </label>
                                        <input
                                            type="text"
                                            v-model="form.phone"
                                            placeholder="Enter Your Phone"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        />
                                    </div>

                                    <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Enter Your Email
                                        </label>
                                        <input
                                            type="text"
                                            v-model="form.email"
                                            placeholder="Enter Your Email"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        />
                                    </div>

                                    <h2 class="text-xl font-semibold mb-4">
                                        Social Media Links
                                    </h2>

                                    <div
                                        v-for="(
                                            link, index
                                        ) in form.socialLinks"
                                        :key="index"
                                        class="mb-4 space-y-4"
                                    >
                                        <div>
                                            <label
                                                class="mb-3 block text-sm font-medium text-black dark:text-white"
                                            >
                                                Platform
                                            </label>
                                            <input
                                                type="text"
                                                v-model="link.platform"
                                                placeholder="Enter Social Media Platform"
                                                class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-white dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            />
                                        </div>
                                        <div>
                                            <label
                                                class="mb-3 block text-sm font-medium text-black dark:text-white"
                                            >
                                                URL
                                            </label>
                                            <input
                                                type="text"
                                                v-model="link.url"
                                                placeholder="Enter URL"
                                                class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-white dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            />
                                        </div>
                                        <button
                                            type="button"
                                            @click="removeSocialLink(index)"
                                            class="text-red-500"
                                        >
                                            Remove Link
                                        </button>
                                    </div>
                                    <button
                                        type="button"
                                        @click="addSocialLink"
                                        class="mt-4 inline-block rounded bg-primary py-2 px-4 text-white"
                                    >
                                        Add Social Link
                                    </button>

                                    <div>
                                        <h2 class="text-xl font-semibold mb-4">
                                            Who Am I
                                        </h2>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Age
                                        </label>
                                        <input
                                            type="text"
                                            v-model="form.age"
                                            placeholder="Enter your age"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        />
                                    </div>

                                    <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Citizen
                                        </label>
                                        <select
                                            v-model="form.citizen"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        >
                                            <option value="" disabled>
                                                Select your country
                                            </option>
                                            <option value="United States">
                                                United States
                                            </option>
                                            <option value="Canada">
                                                Canada
                                            </option>
                                            <option value="United Kingdom">
                                                United Kingdom
                                            </option>
                                            <option value="Australia">
                                                Australia
                                            </option>
                                            <option value="India">India</option>
                                            <option value="Germany">
                                                Germany
                                            </option>
                                            <option value="France">
                                                France
                                            </option>
                                            <option value="Japan">Japan</option>
                                            <!-- Add more countries as needed -->
                                        </select>
                                    </div>

                                    <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Residence
                                        </label>
                                        <textarea
                                            rows="6"
                                            placeholder="Enter your address"
                                            v-model="form.address"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        ></textarea>
                                    </div>

                                    <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Favorate Quote
                                        </label>
                                        <textarea
                                            rows="6"
                                            placeholder="Tell your favouate quote"
                                            v-model="form.favorate_quote"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        ></textarea>
                                    </div>

                                    <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Expertise
                                        </label>
                                        <textarea
                                            rows="6"
                                            placeholder="Tell your expertise"
                                            v-model="form.expertise"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        ></textarea>
                                    </div>

                                    <h2 class="text-xl font-semibold mb-4">
                                        What I Do
                                    </h2>

                                    <div
                                        v-for="(item, index) in form.whatIDo"
                                        :key="index"
                                        class="mb-6"
                                    >
                                        <div>
                                            <label
                                                class="mb-3 block text-sm font-medium text-black dark:text-white"
                                            >
                                                My Skillset
                                            </label>
                                            <input
                                                type="text"
                                                v-model="item.skillset"
                                                placeholder="Enter your skillset"
                                                class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            />
                                        </div>
                                        <div>
                                            <label
                                                class="mb-3 block text-sm font-medium text-black dark:text-white mt-4"
                                            >
                                                Details
                                            </label>
                                            <textarea
                                                rows="6"
                                                v-model="item.details"
                                                placeholder="Enter your details"
                                                class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            ></textarea>
                                        </div>
                                        <div>
                                            <label
                                                class="mb-3 block text-sm font-medium text-black dark:text-white mt-4"
                                            >
                                                Upload Icon
                                            </label>
                                            <input
                                                type="file"
                                                @change="
                                                    handleIconUpload(
                                                        $event,
                                                        index
                                                    )
                                                "
                                                class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter file:py-3 file:px-5 file:hover:bg-primary file:hover:bg-opacity-10 focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:file:bg-white/30 dark:file:text-white dark:focus:border-primary"
                                            />
                                        </div>
                                        <button
                                            type="button"
                                            @click="removeWhatIDo(index)"
                                            class="text-red-500"
                                        >
                                            Remove Skillset
                                        </button>
                                    </div>

                                    <button
                                        @click="addWhatIDo"
                                        class="mt-4 px-6 py-2 bg-primary text-white rounded-lg"
                                    >
                                        Add Another Skill
                                    </button>

                                    <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            My Skillset
                                        </label>
                                        <!-- v-model not added till now-->
                                        <input
                                            type="text"
                                            placeholder="Enter your skillset"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        />
                                    </div>

                                    <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Details
                                        </label>
                                        <!-- v-model not added till now -->
                                        <textarea
                                            rows="6"
                                            placeholder="Enter your details"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        ></textarea>
                                    </div>

                                    <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Upload Icon
                                        </label>
                                        <!-- v-model not added till now-->
                                        <input
                                            type="file"
                                            class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter file:py-3 file:px-5 file:hover:bg-primary file:hover:bg-opacity-10 focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:file:bg-white/30 dark:file:text-white dark:focus:border-primary"
                                        />
                                    </div>

                                    <!-- Skills -->
                                    <h2 class="text-xl font-semibold mb-4">
                                        My Programming Skills
                                    </h2>
                                    <div
                                        v-for="(skill, index) in form.skills"
                                        :key="index"
                                        class="mb-4"
                                    >
                                        <input
                                            type="text"
                                            v-model="skill.name"
                                            placeholder="Enter Skill"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-white dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        />
                                        <button
                                            type="button"
                                            @click="removeSkill(index)"
                                            class="text-red-500"
                                        >
                                            Remove Skill
                                        </button>
                                    </div>
                                    <button
                                        type="button"
                                        @click="addSkill"
                                        class="mt-4 inline-block rounded bg-primary py-2 px-4 text-white"
                                    >
                                        Add Skill
                                    </button>

                                    <h2 class="text-xl font-semibold mb-4">
                                        Education
                                    </h2>
                                    <div
                                        v-for="(
                                            education, index
                                        ) in form.educations"
                                        :key="index"
                                        class="mb-4 space-y-4"
                                    >
                                        <div>
                                            <label
                                                class="mb-3 block text-sm font-medium text-black dark:text-white"
                                            >
                                                Institution
                                            </label>
                                            <input
                                                type="text"
                                                v-model="education.institution"
                                                placeholder="Enter Institution Name"
                                                class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-white dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            />
                                        </div>
                                        <div>
                                            <label
                                                class="mb-3 block text-sm font-medium text-black dark:text-white"
                                            >
                                                Degree
                                            </label>
                                            <input
                                                type="text"
                                                v-model="education.degree"
                                                placeholder="Enter Degree"
                                                class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-white dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            />
                                        </div>
                                        <div>
                                            <label
                                                class="mb-3 block text-sm font-medium text-black dark:text-white"
                                            >
                                                Year
                                            </label>
                                            <input
                                                type="text"
                                                v-model="education.year"
                                                placeholder="Enter Year of Graduation"
                                                class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-white dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            />
                                        </div>
                                        <button
                                            type="button"
                                            @click="removeEducation(index)"
                                            class="text-red-500"
                                        >
                                            Remove Education
                                        </button>
                                    </div>
                                    <button
                                        type="button"
                                        @click="addEducation"
                                        class="mt-4 inline-block rounded bg-primary py-2 px-4 text-white"
                                    >
                                        Add Education
                                    </button>

                                    <!-- Work experience -->
                                    <h2 class="text-xl font-semibold mb-4">
                                        Work Experience
                                    </h2>
                                    <div
                                        v-for="(
                                            experience, index
                                        ) in form.experiences"
                                        :key="index"
                                        class="mb-4 space-y-4"
                                    >
                                        <div>
                                            <label
                                                class="mb-3 block text-sm font-medium text-black dark:text-white"
                                            >
                                                Company
                                            </label>
                                            <input
                                                type="text"
                                                v-model="experience.company"
                                                placeholder="Enter Company Name"
                                                class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-white dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            />
                                        </div>
                                        <div>
                                            <label
                                                class="mb-3 block text-sm font-medium text-black dark:text-white"
                                            >
                                                Role
                                            </label>
                                            <input
                                                type="text"
                                                v-model="experience.role"
                                                placeholder="Enter Job Role"
                                                class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-white dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            />
                                        </div>
                                        <div>
                                            <label
                                                class="mb-3 block text-sm font-medium text-black dark:text-white"
                                            >
                                                Duration
                                            </label>
                                            <input
                                                type="text"
                                                v-model="experience.duration"
                                                placeholder="Enter Duration"
                                                class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-white dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            />
                                        </div>
                                        <button
                                            type="button"
                                            @click="removeExperience(index)"
                                            class="text-red-500"
                                        >
                                            Remove Experience
                                        </button>
                                    </div>
                                    <button
                                        type="button"
                                        @click="addExperience"
                                        class="mt-4 inline-block rounded bg-primary py-2 px-4 text-white"
                                    >
                                        Add Experience
                                    </button>

                                    <h2 class="text-xl font-semibold mb-4">
                                        My Projects
                                    </h2>

                                    <div
                                        v-for="(
                                            project, index
                                        ) in form.projects"
                                        :key="index"
                                        class="mb-6 space-y-4"
                                    >
                                        <div>
                                            <label
                                                class="mb-3 block text-sm font-medium text-black dark:text-white"
                                            >
                                                Upload Image of Project
                                            </label>
                                            <input
                                                type="file"
                                                @change="
                                                    handleFileUpload(
                                                        $event,
                                                        index
                                                    )
                                                "
                                                class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter file:py-3 file:px-5 file:hover:bg-primary file:hover:bg-opacity-10 focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:file:bg-white/30 dark:file:text-white dark:focus:border-primary"
                                            />
                                        </div>

                                        <div>
                                            <label
                                                class="mb-3 block text-sm font-medium text-black dark:text-white"
                                            >
                                                Title
                                            </label>
                                            <input
                                                type="text"
                                                v-model="project.title"
                                                placeholder="Enter title of your project"
                                                class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            />
                                        </div>

                                        <div>
                                            <label
                                                class="mb-3 block text-sm font-medium text-black dark:text-white"
                                            >
                                                Description
                                            </label>
                                            <textarea
                                                v-model="project.description"
                                                rows="6"
                                                placeholder="Describe your project in short"
                                                class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            ></textarea>
                                        </div>

                                        <div>
                                            <label
                                                class="mb-3 block text-sm font-medium text-black dark:text-white"
                                            >
                                                Project link
                                            </label>
                                            <input
                                                type="text"
                                                v-model="project.link"
                                                placeholder="Project URL"
                                                class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            />
                                        </div>

                                        <button
                                            type="button"
                                            @click="removeProject(index)"
                                            class="text-red-500"
                                        >
                                            Remove Project
                                        </button>
                                    </div>
                                    <button
                                        type="button"
                                        @click="addProject"
                                        class="mt-4 inline-block rounded bg-primary py-2 px-4 text-white"
                                    >
                                        Add Project
                                    </button>

                                    <div class="mb-5 mt-6">
                                        <input
                                            type="submit"
                                            value="Create"
                                            class="flex w-full cursor-pointer border border-primary bg-primary p-3 font-medium text-white transition hover:bg-opacity-90"
                                            :class="{
                                                'opacity-25': form.processing,
                                            }"
                                            :disabled="form.processing"
                                        />
                                    </div>
                                </div>
                            </form>
                        </DefaultCard>
                        <!-- Input Fields End -->
                    </div>
                </div>
                <!-- ====== Form Elements Section End -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
