<script setup lang="ts">
import {
  Card,
  CardHeader,
  CardTitle,
  CardFooter,
  CardContent,
} from "@/Components/LandingPage/ui/card";

import { Button } from "@/Components/LandingPage/ui/button";


defineProps<{
  category: string;
}>();

</script>

<template>
  <section
    id="CategoryHeader"
    class="container py-12 sm:py-16"
  >
  <hr/>
      <div class="lg:w-[60%] mx-auto">
        <Card
          class="bg-background shadow-none text-center flex flex-col items-center justify-center border-0"
        >
          <CardHeader>
            <CardTitle class="text-4xl md:text-5xl font-bold">
            <span
                class="text-transparent bg-gradient-to-r from-[#D247BF] to-primary bg-clip-text"
              >
              {{ category }}
              </span>
            </CardTitle>
          </CardHeader>
          <CardContent class="lg:w-[80%] text-xl text-muted-foreground">
            Join StafferHQ community! Connect, share, and grow with
            like-minded enthusiasts. Click to dive in! 🚀
          </CardContent>

          <CardFooter>
            <Button as-child>
              <a
                href=""
                target="_blank"
              >
                How StafferHQ Works
              </a>
            </Button>
          </CardFooter>
        </Card>
      </div>
    <hr/>
  </section>
</template>
