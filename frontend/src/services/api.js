import axios from "axios"

const api = axios.create({
  baseURL: "http://localhost:8080/api", // ajuste se o backend estiver em outro host/porta
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
})

export default api
