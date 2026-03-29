import { createRouter, createWebHistory } from 'vue-router'

import UserIndex from './Userview/index.vue'
import AdminLogin from './Admin/Login/Login.vue'
import SidebarLayout from './Layout/Sidebar.vue'
import Dashboard from './Admin/Dashboard/index.vue'
import CategoryReport from './Admin/CategoryReport/index.vue'
import CategoryList from './Admin/CategoryList/index.vue'
import CategoryDetails from './Admin/CategoryDetails/index.vue'

const routes = [
  { path: '/', component: UserIndex },
  { path: '/admin/login', component: AdminLogin },
  { 
    path: '/admin', 
    component: SidebarLayout,
    children: [
      { path: 'dashboard', component: Dashboard },
      { path: 'category-report', component: CategoryReport },
      { path: 'category-list', component: CategoryList },
      { path: 'category-details', component: CategoryDetails },
    ]
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
