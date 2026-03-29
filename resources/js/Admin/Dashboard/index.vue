<template>
  <div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-hidden">
    <!-- Decorative Blob -->
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-rose-500/20 rounded-full blur-3xl pointer-events-none"></div>
    
    <div class="relative z-10">
      <h1 class="text-4xl font-extrabold pb-2 bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-rose-500 mb-6 tracking-tight drop-shadow-sm">
        Dashboard Overview
      </h1>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gray-900/50 rounded-2xl p-6 border border-gray-800 shadow-inner flex flex-col justify-center">
          <h3 class="text-gray-400 font-medium mb-2">Total Categories</h3>
          <p class="text-4xl font-bold text-white">124</p>
        </div>
        <div class="bg-gray-900/50 rounded-2xl p-6 border border-gray-800 shadow-inner flex flex-col justify-center">
          <h3 class="text-gray-400 font-medium mb-2">Active Reports</h3>
          <p class="text-4xl font-bold text-white">45</p>
        </div>
        <div class="bg-gray-900/50 rounded-2xl p-6 border border-gray-800 shadow-inner flex flex-col justify-center">
          <h3 class="text-gray-400 font-medium mb-2">System Status</h3>
          <p class="text-4xl font-bold text-emerald-400">Online</p>
        </div>
      </div>
    </div>
  </div>
</template>
