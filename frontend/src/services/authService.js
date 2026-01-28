import api from "./api";

export default {
  async register(data) {
    const response = await api.post("/register", data);
    const { user, token } = response.data;
    this.saveAuth(user, token);
    return user;
  },

  async login(email, password) {
    const response = await api.post("/login", { email, password });
    const { user, token } = response.data;
    this.saveAuth(user, token);
    return user;
  },

  async logout() {
    try {
      await api.post("/auth/logout");
    } finally {
      this.clearAuth();
    }
  },

  saveAuth(user, token) {
    localStorage.setItem("user", JSON.stringify(user));
    localStorage.setItem("token", token);
  },

  clearAuth() {
    localStorage.removeItem("user");
    localStorage.removeItem("token");
  },

  getUser() {
    const user = localStorage.getItem("user");
    return user ? JSON.parse(user) : null;
  },

  getToken() {
    return localStorage.getItem("token");
  },

  isAuthenticated() {
    const token = localStorage.getItem("token");
    const user = localStorage.getItem("user");
    return !!(token && user);
  },
};
