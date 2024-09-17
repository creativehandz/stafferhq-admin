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
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.css";
import { ref } from "vue";

const pageTitle = ref("Post A Job");


const form = useForm({
    title: "",
    project_type: "",
    category: "",
    skills: [] as Array<{ name: string }>,
    experience_level: "",
    budget_type: "",
    budget: "",
    email: "",
    hourlyRate: "",
    salaryType: "",
    minSalary: "",
    maxSalary: "",    
    experience: "",
    careerLevel: "",
    qualification: "",
    deadline: "",
    location: "",
    address: "",
    // today: new Date().toISOString().split('T')[0],
    description: "",
    attachment: null,
    fileInputRef: ref(null),

    onFileChange(event) {
      const file = event.target.files[0];
      this.attachment = file;
    },

    submit() {
      const formData = new FormData();
      formData.append("attachment", this.attachment);
      // Add other form data properties to the formData object

      console.log(formData);
      form.post(route("post-a-job"), {
        onSuccess: () => {
          // Optional: Handle success, like showing a notification
          console.log("Success");
        },
        onError: () => {
          // Optional: Handle error, like showing a notification
          console.log("Error", form.errors);
        },
      });
    },

});

const availableSkills = ref([
    { name: "JavaScript" },
    { name: "Python" },
    { name: "Java" },
    { name: "PHP" },
    { name: "C++" },
    // Add more skills as needed
]);

const addCustomSkill = (newSkill: string) => {
    const skill = { name: newSkill };
    availableSkills.value.push(skill);
    form.skills.push(skill);
};

const submit = () => {
    console.log(form);
    form.post(route("post-a-job"), {
        onSuccess: () => {
            // Optional: Handle success, like showing a notification
            console.log("Success");
        },
        onError: () => {
            // Optional: Handle error, like showing a notification
            console.log("Error", form.errors);
        },
    });
};


</script>

<template>
    <Head title="Post A Job" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Post Job
            </h2>
        </template>

        <BreadcrumbDefault :pageTitle="pageTitle" />
        <!-- <div class="h-[calc(100vh-186px)] overflow-hidden sm:h-[calc(100vh-174px)]">
            <div class="h-full rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark lg:flex">
                <div class="fixed top-22.5 bottom-0 z-999 flex w-[230px] -translate-x-[120%] flex-col rounded-md border border-stroke bg-white dark:border-strokedark dark:bg-boxdark lg:static lg:w-1/5 lg:translate-x-0 lg:border-none"></div>
            </div>
           
        </div> -->

        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="mx-auto max-w-screen-2xl">
                <!-- ====== Form Elements Section Start -->
                <div class="grid grid-cols-1 gap-9 ">
                    <div class="flex flex-col gap-9">
                        <!-- Input Fields Start -->
                        <DefaultCard cardTitle="Post Job">
                            <form @submit.prevent="submit">
                                <div class="flex flex-col gap-5 p-6">

                            
                                    <!-- Featured image -->
                                    <div class="mb-5">
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white "
                                        >
                                            Featured Image
                                        </label>
                                        <input
                                            type="file" @change="form.onFileChange" accept="image/*" 
                                            
                                            class="flex w-full cursor-pointer border border-primary bg-primary p-3 font-medium text-white transition hover:bg-opacity-90"       
                                        />
                                        <!-- Display the selected image preview -->
                                         
                                        <!-- <div v-if="image">
                                        <h3>Preview:</h3>
                                        <img :src="image" alt="Selected Image" width="300">
                                        </div> -->
                                    </div>

                                    <!-- Job Title -->
                                    <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Job Title
                                        </label>
                                        <input
                                            type="text"
                                            v-model="form.title"
                                            placeholder="Enter Job Title"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        />
                                    </div>

                                    <!-- Job Description -->
                                    <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Job Description
                                        </label>
                                        <textarea
                                            rows="6"
                                            placeholder="Enter Job Description"
                                            v-model="form.description"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        ></textarea>
                                    </div>

                                    <!-- cateogry | type -->
                                    <SelectJobCategory v-model="form.category"/>
                                    <label
                                        class="block text-sm font-medium text-black dark:text-white"
                                    >
                                        Type
                                    </label>

                                        <select  class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                        <option class="text-body dark:text-bodydark">Full Time</option>
                                        <option class="text-body dark:text-bodydark">Part Time</option>                                        
                                    </select>
                                    <!-- tag | gender -->
                                    <label
                                        class="block text-sm font-medium text-black dark:text-white"
                                    >
                                        Tag
                                    </label>

                                    <multiselect
                                        v-model="form.skills"
                                        :options="availableSkills"
                                        :multiple="true"
                                        :close-on-select="false"
                                        :taggable="true"
                                        :allow-duplicate="false"
                                        tag-placeholder="Add this as a new skill"
                                        placeholder="Select or add your skills"
                                        label="name"
                                        track-by="name"
                                        @tag="addCustomSkill"
                                        class="mb-4"
                                    >
                                    </multiselect>
                                    <label
                                        class="block text-sm font-medium text-black dark:text-white"
                                    >
                                        Gender
                                    </label>

                                        <select  class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                        <option class="text-body dark:text-bodydark">Male</option>
                                        <option class="text-body dark:text-bodydark">Female</option>                                        
                                    </select>


                                    <!-- Job Apply Email -->
                                        <div>
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">Job Apply Email</label>
                                        <input
                                            type="email"
                                            v-model="form.email"
                                            placeholder="Enter Apply Email"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                            required
                                        />
                                        </div>


                                        <!-- Salary Type and Range -->
                                        <div>
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">Salary Type</label>
                                        <select v-model="form.salaryType" class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            <option value="hourly">Hourly</option>
                                            <option value="fixed">Fixed</option>
                                        </select>
                                        </div>

                                        <!-- Hourly Range (Conditional) -->
                                        <div v-if="form.salaryType === 'hourly'">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">Hourly Rate</label>
                                        <input
                                            type="range"
                                            v-model="form.hourlyRate"
                                            min="10"
                                            max="20"
                                            class="w-full"
                                        />
                                        <span>{{ form.hourlyRate }} $/hour</span>
                                        </div>

                                        <!-- Fixed Salary (Conditional) -->
                                        <div v-if="form.salaryType === 'fixed'">
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">Min Salary</label>
                                        <input
                                            type="number"
                                            v-model="form.minSalary"
                                            placeholder="Min Salary"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        />

                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">Max Salary</label>
                                        <input
                                            type="number"
                                            v-model="form.maxSalary"
                                            placeholder="Max Salary"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        />
                                        </div>

                                        <!-- Experience -->
                                        <div>
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">Experience</label>
                                        <select v-model="form.experience" class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            <option value="1">1 Year</option>
                                            <option value="2">2 Years</option>
                                            <option value="3">3 Years</option>
                                            <option value="4">4 Years</option>
                                        </select>
                                        </div>

                                        <!-- Career Level -->
                                        <div>
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">Career Level</label>
                                        <select v-model="form.careerLevel" class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            <option value="manager">Manager</option>
                                            <option value="officer">Officer</option>
                                            <option value="executive">Executive</option>
                                            <option value="student">Student</option>
                                            <option value="other">Other</option>
                                        </select>
                                        </div>
                                

                                        <!-- Qualification -->
                                        <div>
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">Qualification</label>
                                        <select v-model="form.qualification" class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            <option value="associate">Associate Degree</option>
                                            <option value="bachelor">Bachelor's Degree</option>
                                            <option value="master">Master's Degree</option>
                                            <option value="doctorate">Doctorate Degree</option>
                                            <option value="other">Other</option>
                                        </select>
                                        </div>


                                        <!-- Application Deadline Date -->
                                        <div>
                                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">Application Deadline</label>
                                        <input
                                            type="date"
                                            v-model="form.deadline"
                                            
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        />
                                        <!-- :value="today" -->
                                        </div>


                                    <!-- Qualification | Intro video URL -->
                                    <!-- Photo, with browse option --> 
                                    <!-- application deadline date -->
                                    <!-- friendly address -->
                                    <!-- Location -->
                                    <!-- maps location-->
                                    <!-- map  -->
                                     <!-- Friendly Address -->
                                    <div>
                                    <label class="mb-3 block text-sm font-medium text-black dark:text-white">Friendly Address</label>
                                    <input
                                        type="text"
                                        v-model="form.address"
                                        placeholder="Enter Friendly Address"
                                        class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                    />
                                    </div>

                                    <!-- Location (Coordinates) -->
                                    <div>
                                    <label class="mb-3 block text-sm font-medium text-black dark:text-white">Location (Lat, Lng)</label>
                                    <input
                                        type="text"
                                        v-model="form.location"
                                        placeholder="Enter Location (Lat, Lng)"
                                        class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                    />
                                    </div>

                                    <!-- latitude, longitude -->
                                    <!-- logo image, browse -->

                                    <!-- Logo Image Upload -->
                                    <div class="mb-5">
                                    <label class="mb-3 block text-sm font-medium text-black dark:text-white">Company Logo</label>
                                    <input
                                        type="file"
                                        @change="form.onLogoChange"
                                        accept="image/*"
                                        class="flex w-full cursor-pointer border border-primary bg-primary p-3 font-medium text-white transition hover:bg-opacity-90"
                                    />
                                    <!-- Display the selected logo preview -->
                                    <div v-if="logo">
                                        <h3>Logo Preview:</h3>
                                        <img :src="logo" alt="Selected Logo" width="150">
                                    </div>
                                    </div>

                                    <!-- Button, save and preview -->
                                    


                                    <!-- <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            I Want To Create A New Job Post
                                        </label>
                                        <div class="flex flex-col gap-4">
                                            <div
                                                class="flex cursor-pointer select-none items-center gap-2"
                                            >
                                                <input
                                                    type="radio"
                                                    name="project_type"
                                                    id="long_term"
                                                    v-model="form.project_type"
                                                    value="Long Term Project more than 30 Hours/week or 3 months"
                                                />
                                                Long Term Project : >= 30
                                                Hours/week or 3 months
                                            </div>
                                            <div
                                                class="flex cursor-pointer select-none items-center gap-2"
                                            >
                                                <input
                                                    type="radio"
                                                    name="project_type"
                                                    id="short_term"
                                                    v-model="form.project_type"
                                                    value="Short Term Project less than 30 Hours/week or 3 months"
                                                />
                                                Short Term Project : <= 30
                                                Hours/week or 3 months
                                            </div>
                                        </div>
                                    </div> -->
                         
                                    <!-- <MultiSelectTwo v-model="form.skills" /> -->

                                    <!-- <label
                                        class="block text-sm font-medium text-black dark:text-white"
                                    >
                                        Skills
                                    </label>

                                    <multiselect
                                        v-model="form.skills"
                                        :options="availableSkills"
                                        :multiple="true"
                                        :close-on-select="false"
                                        :taggable="true"
                                        :allow-duplicate="false"
                                        tag-placeholder="Add this as a new skill"
                                        placeholder="Select or add your skills"
                                        label="name"
                                        track-by="name"
                                        @tag="addCustomSkill"
                                        class="mb-4"
                                    >
                                    </multiselect> -->

                                    <!-- <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            What Level Of Experience Will It
                                            Need?
                                        </label>
                                        <div class="flex flex-col gap-4">
                                            <div
                                                class="flex cursor-pointer select-none items-center gap-2"
                                            >
                                                <input
                                                    type="radio"
                                                    name="experience_level"
                                                    id="entry"
                                                    v-model="
                                                        form.experience_level
                                                    "
                                                    value="Entry"
                                                />
                                                Entry: Looking for someone
                                                relatively new to this field
                                            </div>
                                            <div
                                                class="flex cursor-pointer select-none items-center gap-2"
                                            >
                                                <input
                                                    type="radio"
                                                    name="experience_level"
                                                    id="Intermediate"
                                                    v-model="
                                                        form.experience_level
                                                    "
                                                    value="intermediate"
                                                />
                                                Intermediate: Looking for
                                                substantial experience in this
                                                field
                                            </div>
                                            <div
                                                class="flex cursor-pointer select-none items-center gap-2"
                                            >
                                                <input
                                                    type="radio"
                                                    name="experience_level"
                                                    id="Expert"
                                                    v-model="
                                                        form.experience_level
                                                    "
                                                    value="expert"
                                                />
                                                Expert: Looking for
                                                comprehensive and deep expertise
                                                in this field
                                            </div>
                                        </div>
                                    </div> -->

                                    <!-- <SelectBudget v-model="form.budget_type" /> -->
                                    <!-- <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Budget
                                        </label>
                                        <input
                                            type="text"
                                            placeholder="Enter Budget"
                                            v-model="form.budget"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary dark:disabled:bg-black"
                                        />
                                    </div>                                     -->

                                    <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Job Detail PDF
                                        </label>
                                        <input
                                            type="file"
                                            @change="form.onFileChange"
                                            ref="form.fileInputRef"
                                            class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter file:py-3 file:px-5 file:hover:bg-primary file:hover:bg-opacity-10 focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:file:bg-white/30 dark:file:text-white dark:focus:border-primary"
                                        />
                                    </div>

                                    <div class="mb-5 mt-6">
                                        <input
                                            type="submit"
                                            value="Post Job"
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
