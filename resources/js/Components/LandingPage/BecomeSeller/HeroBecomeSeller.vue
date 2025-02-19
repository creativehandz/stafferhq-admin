<script setup lang="ts">
import { useColorMode } from "@vueuse/core";
// const mode = useColorMode();

import { Badge } from "@/Components/LandingPage/ui/badge";
import { Button } from "@/Components/LandingPage/ui/button";
import { ArrowRight } from "lucide-vue-next";
import heroImageLight from '../../../../img/LandingPage/heroImageLight.jpg'
import heroImageDark from '../../../../img/LandingPage/heroImageDark.jpg'

</script>

<template>
  <section class="container">
    <div
      class="grid gap-8 py-20 mx-auto place-items-center lg:max-w-screen-xl md:py-32"
    >
      <div class="space-y-8 text-center">
        <Badge
          variant="outline"
          class="py-2 text-sm"
        >
          <span class="mr-2 text-primary text-white">
            <Badge>New</Badge>
          </span>
          <span> Grow Your Business by Connecting with the Right Buyers </span>
        </Badge>

        <div
          class="max-w-screen-md mx-auto text-5xl font-bold text-center md:text-6xl"
        >
          <h1>
            Become a
            <span
              class="text-transparent bg-gradient-to-r from-[#D247BF] to-primary bg-clip-text"
              >Seller
            </span>
            on Towork
          </h1>
        </div>

        <p class="max-w-screen-sm mx-auto text-xl text-muted-foreground">
          At Towork, we provide a seamless platform for professionals and businesses across all industries to connect with potential buyers. Whether you're an independent service provider or a large enterprise, we help you expand your reach and increase your sales.
        </p>

        <div class="space-y-4 md:space-y-0 md:space-x-4">
          <Button class="w-5/6 font-bold md:w-1/4 group/arrow">
            Register on ToWork
            <ArrowRight
              class="ml-2 transition-transform size-5 group-hover/arrow:translate-x-1"
            />
          </Button>

          <Button
            as-child
            variant="secondary"
            class="w-5/6 font-bold md:w-1/4"
          >
            <a
              href="https://github.com/leoMirandaa/shadcn-vue-landing-page.git"
              target="_blank"
              >Login On ToWork</a
            >
          </Button>
        </div>
      </div>

      <div class="relative group mt-14">
        <!-- gradient shadow -->
        <div
          class="absolute -top-6 right-12 w-[90%] h-12 lg:h-[80%] bg-primary/50 blur-3xl rounded-full img-shadow-animation"
        ></div>

        <img
          class="w-full md:w-[1200px] mx-auto rounded-lg relative rouded-lg leading-none flex items-center border border-t-2 border-t-primary/30 img-border-animation"
          :src="heroImageLight"
          alt="dashboard using shadcn-vue"
        />

        <!-- gradient effect img -->
        <div
          class="absolute bottom-0 left-0 w-full h-20 rounded-lg md:h-28 bg-gradient-to-b from-background/0 via-background/50 to-background"
        ></div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.img-shadow-animation {
  animation-name: img-shadow-animation;
  animation-iteration-count: infinite;
  animation-duration: 2s;
  animation-timing-function: linear;
  animation-direction: alternate;
}

.img-border-animation {
  animation-name: img-border-animation;
  animation-iteration-count: infinite;
  animation-duration: 2s;
  animation-timing-function: linear;
  animation-direction: alternate;
}

@keyframes img-shadow-animation {
  from {
    opacity: 0.5;
    transform: translateY(30px);
  }

  to {
    opacity: 1;
    transform: translateY(0px);
  }
}
@keyframes img-border-animation {
  from {
    @apply border-t-primary/10;
  }

  to {
    @apply border-t-primary/60;
  }
}
</style>
