<template>
<div class="my-10">
  <div class="flex overflow-hidden bg-orange-500 shadow-lg rounded-3xl">
    <!-- Left Section (Text) -->
    <div class="flex flex-col justify-center w-1/2 p-10 space-y-6 text-left text-white">
      <h1 class="text-[36px] md:text-[42px] lg:text-[46px] xl:text-[50px] 2xl:text-[54px] font-extrabold leading-tight">
        {{ $page.props.auth.user.name }}, take the credit for referring friends to Fiverr
      </h1>
      <p class="text-[20px] md:text-[22px] lg:text-[24px] leading-relaxed">
        Earn up to <span class="font-semibold">$500 in Fiverr Credits</span> — up to $100 from each referral.
      </p>
      <p class="text-[16px] md:text-[18px] lg:text-[20px] underline mt-5 cursor-pointer hover:text-orange-200">
        Terms and conditions apply
      </p>
    </div>

    <!-- Right Section (Image) -->
    <div class="w-1/2 p-8">
      <img :src="friends" alt="Friends referral image" class="object-cover w-full h-auto shadow-md rounded-xl" />
    </div>
  </div>
</div>

</template>

<script setup lang="ts">
import friends from '@/assets/friends.png';
</script>