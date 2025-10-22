<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-50">
    <div class="w-full max-w-md p-8 bg-white rounded-3xl shadow-lg border border-gray-200">
      <h2 class="text-3xl font-extrabold text-center text-green-600 mb-6">
        Cadastrar Endereço
      </h2>
      <p class="text-center text-gray-500 mb-6">
        Preencha os dados para cadastrar o endereço da instituição
      </p>

      <!-- Mensagem de erro -->
      <transition name="fade">
        <div
          v-if="errorMessage"
          class="mb-4 flex items-center justify-between bg-red-100 border border-red-300 text-red-700 rounded-xl px-4 py-3 shadow-sm animate-fade-in"
        >
          <p class="text-sm font-medium">{{ errorMessage }}</p>
          <button
            @click="errorMessage = ''"
            class="text-red-500 hover:text-red-700 font-bold text-lg"
          >
            ×
          </button>
        </div>
      </transition>

      <!-- Mensagem de sucesso -->
      <transition name="fade">
        <div
          v-if="successMessage"
          class="mb-4 flex items-center justify-between bg-green-100 border border-green-300 text-green-700 rounded-xl px-4 py-3 shadow-sm animate-fade-in"
        >
          <p class="text-sm font-medium">{{ successMessage }}</p>
          <button
            @click="successMessage = ''"
            class="text-green-500 hover:text-green-700 font-bold text-lg"
          >
            ×
          </button>
        </div>
      </transition>

      <form @submit.prevent="saveAddress">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">CEP</label>
          <input
            type="text"
            v-model="cep"
            @blur="buscarCep"
            placeholder="Digite o CEP"
            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition"
          />
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Rua</label>
          <input
            type="text"
            v-model="rua"
            placeholder="Rua Exemplo"
            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition"
          />
        </div>

        <div class="mb-4 grid grid-cols-2 gap-3">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Número</label>
            <input
              type="text"
              v-model="numero"
              placeholder="Ex: 123"
              class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Complemento</label>
            <input
              type="text"
              v-model="complemento"
              placeholder="Apto, bloco, sala..."
              class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition"
            />
          </div>
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Bairro</label>
          <input
            type="text"
            v-model="bairro"
            placeholder="Bairro"
            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition"
          />
        </div>

        <div class="mb-4 grid grid-cols-2 gap-3">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Cidade</label>
            <input
              type="text"
              v-model="cidade"
              placeholder="Cidade"
              class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
            <input
              type="text"
              v-model="estado"
              placeholder="UF"
              maxlength="2"
              class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition uppercase"
            />
          </div>
        </div>

        <button
          type="submit"
          class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-xl transition"
        >
          Salvar Endereço
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { addressService } from "@/services/addressService";
import api from "@/services/api";

const router = useRouter();

// Campos do formulário
const cep = ref("");
const rua = ref("");
const numero = ref("");
const complemento = ref("");
const bairro = ref("");
const cidade = ref("");
const estado = ref("");

// Estados de controle
const errorMessage = ref("");
const successMessage = ref("");
const loading = ref(false);

// Função para buscar dados do CEP via backend
const buscarCep = async () => {
  if (!cep.value) {
    errorMessage.value = "Informe um CEP válido.";
    return;
  }

  try {
    loading.value = true;
    errorMessage.value = "";

    const { data } = await api.get(`/cep/${cep.value}`);

    // Mapeia automaticamente os campos retornados (seja via ViaCEP ou backend)
    rua.value = data.logradouro || data.rua || "";
    bairro.value = data.bairro || "";
    cidade.value = data.localidade || data.cidade || "";
    estado.value = data.uf || data.estado || "";
  } catch (error) {
    errorMessage.value = "Não foi possível buscar o CEP informado.";
  } finally {
    loading.value = false;
  }
};

// Função para salvar o endereço
const saveAddress = async () => {
  loading.value = true;
  errorMessage.value = "";
  successMessage.value = "";

  console.log('Iniciando cadastro de endereço...');
  console.log('Token no localStorage:', localStorage.getItem('token') ? 'Presente' : 'Ausente');
  
  const user = JSON.parse(localStorage.getItem('user') || '{}');
  console.log('Usuário logado:', user);
  console.log('Tipo de usuário:', user.tipo_usuario);

  try {
    const addressData = {
      cep: cep.value,
      logradouro: rua.value,
      numero: numero.value,
      complemento: complemento.value,
      bairro: bairro.value,
      cidade: cidade.value,
      estado: estado.value,
    };

    const result = await addressService.addAddress(addressData);
    
    successMessage.value = "Endereço cadastrado com sucesso!";

    //router.push("/dashboard");
  } catch (error) {
    
    if (error.response?.status === 401) {
      errorMessage.value = "Você precisa estar logado para cadastrar um endereço.";
    } else if (error.response?.status === 403) {
      errorMessage.value = "Apenas instituições podem cadastrar endereços.";
    } else if (error.response?.status === 422) {
      const validationErrors = error.response.data.errors;
      if (validationErrors) {
        const firstError = Object.values(validationErrors)[0][0];
        errorMessage.value = firstError;
      } else {
        errorMessage.value = "Dados inválidos. Verifique os campos obrigatórios.";
      }
    } else {
      errorMessage.value = error?.message || error.response?.data?.message || "Erro ao cadastrar o endereço.";
    }
    return false;
  } finally {
    loading.value = false;
    return false;
  }
};
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

.animate-fade-in {
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-4px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>


<style scoped>
  .fade-enter-active,
  .fade-leave-active {
      transition: opacity 0.3s ease;
  }

  .fade-enter-from,
  .fade-leave-to {
      opacity: 0;
  }

  .animate-fade-in {
      animation: fadeIn 0.3s ease-out;
  }

  @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-5px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
  }
</style>
