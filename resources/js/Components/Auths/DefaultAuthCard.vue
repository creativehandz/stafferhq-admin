<script setup lang="ts">
const props = defineProps(['subtitle', 'title', 'customClasses'])
</script>

<template>
  <!-- ====== Forms Section Start -->
  <div
    class="bg-white border rounded-sm border-stroke shadow-default dark:border-strokedark dark:bg-boxdark"
  >
    <div class="flex flex-wrap items-center">
      <div class="hidden w-full xl:block xl:w-1/2">
        <div class="py-17.5 px-26 text-center">
          <router-link class="mb-5.5 flex justify-center items-center gap-4" to="/">
            <!-- <img class="hidden dark:block h-9" src="../../../img/logo.png" alt="Logo" />
            <img class="dark:hidden h-9" src="../../../img/logo.png" alt="Logo" />
            <h1 class="text-3xl font-bold text-black dark:text-white">StafferHQ</h1> -->
          </router-link>        
            
          <span class="inline-block mt-15">
            <div
        class="bg-[#FB7B24] rounded-[25px] w-[480px] h-[700px] flex justify-center items-center"
      >
            <img src="../../../img/Business, analytics, sucess, startup, Technology _ account, setting, options, preferences.png" alt="illustration">
            </div>
          </span>
        </div>
      </div>
      <div class="w-full border-stroke dark:border-strokedark xl:w-1/2 ">
        <div class="w-full p-4 sm:p-12.5 xl:p-17.5">
          
          <h2 class="text-2xl  dark:text-white sm:text-title-xl2 text-[48px] font-bold font-crimsonPro text-black mb-4">
            {{ props.title }}
          </h2>
          <span class="mb-1.5 block font-medium">{{ props.subtitle }}</span>

          <slot></slot>
        </div>
      </div>
    </div>
  </div>
  <!-- ====== Forms Section End -->
</template>
