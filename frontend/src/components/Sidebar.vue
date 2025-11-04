<template>
  <aside 
    :class="[
      'bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 flex flex-col justify-between transition-all duration-300 h-[90vh] relative',
      isExpanded ? 'w-64 p-6' : 'w-16 p-4'
    ]"
  >
    <!-- Toggle Button -->
    <button
      @click="toggleSidebar"
      :class="[
        'absolute -right-3 top-6 w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center hover:bg-green-700 hover:scale-110 transition-all duration-300 shadow-lg hover:shadow-xl z-10',
        isMobile ? 'hidden' : 'block'
      ]"
      :title="isExpanded ? 'Comprimir sidebar' : 'Expandir sidebar'"
    >
      <svg 
        :class="{ 'rotate-180': isExpanded }"
        class="w-3 h-3 transition-transform duration-300" 
        fill="none" 
        stroke="currentColor" 
        viewBox="0 0 24 24"
      >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
      </svg>
    </button>

    <div>
      <!-- Logo -->
      <div class="flex items-center justify-center mb-8 relative">
        <div v-if="isExpanded" class="text-2xl font-extrabold text-green-600 text-center">
          🐾 MyPet
        </div>
        <div v-else class="text-2xl relative group">
          🐾
          <div class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
            MyPet
          </div>
        </div>
        <!-- Indicador de estado comprimido -->
        <div v-if="!isExpanded && !isMobile" class="absolute -bottom-2 w-1 h-1 bg-green-500 rounded-full animate-pulse"></div>
      </div>

      <!-- Navigation -->
      <nav class="space-y-2">
        <router-link
          to="/dashboard"
          :class="[
            'flex items-center w-full py-3 rounded-xl hover:bg-green-100 text-gray-700 font-medium transition group relative',
            isExpanded ? 'px-3' : 'justify-center px-2',
            { 'bg-green-100 text-green-700': $route.path === '/dashboard' }
          ]"
        >
          <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
          </svg>
          <span v-if="isExpanded" class="ml-3">Feed</span>
          <div v-else class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
            Feed
          </div>
        </router-link>

        <router-link
          to="/addPet"
          :class="[
            'flex items-center w-full py-3 rounded-xl hover:bg-green-100 text-gray-700 font-medium transition group relative',
            isExpanded ? 'px-3' : 'justify-center px-2',
            { 'bg-green-100 text-green-700': $route.path === '/addPet' }
          ]"
        >
          <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <span v-if="isExpanded" class="ml-3">Pets</span>
          <div v-else class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
            Pets
          </div>
        </router-link>

        <router-link
          v-if="isInstitution"
          to="/addAddress"
          :class="[
            'flex items-center w-full py-3 rounded-xl hover:bg-green-100 text-gray-700 font-medium transition group relative',
            isExpanded ? 'px-3' : 'justify-center px-2',
            { 'bg-green-100 text-green-700': $route.path === '/addAddress' }
          ]"
        >
          <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
          <span v-if="isExpanded" class="ml-3">Endereço</span>
          <div v-else class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
            Endereço
          </div>
        </router-link>
      </nav>
    </div>

    <!-- Logout Button -->
    <button
      @click="logout"
      :class="[
        'flex items-center w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-3 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 group relative',
        isExpanded ? 'justify-center' : 'justify-center'
      ]"
    >
      <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
      </svg>
      <span v-if="isExpanded" class="ml-2">Sair</span>
      <div v-else class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
        Sair
      </div>
    </button>
  </aside>
</template>

<script setup>
import { computed, onMounted, onUnmounted } from "vue";
import { useRouter } from "vue-router";
import authService from "@/services/authService";
import { useSidebar } from "@/composables/useSidebar";

const router = useRouter();
const { isExpanded, isMobile, toggleSidebar, handleResize } = useSidebar();

const user = computed(() => authService.getUser());
const isInstitution = computed(() => user.value?.tipo_usuario === 1);

const logout = () => {
  authService.logout();
  router.push("/");
};

onMounted(() => {
  handleResize();
  window.addEventListener('resize', handleResize);
});

onUnmounted(() => {
  window.removeEventListener('resize', handleResize);
});
</script>