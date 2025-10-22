<template>
  <div class="min-h-screen bg-gray-50">
    <nav class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <h1 class="text-xl font-semibold text-gray-900">MyPet</h1>
          </div>
          <div class="flex items-center space-x-4">
            <span class="text-gray-700">Olá, {{ user?.name }}</span>
            <button
              @click="logout"
              class="text-gray-500 hover:text-gray-700"
            >
              Sair
            </button>
          </div>
        </div>
      </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          
          <!-- Card Adicionar Pet -->
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-6">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                    <span class="text-white text-sm font-medium">🐕</span>
                  </div>
                </div>
                <div class="ml-4">
                  <h3 class="text-lg font-medium text-gray-900">Adicionar Pet</h3>
                  <p class="text-sm text-gray-500">Cadastre um novo pet</p>
                </div>
              </div>
              <div class="mt-4">
                <router-link
                  to="/addPet"
                  class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700"
                >
                  Adicionar
                </router-link>
              </div>
            </div>
          </div>

          <!-- Card Adicionar Endereço -->
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-6">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                    <span class="text-white text-sm font-medium">📍</span>
                  </div>
                </div>
                <div class="ml-4">
                  <h3 class="text-lg font-medium text-gray-900">Adicionar Endereço</h3>
                  <p class="text-sm text-gray-500">Cadastre um novo endereço</p>
                </div>
              </div>
              <div class="mt-4">
                <router-link
                  to="/addAddress"
                  class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700"
                >
                  Adicionar
                </router-link>
              </div>
            </div>
          </div>

          <!-- Card Meus Pets -->
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-6">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                    <span class="text-white text-sm font-medium">🏠</span>
                  </div>
                </div>
                <div class="ml-4">
                  <h3 class="text-lg font-medium text-gray-900">Meus Pets</h3>
                  <p class="text-sm text-gray-500">Visualizar pets cadastrados</p>
                </div>
              </div>
              <div class="mt-4">
                <button
                  @click="loadPets"
                  class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700"
                >
                  Ver Pets
                </button>
              </div>
            </div>
          </div>

        </div>

        <!-- Lista de Pets -->
        <div v-if="pets.length > 0" class="mt-8">
          <h2 class="text-lg font-medium text-gray-900 mb-4">Meus Pets</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div
              v-for="pet in pets"
              :key="pet.id"
              class="bg-white rounded-lg shadow p-4"
            >
              <h3 class="font-medium text-gray-900">{{ pet.nome }}</h3>
              <p class="text-sm text-gray-500">{{ pet.raca }} - {{ pet.cor }}</p>
              <p class="text-xs text-gray-400 mt-1">
                Status: {{ getStatusText(pet.status_id) }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '@/services/api'
import authService from '@/services/authService'

export default {
  name: 'Dashboard',
  data() {
    return {
      user: null,
      pets: []
    }
  },
  mounted() {
    this.user = authService.getUser()
  },
  methods: {
    async loadPets() {
      try {
        const response = await api.get('/pets')
        this.pets = response.data
      } catch (error) {
        console.error('Erro ao carregar pets:', error)
      }
    },
    getStatusText(statusId) {
      const status = {
        1: 'Disponível',
        2: 'Adotado',
        3: 'Perdido'
      }
      return status[statusId] || 'Desconhecido'
    },
    logout() {
      authService.logout()
      this.$router.push('/')
    }
  }
}
</script>