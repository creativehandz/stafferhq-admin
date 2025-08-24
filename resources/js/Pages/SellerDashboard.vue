<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";

// Get page props for user data
const page = usePage();

// Debug: Log all props to console
console.log('=== SELLER DASHBOARD DEBUG ===');
console.log('Full page props:', page.props);
console.log('Auth object:', page.props.auth);
console.log('User object:', page.props.auth?.user);
console.log('User name:', page.props.auth?.user?.name);
console.log('===============================');

const user = computed(() => {
    // More defensive checks
    const props = page.props || {};
    const auth = props.auth || {};
    const userData = auth.user || { name: 'User', email: 'user@example.com' };
    console.log('Computed user data:', userData);
    console.log('Props structure:', { props, auth, user: auth.user });
    return userData;
});

// Static dashboard data
const sellerStats = ref([
    {
        title: "Active Gigs",
        value: "12",
        icon: "🎯",
        color: "bg-blue-500",
        change: "+3 this month"
    },
    {
        title: "Orders Completed",
        value: "47",
        icon: "✅",
        color: "bg-green-500",
        change: "+8 this week"
    },
    {
        title: "Total Earnings",
        value: "$2,485",
        icon: "💰",
        color: "bg-yellow-500",
        change: "+$340 this month"
    },
    {
        title: "Client Rating",
        value: "4.9",
        icon: "⭐",
        color: "bg-purple-500",
        change: "Based on 47 reviews"
    }
]);

// Debug: Log static data
console.log('Seller stats data:', sellerStats.value);
console.log('Stats array length:', sellerStats.value.length);

const recentOrders = ref([
    {
        id: "#ORD-001",
        service: "Logo Design for Tech Startup",
        client: "John Smith",
        status: "In Progress",
        amount: "$150",
        deadline: "2 days",
        statusColor: "bg-yellow-100 text-yellow-800"
    },
    {
        id: "#ORD-002",
        service: "Website Landing Page",
        client: "Sarah Johnson",
        status: "Completed",
        amount: "$300",
        deadline: "Delivered",
        statusColor: "bg-green-100 text-green-800"
    },
    {
        id: "#ORD-003",
        service: "Brand Identity Package",
        client: "Mike Wilson",
        status: "Pending Review",
        amount: "$450",
        deadline: "1 day",
        statusColor: "bg-blue-100 text-blue-800"
    },
    {
        id: "#ORD-004",
        service: "Social Media Graphics",
        client: "Emma Davis",
        status: "New Order",
        amount: "$75",
        deadline: "5 days",
        statusColor: "bg-orange-100 text-orange-800"
    }
]);

const quickActions = ref([
    {
        title: "Create New Gig",
        description: "Add a new service to your portfolio",
        icon: "➕",
        color: "bg-blue-600",
        action: "create-gig"
    },
    {
        title: "Manage Orders",
        description: "View and update your active orders",
        icon: "📋",
        color: "bg-green-600",
        action: "manage-orders"
    },
    {
        title: "View Analytics",
        description: "Check your performance metrics",
        icon: "📊",
        color: "bg-purple-600",
        action: "analytics"
    },
    {
        title: "Message Center",
        description: "Chat with your clients",
        icon: "💬",
        color: "bg-orange-600",
        action: "messages"
    }
]);

const achievements = ref([
    {
        title: "Top Rated Seller",
        description: "Maintained 5-star rating for 3 months",
        icon: "🏆",
        earned: true
    },
    {
        title: "Fast Delivery",
        description: "Delivered 20 orders on time",
        icon: "⚡",
        earned: true
    },
    {
        title: "Client Favorite",
        description: "50+ positive reviews",
        icon: "❤️",
        earned: false
    }
]);
</script>

<template>
    <Head title="Seller Dashboard" />

    <AuthenticatedLayout>
        <!-- Debug: Simple test message -->
        <div style="background: red; color: white; padding: 10px; margin: 10px;">
            🔧 DEBUG: SellerDashboard component is loading! Check console for prop data.
            Props available: {{ !!page.props }}, Auth: {{ !!page.props?.auth }}, User: {{ !!user }}
        </div>
        
        <!-- Only render when we have basic page structure -->
        <div v-if="page.props" class="min-h-screen bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                
                <!-- Welcome Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Welcome back, {{ user?.name || 'User' }}! 🚀
                    </h1>
                    <p class="mt-2 text-gray-600">
                        Here's your seller performance overview and recent activity.
                    </p>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div 
                        v-for="stat in sellerStats" 
                        :key="stat.title"
                        class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">{{ stat.title }}</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ stat.value }}</p>
                            </div>
                            <div :class="`w-12 h-12 ${stat.color} rounded-lg flex items-center justify-center text-white text-xl`">
                                {{ stat.icon }}
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-gray-500">{{ stat.change }}</span>
                        </div>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Recent Orders -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-semibold text-gray-900">Recent Orders</h2>
                                <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    View All Orders
                                </button>
                            </div>
                            <div class="space-y-4">
                                <div 
                                    v-for="order in recentOrders"
                                    :key="order.id"
                                    class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors"
                                >
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center space-x-3">
                                            <span class="text-sm font-medium text-gray-500">{{ order.id }}</span>
                                            <span :class="`px-2 py-1 rounded-full text-xs font-medium ${order.statusColor}`">
                                                {{ order.status }}
                                            </span>
                                        </div>
                                        <span class="text-lg font-semibold text-gray-900">{{ order.amount }}</span>
                                    </div>
                                    <h3 class="font-medium text-gray-900 mb-1">{{ order.service }}</h3>
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span>Client: {{ order.client }}</span>
                                        <span>Deadline: {{ order.deadline }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6">Quick Actions</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div 
                                    v-for="action in quickActions"
                                    :key="action.action"
                                    class="p-4 rounded-lg border border-gray-200 hover:border-gray-300 cursor-pointer transition-all hover:shadow-sm"
                                >
                                    <div class="flex items-center mb-3">
                                        <div :class="`w-10 h-10 ${action.color} rounded-lg flex items-center justify-center text-white text-lg mr-3`">
                                            {{ action.icon }}
                                        </div>
                                        <h3 class="font-semibold text-gray-900">{{ action.title }}</h3>
                                    </div>
                                    <p class="text-sm text-gray-600">{{ action.description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        
                        <!-- Achievements -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Achievements</h2>
                            <div class="space-y-4">
                                <div 
                                    v-for="achievement in achievements"
                                    :key="achievement.title"
                                    class="flex items-start space-x-3"
                                >
                                    <div :class="`w-10 h-10 rounded-full flex items-center justify-center text-lg ${achievement.earned ? 'bg-yellow-100' : 'bg-gray-100'}`">
                                        {{ achievement.icon }}
                                    </div>
                                    <div class="flex-1">
                                        <h3 :class="`font-medium ${achievement.earned ? 'text-gray-900' : 'text-gray-500'}`">
                                            {{ achievement.title }}
                                        </h3>
                                        <p :class="`text-sm ${achievement.earned ? 'text-gray-600' : 'text-gray-400'}`">
                                            {{ achievement.description }}
                                        </p>
                                    </div>
                                    <div v-if="achievement.earned" class="text-green-500">
                                        ✓
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Performance Overview -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl border border-blue-200 p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">📈 Performance Overview</h2>
                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-700">Response Rate</span>
                                        <span class="font-medium">98%</span>
                                    </div>
                                    <div class="w-full bg-white rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: 98%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-700">On-Time Delivery</span>
                                        <span class="font-medium">95%</span>
                                    </div>
                                    <div class="w-full bg-white rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: 95%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-700">Order Completion</span>
                                        <span class="font-medium">100%</span>
                                    </div>
                                    <div class="w-full bg-white rounded-full h-2">
                                        <div class="bg-purple-500 h-2 rounded-full" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Monthly Goals -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">🎯 Monthly Goals</h2>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Complete 50 Orders</span>
                                    <span class="text-green-600 font-medium">47/50</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 94%"></div>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Earn $3,000</span>
                                    <span class="text-blue-600 font-medium">$2,485/$3,000</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: 83%"></div>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">5-Star Reviews</span>
                                    <span class="text-purple-600 font-medium">42/45</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-purple-500 h-2 rounded-full" style="width: 93%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Fallback when props not loaded -->
        <div v-else class="min-h-screen bg-gray-50 flex items-center justify-center">
            <div class="text-center">
                <div class="animate-spin rounded-full h-32 w-32 border-b-2 border-blue-500 mx-auto"></div>
                <p class="mt-4 text-gray-600">Loading seller dashboard...</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Custom styles for the seller dashboard */
.bg-gradient-to-br {
    background: linear-gradient(to bottom right, var(--tw-gradient-stops));
}
</style>
