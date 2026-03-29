import { createRouter, createWebHistory } from 'vue-router'

import UserIndex from './Userview/index.vue'
import AdminLogin from './Admin/Login/Login.vue'
import SidebarLayout from './Layout/Sidebar.vue'
import Dashboard from './Admin/Dashboard/index.vue'
import CategoryReport from './Admin/CategoryReport/index.vue'
import CategoryList from './Admin/CategoryList/index.vue'
import CategoryDetails from './Admin/CategoryDetails/index.vue'
import ContactUs from './Admin/ContactUs/index.vue'
import PressRelease from './Admin/PressRelease/index.vue'
import PressReleaseDetails from './Admin/PressReleaseDetails/index.vue'
import RequestForm from './Admin/RequestForm/index.vue'
import Blogs from './Admin/Blogs/index.vue'
import BlogDetails from './Admin/BlogDetails/index.vue'

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
      { path: 'contact-us', component: ContactUs },
      { path: 'press-release', component: PressRelease },
      { path: 'press-release-details', component: PressReleaseDetails },
      { path: 'request-form', component: RequestForm },
      { path: 'blogs', component: Blogs },
      { path: 'blog-details', component: BlogDetails },
    ]
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
