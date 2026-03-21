import { createApp } from 'vue'
import router from './router'

import App from './App.vue' // optional wrapper (recommended)

createApp(App)
  .use(router)
  .mount('#app')
