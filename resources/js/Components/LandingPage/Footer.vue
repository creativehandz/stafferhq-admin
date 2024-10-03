<template>
  <div class="container px-4 py-8 mx-auto"> 
    <!-- Join Us Section -->
    <div class="px-6 py-12 text-center text-white bg-[#FB7B24] rounded-3xl md:px-16">
      <h2 class="mb-4 text-4xl font-bold text-center text-white ">Join us!</h2>
      <p class="mb-6 text-lg font-bold text-white">Services and more, just a few clicks away</p>
      <button class="px-11 py-6 font-bold text-black transition-all duration-300 rounded-full shadow-md bg-[#F5F535] hover:bg-yellow-400">
        Get ToWork!
      </button>
    </div>

    <!-- Footer Section -->
    <footer class="flex items-center justify-between pt-4 pb-6 mt-8 text-sm text-gray-600 border-t">
      <div>
        <strong class="font-bold text-black">ToWork.</strong>
        <span> © TheFaceCraft, 2024</span>
      </div>
      <div class="flex space-x-4">
        <a href="#" class="hover:underline">Terms of Service</a>
        <a href="#" class="hover:underline">Privacy Policy</a>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
// No additional logic needed
</script>

<style scoped>
  h2 {
    font-family: Crimson Pro;
    font-size: 80px;    
    line-height: 96px;
  }
  p {
    font-family: DM sans;
    font-size: 24px;
    line-height: 30px;
  }
  button {
    font-family: sans-serif;
    font-size: 24px;
    line-height: 30px;
  }
</style>
