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
import SelectGroupOne from "@/Components/Forms/SelectGroup/SelectGroupOne.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import SelectBudget from "@/Components/Forms/SelectGroup/SelectBudget.vue";
</script>

<template>
    <Head title="Post A Job" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Post A Job
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
                <!-- ====== Form Elements Section Start -->
                <div class="grid grid-cols-1 gap-9 sm:grid-cols-2">
                    <div class="flex flex-col gap-9">
                        <!-- Input Fields Start -->
                        <DefaultCard cardTitle="Post A Job">
                            <form action="">
                                <div class="flex flex-col gap-5 p-6">
                                    <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Job Title
                                        </label>
                                        <input
                                            type="text"
                                            placeholder="Enter Job Title"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        />
                                    </div>

                                    <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Job Description
                                        </label>
                                        <textarea
                                            rows="6"
                                            placeholder="Enter Job Description"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                        ></textarea>
                                    </div>

                                    <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Budget
                                        </label>
                                        <input
                                            type="text"
                                            placeholder="Enter Budget"
                                            class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary dark:disabled:bg-black"
                                        />
                                        <SelectBudget />
                                    </div>

                                    <div>
                                        <label
                                            class="mb-3 block text-sm font-medium text-black dark:text-white"
                                        >
                                            Job Detail PDF
                                        </label>
                                        <input
                                            type="file"
                                            class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter file:py-3 file:px-5 file:hover:bg-primary file:hover:bg-opacity-10 focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:file:bg-white/30 dark:file:text-white dark:focus:border-primary"
                                        />
                                    </div>

                                    <div class="mb-5 mt-6">
                                        <input
                                            type="submit"
                                            value="Post Job"
                                            class="flex w-full cursor-pointer border border-primary bg-primary p-3 font-medium text-white transition hover:bg-opacity-90"
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
