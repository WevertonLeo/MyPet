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
            required
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
            required
            placeholder="seuemail@email.com"
            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition"
          />
        </div>

        <!-- Senha -->
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
          <input
            type="password"
            v-model="password"
            required
            minlength="8"
            placeholder="********"
            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition"
          />
        </div>

        <!-- Checkbox Instituição -->
        <div class="mb-6 flex items-center">
          <input
            type="checkbox"
            id="tipoUsuario"
            v-model="tipoUsuario"
            class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
            value="true"
          />
          <label for="tipoUsuario" class="ml-2 text-sm text-gray-700">
            Sou uma instituição
          </label>
        </div>

        <div v-if="error" class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded-xl text-sm">
          {{ error }}
        </div>

        <!-- Botão -->
        <button
          type="submit"
          :disabled="loading"
          class="w-full bg-green-600 hover:bg-green-700 disabled:opacity-50 text-white font-semibold py-2 rounded-xl transition"
        >
          {{ loading ? 'Cadastrando...' : 'Cadastrar' }}
        </button>
      </form>

      <p class="mt-4 text-center text-gray-500">
        Já tem conta?
        <router-link to="/" class="text-green-600 hover:underline">
          Entrar
        </router-link>
      </p>
    </div>
  </div>
</template>

<script setup>
    import { ref } from "vue";
    import { useRouter } from "vue-router";
    import authService from "@/services/authService";

    const router = useRouter();
    const name = ref("");
    const email = ref("");
    const password = ref("");
    const tipoUsuario = ref(false);
    const loading = ref(false);
    const error = ref("");

    const register = async () => {
        loading.value = true;
        error.value = "";

        const userData = {
          name: name.value,
          email: email.value,
          password: password.value,
          tipo_usuario: tipoUsuario.value,
        };

        try {
            await authService.register(userData);

            if(userData.tipo_usuario){
                router.push('/addAdress');
                return;
            }

            router.push("/addPet");
            return;
        } catch (err) {
            error.value = err.response?.data?.message || "Erro ao cadastrar usuário.";
        } finally {
            loading.value = false;
        }
    };
</script>
