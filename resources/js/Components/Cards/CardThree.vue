<script setup lang="ts">
import PrimaryButton from "../PrimaryButton.vue";
</script>

<template>
    <div
        class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"
    >
        <div class="flex justify-between px-6">
            <div class="flex items-center gap-3 py-5">
                <div class="h-10 w-10 rounded-full">
                    <img src="../../../img/user/user-03.png" alt="User" />
                </div>
                <div>
                    <h4 class="font-medium text-black dark:text-white">
                        Naimur Rahman
                    </h4>
                    <p class="text-xs font-medium">Software Developer</p>
                </div>
            </div>
            <button>
                <svg class="fill-current" fill="#000000" width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M20.5,4.609A5.811,5.811,0,0,0,16,2.5a5.75,5.75,0,0,0-4,1.455A5.75,5.75,0,0,0,8,2.5,5.811,5.811,0,0,0,3.5,4.609c-.953,1.156-1.95,3.249-1.289,6.66,1.055,5.447,8.966,9.917,9.3,10.1a1,1,0,0,0,.974,0c.336-.187,8.247-4.657,9.3-10.1C22.45,7.858,21.453,5.765,20.5,4.609Zm-.674,6.28C19.08,14.74,13.658,18.322,12,19.34c-2.336-1.41-7.142-4.95-7.821-8.451-.513-2.646.189-4.183.869-5.007A3.819,3.819,0,0,1,8,4.5a3.493,3.493,0,0,1,3.115,1.469,1.005,1.005,0,0,0,1.76.011A3.489,3.489,0,0,1,16,4.5a3.819,3.819,0,0,1,2.959,1.382C19.637,6.706,20.339,8.243,19.826,10.889Z"/></svg>
            </button>
        </div>
        <div class="flex gap-3 justify-between px-6">
            <div class="flex gap-1 items-center">
                <svg
                    fill="#000000"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    id="money-dollar-coin"
                    data-name="Line Color"
                    xmlns="http://www.w3.org/2000/svg"
                    class="icon line-color"
                >
                    <path
                        id="secondary"
                        d="M10,15h2.5A1.5,1.5,0,0,0,14,13.5h0A1.5,1.5,0,0,0,12.5,12h-1A1.5,1.5,0,0,1,10,10.5h0A1.5,1.5,0,0,1,11.5,9H14"
                        style="
                            fill: none;
                            stroke: rgb(44, 169, 188);
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-width: 2;
                        "
                    ></path>
                    <path
                        id="secondary-2"
                        data-name="secondary"
                        d="M12,9V8m0,8V15"
                        style="
                            fill: none;
                            stroke: rgb(44, 169, 188);
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-width: 2;
                        "
                    ></path>
                    <circle
                        id="primary"
                        cx="12"
                        cy="12"
                        r="9"
                        style="
                            fill: none;
                            stroke: rgb(0, 0, 0);
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-width: 2;
                        "
                    ></circle>
                </svg>
                <p class="font-medium">$750.00/hr</p>
            </div>
            <div class="flex gap-1 items-center">
                <svg
                    fill="#000000"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M19,6.5H16v-1a3,3,0,0,0-3-3H11a3,3,0,0,0-3,3v1H5a3,3,0,0,0-3,3v9a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3v-9A3,3,0,0,0,19,6.5Zm-9-1a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1v1H10Zm10,13a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V13.45H7V14.5a1,1,0,0,0,2,0V13.45h6V14.5a1,1,0,0,0,2,0V13.45h3Zm0-7H4V9.5a1,1,0,0,1,1-1H19a1,1,0,0,1,1,1Z"
                    />
                </svg>
                <p class="font-medium">$1M+ earned</p>
            </div>
        </div>

        <div class="flex gap-3 justify-between px-6 py-3">
            <div class="flex gap-1 items-center">
                <p class="font-medium">98% Job Success</p>
            </div>
            <div class="flex gap-1 items-center">
               
                <p class="font-medium">Top Rated Plus</p>
            </div>
        </div>
    </div>
</template>
