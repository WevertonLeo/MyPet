<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-50">
    <div class="w-full max-w-md p-8 bg-white rounded-3xl shadow-lg border border-gray-200">
      <h2 class="text-3xl font-extrabold text-center text-green-600 mb-6">
        MyPet
      </h2>
      <p class="text-center text-gray-500 mb-6">Crie sua conta</p>

      <form @submit.prevent="register">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
          <input
            type="text"
            v-model="name"
            placeholder="Seu nome"
            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition"
          />
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input
            type="email"
            v-model="email"
            placeholder="seuemail@email.com"
            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition"
          />
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
          <input
            type="password"
            v-model="password"
            placeholder="********"
            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition"
          />
        </div>
        <div class="mb-6 flex items-center">
          <input
            type="checkbox"
            id="institution"
            v-model="institution"
            class="mr-2"
          />
          <label for="institution" class="text-gray-700">Sou uma instituição</label>
        </div>

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
import { ref } from "vue";

const name = ref("");
const email = ref("");
const password = ref("");
const institution = ref(false);

const register = () => {
  console.log("Cadastro:", name.value, email.value, password.value, institution.value);
};
</script>
