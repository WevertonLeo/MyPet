<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-50">
    <div class="w-full max-w-md p-8 bg-white rounded-3xl shadow-lg border border-gray-200">
      <h2 class="text-3xl font-extrabold text-center text-green-600 mb-6">
        MyPet
      </h2>
      <p class="text-center text-gray-500 mb-6">Crie sua conta</p>

      <form @submit.prevent="register">
        <!-- Nome -->
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
          <input
            type="text"
            v-model="name"
            placeholder="Seu nome completo"
            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition"
          />
        </div>

        <!-- Email -->
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input
            type="email"
            v-model="email"
            placeholder="seuemail@email.com"
            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition"
          />
        </div>

        <!-- Senha -->
        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
          <input
            type="password"
            v-model="password"
            placeholder="********"
            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition"
          />
        </div>

        <!-- Checkbox Instituição -->
        <div class="mb-6 flex items-center">
          <input
            type="checkbox"
            id="isInstitution"
            v-model="isInstitution"
            class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
          />
          <label for="isInstitution" class="ml-2 text-sm text-gray-700">
            Sou uma instituição
          </label>
        </div>

        <!-- Botão -->
        <button
          type="submit"
          class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-xl transition"
        >
          Cadastrar
        </button>
      </form>

      <p class="mt-4 text-center text-gray-500">
        Já tem conta?
        <router-link to="/login" class="text-green-600 hover:underline">
          Entrar
        </router-link>
      </p>
    </div>
  </div>
</template>

<script setup>
    import { ref } from "vue"
    import { useRouter } from "vue-router"
    import { registerUser } from "@/services/userService"

    const router = useRouter()

    const name = ref("")
    const email = ref("")
    const password = ref("")
    const isInstitution = ref(false)
    const loading = ref(false)
    const errorMessage = ref("")

    const register = async () => {
        loading.value = true
        errorMessage.value = ""

        const userData = {
            name: name.value,
            email: email.value,
            password: password.value,
            tipo_usuario: isInstitution.value ? 1 : 0,
        }

        try {
            const response = await registerUser(userData)
            console.log("Usuário cadastrado:", response)

            if (userData.tipo_usuario === 1) {
                //router.push("/address/new")
                console.log("Adicionar Endereço");
            } else {
                //router.push("/pets/new")
                console.log("Adicionar Pet");
            }
        } catch (error) {
            errorMessage.value = error.message || "Erro ao registrar usuário."
        } finally {
            loading.value = false
        }
    }
</script>
