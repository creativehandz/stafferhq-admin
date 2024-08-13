<script setup lang="ts">
import { ref } from 'vue';
import HeaderArea from '@/Components/Header/HeaderArea.vue'
import { Link } from '@inertiajs/vue3';
import SidebarAreaEmployer from '@/Components/Sidebar/SidebarAreaEmployer.vue';

const showingNavigationDropdown = ref(false);
</script>

<template>
<div>
<!-- ===== Page Wrapper Start ===== -->
  <div class="flex h-screen overflow-hidden">
    <!-- ===== Sidebar Start ===== -->
    <SidebarAreaEmployer />
    <!-- ===== Sidebar End ===== -->

    <!-- ===== Content Area Start ===== -->
    <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
      <!-- ===== Header Start ===== -->
      <HeaderArea />
      <!-- ===== Header End ===== -->

      <!-- ===== Main Content Start ===== -->
      <main>
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
          <slot></slot>
        </div>
      </main>
      <!-- ===== Main Content End ===== -->
    </div>
  </div>
  <!-- ===== Page Wrapper End ===== -->
  </div>
</template>
