<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-gray-100 flex items-center justify-center p-4 lg:p-6">
    <!-- Mobile Menu -->
    <MobileMenu />
    
    <div class="flex flex-col lg:flex-row w-full max-w-7xl h-auto lg:h-[90vh] bg-transparent gap-4 lg:gap-6">

      <div class="hidden lg:block transition-all duration-300">
        <Sidebar />
      </div>

      <div class="flex-1 bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 flex flex-col overflow-hidden">
        <header class="bg-white/50 backdrop-blur-sm border-b border-gray-200/50 px-4 sm:px-6 lg:px-8 py-4 lg:py-6">
          <div class="flex items-center gap-3">
            <div class="w-2 h-6 lg:h-8 bg-gradient-to-b from-green-500 to-emerald-600 rounded-full"></div>
            <div>
              <h1 class="text-xl lg:text-2xl font-bold text-gray-900">
                Feed Principal
              </h1>
              <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Bem-vindo(a) ao MyPet 🐶
              </p>
            </div>
          </div>
        </header>

        <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-semibold text-gray-800">Publicações Recentes</h2>
            <button
              class="flex items-center bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-4 py-2 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
              </svg>
              Atualizar
            </button>
          </div>

          <div class="space-y-4">
            <div
              v-for="post in posts"
              :key="post.id"
              class="bg-white/60 backdrop-blur-sm rounded-2xl shadow-sm p-6 border border-gray-200/50 hover:shadow-lg hover:bg-white/80 transition-all duration-200"
            >
              <div class="flex items-center mb-3">
                <img
                  :src="post.avatar"
                  alt="avatar"
                  class="w-12 h-12 rounded-full mr-3"
                />
                <div>
                  <h3 class="font-semibold text-gray-800">{{ post.nome }}</h3>
                  <p class="text-gray-400 text-sm">{{ post.data }}</p>
                </div>
              </div>

              <p class="text-gray-700 mb-3">{{ post.conteudo }}</p>

              <div v-if="post.imagem">
                <img
                  :src="post.imagem"
                  alt="imagem do post"
                  class="rounded-2xl shadow-sm max-h-80 object-cover w-full"
                />
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import Sidebar from "@/components/Sidebar.vue";
import MobileMenu from "@/components/MobileMenu.vue";

const posts = ref([
  {
    id: 1,
    nome: "Instituição Pata Feliz",
    avatar: "https://i.pravatar.cc/100?img=5",
    data: "21/10/2025 14:30",
    conteudo: "Adotamos mais um amiguinho hoje! 🐶💚",
    imagem: "https://images.unsplash.com/photo-1507149833265-60c372daea22?w=800",
  },
  {
    id: 2,
    nome: "Carlos Silva",
    avatar: "https://i.pravatar.cc/100?img=2",
    data: "20/10/2025 10:15",
    conteudo: "Meu cachorro Max completou 2 anos hoje! 🎉🐾",
    imagem: "https://images.unsplash.com/photo-1601758125946-6ec2ef642b87?w=800",
  },
  {
    id: 3,
    nome: "Lar dos Gatinhos",
    avatar: "https://i.pravatar.cc/100?img=7",
    data: "19/10/2025 16:42",
    conteudo: "Temos novos gatinhos para adoção, venham conhecer!",
    imagem: null,
  },
]);
</script>

<style scoped>
    main::-webkit-scrollbar {
        width: 8px;
    }

    main::-webkit-scrollbar-thumb {
        background-color: #d1d5db;
        border-radius: 10px;
    }

    main::-webkit-scrollbar-thumb:hover {
        background-color: #9ca3af;
    }
</style>
