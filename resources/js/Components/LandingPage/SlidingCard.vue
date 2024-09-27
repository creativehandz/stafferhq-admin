<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from "@/Components/LandingPage/ui/avatar";

import {
  Card,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/Components/LandingPage/ui/card";

import {
  Carousel,
  CarouselContent,
  CarouselItem,
  CarouselNext,
  CarouselPrevious,
} from "@/Components/LandingPage/ui/carousel";


interface PopularSubCategoryProps {
  image: string;
  name: string;
}

defineProps<{
  popularSubCategoryList: PopularSubCategoryProps[]
}>();


</script>

<template>
  <section
    id="SlidingCard"
    class="container py-12 sm:py-16"
  >
    <div class="text-center mb-8">
      <h2 class="text-lg text-primary text-center mb-2 tracking-wider">
        Popular
      </h2>

      <h2 class="text-3xl md:text-4xl text-center font-bold mb-4">
        Most popular in this category
      </h2>
    </div>

    <Carousel
      :opts="{
        align: 'start',
      }"
      class="relative w-[80%] sm:w-[90%] lg:max-w-screen-xl mx-auto"
    >
      <CarouselContent>
        <CarouselItem
          v-for="subCategory in popularSubCategoryList"
          :key="subCategory.name"
          class="md:basis-1/3 lg:basis-1/4"
        >
          <Card class="bg-muted/50 dark:bg-card">
           
            <CardHeader>
              <div class="flex flex-row items-center gap-4">
                <Avatar>
                  <AvatarImage
                    src="https://github.com/radix-vue.png"
                    alt="@radix-vue"
                  />
                  <AvatarFallback>SV</AvatarFallback>
                </Avatar>

                <div class="flex flex-col">
                  <CardTitle class="text-lg">{{ subCategory.name }}</CardTitle>
                </div>
              </div>
            </CardHeader>
          </Card>
        </CarouselItem>
      </CarouselContent>
      <CarouselPrevious />
      <CarouselNext />
    </Carousel>
  </section>
</template>
