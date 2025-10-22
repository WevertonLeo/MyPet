<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
      <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
        Adicionar Novo Pet
      </h2>

      <form @submit.prevent="submitForm" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Nome do Pet *
          </label>
          <input
            v-model="form.nome"
            type="text"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Digite o nome do pet"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Raça *
          </label>
          <input
            v-model="form.raca"
            type="text"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Digite a raça"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Cor *
          </label>
          <input
            v-model="form.cor"
            type="text"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Digite a cor"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Status *
          </label>
          <select
            v-model="form.status_id"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <option value="">Selecione o status</option>
            <option value="1">Disponível</option>
            <option value="2">Adotado</option>
            <option value="3">Perdido</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Foto do Pet
          </label>
          <input
            @change="handleFileUpload"
            type="file"
            accept="image/*"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>

        <div class="flex gap-3 pt-4">
          <button
            type="button"
            @click="$router.push('/')"
            class="flex-1 py-2 px-4 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200"
          >
            Cancelar
          </button>
          <button
            type="submit"
            :disabled="loading"
            class="flex-1 py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50 transition duration-200"
          >
            {{ loading ? 'Salvando...' : 'Salvar Pet' }}
          </button>
        </div>
      </form>

      <div v-if="message" class="mt-4 p-3 rounded-md" :class="messageClass">
        {{ message }}
      </div>
    </div>
  </div>
</template>

<script>
import api from '@/services/api'

export default {
  name: 'AddPet',
  data() {
    return {
      form: {
        nome: '',
        raca: '',
        cor: '',
        status_id: '',
        foto: null
      },
      loading: false,
      message: '',
      messageClass: ''
    }
  },
  methods: {
    handleFileUpload(event) {
      this.form.foto = event.target.files[0]
    },
    async submitForm() {
      this.loading = true
      this.message = ''

      try {
        const formData = new FormData()
        Object.keys(this.form).forEach(key => {
          if (this.form[key] !== null && this.form[key] !== '') {
            formData.append(key, this.form[key])
          }
        })

        await api.post('/pets', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })

        this.message = 'Pet cadastrado com sucesso!'
        this.messageClass = 'bg-green-100 text-green-700 border border-green-300'
        
        setTimeout(() => {
          this.$router.push('/')
        }, 2000)

      } catch (error) {
        this.message = error.response?.data?.message || 'Erro ao cadastrar pet'
        this.messageClass = 'bg-red-100 text-red-700 border border-red-300'
      } finally {
        this.loading = false
      }
    }
  }
}
</script>