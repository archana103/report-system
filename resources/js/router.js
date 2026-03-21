import { createRouter, createWebHistory } from 'vue-router'

import UserIndex from './Userview/index.vue'
import AdminLogin from './Admin/Login/Login.vue'

const routes = [
  { path: '/', component: UserIndex },
  { path: '/admin/login', component: AdminLogin }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
