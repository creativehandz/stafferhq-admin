<script setup lang="ts">
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
    CardFooter,
} from "@/Components/LandingPage/ui/card";

import LinkedInIcon from "@/Components/LandingPage/icons/LinkedInIcon.vue";
import GithubIcon from "@/Components/LandingPage/icons/GithubIcon.vue";
import XIcon from "@/Components/LandingPage/icons/XIcon.vue";
import Button from "./ui/button/Button.vue";

interface TeamProps {
    imageUrl: string;
    firstName: string;
    lastName: string;
    positions: string[];
    socialNetworks: SocialNetworkProps[];
}

interface SocialNetworkProps {
    name: string;
    url: string;
}

const teamList: TeamProps[] = [
    {
        imageUrl: "https://i.pravatar.cc/250?img=58",
        firstName: "I am a",
        lastName: "Software Developer",
        positions: ["Leo Miranda"],
        socialNetworks: [
            {
                name: "LinkedIn",
                url: "https://www.linkedin.com/in/leopoldo-miranda/",
            },
            {
                name: "Github",
                url: "https://github.com/leoMirandaa",
            },
            {
                name: "X",
                url: "https://x.com/leo_mirand4",
            },
        ],
    },
    {
        imageUrl:
            "https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=1528&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        firstName: "I am a",
        lastName: "UI/UX Designer",
        positions: ["Elizabeth Moore"],
        socialNetworks: [
            {
                name: "LinkedIn",
                url: "https://www.linkedin.com/in/leopoldo-miranda/",
            },
            {
                name: "X",
                url: "https://x.com/leo_mirand4",
            },
        ],
    },
    {
        imageUrl:
            "https://images.unsplash.com/photo-1527980965255-d3b416303d12?q=80&w=1760&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        firstName: "I am a",
        lastName: "Writer",
        positions: ["David Diaz "],
        socialNetworks: [
            {
                name: "LinkedIn",
                url: "https://www.linkedin.com/in/leopoldo-miranda/",
            },
            {
                name: "Github",
                url: "https://github.com/leoMirandaa",
            },
        ],
    },
    {
        imageUrl:
            "https://images.unsplash.com/photo-1573497161161-c3e73707e25c?q=80&w=1587&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        firstName: "I am a",
        lastName: "Video Editor",
        positions: ["Sarah Robinson"],
        socialNetworks: [
            {
                name: "LinkedIn",
                url: "https://www.linkedin.com/in/leopoldo-miranda/",
            },
            {
                name: "Github",
                url: "https://github.com/leoMirandaa",
            },
            {
                name: "X",
                url: "https://x.com/leo_mirand4",
            },
        ],
    },
    {
        imageUrl:
            "https://images.unsplash.com/photo-1616805765352-beedbad46b2a?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        firstName: "I am a",
        lastName: "Musician",
        positions: ["Michael Holland"],
        socialNetworks: [
            {
                name: "LinkedIn",
                url: "https://www.linkedin.com/in/leopoldo-miranda/",
            },
        ],
    },
    {
        imageUrl:
            "https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?q=80&w=1587&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        firstName: "I am a",
        lastName: "Voiceover Artist",
        positions: ["Zoe Garcia"],
        socialNetworks: [
            {
                name: "LinkedIn",
                url: "https://www.linkedin.com/in/leopoldo-miranda/",
            },
            {
                name: "Github",
                url: "https://github.com/leoMirandaa",
            },
        ],
    },
    {
        imageUrl:
            "https://images.unsplash.com/photo-1633332755192-727a05c4013d?q=80&w=1480&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        firstName: "I am a",
        lastName: "Social Media Manager",
        positions: ["Evan James"],
        socialNetworks: [
            {
                name: "LinkedIn",
                url: "https://www.linkedin.com/in/leopoldo-miranda/",
            },
            {
                name: "Github",
                url: "https://github.com/leoMirandaa",
            },
            {
                name: "X",
                url: "https://x.com/leo_mirand4",
            },
        ],
    },
    // {
    //   imageUrl:
    //     "https://images.unsplash.com/photo-1573497019236-17f8177b81e8?q=80&w=1740&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3Dhttps://images.unsplash.com/photo-1573497019236-17f8177b81e8?q=80&w=1740&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
    //   firstName: "What's Your",
    //   lastName: "Skill?",
    //   positions: ["Become a Seller"],
    //   socialNetworks: [
    //     {
    //       name: "X",
    //       url: "https://x.com/leo_mirand4",
    //     },
    //   ],
    // },
];

const socialIcon = (socialName: string) => {
    switch (socialName) {
        case "LinkedIn":
            return LinkedInIcon;

        case "Github":
            return GithubIcon;

        case "X":
            return XIcon;
    }
};
</script>

<template>
    <section id="team" class="container lg:w-[75%] py-24 sm:py-32">
        <div class="text-center mb-8">
            <h2 class="text-lg text-primary text-center mb-2 tracking-wider">
                Community
            </h2>

            <h2 class="text-3xl md:text-4xl text-center font-bold">
                Join our growing freelance community
            </h2>
        </div>

        <div
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8"
        >
            <Card
                v-for="{
                    imageUrl,
                    firstName,
                    lastName,
                    positions,
                    socialNetworks,
                } in teamList"
                :key="imageUrl"
                class="bg-muted/60 dark:bg-card flex flex-col h-full overflow-hidden group/hoverimg"
            >
                <CardHeader class="p-0 gap-0">
                    <div class="h-full overflow-hidden">
                        <img
                            :src="imageUrl"
                            alt=""
                            class="w-full aspect-square object-cover saturate-0 transition-all duration-200 ease-linear size-full group-hover/hoverimg:saturate-100 group-hover/hoverimg:scale-[1.01]"
                        />
                    </div>
                    <CardTitle class="py-6 pb-4 px-6"
                        >{{ firstName }}
                        <span class="text-primary">{{ lastName }}</span>
                    </CardTitle>
                </CardHeader>

                <CardContent
                    v-for="(position, index) in positions"
                    :key="index"
                    :class="{
                        'pb-0 text-muted-foreground ': true,
                        'pb-4': index === positions.length - 1,
                    }"
                >
                    {{ position
                    }}<span v-if="index < positions.length - 1">,</span>
                </CardContent>
                <!-- 
        <CardFooter class="space-x-4 mt-auto">
          <a
            v-for="{ name, url } in socialNetworks"
            key="name"
            :href="url"
            target="_blank"
            class="hover:opacity-80 transition-all"
          >
            <component :is="socialIcon(name)" />
          </a>
        </CardFooter> -->
            </Card>
            <Card
                class="bg-muted/60 dark:bg-card flex flex-col h-full overflow-hidden group/hoverimg items-center justify-center"
            >
                <CardHeader class="p-0 gap-0">
                    <div class="h-[40%] overflow-hidden">
                        <div
                            class="w-full aspect-square object-cover saturate-0 transition-all duration-200 ease-linear size-full group-hover/hoverimg:saturate-100 group-hover/hoverimg:scale-[1.01]"
                        >
                            <!-- <h1>Hello</h1> -->
                        </div>
                    </div>
                    
                    <CardTitle class="py-5">
                        What's Your
                        <span class="text-primary"> Skill? </span>
                    </CardTitle>
                    <Button as-child size="sm" variant="default">
                    <div
                        class="rounded-md text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white cursor-pointer"
                    >
                        Become a Seller
                    </div>
                </Button>
                </CardHeader>

               

                <!-- <CardFooter class="space-x-4 mt-auto">
          <a
           
            class="hover:opacity-80 transition-all"
          >
            
          </a>
        </CardFooter> -->
            </Card>
        </div>
    </section>
</template>
