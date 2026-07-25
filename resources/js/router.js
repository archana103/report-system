import { createRouter, createWebHistory } from 'vue-router'

import UserIndex from './Userview/index.vue'
import UserReports from './Userview/Reports.vue'
import UserReportDetail from './Userview/ReportDetail.vue'
import UserIndustryCategory from './Userview/IndustryCategory.vue'
import UserAbout from './Userview/AboutUs.vue'
import UserBlogs from './Userview/Blogs.vue'
import UserPressReleases from './Userview/PressReleases.vue'
import UserContact from './Userview/Contact.vue'
import UserThankYou from './Userview/ThankYou.vue'
import UserBlogDetail from './Userview/BlogDetail.vue'
import UserPressReleaseDetail from './Userview/PressReleaseDetail.vue'
import UserCheckout from './Userview/Checkout.vue'
import UserPurchaseForm from './Userview/components/CheckoutForm.vue'
import UserServices from './Userview/Services.vue'
import UserPrivacyPolicy from './Userview/PrivacyPolicy.vue'
import UserTermsAndConditions from './Userview/TermsAndConditions.vue'
import AdminLogin from './Admin/Login/Login.vue'
import SidebarLayout from './Layout/Sidebar.vue'
import PricingSetup from './Admin/PricingSetup/index.vue'
import BlogRequests from './Admin/BlogRequests/index.vue'
import Newsletters from './Admin/Newsletters/index.vue'
import Dashboard from './Admin/Dashboard/index.vue'
import CategoryReport from './Admin/CategoryReport/index.vue'
import ReportList from './Admin/ReportList/index.vue'
import ReportDetails from './Admin/ReportDetails/index.vue'
import ContactUs from './Admin/ContactUs/index.vue'
import PressRelease from './Admin/PressRelease/index.vue'
import PressReleaseDetails from './Admin/PressReleaseDetails/index.vue'
import RequestForm from './Admin/RequestForm/index.vue'
import Blogs from './Admin/Blogs/index.vue'
import BlogDetails from './Admin/BlogDetails/index.vue'
import TopSellingReports from './Admin/TopSellingReports/index.vue'

import ChangePassword from './Admin/ChangePassword/index.vue'
import ReportMethodology from './Admin/ReportMethodology/index.vue'
import PageSeos from './Admin/PageSeos/index.vue'
import Purchases from './Admin/Purchases/index.vue'

const routes = [
  { path: '/', component: UserIndex },
  { path: '/reports', component: UserReports },
  { path: '/about-us', component: UserAbout },
  { path: '/blogs', component: UserBlogs },
  { path: '/press-releases', component: UserPressReleases },
  { path: '/contact-us', component: UserContact },
  { path: '/services', component: UserServices },
  { path: '/privacy-policy', component: UserPrivacyPolicy },
  { path: '/terms-and-conditions', component: UserTermsAndConditions },
  { path: '/thank-you', component: UserThankYou },
  { path: '/industry/:name', component: UserIndustryCategory },
  { path: '/report/:slug', component: UserReportDetail },
  { path: '/blog/:slug', component: UserBlogDetail },
  { path: '/press-release/:slug', component: UserPressReleaseDetail },
  { path: '/checkout/:slug', component: UserCheckout },
  { path: '/purchase/:slug', component: UserPurchaseForm },
  { path: '/report', redirect: '/reports' },
  { path: '/admin/login', component: AdminLogin },
  { 
    path: '/admin', 
    component: SidebarLayout,
    children: [
      { path: 'dashboard', component: Dashboard },
      { path: 'category-report', component: CategoryReport },
      { path: 'category-list', component: ReportList },
      { path: 'category-details', component: ReportDetails },
      { path: 'pricing-setup', component: PricingSetup },
      { path: 'top-selling-reports', component: TopSellingReports },
      { path: 'contact-us', component: ContactUs },
      { path: 'press-release', component: PressRelease },
      { path: 'press-release-details', component: PressReleaseDetails },
      { path: 'request-form', component: RequestForm },
      { path: 'blogs', component: Blogs },
      { path: 'blog-details', component: BlogDetails },
      { path: 'blog-requests', component: BlogRequests },
      { path: 'newsletters', component: Newsletters },
      { path: 'change-password', component: ChangePassword },
      { path: 'report-methodology', component: ReportMethodology },
      { path: 'page-seo', component: PageSeos },
      { path: 'purchases', component: Purchases },
    ]
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return { el: to.hash, behavior: 'smooth' }
    } else if (savedPosition) {
      return savedPosition
    } else {
      return { top: 0, behavior: 'smooth' }
    }
  }
})

router.beforeEach((to, from) => {
  const isAuth = localStorage.getItem('user') || sessionStorage.getItem('user')

  if (to.path.startsWith('/admin') && to.path !== '/admin/login' && !isAuth) {
    return '/admin/login'
  } else if (to.path === '/admin') {
    return '/admin/dashboard'
  }
})

let defaultTitle = 'Epignosis Insights';
if (typeof document !== 'undefined') {
  defaultTitle = document.title;
}

router.afterEach((to) => {
  if (to.meta && to.meta.title) {
    document.title = to.meta.title;
  } else {
    document.title = defaultTitle;
  }
})

export default router

