import { createApp } from 'vue'
import './bootstrap'
import router from './router'

import App from './App.vue' // optional wrapper (recommended)

const app = createApp(App)

app.config.globalProperties.$assetUrl = import.meta.env.VITE_AWS_URL || ''

app.use(router)
app.mount('#app')

