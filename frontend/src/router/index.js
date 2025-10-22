import { createRouter, createWebHistory } from "vue-router";
import Login from "@/views/Login/Login.vue";
import Register from "@/views/User/Register.vue";
import Dashboard from "@/views/Dashboard.vue";
import AddPet from "@/views/Pet/AddPet.vue";
import AddAddress from "@/views/Profile/AddAddress.vue";
import authService from "@/services/authService";

const routes = [
  { path: "/", component: Login },
  { path: "/login", component: Login },
  { path: "/register", component: Register },
  {
    path: "/dashboard",
    component: Dashboard,
    meta: { requiresAuth: true }
  },
  {
    path: "/addPet",
    component: AddPet,
    meta: { requiresAuth: true }
  },
  {
    path: "/addAddress",
    component: AddAddress,
    meta: { requiresAuth: true }
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Middleware de autenticação
router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !authService.isAuthenticated()) {
    return next("/");
  }

  if (to.path === "/" && authService.isAuthenticated()) {
    return next("/dashboard");
  }
  
  next();
});

export default router;
