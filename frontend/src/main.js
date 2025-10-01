import { createApp } from 'vue'
import App from './App.vue'
import router from './router' // importa o router
import './assets/main.css'

const app = createApp(App)
app.use(router) // usa o router
app.mount('#app')