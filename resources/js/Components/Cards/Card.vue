<script setup lang="ts">
import PrimaryButton from '../PrimaryButton.vue';
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
                    <p class="text-xs font-medium">Ux Designer</p>
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
            <!-- <a
                aria-current="page"
                href="/ui-elements/cards#"
                class="router-link-active router-link-exact-active block px-4"
                ><img src="../../../img/cards/cards-01.png" alt="Cards"
            /></a> -->
            <div class="flex pl-6">
                <button
                        class="inline-flex rounded-full border py-1 px-3 text-sm font-medium hover:opacity-80"
                        style="
                            border-color: rgb(249, 193, 7);
                            color: rgb(249, 193, 7);
                        "
                    >
                        In Progress
                    </button>
            </div>
            <div class="p-6">
                <h4
                    class="mb-3 text-xl font-semibold text-black dark:text-white"
                >
                    <a
                        aria-current="page"
                        href="/ui-elements/cards#"
                        class="router-link-active router-link-exact-active"
                        >Card Title here</a
                    >
                </h4>
                <p class="font-medium">
                    Lorem ipsum dolor sit amet, vehiculaum ero felis loreum
                    fitiona fringilla goes scelerisque Interdum et.
                </p>
            </div>
            <div class="flex p-6 justify-between">
                <PrimaryButton>Hire This Talent</PrimaryButton>
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" width="18" height="18" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>
                </button>
            </div>
        </div>
    
</template>
