import axios from "axios";

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || "http://localhost:8080/api",
  timeout: 10000,
});

api.interceptors.request.use((config) => {
  const token = localStorage.getItem("token");
  console.log('Token no interceptor:', token ? 'Presente' : 'Ausente');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
    console.log('Header Authorization definido:', config.headers.Authorization.substring(0, 20) + '...');
  }
  return config;
});

api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem("token");
      localStorage.removeItem("user");
      window.location.href = "/";
    }
    return Promise.reject(error);
  }
);

export default api;
