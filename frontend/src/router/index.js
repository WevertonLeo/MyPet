import { createRouter, createWebHistory } from 'vue-router'

// Views
import Login from '@/views/Login/Login.vue'
import Register from '@/views/User/Register.vue'
//import AddPet from '../views/Pet/AddPet.vue'
//import AddAddress from '../views/User/AddAddres.vue'

const routes = [
  { path: '/', redirect: '/login' },
  { path: '/login', name: 'Login', component: Login },
  { path: '/register', name: 'Register', component: Register },
  //{ path: '/pets/new', component: AddPet },
  //{ path: '/address/new', component: AddAddress },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router