<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
const props = defineProps(['pageTitle'])
</script>

<template>
  <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

    <div class="flex gap-3 font-normal text-black dark:text-white">
      <a href="">Freelancers</a>
      <span> | </span>
      <a href="">Web Mobile & Software Dev</a>
      <a href="">AI Service</a>
      <a href="">Admin Support</a>
      <a href="">More</a>
    </div>

    <nav>
      <ol class="flex items-center gap-2">
        <li>
          <Link :href="route('dashboard')">
          <router-link class="font-medium" to="/"> Dashboard / </router-link>
        </Link>
        </li>
        <li class="font-medium text-primary">{{ props.pageTitle }}</li>
      </ol>
    </nav>
  </div>
</template>
