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
            <div class="w-2 h-6 lg:h-8 bg-gradient-to-b from-green-500 to-emerald-600 rounded-full"></div>
            <div>
              <h1 class="text-xl lg:text-2xl font-bold text-gray-900">
                {{ isEditing ? 'Editar Endereço' : 'Novo Endereço' }}
              </h1>
              <p class="text-xs sm:text-sm text-gray-500 mt-1">
                {{ isEditing ? 'Atualize as informações do seu endereço' : 'Configure o endereço da sua instituição' }}
              </p>
            </div>
          </div>
        </header>

        <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
          <div class="max-w-2xl mx-auto">

            <transition name="fade">
              <div
                v-if="errorMessage"
                class="mb-6 flex items-center gap-3 bg-red-50/80 backdrop-blur-sm border border-red-200/50 text-red-700 rounded-xl px-4 py-3 shadow-sm"
              >
                <div class="w-2 h-2 bg-red-500 rounded-full flex-shrink-0"></div>
                <p class="text-sm font-medium flex-1">{{ errorMessage }}</p>
                <button
                  @click="errorMessage = ''"
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
                v-if="successMessage"
                class="mb-6 flex items-center gap-3 bg-green-50/80 backdrop-blur-sm border border-green-200/50 text-green-700 rounded-xl px-4 py-3 shadow-sm"
              >
                <div class="w-2 h-2 bg-green-500 rounded-full flex-shrink-0"></div>
                <p class="text-sm font-medium flex-1">{{ successMessage }}</p>
                <button
                  @click="successMessage = ''"
                  class="text-green-400 hover:text-green-600 transition-colors"
                >
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                  </svg>
                </button>
              </div>
            </transition>

            <form @submit.prevent="saveAddress" class="space-y-6">
              <div class="space-y-1">
                <label class="text-sm font-medium text-gray-900">CEP</label>
                <div class="relative">
                  <input
                    type="text"
                    v-model="cep"
                    @blur="buscarCep"
                    placeholder="00000-000"
                    class="w-full px-4 py-3 bg-white/50 border border-gray-200/50 rounded-xl focus:ring-2 focus:ring-green-500/20 focus:border-green-500 focus:outline-none transition-all duration-200 backdrop-blur-sm"
                  />
                  <div v-if="loading" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                    <div class="w-4 h-4 border-2 border-green-500 border-t-transparent rounded-full animate-spin"></div>
                  </div>
                </div>
              </div>

              <div class="space-y-1">
                <label class="text-sm font-medium text-gray-900">Logradouro</label>
                <input
                  type="text"
                  v-model="rua"
                  placeholder="Rua, Avenida, Praça..."
                  class="w-full px-4 py-3 bg-white/50 border border-gray-200/50 rounded-xl focus:ring-2 focus:ring-green-500/20 focus:border-green-500 focus:outline-none transition-all duration-200 backdrop-blur-sm"
                />
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                  <label class="text-sm font-medium text-gray-900">Número</label>
                  <input
                    type="text"
                    v-model="numero"
                    placeholder="123"
                    class="w-full px-4 py-3 bg-white/50 border border-gray-200/50 rounded-xl focus:ring-2 focus:ring-green-500/20 focus:border-green-500 focus:outline-none transition-all duration-200 backdrop-blur-sm"
                  />
                </div>
                <div class="space-y-1">
                  <label class="text-sm font-medium text-gray-900">Complemento</label>
                  <input
                    type="text"
                    v-model="complemento"
                    placeholder="Apto, Sala..."
                    class="w-full px-4 py-3 bg-white/50 border border-gray-200/50 rounded-xl focus:ring-2 focus:ring-green-500/20 focus:border-green-500 focus:outline-none transition-all duration-200 backdrop-blur-sm"
                  />
                </div>
              </div>

              <div class="space-y-1">
                <label class="text-sm font-medium text-gray-900">Bairro</label>
                <input
                  type="text"
                  v-model="bairro"
                  placeholder="Nome do bairro"
                  class="w-full px-4 py-3 bg-white/50 border border-gray-200/50 rounded-xl focus:ring-2 focus:ring-green-500/20 focus:border-green-500 focus:outline-none transition-all duration-200 backdrop-blur-sm"
                />
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2 space-y-1">
                  <label class="text-sm font-medium text-gray-900">Cidade</label>
                  <input
                    type="text"
                    v-model="cidade"
                    placeholder="Nome da cidade"
                    class="w-full px-4 py-3 bg-white/50 border border-gray-200/50 rounded-xl focus:ring-2 focus:ring-green-500/20 focus:border-green-500 focus:outline-none transition-all duration-200 backdrop-blur-sm"
                  />
                </div>
                <div class="space-y-1">
                  <label class="text-sm font-medium text-gray-900">UF</label>
                  <input
                    type="text"
                    v-model="estado"
                    placeholder="SP"
                    maxlength="2"
                    class="w-full px-4 py-3 bg-white/50 border border-gray-200/50 rounded-xl focus:ring-2 focus:ring-green-500/20 focus:border-green-500 focus:outline-none transition-all duration-200 backdrop-blur-sm uppercase text-center"
                  />
                </div>
              </div>

              <div class="pt-4">
                <button
                  type="submit"
                  :disabled="loading"
                  class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold py-4 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2"
                >
                  <span v-if="loading" class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                  <span v-else-if="isEditing">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                  </span>
                  <span v-else>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                  </span>
                  {{ loading ? 'Processando...' : (isEditing ? 'Atualizar Endereço' : 'Salvar Endereço') }}
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
    import { ref, onMounted } from "vue";
    import { useRouter } from "vue-router";
    import { addressService } from "@/services/addressService";
    import api from "@/services/api";
    import Sidebar from "@/components/Sidebar.vue";
    import MobileMenu from "@/components/MobileMenu.vue";

    const router = useRouter();

    const cep = ref("");
    const rua = ref("");
    const numero = ref("");
    const complemento = ref("");
    const bairro = ref("");
    const cidade = ref("");
    const estado = ref("");

    const errorMessage = ref("");
    const successMessage = ref("");
    const loading = ref(false);
    const isEditing = ref(false);

    const buscarCep = async () => {
        if (!cep.value) {
            errorMessage.value = "Informe um CEP válido.";
            return;
        }

        try {
            loading.value = true;
            errorMessage.value = "";

            const { data } = await api.get(`/cep/${cep.value}`);

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

    const loadAddress = async () => {
        try {
            const address = await addressService.getAddresses();
            if (address) {
              isEditing.value = true;
              cep.value = address.cep || "";
              rua.value = address.logradouro || "";
              numero.value = address.numero || "";
              complemento.value = address.complemento || "";
              bairro.value = address.bairro || "";
              cidade.value = address.cidade || "";
              estado.value = address.estado || "";
            }
        } catch (error) {
          // Endereço não existe, manter formulário vazio
        }
    };

    const saveAddress = async () => {
        loading.value = true;
        errorMessage.value = "";
        successMessage.value = "";

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

            if (isEditing.value) {
              await addressService.updateAddress(addressData);
              successMessage.value = "Endereço atualizado com sucesso!";
            } else {
              await addressService.addAddress(addressData);
              successMessage.value = "Endereço cadastrado com sucesso!";
            }

            setTimeout(() => router.push("/dashboard"), 1500);
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
                errorMessage.value = error?.message || error.response?.data?.message || "Erro ao processar endereço.";
            }
        } finally {
            loading.value = false;
        }
    };

    onMounted(() => {
      loadAddress();
    });
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
  background: linear-gradient(to bottom, #10b981, #059669);
  border-radius: 3px;
}
main::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(to bottom, #059669, #047857);
}

/* Input focus animation */
input:focus {
  transform: translateY(-1px);
  box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.1), 0 10px 10px -5px rgba(16, 185, 129, 0.04);
}

/* Button hover animation */
button[type="submit"]:hover:not(:disabled) {
  box-shadow: 0 20px 25px -5px rgba(16, 185, 129, 0.2), 0 10px 10px -5px rgba(16, 185, 129, 0.1);
}
</style>
