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
  id: number;
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
    class="container"
  >
    <div class="mb-8 text-center">
      <h2 class="mb-2 text-lg tracking-wider text-center text-primary">
        Popular
      </h2>

      <h2 class="mb-4 text-3xl font-bold text-center md:text-4xl">
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
          class="sm:basis-1/2 md:basis-1/3 xl:basis-1/4"
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
                  <CardTitle class="text-lg"> <a :href="`/categories/${subCategory.id}/sellers`"> {{ subCategory.name }}</a></CardTitle>
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
