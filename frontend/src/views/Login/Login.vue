<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-50">
    <div class="w-full max-w-md p-8 bg-white rounded-3xl shadow-lg border border-gray-200">
      <h2 class="text-3xl font-extrabold text-center text-green-600 mb-6">
        MyPet
      </h2>
      <p class="text-center text-gray-500 mb-6">Faça login na sua conta</p>

      <form @submit.prevent="login">
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
        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
          <input
            type="password"
            v-model="password"
            required
            placeholder="********"
            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition"
          />
        </div>
        
        <div v-if="error" class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded-xl text-sm">
          {{ error }}
        </div>
        
        <button
          type="submit"
          :disabled="loading"
          class="w-full bg-green-600 hover:bg-green-700 disabled:opacity-50 text-white font-semibold py-2 rounded-xl transition"
        >
          {{ loading ? 'Entrando...' : 'Entrar' }}
        </button>
      </form>

      <p class="mt-4 text-center text-gray-500">
        Não tem conta?
        <router-link to="/register" class="text-green-600 hover:underline">
          Cadastre-se
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
    const email = ref("");
    const password = ref("");
    const loading = ref(false);
    const error = ref("");

    const login = async () => {
        loading.value = true;
        error.value = "";

        try {
            await authService.login(email.value, password.value);
            router.push("/dashboard");
        } catch (err) {
            error.value = err.response?.data?.message || "Erro ao fazer login. Verifique suas credenciais.";
        } finally {
            loading.value = false;
        }
    };
</script>
