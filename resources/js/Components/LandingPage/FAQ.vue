<script setup lang="ts">
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from "@/Components/LandingPage/ui/accordion";

interface FAQProps {
  question: string;
  answer: string;
  value: string;
}

const FAQList: FAQProps[] = [
  {
    question: "What can I sell?",
    answer: "Be creative! You can offer any service you wish as long as it's legal and complies with our terms. There are over 200 categories you can browse to get ideas.",
    value: "item-1",
  },
  {
    question: "How much time will I need to invest?",
    answer:
      "It's very flexible. You need to put in some time and effort in the beginning to learn the marketplace and then you can decide for yourself what amount of work you want to do.",
    value: "item-2",
  },
  {
    question:
      "How much money can I make?",
    answer:
      "It's totally up to you. You can work as much as you want. Many sellers work on StafferHQ full time and some keep their 9-5 job while using StafferHQ to make extra money.",
    value: "item-3",
  },
  {
    question: "How do I price my service?",
    answer: "With Gig Packages, you set your pricing anywhere from $5 - $995 and offer three versions of your service at three different prices.",
    value: "item-4",
  },
  {
    question:
      "How much does it cost",
    answer: "It's free to join StafferHQ. There is no subscription required or fees to list your services. You keep 80% of each transaction.",
    value: "item-5",
  },
  {
    question:
      "How do I get paid?",
    answer: "Once you complete a buyer's order, the money is transferred to your account. No need to chase clients for payments and wait 60 or 90 days for a check.",
    value: "item-6",
  },
];
</script>

<template>
  <section
    id="faq"
    class="container md:w-[700px] py-24 sm:py-32"
  >
    <div class="text-center mb-8">
      <h2 class="text-lg text-primary text-center mb-2 tracking-wider">FAQS</h2>

      <h2 class="text-3xl md:text-4xl text-center font-bold">
        Common Questions
      </h2>
    </div>

    <Accordion
      type="single"
      collapsible
      class="AccordionRoot"
    >
      <AccordionItem
        v-for="{ question, answer, value } in FAQList"
        :key="value"
        :value="value"
      >
        <AccordionTrigger class="text-left"> {{ question }} </AccordionTrigger>

        <AccordionContent>{{ answer }}</AccordionContent>
      </AccordionItem>
    </Accordion>

    <h3 class="font-medium mt-4">
      Still have questions?
      <a
        href="#"
        class="text-muted-foreground"
      >
        <a
          href="#"
          class="underline"
          >Contact us</a
        >
      </a>
    </h3>
  </section>
</template>
