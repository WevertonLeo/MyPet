<template>
  <div class="lg:hidden">
    <!-- Mobile Menu Button -->
    <button
      @click="isOpen = !isOpen"
      class="fixed top-4 left-4 z-50 w-12 h-12 bg-green-600 text-white rounded-xl flex items-center justify-center hover:bg-green-700 transition-colors shadow-lg"
    >
      <svg 
        :class="{ 'rotate-90': isOpen }"
        class="w-6 h-6 transition-transform duration-300" 
        fill="none" 
        stroke="currentColor" 
        viewBox="0 0 24 24"
      >
        <path 
          v-if="!isOpen"
          stroke-linecap="round" 
          stroke-linejoin="round" 
          stroke-width="2" 
          d="M4 6h16M4 12h16M4 18h16"
        />
        <path 
          v-else
          stroke-linecap="round" 
          stroke-linejoin="round" 
          stroke-width="2" 
          d="M6 18L18 6M6 6l12 12"
        />
      </svg>
    </button>

    <!-- Mobile Menu Overlay -->
    <transition name="fade">
      <div
        v-if="isOpen"
        @click="isOpen = false"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40"
      />
    </transition>

    <!-- Mobile Menu -->
    <transition name="slide">
      <div
        v-if="isOpen"
        class="fixed top-0 left-0 h-full w-80 bg-white/95 backdrop-blur-sm shadow-2xl z-50 p-6"
      >
        <div class="mt-16 h-full">
          <div class="h-full">
            <Sidebar />
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Sidebar from './Sidebar.vue'

const isOpen = ref(false)
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
  transform: translateX(-100%);
}
</style>