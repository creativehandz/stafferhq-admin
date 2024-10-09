<script setup lang="ts">
import { Button } from "@/Components/LandingPage/ui/button";
import { Sun } from "lucide-vue-next"; // Only keep the icon for light mode
</script>

<template>
  <Button
    size="sm"
    variant="ghost"
    class="justify-start w-full"
  >
    <div class="flex gap-2">
      <Sun class="size-5" />
      <span class="block lg:hidden">Light</span>
    </div>

    <span class="sr-only">Toggle theme</span>
  </Button>
</template>
