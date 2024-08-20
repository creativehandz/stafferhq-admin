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
                    <p class="text-xs font-medium">India</p>
                </div>
            </div>
            <button>
                <svg
                    fill="#000000"
                    width="18"
                    height="18"
                    viewBox="0 0 32 32"
                    enable-background="new 0 0 32 32"
                    id="Glyph"
                    version="1.1"
                    xml:space="preserve"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                >
                    <path
                        d="M16,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S17.654,13,16,13z"
                        id="XMLID_287_"
                    />
                    <path
                        d="M6,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S7.654,13,6,13z"
                        id="XMLID_289_"
                    />
                    <path
                        d="M26,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S27.654,13,26,13z"
                        id="XMLID_291_"
                    />
                </svg>
            </button>
        </div>
        <div class="flex gap-3 px-6">
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
                <p class="font-medium">$10.00/hr</p>
            </div>
            <div class="flex gap-1 items-center">
                <svg
                    fill="#000000"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    id="star"
                    data-name="Line Color"
                    xmlns="http://www.w3.org/2000/svg"
                    class="icon line-color"
                >
                    <polygon
                        id="primary"
                        points="12 4 9.22 9.27 3 10.11 7.5 14.21 6.44 20 12 17.27 17.56 20 16.5 14.21 21 10.11 14.78 9.27 12 4"
                        style="
                            fill: none;
                            stroke: rgb(0, 0, 0);
                            stroke-linecap: round;
                            stroke-linejoin: round;
                            stroke-width: 2;
                        "
                    ></polygon>
                </svg>
                <p class="font-medium">5.00</p>
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
                <p class="font-medium">3</p>
            </div>
        </div>
        <!-- <a
                aria-current="page"
                href="/ui-elements/cards#"
                class="router-link-active router-link-exact-active block px-4"
                ><img src="../../../img/cards/cards-01.png" alt="Cards"
            /></a> -->

        <div class="p-6">
            <h4 class="mb-3 text-xl font-semibold text-black dark:text-white">
                <a
                    aria-current="page"
                    href="/ui-elements/cards#"
                    class="router-link-active router-link-exact-active"
                    >Current Contract:</a
                >
            </h4>
            <p class="font-medium">
                Lorem ipsum dolor sit amet, vehiculaum ero felis loreum fitiona
                fringilla goes scelerisque Interdum et.
            </p>
        </div>
        <div class="flex pl-6">
            <button
                class="inline-flex rounded-full border py-1 px-3 text-sm font-medium hover:opacity-80"
                style="
                    border-color: rgb(59, 162, 184);
                    color: rgb(59, 162, 184);
                "
            >
                <svg
                    width="18"
                    height="18"
                    viewBox="0 0 128 128"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    aria-hidden="true"
                    role="img"
                    class="iconify iconify--noto"
                    preserveAspectRatio="xMidYMid meet"
                >
                    <path
                        d="M69.68 54.04S98.65 7.63 99.31 6.47c.66-1.16.8-3.29-1.02-3.29S51.34 49.25 51.34 49.25l-32.05 19s-2.15 1.32-1.82 2.97s1.77 1.72 2.43 1.72s34.85-.18 36.84-.24c2.47-.07 1.86 3.44 1.86 3.44l-21.64 34.02s-9.45 13.08-9.45 13.97c0 1.31 1.58 1.96 3.05 1.08c1.14-.68 74.84-63.13 78.09-67.42c.88-1.17 1.33-4.25-2.3-4.25s-32.54 8.42-32.54 8.42l-4.13-7.92z"
                        fill="#feb804"
                    ></path>
                    <path
                        d="M64.61 50.35c-.89 1.22-1.13 3.26.79 3.38c1.91.11 40.95-.18 40.95-.18S78.46 79.18 70.02 86.83s-36.39 32.43-38.27 34.18c-1.84 1.72-3.51 3.3-4.19 3.08c-.11-.03-.25-.62 2.38-4.95c2.4-3.95 25.44-42.56 26.34-44.02c.9-1.46 1.69-2.7 2.14-3.38c.45-.68 1.91-4.39-1.13-4.39s-38 .9-38 .9s24.15-20.49 31.13-26S96.96 3.18 98.29 3.18S65.51 49.12 64.61 50.35z"
                        fill="#ffc927"
                    ></path>
                    <path
                        d="M63.45 70.75c1.8-2.59 3.57-2.78 4.64-2.14c1.38.83 1.52 2.74-.22 5.05c-2.74 3.66-22.88 30.61-23.65 31.56c-1.46 1.8-3.61 1.01-2.21-1.6c1.17-2.16 19.58-30.19 21.44-32.87z"
                        fill="#ffe567"
                    ></path>
                    <path
                        d="M34.83 65.49c-3.45 2.31-6.66-1.14-4.35-3.67s17.47-15.15 20.54-17.76s20.99-18.2 22.38-19.32c1.84-1.48 2.98.02 1.82 1.56c-1.15 1.54-13.82 14.2-19.41 19.34c-4.32 3.98-17.7 17.65-20.98 19.85z"
                        fill="#ffe567"
                    ></path>
                </svg>

                Available for Rehire
            </button>
        </div>
        <div class="flex p-6 justify-between">
            <PrimaryButton>Rehire</PrimaryButton>
            <button>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="#000000"
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"
                    />
                </svg>
            </button>
        </div>
    </div>
</template>
