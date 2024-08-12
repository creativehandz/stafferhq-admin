<script setup lang="ts">
import InputError from "@/Components/InputError.vue";
import { ref } from "vue";

const selectedOption = ref<string>("");
const isOptionSelected = ref<boolean>(false);

const changeTextColor = () => {
    isOptionSelected.value = true;
};
</script>

<template>
    <div>
        <label
            class="mt-4 mb-3 block font-medium text-sm text-black dark:text-white"
        >
            Select User Type
        </label>
        <div class="relative z-20 bg-white dark:bg-form-input mb-3">
            <span class="absolute top-1/2 left-4 z-30 -translate-y-1/2">
                <svg
                    class="fill-current"
                    width="18"
                    height="18"
                    viewBox="0 0 18 18"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M9.0002 7.79065C11.0814 7.79065 12.7689 6.1594 12.7689 4.1344C12.7689 2.1094 11.0814 0.478149 9.0002 0.478149C6.91895 0.478149 5.23145 2.1094 5.23145 4.1344C5.23145 6.1594 6.91895 7.79065 9.0002 7.79065ZM9.0002 1.7719C10.3783 1.7719 11.5033 2.84065 11.5033 4.16252C11.5033 5.4844 10.3783 6.55315 9.0002 6.55315C7.62207 6.55315 6.49707 5.4844 6.49707 4.16252C6.49707 2.84065 7.62207 1.7719 9.0002 1.7719Z"
                        fill=""
                    />
                    <path
                        d="M10.8283 9.05627H7.17207C4.16269 9.05627 1.71582 11.5313 1.71582 14.5406V16.875C1.71582 17.2125 1.99707 17.5219 2.3627 17.5219C2.72832 17.5219 3.00957 17.2407 3.00957 16.875V14.5406C3.00957 12.2344 4.89394 10.3219 7.22832 10.3219H10.8564C13.1627 10.3219 15.0752 12.2063 15.0752 14.5406V16.875C15.0752 17.2125 15.3564 17.5219 15.7221 17.5219C16.0877 17.5219 16.3689 17.2407 16.3689 16.875V14.5406C16.2846 11.5313 13.8377 9.05627 10.8283 9.05627Z"
                        fill=""
                    />
                </svg>
            </span>
            <select
                v-model="selectedOption"
                :class="{ 'text-black dark:text-white': isOptionSelected }"
                @change="changeTextColor"
                class="relative z-20 w-full appearance-none rounded-lg border border-stroke bg-transparent py-4 px-12 outline-none transition focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary text-black dark:text-white"
            >
                <option value="" disabled selected>Are You An</option>
                <option value="Employer" class="text-body dark:text-bodydark">
                    Employer
                </option>
                <option value="Employee" class="text-body dark:text-bodydark">
                    Employee
                </option>
            </select>
            <span class="absolute top-1/2 right-4 z-10 -translate-y-1/2">
                <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="fill-current"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <g opacity="0.8">
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z"
                            fill=""
                        ></path>
                    </g>
                </svg>
            </span>
        </div>
    </div>
</template>
