<script setup lang="ts">
import { onClickOutside } from '@vueuse/core'
import { ref } from 'vue'

const target = ref(null)
const dropdownOpen = ref(false)
const notifying = ref(true)

onClickOutside(target, () => {
  dropdownOpen.value = false
})

const notificationItems = ref([
  {
    route: '#',
    title: 'Edit your information in a swipe',
    details:
      'Sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim.',
    time: '12 May, 2025'
  },
  {
    route: '#',
    title: 'It is a long established fact',
    details: 'that a reader will be distracted by the readable.',
    time: '24 Feb, 2025'
  },
  {
    route: '#',
    title: 'There are many variations',
    details: 'of passages of Lorem Ipsum available, but the majority have suffered',
    time: '04 Jan, 2025'
  },
  {
    route: '#',
    title: 'There are many variations',
    details: 'of passages of Lorem Ipsum available, but the majority have suffered',
    time: '01 Dec, 2024'
  }
])
</script>

<template>
  <li class="relative" ref="target">
    <router-link
      class="relative flex h-8.5 w-8.5 items-center justify-center rounded-full border-[0.5px] border-stroke bg-gray hover:text-primary"
      to="#"
      @click.prevent="(dropdownOpen = !dropdownOpen), (notifying = false)"
    >
      <span
        :class="!notifying && 'hidden'"
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
        viewBox="0 0 24 22"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
      <path d="M20.16,5A6.29,6.29,0,0,0,12,4.36a6.27,6.27,0,0,0-8.16,9.48l6.21,6.22a2.78,2.78,0,0,0,3.9,0l6.21-6.22A6.27,6.27,0,0,0,20.16,5Zm-1.41,7.46-6.21,6.21a.76.76,0,0,1-1.08,0L5.25,12.43a4.29,4.29,0,0,1,0-6,4.27,4.27,0,0,1,6,0,1,1,0,0,0,1.42,0,4.27,4.27,0,0,1,6,0A4.29,4.29,0,0,1,18.75,12.43Z"/>
      </svg>
    </router-link>

    <!-- Dropdown Start -->
    <div
      v-show="dropdownOpen"
      class="absolute -right-27 mt-2.5 flex h-90 w-75 flex-col rounded-sm border border-stroke bg-white shadow-default sm:right-0 sm:w-80"
    >
      <div class="px-4.5 py-3">
        <h5 class="text-sm font-medium text-bodydark2">Notification</h5>
      </div>

      <ul class="flex flex-col h-auto overflow-y-auto">
        <template v-for="(item, index) in notificationItems" :key="index">
          <li>
            <router-link
              class="flex flex-col gap-2.5 border-t border-stroke px-4.5 py-3 hover:bg-gray-2 "
              :to="item.route"
            >
              <p class="text-sm">
                <span class="text-black ">{{ item.title }}</span>
                {{ item.details }}
              </p>

              <p class="text-xs">{{ item.time }}</p>
            </router-link>
          </li>
        </template>
      </ul>
    </div>
    <!-- Dropdown End -->
  </li>
</template>
