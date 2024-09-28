<script setup lang="ts">
import { ref, reactive } from "vue";
import { Button } from "./ui/button";
import { Card, CardHeader, CardContent, CardFooter } from "./ui/card";
import { Label } from "./ui/label";
import { Input } from "./ui/input";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "./ui/select";
import { Textarea } from "./ui/textarea";
import {
    Alert,
    AlertDescription,
    AlertTitle,
} from "@/Components/LandingPage/ui/alert";
import { AlertCircle, Building2, Phone, Mail, Clock } from "lucide-vue-next";

const props = defineProps<{
    category: string;
}>();

interface ContactFormeProps {
    firstName: string;
    lastName: string;
    email: string;
    subject: string;
    message: string;
}
const contactForm = reactive<ContactFormeProps>({
    firstName: "",
    lastName: "",
    email: "",
    subject: "Web Development",
    message: "",
});
const invalidInputForm = ref<boolean>(false);
const handleSubmit = () => {
    const { firstName, lastName, email, subject, message } = contactForm;
    console.log(contactForm);
    const mailToLink = `mailto:lalitkumawat1129@gmail.com?subject=${subject}&body=Hello I am ${firstName} ${lastName}, my Email is ${email}. %0D%0A${message}`;
    window.location.href = mailToLink;
};
</script>
<template>
    <section id="flexcard" class="container py-24 sm:py-32">
        <section
            class="lg:flex justify-between space-y-10 lg:space-y-0 bg-muted/60 dark:bg-card p-10 rounded-xl"
        >
            <div>
                <div class="mb-4">
                    <h2 class="text-lg text-primary mb-2 tracking-wider">
                        All-in-one service request
                    </h2>
                    <h2 class="text-3xl md:text-4xl font-semibold">
                        Seeking a
                        <span class="font-light italic"
                            >full suite of services?</span
                        >
                    </h2>
                </div>
                <p class="mb-8 text-title-xsm lg:w-5/6">
                    Find a comprehensive {{ category }} agency to handle it all.
                </p>
                <div class="flex flex-col gap-4">
                    <div class="">
                        <Button as-child size="sm" variant="default">
                            <div
                                class="rounded-md text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white cursor-pointer"
                            >
                                Browse Agencies
                            </div>
                        </Button>
                    </div>
                </div>
            </div>
            <!-- Video -->
            <div class="lg:w-[50%] lg:h-full">
                <img
                    src="https://fiverr-res.cloudinary.com/image/upload/f_auto,q_auto/v1/attachments/generic_asset/asset/da1594ab63ac10603bc01158360e0038-1723034424480/Graphic_Design_2x.png"
                    alt=""
                />
            </div>
        </section>
    </section>
</template>
