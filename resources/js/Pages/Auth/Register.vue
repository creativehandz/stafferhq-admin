<script setup lang="ts">
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import DefaultAuthCard from "@/Components/Auths/DefaultAuthCard.vue";
import { ref } from "vue";

const isOptionSelected = ref<boolean>(false);

const changeTextColor = () => {
    isOptionSelected.value = true;
};

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    role: "",
});
 
const submit = () => {
    form.post(route("register"), {
        onFinish: () => {
            form.reset("password", "password_confirmation");
        },
    });
};
</script>

<template>
    <AuthLayout>
        <Head title="Register" />

        <DefaultAuthCard  title="Sign Up ToWork">
            <!-- Subtitle -->
            <p class="text-[24px] mb-2.5 font-medium text-base  text-black">
                Already have an account?
                <span class="text-[#FB7B24] cursor-pointer">
                    Log in!
                </span>
            </p>
            <form @submit.prevent="submit">
                <div>
                    <InputLabel
                        for="name"
                        value="Name"
                        class="mb-2.5 block font-medium text-black dark:text-white"
                    />
                    <div class="relative">
                        <TextInput
                            id="name"
                            type="text"
                            placeholder="Enter your full name"
                            class="w-full py-4 pl-6 pr-10 text-black bg-transparent border rounded-[50px] outline-none border-stroke focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary dark:text-white"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                        />                        
                    </div>

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">
                    <InputLabel
                        for="email"
                        value="Email"
                        class="mb-2.5 block font-medium text-black dark:text-white"
                    />
                    <div class="relative">
                        <TextInput
                            id="email"
                            type="email"
                            placeholder="Enter your email"
                            class="w-full py-4 pl-6 pr-10 text-black bg-transparent border rounded-[50px] outline-none border-stroke focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary dark:text-white"
                            v-model="form.email"
                            required
                            autocomplete="username"
                        />
                    </div>
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel
                        for="password"
                        value="Password"
                        class="mb-2.5 block font-medium text-black dark:text-white"
                    />
                    <div class="relative">
                        <TextInput
                            id="password"
                            type="password"
                            placeholder="Enter your password"
                            class="w-full py-4 pl-6 pr-10 text-black bg-transparent border rounded-[50px] outline-none border-stroke focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary dark:text-white"
                            v-model="form.password"
                            required
                            autocomplete="new-password"
                        />
                    </div>

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
                <div class="mt-4">
                    <InputLabel
                        for="password_confirmation"
                        value="Confirm Password"
                        class="mb-2.5 block font-medium text-black dark:text-white"
                    />

                    <div class="relative">
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            placeholder="Re-enter your password"
                            class="w-full py-4 pl-6 pr-10 text-black bg-transparent border rounded-[50px] outline-none border-stroke focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary dark:text-white"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                        />
                       
                    </div>
                    <InputError
                        class="mt-2"
                        :message="form.errors.password_confirmation"
                    />
                </div>

                <div>
                    <label class="block mt-4 mb-3 text-sm font-medium text-black dark:text-white">
                        You're a:
                    </label>
                    <div class="flex items-center space-x-6">
                        <label class="flex items-center text-base font-bold text-black dark:text-white">
                            <input
                                type="radio"
                                value="1"
                                v-model="form.role"
                                class="text-orange-500 transition duration-150 ease-in-out form-radio"
                                required
                            />
                            <span class="ml-2 ">Buyer</span>
                        </label>
                        <label class="flex items-center text-base font-bold text-black dark:text-white">
                            <input
                                type="radio"
                                value="2"
                                v-model="form.role"
                                class="text-orange-500 transition duration-150 ease-in-out form-radio"
                                required
                            />
                            <span class="ml-2 ">Seller</span>
                        </label>
                    </div>
                    <InputError class="mt-2" :message="form.errors.role" />
                </div>

                <div class="mt-6 mb-5">
                    <input
                        type="submit"
                        value="Sign Up"
                        class="w-full p-4 font-bold text-black transition border rounded-[50px] cursor-pointer border-primary bg-[#F5F535] hover:bg-opacity-90"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    />
                </div>
            </form>
        </DefaultAuthCard>
    </AuthLayout>
</template>
