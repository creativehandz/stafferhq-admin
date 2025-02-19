<script setup lang="ts">
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/LandingPage/ui/card";
import { Badge } from "@/Components/LandingPage/ui/badge";
import roboto from '../../../../img/LandingPage/roboto.png'
import runner from '../../../../img/LandingPage/runner.png'
import pacheco from '../../../../img/LandingPage/pacheco.png'
import gamestation from '../../../../img/LandingPage/gamestation.png'

interface HowItWorksProps {
  badgeTitle: string;
  title: string;
  description: string;
  image: string;
}

const HowItWorksList: HowItWorksProps[] = [
  {
    badgeTitle: "Contribute",
    title: "Step 1: Sign Up & Create Your Profile",
    description:
      "Register on Towork by providing your details and selecting the services you offer. A complete profile increases your chances of getting hired.",
    image: roboto,
  },
  {
    badgeTitle: "Discover",
    title: "Step 2: List Your Services",
    description:
      "Describe your expertise, pricing, and availability to attract the right customers. Add images, videos, and customer testimonials for better engagement.",
    image: runner,
  },
  {
    badgeTitle: "Innovate",
    title: "Step 3: Get Hired & Deliver Services",
    description:
      "Receive service requests from buyers, communicate efficiently, and complete projects professionally to build a strong reputation.",
    image: pacheco,
  },
  {
    badgeTitle: "Collaborate",
    title: "Step 4: Secure Payments & Grow Your Business",
    description:
      "Receive payments securely and on time. Scale your business with insights from analytics and customer feedback.",
    image: gamestation,
  },
];
</script>

<template>
  <section
    id="features"
    class="container py-24 sm:py-32"
  >
    <div class="text-center mb-8">
      <h2 class="text-lg text-primary text-center mb-2 tracking-wider">
        How It Works
      </h2>

      <h2 class="text-3xl md:text-4xl text-center font-bold">
        Step-by-Step Process
      </h2>
    </div>

    <div class="lg:w-[80%] mx-auto relative">
      <div
        v-for="(
          { badgeTitle, title, description, image }, index
        ) in HowItWorksList"
        :key="title"
        :class="[
          'flex mb-8 items-center',
          { ' flex-row-reverse': index % 2 !== 0 },
        ]"
      >
        <Card class="h-full bg-transparent border-0 shadow-none">
          <CardHeader>
            <div class="pb-4">
              <Badge>{{ badgeTitle }}</Badge>
            </div>

            <CardTitle>
              {{ title }}
            </CardTitle>
          </CardHeader>

          <CardContent class="text-muted-foreground w-[80%]">
            {{ description }}
          </CardContent>
        </Card>

        <img
          :src="image"
          :alt="`Image describing ${title} `"
          className="w-[150px]  md:w-[250px] lg:w-[300px] mx-auto -scale-x-100 "
        />
        <div
          :class="[
            '-z-10 absolute right-0 w-44 h-72  lg:w-64 lg:h-80 rounded-full bg-primary/15 dark:bg-primary/10 blur-3xl',
            {
              'left-0': index % 2 !== 0,
            },
          ]"
        ></div>
      </div>
    </div>
  </section>
</template>
