<template>
  <div
    class="min-h-screen flex items-center justify-center bg-[#0b1121] text-white font-sans relative overflow-hidden selection:bg-teal-500 selection:text-white">
    <!-- Background Image with Opacity -->
    <div
      class="absolute inset-0 bg-cover bg-center opacity-30 pointer-events-none"
      :style="{ backgroundImage: `url('${$assetUrl}/assets/images/loginpageimage.jpg?v=1.1')` }">
    </div>

    <!-- Decorative Gradients -->
    <div
      class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-teal-600/20 rounded-full blur-[120px] pointer-events-none">
    </div>
    <div
      class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-emerald-600/20 rounded-full blur-[120px] pointer-events-none">
    </div>

    <div
      class="w-full max-w-md bg-gray-800/40 p-8 rounded-3xl shadow-2xl border border-gray-700/50 backdrop-blur-sm relative z-10 w-[90%] mx-auto">
      <div class="text-center mb-8">
        <h2
          class="text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-emerald-500 tracking-wide uppercase">
          Admin Login
        </h2>
        <p class="text-gray-400 mt-2 text-sm">Sign in to access the control panel</p>
      </div>

      <form @submit.prevent="login" class="space-y-5">
        <!-- Email -->
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-300 text-left">Email Address</label>
          <div class="relative">
            <input v-model="form.email" type="email" placeholder="admin@example.com"
              class="w-full bg-gray-900/50 border border-gray-700 text-white px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all placeholder-gray-600" />
          </div>
          <p v-if="errors.email" class="text-rose-400 text-xs mt-1.5 font-medium text-left">
            {{ errors.email }}
          </p>
        </div>

        <!-- Password -->
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-300 text-left">Password</label>
          <div class="relative flex items-center">
            <input v-model="form.password" :type="showPassword ? 'text' : 'password'" placeholder="••••••••"
              class="w-full bg-gray-900/50 border border-gray-700 text-white pl-4 pr-11 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all placeholder-gray-600" />
            <button 
              type="button" 
              @click="showPassword = !showPassword"
              class="absolute right-4 text-gray-500 hover:text-gray-300 focus:outline-none"
            >
              <svg v-if="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
              <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            </button>
          </div>
          <p v-if="errors.password" class="text-rose-400 text-xs mt-1.5 font-medium text-left">
            {{ errors.password }}
          </p>
        </div>

        <button type="submit"
          class="w-full bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-400 hover:to-emerald-500 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-teal-500/25 transition-all duration-200 mt-6 active:scale-[0.98]">
          Sign In
        </button>

        <div v-if="serverError" class="p-3 bg-rose-500/10 border border-rose-500/20 rounded-xl mt-4">
          <p class="text-rose-400 text-sm text-center font-medium">
            {{ serverError }}
          </p>
        </div>

      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue"
import { validateLogin, loginRequest } from "./composables/login.js"


const form = reactive({
  email: "",
  password: "",
})

const showPassword = ref(false)

const errors = ref({
  email: "",
  password: "",
})

const serverError = ref("")
const login = async () => {
  serverError.value = ""

  // validation
  if (!validateLogin(form, errors.value)) return

  try {
    const response = await loginRequest(form)
    localStorage.setItem('user', JSON.stringify(response.data.user))
    window.location.href = "/admin/dashboard"

  } catch (err) {
    serverError.value =
      err.response?.data?.message || "Login failed"
  }
}
</script>
