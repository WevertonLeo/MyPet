<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-gray-100 flex items-center justify-center p-4 lg:p-6">
    <!-- Mobile Menu -->
    <MobileMenu />
    
    <div class="flex flex-col lg:flex-row w-full max-w-7xl h-auto lg:h-[90vh] bg-transparent gap-4 lg:gap-8">

      <div class="hidden lg:block">
        <Sidebar />
      </div>

      <div class="flex-1 bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 flex flex-col overflow-hidden">
        <header class="bg-white/50 backdrop-blur-sm border-b border-gray-200/50 px-4 sm:px-6 lg:px-8 py-4 lg:py-6">
          <div class="flex items-center gap-3">
            <div class="w-2 h-6 lg:h-8 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-full"></div>
            <div>
              <h1 class="text-xl lg:text-2xl font-bold text-gray-900">
                Novo Pet
              </h1>
              <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Cadastre um novo pet para adoção
              </p>
            </div>
          </div>
        </header>

        <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
          <div class="max-w-2xl mx-auto">

            <transition name="fade">
              <div
                v-if="message && messageClass.includes('red')"
                class="mb-6 flex items-center gap-3 bg-red-50/80 backdrop-blur-sm border border-red-200/50 text-red-700 rounded-xl px-4 py-3 shadow-sm"
              >
                <div class="w-2 h-2 bg-red-500 rounded-full flex-shrink-0"></div>
                <p class="text-sm font-medium flex-1">{{ message }}</p>
                <button
                  @click="message = ''"
                  class="text-red-400 hover:text-red-600 transition-colors"
                >
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                  </svg>
                </button>
              </div>
            </transition>

            <transition name="fade">
              <div
                v-if="message && messageClass.includes('green')"
                class="mb-6 flex items-center gap-3 bg-green-50/80 backdrop-blur-sm border border-green-200/50 text-green-700 rounded-xl px-4 py-3 shadow-sm"
              >
                <div class="w-2 h-2 bg-green-500 rounded-full flex-shrink-0"></div>
                <p class="text-sm font-medium flex-1">{{ message }}</p>
                <button
                  @click="message = ''"
                  class="text-green-400 hover:text-green-600 transition-colors"
                >
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                  </svg>
                </button>
              </div>
            </transition>

            <form @submit.prevent="submitForm" class="space-y-6">
              <div class="space-y-1">
                <label class="text-sm font-medium text-gray-900">Nome do Pet</label>
                <input
                  v-model="form.nome"
                  type="text"
                  required
                  placeholder="Digite o nome do pet"
                  class="w-full px-4 py-3 bg-white/50 border border-gray-200/50 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:outline-none transition-all duration-200 backdrop-blur-sm"
                />
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                  <label class="text-sm font-medium text-gray-900">Raça</label>
                  <input
                    v-model="form.raca"
                    type="text"
                    required
                    placeholder="Ex: Labrador, SRD..."
                    class="w-full px-4 py-3 bg-white/50 border border-gray-200/50 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:outline-none transition-all duration-200 backdrop-blur-sm"
                  />
                </div>
                <div class="space-y-1">
                  <label class="text-sm font-medium text-gray-900">Cor</label>
                  <input
                    v-model="form.cor"
                    type="text"
                    required
                    placeholder="Ex: Marrom, Preto..."
                    class="w-full px-4 py-3 bg-white/50 border border-gray-200/50 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:outline-none transition-all duration-200 backdrop-blur-sm"
                  />
                </div>
              </div>

              <div class="space-y-1">
                <label class="text-sm font-medium text-gray-900">Status</label>
                <select
                  v-model="form.status_id"
                  required
                  class="w-full px-4 py-3 bg-white/50 border border-gray-200/50 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:outline-none transition-all duration-200 backdrop-blur-sm"
                >
                  <option value="">Selecione o status</option>
                  <option value="1">Disponível para adoção</option>
                  <option value="2">Adotado</option>
                  <option value="3">Perdido</option>
                </select>
              </div>

              <div class="space-y-1">
                <label class="text-sm font-medium text-gray-900">Foto do Pet</label>
                <div class="relative">
                  <input
                    @change="handleFileUpload"
                    type="file"
                    accept="image/*"
                    class="w-full px-4 py-3 bg-white/50 border border-gray-200/50 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:outline-none transition-all duration-200 backdrop-blur-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                  />
                </div>
              </div>

              <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <button
                  type="button"
                  @click="$router.push('/dashboard')"
                  class="flex-1 px-6 py-3 bg-gray-100/80 backdrop-blur-sm border border-gray-200/50 text-gray-700 font-medium rounded-xl hover:bg-gray-200/80 transition-all duration-200"
                >
                  Cancelar
                </button>
                <button
                  type="submit"
                  :disabled="loading"
                  class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold py-4 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2"
                >
                  <span v-if="loading" class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                  <span v-else>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                  </span>
                  {{ loading ? 'Salvando...' : 'Salvar Pet' }}
                </button>
              </div>
            </form>
          </div>
        </main>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import Sidebar from '@/components/Sidebar.vue'
import MobileMenu from '@/components/MobileMenu.vue'

const router = useRouter()

const form = ref({
  nome: '',
  raca: '',
  cor: '',
  status_id: '',
  foto: null
})

const loading = ref(false)
const message = ref('')
const messageClass = ref('')

const handleFileUpload = (event) => {
  form.value.foto = event.target.files[0]
}

const submitForm = async () => {
  loading.value = true
  message.value = ''

  try {
    const formData = new FormData()
    Object.keys(form.value).forEach(key => {
      if (form.value[key] !== null && form.value[key] !== '') {
        formData.append(key, form.value[key])
      }
    })

    await api.post('/pets', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })

    message.value = 'Pet cadastrado com sucesso!'
    messageClass.value = 'bg-green-100 text-green-700 border border-green-300'
    
    setTimeout(() => {
      router.push('/dashboard')
    }, 2000)

  } catch (error) {
    message.value = error.response?.data?.message || 'Erro ao cadastrar pet'
    messageClass.value = 'bg-red-100 text-red-700 border border-red-300'
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(-8px) scale(0.95);
}

/* Glassmorphism effect */
.backdrop-blur-sm {
  backdrop-filter: blur(8px);
}

/* Custom scrollbar */
main::-webkit-scrollbar {
  width: 6px;
}
main::-webkit-scrollbar-track {
  background: transparent;
}
main::-webkit-scrollbar-thumb {
  background: linear-gradient(to bottom, #3b82f6, #4f46e5);
  border-radius: 3px;
}
main::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(to bottom, #2563eb, #4338ca);
}

/* Input focus animation */
input:focus, select:focus {
  transform: translateY(-1px);
  box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1), 0 10px 10px -5px rgba(59, 130, 246, 0.04);
}

/* Button hover animation */
button[type="submit"]:hover:not(:disabled) {
  box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.2), 0 10px 10px -5px rgba(59, 130, 246, 0.1);
}
</style>