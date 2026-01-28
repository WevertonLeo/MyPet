import api from "./api"

export async function registerUser(userData) {
  try {
    const response = await api.post("/user", userData)
    return response.data
  } catch (error) {
    console.error("Erro ao registrar usuário:", error)
    throw error.response?.data || { message: "Erro desconhecido." }
  }
}
