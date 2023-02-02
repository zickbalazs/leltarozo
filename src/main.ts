import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

import './assets/main.css'
import '../node_modules/bootstrap-icons/font/bootstrap-icons.css'
import 'bootstrap'

const app = createApp(App)

app.use(router)

app.mount('#app')
