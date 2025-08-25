<script setup lang="ts">
import { onClickOutside } from '@vueuse/core'
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

interface NotificationData {
  id: number
  title: string
  message: string
  type: string
  data: any
  action_url: string | null  // This will be mapped from 'route' column
  is_read: boolean
  created_at: string
  created_at_formatted: string
}

const target = ref(null)
const dropdownOpen = ref(false)
const notifying = ref(false)
const notifications = ref<NotificationData[]>([])
const unreadCount = ref(0)
const loading = ref(true)

onClickOutside(target, () => {
  dropdownOpen.value = false
})

// Computed property to show notification indicator
const hasNotifications = computed(() => unreadCount.value > 0)

// Fetch notifications from API
const fetchNotifications = async () => {
  try {
    loading.value = true
    const response = await axios.get('/web/notifications')
    notifications.value = response.data
  } catch (error) {
    console.error('Error fetching notifications:', error)
  } finally {
    loading.value = false
  }
}

// Fetch unread count
const fetchUnreadCount = async () => {
  try {
    const response = await axios.get('/web/notifications/unread-count')
    unreadCount.value = response.data.count
    notifying.value = response.data.count > 0
  } catch (error) {
    console.error('Error fetching unread count:', error)
  }
}

// Mark notification as read
const markAsRead = async (notificationId: number) => {
  try {
    await axios.post(`/web/notifications/${notificationId}/mark-read`)
    // Update the notification in the list
    const notification = notifications.value.find(n => n.id === notificationId)
    if (notification) {
      notification.is_read = true
    }
    // Update unread count
    fetchUnreadCount()
  } catch (error) {
    console.error('Error marking notification as read:', error)
  }
}

// Mark all notifications as read
const markAllAsRead = async () => {
  try {
    await axios.post('/web/notifications/mark-all-read')
    // Update all notifications in the list
    notifications.value.forEach(notification => {
      notification.is_read = true
    })
    unreadCount.value = 0
    notifying.value = false
  } catch (error) {
    console.error('Error marking all notifications as read:', error)
  }
}

// Handle notification click
const handleNotificationClick = (notification: NotificationData) => {
  if (!notification.is_read) {
    markAsRead(notification.id)
  }
  
  // Navigate to action URL if provided
  if (notification.action_url) {
    window.location.href = notification.action_url
  }
}

// Handle dropdown toggle
const toggleDropdown = () => {
  dropdownOpen.value = !dropdownOpen.value
  if (dropdownOpen.value) {
    fetchNotifications()
  }
}

// Initialize component
onMounted(() => {
  fetchUnreadCount()
  
  // Poll for new notifications every 30 seconds
  setInterval(() => {
    fetchUnreadCount()
    if (dropdownOpen.value) {
      fetchNotifications()
    }
  }, 30000)
})
</script>

<template>
  <li class="relative" ref="target">
    <router-link
      class="relative flex h-8.5 w-8.5 items-center justify-center rounded-full border-[0.5px] border-stroke bg-gray hover:text-primary"
      to="#"
      @click.prevent="toggleDropdown"
    >
      <span
        :class="!hasNotifications && 'hidden'"
        class="absolute -top-0.5 right-0 z-1 h-2 w-2 rounded-full bg-meta-1"
      >
        <span
          class="absolute inline-flex w-full h-full rounded-full opacity-75 -z-1 animate-ping bg-meta-1"
        ></span>
      </span>

      <svg
        class="duration-300 ease-in-out fill-current"
        width="18"
        height="18"
        viewBox="0 0 18 18"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M16.1999 14.9343L15.6374 14.0624C15.5249 13.8937 15.4687 13.7249 15.4687 13.528V7.67803C15.4687 6.01865 14.7655 4.47178 13.4718 3.31865C12.4312 2.39053 11.0812 1.7999 9.64678 1.6874V1.1249C9.64678 0.787402 9.36553 0.478027 8.9999 0.478027C8.6624 0.478027 8.35303 0.759277 8.35303 1.1249V1.65928C8.29678 1.65928 8.24053 1.65928 8.18428 1.6874C4.92178 2.05303 2.4749 4.66865 2.4749 7.79053V13.528C2.44678 13.8093 2.39053 13.9499 2.33428 14.0343L1.7999 14.9343C1.63115 15.2155 1.63115 15.553 1.7999 15.8343C1.96865 16.0874 2.2499 16.2562 2.55928 16.2562H8.38115V16.8749C8.38115 17.2124 8.6624 17.5218 9.02803 17.5218C9.36553 17.5218 9.6749 17.2405 9.6749 16.8749V16.2562H15.4687C15.778 16.2562 16.0593 16.0874 16.228 15.8343C16.3968 15.553 16.3968 15.2155 16.1999 14.9343ZM3.23428 14.9905L3.43115 14.653C3.5999 14.3718 3.68428 14.0343 3.74053 13.6405V7.79053C3.74053 5.31553 5.70928 3.23428 8.3249 2.95303C9.92803 2.78428 11.503 3.2624 12.6562 4.2749C13.6687 5.1749 14.2312 6.38428 14.2312 7.67803V13.528C14.2312 13.9499 14.3437 14.3437 14.5968 14.7374L14.7655 14.9905H3.23428Z"
          fill=""
        />
      </svg>
    </router-link>

    <!-- Dropdown Start -->
    <div
      v-show="dropdownOpen"
      class="absolute -right-27 mt-2.5 flex h-90 w-75 flex-col rounded-sm border border-stroke bg-white shadow-default sm:right-0 sm:w-80"
    >
      <div class="px-4.5 py-3 flex justify-between items-center">
        <h5 class="text-sm font-medium text-bodydark2">
          Notifications
          <span v-if="unreadCount > 0" class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
            {{ unreadCount }}
          </span>
        </h5>
        <button
          v-if="unreadCount > 0"
          @click="markAllAsRead"
          class="text-xs text-primary hover:underline"
        >
          Mark all read
        </button>
      </div>

      <ul class="flex flex-col h-auto overflow-y-auto">
        <!-- Loading state -->
        <li v-if="loading" class="px-4.5 py-3 text-center text-sm text-bodydark2">
          Loading notifications...
        </li>
        
        <!-- No notifications -->
        <li v-else-if="notifications.length === 0" class="px-4.5 py-3 text-center text-sm text-bodydark2">
          No notifications yet
        </li>
        
        <!-- Notification items -->
        <template v-else v-for="(notification, index) in notifications" :key="notification.id">
          <li>
            <div
              @click="handleNotificationClick(notification)"
              class="flex flex-col gap-2.5 border-t border-stroke px-4.5 py-3 hover:bg-gray-2 cursor-pointer"
              :class="{ 'bg-blue-50': !notification.is_read }"
            >
              <div class="flex items-start justify-between">
                <p class="text-sm">
                  <span class="text-black font-medium">{{ notification.title }}</span>
                </p>
                <span
                  v-if="!notification.is_read"
                  class="inline-block w-2 h-2 bg-blue-500 rounded-full ml-2 mt-1"
                ></span>
              </div>
              
              <p class="text-sm text-bodydark2">{{ notification.message }}</p>
              
              <div class="flex justify-between items-center">
                <p class="text-xs text-bodydark2">{{ notification.created_at }}</p>
                <span
                  v-if="notification.type === 'order'"
                  class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full"
                >
                  Order
                </span>
              </div>
            </div>
          </li>
        </template>
      </ul>
    </div>
    <!-- Dropdown End -->
  </li>
</template>
