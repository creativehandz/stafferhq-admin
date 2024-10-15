<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import BreadcrumbDefault from "@/Components/Breadcrumbs/BreadcrumbDefault.vue";
import { ref, onMounted, onUnmounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { formatDate } from "@/stores/formateDistanceToNow";
import axios from "axios";

const pageTitle = ref("Messages");
const messages = ref<Message[]>([]);
const newMessage = ref<string>(""); // lowercase 'string' type
const receiverId = ref<number | null>(null);
const selectedUser = ref<User | null>(null);
const currentUserId = usePage().props.auth.user.id;

type User = {
    id: number;
    name: string;
    email: string;
    role: number;
};

// Define the type for the props
type Props = {
    users: User[];
};

// Receive the users data passed from the backend with correct type
const props = defineProps<Props>();

type Message = {
    id: number;
    user_id: number;
    receiver_id: number;
    message: string;
    created_at: string;
    updated_at: string; // Ensure this matches your actual event structure
};

type MessageEvent = {
    message: Message;
};

const fetchMessages = async () => {
    if (receiverId.value === null) return;

    try {
        const response = await axios.get(`/messages/${receiverId.value}`);
        messages.value = response.data;
    } catch (error) {
        console.error("Failed to fetch messages:", error);
    }
};

const sendMessage = async () => {
    if (!newMessage.value.trim() || receiverId.value === null) return;
    try {
        await axios.post("/messages", {
            message: newMessage.value,
            receiver_id: receiverId.value,
        }).then((response) => {
            messages.value.push(response.data.message);
        });
        newMessage.value = "";
    } catch (error) {
        console.error("Failed to send message:", error);
    }
};

const Typing = () => {
    console.log("I am called")
    const receiver_id = currentUserId;
    window.Echo.private(`chat.${receiver_id}`)
    .whisper('test', {
        name: selectedUser.value?.name,
    });
}

// Handle user selection from the list
const selectReceiver = (user: User) => {
    if (receiverId.value !== user.id) {
        selectedUser.value = user;
        receiverId.value = user.id;
        fetchMessages(); // Fetch messages for the selected user
    }
};

// Manage Echo listeners
const setupEcho = () => {
    if (currentUserId) {
        window.Echo.private(`chat.${currentUserId}`)
            .listen('MessageSent', (e: MessageEvent) => {
                console.log("Message received:", e.message);
                messages.value.push(e.message);  // Push the message to the array
            })
            .listenForWhisper('test', (e: { name: string; }) => {
                console.log("client-test event received, Name: " + e.name);
            });

        console.log("Subscribed to chat channel: chat-" + currentUserId);
    }
};

const removeEchoListener = () => {
    if (currentUserId) {
        window.Echo.private(`chat.${currentUserId}`).stopListening('MessageSent');
        window.Echo.private(`chat.${currentUserId}`).stopListening('client-test');
        console.log("Unsubscribed from chat channel: chat-" + currentUserId);
    }
};

// Lifecycle hooks
onMounted(() => {
    if (props.users.length > 0 && currentUserId) {
        selectReceiver(props.users[0]);  // Select the first user if available
        setupEcho();  // Setup Echo after currentUserId is ready
    }
});

onUnmounted(() => {
    removeEchoListener();  // Clean up listeners when component is unmounted
});

</script>

<template>
    <Head title="Messages" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Messages
            </h2>
        </template>

        <div>
            <BreadcrumbDefault :pageTitle="pageTitle" />

            <div class="h-[calc(100vh-186px)] overflow-hidden sm:h-[calc(100vh-174px)]">
                <div class="h-full rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark xl:flex">
                    <!-- User List Sidebar -->
                    <div class="hidden h-full flex-col xl:flex xl:w-1/4">
                        <div class="sticky border-b border-stroke px-6 py-7.5 dark:border-strokedark">
                            <h3 class="text-lg font-medium text-black dark:text-white 2xl:text-xl">
                                Active Conversations
                                <span class="rounded-md border-[.5px] border-stroke bg-gray-2 py-0.5 px-2 text-base font-medium text-black dark:border-strokedark dark:bg-boxdark-2 dark:text-white 2xl:ml-4">
                                    {{ props.users.length }}
                                </span>
                            </h3>
                        </div>
                        <div class="flex max-h-full flex-col overflow-auto p-5">
                            <form class="sticky mb-7">
                                <input
                                    type="text"
                                    class="w-full rounded border border-stroke bg-gray-2 py-2.5 pl-5 pr-10 text-sm outline-none focus:border-primary dark:border-strokedark dark:bg-boxdark-2"
                                    placeholder="Search..." />
                                <button class="absolute top-1/2 right-4 -translate-y-1/2">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.25 3C5.3505 3 3 5.3505 3 8.25C3 11.1495 5.3505 13.5 8.25 13.5C11.1495 13.5 13.5 11.1495 13.5 8.25C13.5 5.3505 11.1495 3 8.25 3ZM1.5 8.25C1.5 4.52208 4.52208 1.5 8.25 1.5C11.9779 1.5 15 4.52208 15 8.25C15 11.9779 11.9779 15 8.25 15C4.52208 15 1.5 11.9779 1.5 8.25Z" fill="#637381"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.957 11.958C12.2499 11.6651 12.7247 11.6651 13.0176 11.958L16.2801 15.2205C16.573 15.5133 16.573 15.9882 16.2801 16.2811C15.9872 16.574 15.5124 16.574 15.2195 16.2811L11.957 13.0186C11.6641 12.7257 11.6641 12.2508 11.957 11.958Z" fill="#637381"></path>
                                    </svg>
                                </button>
                            </form>
                            <div class="no-scrollbar max-h-full space-y-2.5 overflow-auto">
                                <div class="user-list">
                                    <ul>
                                        <li v-for="user in props.users" :key="user.id" @click="selectReceiver(user)">
                                            <div class="flex cursor-pointer items-center rounded py-2 px-4 hover:bg-gray-2 dark:hover:bg-strokedark">
                                                <div class="relative mr-3.5 h-11 w-full max-w-11 rounded-full">
                                                    <img src='../../img/user/user-03.png' alt="profile" class="h-full w-full object-cover object-center" />
                                                    <span class="absolute bottom-0 right-0 block h-3 w-3 rounded-full border-2 border-gray-2 bg-success"></span>
                                                </div>
                                                <div class="w-full">
                                                    <h5 class="text-sm font-medium text-black dark:text-white">
                                                        {{ user.name }}
                                                    </h5>
                                                    <p class="text-sm font-medium">
                                                        Last Message will display here
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Chat Area -->
                    <div class="flex h-full flex-col border-l border-stroke dark:border-strokedark xl:w-3/4">
                        <div class="sticky flex items-center justify-between border-b border-stroke px-6 py-4.5 dark:border-strokedark">
                            <div class="flex items-center">
                                <div class="mr-4.5 h-13 w-full max-w-13 overflow-hidden rounded-full">
                                    <img src='../../img/user/user-03.png' alt="avatar" class="h-full w-full object-cover object-center" />
                                </div>
                                <div>
                                    <h5 class="font-medium text-black dark:text-white">
                                        {{ selectedUser?.name }}
                                    </h5>
                                    <p class="text-sm font-medium">
                                        Reply to message
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="max-h-full space-y-3.5 overflow-auto px-6 py-7.5">
                            <div v-for="message in messages" :key="message.id">
                                <!-- Message from another user -->
                                <div v-if="message.user_id !== currentUserId" class="max-w-125">
                                    <div class="mb-2.5 rounded-2xl rounded-tl-none bg-gray py-3 px-5 dark:bg-boxdark-2">
                                        <p class="font-medium">
                                            {{ message.message }}
                                        </p>
                                    </div>
                                    <p class="text-xs font-medium">
                                        {{ formatDate(message.created_at) }}
                                    </p>
                                </div>

                                <!-- Message sent by the current user -->
                                <div v-else class="ml-auto max-w-125">
                                    <div class="mb-2.5 rounded-2xl rounded-br-none bg-primary py-3 px-5">
                                        <p class="font-medium text-white">
                                            {{ message.message }}
                                        </p>
                                    </div>
                                    <p class="text-right text-xs font-medium">
                                        {{ formatDate(message.created_at) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Message Input -->
                        <div class="sticky bottom-0 border-t border-stroke bg-white py-5 px-6 dark:border-strokedark dark:bg-boxdark">
                            <form @submit.prevent="sendMessage" class="flex items-center justify-between space-x-4.5">
                                <div class="relative w-full">
                                    <input
                                        v-model="newMessage"
                                        type="text"
                                        placeholder="Type something here"
                                        id="newMessage"
                                        @change="Typing"
                                        class="h-13 w-full rounded-md border border-stroke bg-gray pl-5 pr-19 font-medium text-black placeholder-body outline-none focus:border-primary dark:border-strokedark dark:bg-boxdark-2 dark:text-white"
                                    />
                                    <div class="absolute right-5 top-1/2 inline-flex -translate-y-1/2 items-center justify-end space-x-4">
                                        <button class="hover:text-primary">
                                            <svg width="18" height="18" viewBox="0 0 18 18" class="fill-current">
                                                <path
                                                    fill-rule="evenodd"
                                                    clip-rule="evenodd"
                                                    d="M11.835 1.79102C11.2378 1.79102 10.6651 2.02824 10.2428 2.45051L3.3503 9.34302C2.64657 10.0467 2.25122 11.0012 2.25122 11.9964C2.25122 12.9917 2.64657 13.9461 3.3503 14.6499C4.05403 15.3536 5.0085 15.7489 6.00372 15.7489C6.99895 15.7489 7.95341 15.3536 8.65714 14.6499L15.5496 7.75736C15.8425 7.46446 16.3174 7.46446 16.6103 7.75736C16.9032 8.05025 16.9032 8.52512 16.6103 8.81802L9.7178 15.7105C8.73277 16.6956 7.39677 17.2489 6.00372 17.2489C4.61067 17.2489 3.27468 16.6956 2.28964 15.7105C1.30461 14.7255 0.751221 13.3895 0.751221 11.9964C0.751221 10.6034 1.30461 9.26739 2.28964 8.28236L9.18214 1.38985C9.88572 0.686279 10.84 0.291016 11.835 0.291016C12.83 0.291016 13.7842 0.686279 14.4878 1.38985C15.1914 2.09343 15.5866 3.04768 15.5866 4.04268C15.5866 5.03769 15.1914 5.99194 14.4878 6.69552L7.5878 13.588C7.16569 14.0101 6.59318 14.2473 5.99622 14.2473C5.39926 14.2473 4.82676 14.0101 4.40464 13.588C3.98253 13.1659 3.74539 12.5934 3.74539 11.9964C3.74539 11.3995 3.98253 10.827 4.40464 10.4049L10.7725 4.04454C11.0655 3.75182 11.5404 3.7521 11.8331 4.04517C12.1258 4.33823 12.1256 4.81311 11.8325 5.10583L5.4653 11.4655C5.32469 11.6063 5.24539 11.7974 5.24539 11.9964C5.24539 12.1956 5.32449 12.3865 5.4653 12.5274C5.60611 12.6682 5.79709 12.7473 5.99622 12.7473C6.19535 12.7473 6.38633 12.6682 6.52714 12.5274L13.4271 5.63486C13.8492 5.21261 14.0866 4.63973 14.0866 4.04268C14.0866 3.4455 13.8494 2.87278 13.4271 2.45051C13.0049 2.02824 12.4321 1.79102 11.835 1.79102Z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <button
                                    type="submit"
                                    class="flex h-13 w-full max-w-13 items-center justify-center rounded-md bg-primary text-white hover:bg-opacity-90">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22 2L11 13" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
