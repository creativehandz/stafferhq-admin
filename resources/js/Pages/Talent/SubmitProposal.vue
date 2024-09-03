<script setup lang="ts">
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { formatDate } from "@/stores/formateDistanceToNow";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

const pageTitle = ref("Submit a Proposal");

// Define the Job type
type Job = {
    id: number;
    title: string;
    project_type: string;
    category?: string;
    skills?: string[];
    experience_level: string;
    budget_type?: string;
    budget: number;
    description: string;
    location?: string;
    attachment?: File | null;
    created_at: string;
    // Add any other fields that are present in your job object
};

// Define the type for the props
type Props = {
    job: Job;
};

// Receive the jobs data passed from the backend with correct type
const props = defineProps<Props>();
</script>

<template>
    <Head title="Submit a Proposal" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Submit a Proposal
            </h2>
        </template>

        <!-- Breadcrumb Start -->
        <BreadcrumbDefault :pageTitle="pageTitle" />
        <!-- Breadcrumb End -->

        <div class="py-6 min-w-full grid col-span-12 gap-2">
            <div class="mb-6 flex-col gap-3">
                <div
                    class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"
                >
                    <div class="p-4 sm:p-6 xl:p-10">
                        <h2
                            class="pb-5 text-title-sm2 font-semibold text-black dark:text-white"
                        >
                            Job Details
                        </h2>
                        <h2
                            class="text-title-md2 font-semibold text-black dark:text-white"
                        >
                            {{ props.job.title }}
                        </h2>
                        <div class="flex gap-3 py-5">
                            <p class="text-xs font-medium">
                                Posted {{ formatDate(props.job.created_at) }}
                            </p>
                            <div class="flex">
                                <svg
                                    class="fill-current"
                                    width="18"
                                    height="18"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M12 2c-4.4 0-8 3.6-8 8 0 5.4 7 11.5 7.3 11.8.2.1.5.2.7.2.2 0 .5-.1.7-.2.3-.3 7.3-6.4 7.3-11.8 0-4.4-3.6-8-8-8zm0 17.7c-2.1-2-6-6.3-6-9.7 0-3.3 2.7-6 6-6s6 2.7 6 6-3.9 7.7-6 9.7zM12 6c-2.2 0-4 1.8-4 4s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
                                        fill=""
                                    />
                                </svg>
                                <p class="text-xs font-medium">
                                    {{ props.job.location }}
                                </p>
                            </div>
                        </div>
                        {{ props.job.description }}
                        <div class="py-4 sm:py-6 xl:py-10">
                            <div class="flex justify-between">
                                <div class="flex gap-2">
                                    <svg
                                        class="fill-current"
                                        width="18"
                                        height="18"
                                        viewBox="0 0 32 32"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                    >
                                        <defs>
                                            <clipPath id="clip-pricetag2">
                                                <rect width="32" height="32" />
                                            </clipPath>
                                        </defs>
                                        <g
                                            id="pricetag2"
                                            clip-path="url(#clip-pricetag2)"
                                        >
                                            <g
                                                id="Group_2401"
                                                data-name="Group 2401"
                                                transform="translate(-208 -260)"
                                            >
                                                <g
                                                    id="Group_2397"
                                                    data-name="Group 2397"
                                                >
                                                    <g
                                                        id="Group_2396"
                                                        data-name="Group 2396"
                                                    >
                                                        <g
                                                            id="Group_2395"
                                                            data-name="Group 2395"
                                                        >
                                                            <path
                                                                id="Path_3856"
                                                                data-name="Path 3856"
                                                                d="M227.168,273.419l.524-.524q.4-.4.087-.708t-.713.1l-.514.514a3.37,3.37,0,0,0-2.156-.915,2.941,2.941,0,0,0-2.675,2.156,2.6,2.6,0,0,0,.08,1.337,8.391,8.391,0,0,0,.687,1.486l-2.256,2.255a1.844,1.844,0,0,1-.254-.788,1.652,1.652,0,0,1,.092-.679,8.652,8.652,0,0,1,.381-.836.745.745,0,0,0,.077-.495.906.906,0,0,0-.267-.471.854.854,0,0,0-.64-.266.828.828,0,0,0-.6.237,2.367,2.367,0,0,0-.507.779,2.985,2.985,0,0,0-.211,1.05,3.323,3.323,0,0,0,.2,1.215,4.338,4.338,0,0,0,.725,1.258l-1.309,1.31a.861.861,0,0,0-.26.4.386.386,0,0,0,.138.352.336.336,0,0,0,.376.114,1.61,1.61,0,0,0,.473-.362l1.208-1.207a3.856,3.856,0,0,0,1.562.834,2.913,2.913,0,0,0,1.552-.024,3.061,3.061,0,0,0,1.295-.776,2.85,2.85,0,0,0,.65-.975,2.564,2.564,0,0,0,.174-1.1,2.806,2.806,0,0,0-.245-1.031q-.22-.492-.657-1.259l2.018-2.017a1.554,1.554,0,0,1-.034,1.576.853.853,0,0,0,.1,1.13.826.826,0,0,0,.606.252.807.807,0,0,0,.6-.242,1.666,1.666,0,0,0,.362-.6,2.914,2.914,0,0,0,.172-.846,2.5,2.5,0,0,0-.162-1.133A4.3,4.3,0,0,0,227.168,273.419Zm-4.263,6.31a1.413,1.413,0,0,1-.956.422,1.883,1.883,0,0,1-1.149-.364l2.124-2.124a2.987,2.987,0,0,1,.374,1.154A1.174,1.174,0,0,1,222.9,279.729Zm.844-4.123a2.76,2.76,0,0,1-.294-1.006,1.274,1.274,0,0,1,1.2-1.167,2.414,2.414,0,0,1,.955.315Z"
                                                                fill=""
                                                            />
                                                        </g>
                                                    </g>
                                                </g>
                                                <g
                                                    id="Group_2400"
                                                    data-name="Group 2400"
                                                >
                                                    <g
                                                        id="Group_2399"
                                                        data-name="Group 2399"
                                                    >
                                                        <g
                                                            id="Group_2398"
                                                            data-name="Group 2398"
                                                        >
                                                            <path
                                                                id="Path_3857"
                                                                data-name="Path 3857"
                                                                d="M239.516,261.014a.47.47,0,0,0-.519-.462.506.506,0,0,0-.48.514c0,.063-.013,1.556-3.314,1.978a4.632,4.632,0,0,0-1.631.529l-1.613-1.614a1,1,0,0,0-.966-.259l-8.016,2.149a1,1,0,0,0-.675.292l-13.526,13.526a1,1,0,0,0,0,1.414l12.08,12.079a1,1,0,0,0,1.414,0L235.8,277.635a1,1,0,0,0,.292-.673l2.148-8.018a1,1,0,0,0-.259-.966l-3.657-3.657a3.672,3.672,0,0,1,1.01-.285C239.621,263.488,239.522,261.114,239.516,261.014Zm-5.361,15.433-12.592,12.592L210.9,278.374l12.592-12.593,7.464-2,1.092,1.093a7.589,7.589,0,0,0-1.165,2.164,2.122,2.122,0,1,0,.967.245,6.461,6.461,0,0,1,.908-1.7l3.4,3.4Zm-2.545-8.12a1,1,0,1,1-1.415,0,.978.978,0,0,1,.371-.227,7.822,7.822,0,0,0-.161.886.5.5,0,0,0,.448.545.423.423,0,0,0,.05,0,.5.5,0,0,0,.5-.451,7.226,7.226,0,0,1,.147-.8C231.566,268.3,231.591,268.309,231.61,268.327Z"
                                                                fill=""
                                                            />
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                    <div class="flex flex-col gap-1">
                                        <p class="text-xs font-bold">
                                            {{ "$" + props.job.budget }}
                                        </p>
                                        <p class="text-xs font-medium">
                                            {{ props.job.budget_type }} Price
                                        </p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <svg
                                        class="fill-current"
                                        fill="none"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 100 100"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M43.84,46.76a5.35,5.35,0,1,1,5.46-5.34A5.41,5.41,0,0,1,43.84,46.76Z"
                                            fill-rule="evenodd"
                                        />
                                        <path
                                            d="M77.33,55.7,70.06,44.9V44A24,24,0,0,0,46.19,20a22,22,0,0,0-5.67.7A23.89,23.89,0,0,0,22.31,44a21.92,21.92,0,0,0,3.58,12.7c4.18,6,7,10.8,5.27,17.3a4.58,4.58,0,0,0,.9,4.2A4.43,4.43,0,0,0,35.74,80h19.6A4.72,4.72,0,0,0,60,76.2a5,5,0,0,0,.2-1.2,2.37,2.37,0,0,1,2.39-2H64a4.72,4.72,0,0,0,4.68-3.4A41.31,41.31,0,0,0,70.16,60h5.17a2.78,2.78,0,0,0,2.19-1.6A2.86,2.86,0,0,0,77.33,55.7ZM57.49,47.33l-1,1.57a2.22,2.22,0,0,1-1.76.94,2.38,2.38,0,0,1-.72-.16l-2.65-1a11.64,11.64,0,0,1-3.85,2.2l-.48,2.91a2,2,0,0,1-2,1.65h-2a2,2,0,0,1-2-1.65l-.48-2.91a10,10,0,0,1-3.69-2l-2.81,1a2.38,2.38,0,0,1-.72.16,2.1,2.1,0,0,1-1.76-1l-1-1.65a1.94,1.94,0,0,1,.48-2.51l2.33-1.89a10.11,10.11,0,0,1-.24-2.12,9.41,9.41,0,0,1,.24-2L31.1,36.88a1.92,1.92,0,0,1-.48-2.51l1-1.65a2,2,0,0,1,1.76-1,2.38,2.38,0,0,1,.72.16l2.81,1a11.52,11.52,0,0,1,3.69-2.12L41,28a1.91,1.91,0,0,1,2-1.57h2a1.92,1.92,0,0,1,2,1.49l.48,2.83a11.31,11.31,0,0,1,3.69,2l2.81-1a2.38,2.38,0,0,1,.72-.16,2.1,2.1,0,0,1,1.76,1l1,1.65A2,2,0,0,1,57,36.8l-2.33,1.89a9.56,9.56,0,0,1,.24,2.12,9.41,9.41,0,0,1-.24,2L57,44.74A2,2,0,0,1,57.49,47.33Z"
                                            fill-rule="evenodd"
                                        />
                                    </svg>
                                    <div class="flex flex-col gap-1">
                                        <p class="text-xs font-bold">
                                            {{ props.job.experience_level }}
                                        </p>
                                        <p class="text-xs font-medium">
                                            I am looking for mix of experience
                                            and value
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-2 sm:py-3 xl:py-5">
                            <div class="flex-col space-y-4">
                                <h2
                                    class="text-title-md2 font-semibold text-black dark:text-white"
                                >
                                    Skills and Expertise
                                </h2>
                                <button
                                    class="inline-flex rounded-full border py-1 px-3 text-sm font-medium hover:opacity-80"
                                    style="
                                        border-color: rgb(60, 167, 69);
                                        color: rgb(60, 167, 69);
                                    "
                                >
                                    Skill here
                                </button>
                            </div>
                        </div>
                        <div class="py-2 sm:py-3 xl:py-5">
                            <div class="flex-col space-y-1">
                                <h2
                                    class="text-title-md2 font-semibold text-black dark:text-white"
                                >
                                    Terms
                                </h2>
                                <p class="text-sm font-medium">Terms here</p>
                            </div>
                        </div>
                        <div class="py-2 sm:py-3 xl:py-5">
                            <div class="flex-col space-y-5">
                                <h2
                                    class="text-title-md2 font-semibold text-black dark:text-white"
                                >
                                    Cover Letter
                                </h2>
                                <textarea
                                    rows="6"
                                    placeholder="Write your cover letter"
                                    class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                    _mstplaceholder="289419"
                                    _msthash="279"
                                ></textarea>
                                <input
                                    type="file"
                                    class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter file:py-3 file:px-5 file:hover:bg-primary file:hover:bg-opacity-10 focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:file:bg-white/30 dark:file:text-white dark:focus:border-primary"
                                />
                                <PrimaryButton>Submit</PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
