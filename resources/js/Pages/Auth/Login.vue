<script setup lang="ts">
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import DefaultAuthCard from "@/Components/Auths/DefaultAuthCard.vue";
import InputGroup from "@/Components/Auths/InputGroup.vue";

import AuthLayout from "@/Layouts/AuthLayout.vue";


defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => {
            form.reset("password");
        },
    });
};
</script>

<template>
    <AuthLayout>
        <Head title="Sign in" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <DefaultAuthCard  title="Log in ToWork">
            <p class="text-[24px] mb-2.5 font-medium text-base text-black">
                Don’t have an account? 
                <a href="/register"><input class="text-[#FB7B24] cursor-pointer" type="submit" value="Sign Up!"/></a>
            </p>
            <form @submit.prevent="submit">
                <div>
                    <InputLabel
                        for="email"
                        value="Email"
                        class="mb-2.5 block font-medium text-black "
                    />
                    <div class="relative">
                        <TextInput
                            id="email"
                            type="email"
                            
                            class="w-full py-4 pl-6 pr-10 text-black bg-transparent border rounded-[50px] outline-none border-stroke focus:border-primary focus-visible:shadow-none "
                            v-model="form.email"
                            required
                            placeholder="Enter you Email"
                            autofocus
                            autocomplete="username"
                        />
                        
                    </div>
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                <InputLabel for="password" value="Password" class="mb-2.5 block font-medium text-black " />
                <div class="relative">
                <TextInput
                    id="password"
                    type="password"
                    
                    class="w-full py-4 pl-6 pr-10 text-black bg-transparent border rounded-[50px] outline-none border-stroke focus:border-primary focus-visible:shadow-none "
                    v-model="form.password"
                    required
                    placeholder="Enter your Password"
                    autocomplete="current-password"
                />
            </div>
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

                           
                <div class="mt-6 mb-5">
                    <input
                        type="submit"
                        value="Sign In"
                        class="w-full p-4 font-bold text-black transition border rounded-[50px] cursor-pointer border-primary bg-[#F5F535] hover:bg-opacity-90" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    />
                </div>                
            </form>
        </DefaultAuthCard>
    </AuthLayout>
</template>
