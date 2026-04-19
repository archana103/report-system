<template>
  <div class="flex h-screen bg-[#0f172a] text-white font-sans selection:bg-indigo-500 selection:text-white">
    <!-- Leftbar (Sidebar) -->
    <aside class="w-64 flex flex-col bg-gradient-to-b from-gray-900 to-gray-800 border-r border-gray-700 shadow-2xl transition-all duration-300 relative z-20">
      <div class="p-6 flex items-center justify-center border-b border-gray-700">
        <h2 class="text-2xl font-medium bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-purple-500 tracking-wide uppercase">
          Admin Panel
        </h2>
      </div>

      <nav class="flex-1 px-4 py-6 space-y-3 overflow-y-auto">
        <router-link
          to="/admin/dashboard"
          class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 border border-transparent hover:border-gray-700 relative overflow-hidden group"
          active-class="bg-gradient-to-r from-indigo-600 to-purple-600 shadow-lg border-transparent hover:border-transparent text-white ring-1 ring-white/20"
        >
          <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/5 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
          <svg class="w-5 h-5 text-indigo-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
          <span class="font-medium relative z-10 text-gray-200 group-[.router-link-active]:text-white">Dashboard</span>
        </router-link>

        <div>
          <button
            @click="activeMenu = activeMenu === 'master' ? '' : 'master'"
            class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 border border-transparent hover:border-gray-700 group"
            :class="{ 'bg-white/5 border-gray-700': activeMenu === 'master' }"
          >
            <div class="flex items-center gap-3">
              <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
              <span class="font-medium text-gray-200 group-hover:text-white">Master</span>
            </div>
            <svg class="w-4 h-4 text-gray-400 group-hover:text-white transition-transform duration-300 transform" :class="{'rotate-180': activeMenu === 'master'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </button>

          <div
            v-show="activeMenu === 'master'"
            class="mt-3 space-y-1 overflow-hidden relative"
          >
            <!-- Vertical decorative line for nested items -->
            <div class="absolute left-6 top-0 bottom-0 w-px bg-gray-700"></div>

            <router-link
              to="/admin/category-report"
              class="relative flex items-center px-12 py-2.5 rounded-lg text-sm text-gray-400 hover:text-white hover:bg-white/5 transition-all duration-200"
              active-class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item"
            >
               Report Category
            </router-link>
            <router-link
              to="/admin/category-list"
              class="relative flex items-center px-12 py-2.5 rounded-lg text-sm text-gray-400 hover:text-white hover:bg-white/5 transition-all duration-200"
              active-class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item"
            >
              Report List
            </router-link>
            <router-link
              to="/admin/category-details"
              class="relative flex items-center px-12 py-2.5 rounded-lg text-sm text-gray-400 hover:text-white hover:bg-white/5 transition-all duration-200"
              active-class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item"
            >
              Report Details
            </router-link>
            <router-link
              to="/admin/top-selling-reports"
              class="relative flex items-center px-12 py-2.5 rounded-lg text-sm text-gray-400 hover:text-white hover:bg-white/5 transition-all duration-200"
              active-class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item"
            >
              Top Selling Reports
            </router-link>
          </div>
        </div>

        <!-- Blogs Accordion -->
        <div>
          <button
            @click="activeMenu = activeMenu === 'blogs' ? '' : 'blogs'"
            class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 border border-transparent hover:border-gray-700 group"
            :class="{ 'bg-white/5 border-gray-700': activeMenu === 'blogs' }"
          >
            <div class="flex items-center gap-3">
              <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2"></path></svg>
              <span class="font-medium text-gray-200 group-hover:text-white">Blogs</span>
            </div>
            <svg class="w-4 h-4 text-gray-400 group-hover:text-white transition-transform duration-300 transform" :class="{'rotate-180': activeMenu === 'blogs'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </button>

          <div
            v-show="activeMenu === 'blogs'"
            class="mt-3 space-y-1 overflow-hidden relative"
          >
            <div class="absolute left-6 top-0 bottom-0 w-px bg-gray-700"></div>

            <router-link
              to="/admin/blogs"
              class="relative flex items-center px-12 py-2.5 rounded-lg text-sm text-gray-400 hover:text-white hover:bg-white/5 transition-all duration-200"
              active-class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item"
            >
               Blogs List
            </router-link>
            <router-link
              to="/admin/blog-details"
              class="relative flex items-center px-12 py-2.5 rounded-lg text-sm text-gray-400 hover:text-white hover:bg-white/5 transition-all duration-200"
              active-class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item"
            >
              Blog Details
            </router-link>
          </div>
        </div>

        <!-- Contact Accordion -->
        <div>
          <button
            @click="activeMenu = activeMenu === 'contact' ? '' : 'contact'"
            class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 border border-transparent hover:border-gray-700 group"
            :class="{ 'bg-white/5 border-gray-700': activeMenu === 'contact' }"
          >
            <div class="flex items-center gap-3">
              <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
              <span class="font-medium text-gray-200 group-hover:text-white">Contact</span>
            </div>
            <svg class="w-4 h-4 text-gray-400 group-hover:text-white transition-transform duration-300 transform" :class="{'rotate-180': activeMenu === 'contact'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </button>

          <div
            v-show="activeMenu === 'contact'"
            class="mt-3 space-y-1 overflow-hidden relative"
          >
            <div class="absolute left-6 top-0 bottom-0 w-px bg-gray-700"></div>

            <router-link
              to="/admin/contact-us"
              class="relative flex items-center px-12 py-2.5 rounded-lg text-sm text-gray-400 hover:text-white hover:bg-white/5 transition-all duration-200"
              active-class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item"
            >
               Contact Us Data
            </router-link>
            <router-link
              to="/admin/request-form"
              class="relative flex items-center px-12 py-2.5 rounded-lg text-sm text-gray-400 hover:text-white hover:bg-white/5 transition-all duration-200"
              active-class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item"
            >
              Request Form Data
            </router-link>
          </div>
        </div>

        <router-link
          to="/admin/press-release"
          class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 border border-transparent hover:border-gray-700 relative overflow-hidden group"
          active-class="bg-gradient-to-r from-indigo-600 to-purple-600 shadow-lg border-transparent hover:border-transparent text-white ring-1 ring-white/20"
        >
          <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/5 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
          <svg class="w-5 h-5 text-indigo-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
          <span class="font-medium relative z-10 text-gray-200 group-[.router-link-active]:text-white">Press Release</span>
        </router-link>

        <router-link
          to="/admin/press-release-details"
          class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 border border-transparent hover:border-gray-700 relative overflow-hidden group"
          active-class="bg-gradient-to-r from-indigo-600 to-purple-600 shadow-lg border-transparent hover:border-transparent text-white ring-1 ring-white/20"
        >
          <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/5 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
          <svg class="w-5 h-5 text-indigo-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
          <span class="font-medium relative z-10 text-gray-200 group-[.router-link-active]:text-white">Press Release Details</span>
        </router-link>




      </nav>

      <div class="p-4 border-t border-gray-700 bg-gray-900/50">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center font-medium shadow-lg ring-2 ring-gray-800">
            A
          </div>
          <div>
            <p class="text-sm font-medium">Administrator</p>
            <p class="text-xs text-gray-500">View Profile</p>
          </div>
        </div>
      </div>
    </aside>

    <!-- Rightbar (Main Area) -->
    <main class="flex-1 overflow-auto bg-[#0b1121] relative flex flex-col">
       <!-- Subtle Background Glow -->
       <div class="fixed top-0 left-64 right-0 h-96 bg-indigo-900/10 blur-[120px] pointer-events-none rounded-full"></div>

       <header class="h-16 border-b border-gray-800 bg-[#0f172a]/80 backdrop-blur-md sticky top-0 z-10 flex items-center px-6 shadow-sm">
         <h1 class="text-lg text-gray-300 font-medium">Dashboard Overview</h1>
       </header>

       <div class="flex-1 p-5 relative z-10 w-full max-w-full mx-auto">
         <router-view v-slot="{ Component }">
           <transition name="fade" mode="out-in">
             <component :is="Component" />
           </transition>
         </router-view>
       </div>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'
const activeMenu = ref('master') // Master is open by default
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.25s ease, transform 0.25s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(15px);
}

.router-active-item::before {
  content: '';
  position: absolute;
  left: -24px;
  top: 50%;
  transform: translateY(-50%);
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background-color: #818cf8; /* indigo-400 */
  box-shadow: 0 0 10px #818cf8;
}
</style>
