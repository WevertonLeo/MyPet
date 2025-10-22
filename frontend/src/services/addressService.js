import api from "./api";

export const addressService = {
  /**
   * @param {Object} addressData - Dados do endereço
   * @returns {Promise}
   */
  async addAddress(addressData) {
    try {
      const response = await api.post("/enderecos", addressData);
      return response.data;
    } catch (error) {
      console.error("Erro ao cadastrar endereço:", error);
      throw error.response?.data || { message: "Erro desconhecido no servidor." };
    }
  },

  /**
   * @returns {Promise}
   */
  async getAddresses() {
    try {
      const response = await api.get("/enderecos");
      return response.data;
    } catch (error) {
      console.error("Erro ao buscar endereços:", error);
      throw error.response?.data || { message: "Erro desconhecido no servidor." };
    }
  },
};
