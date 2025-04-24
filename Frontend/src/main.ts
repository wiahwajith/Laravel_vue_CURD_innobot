// import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import axiosPlugin from './plugins/axios.ts';


import App from './App.vue'
import router from './router'

import quasar from './plugins/quasar.ts'



const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(axiosPlugin);

quasar(app)

app.mount('#app')
