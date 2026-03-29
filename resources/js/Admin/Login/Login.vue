<template>
  <div class="min-h-screen flex items-center justify-center bg-[#0b1121] text-white font-sans relative overflow-hidden selection:bg-indigo-500 selection:text-white">
    <!-- Decorative Gradients -->
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-600/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-600/20 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-md bg-gray-800/40 p-8 rounded-3xl shadow-2xl border border-gray-700/50 backdrop-blur-sm relative z-10 w-[90%] mx-auto">
      <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-purple-500 tracking-wide uppercase">
          Admin Login
        </h2>
        <p class="text-gray-400 mt-2 text-sm">Sign in to access the control panel</p>
      </div>

      <form @submit.prevent="login" class="space-y-5">
        <!-- Email -->
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-300 text-left">Email Address</label>
          <div class="relative">
            <input
              v-model="form.email"
              type="email"
              placeholder="admin@example.com"
              class="w-full bg-gray-900/50 border border-gray-700 text-white px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder-gray-600"
            />
          </div>
          <p v-if="errors.email" class="text-rose-400 text-xs mt-1.5 font-medium text-left">
            {{ errors.email }}
          </p>
        </div>

        <!-- Password -->
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-300 text-left">Password</label>
          <div class="relative">
            <input
              v-model="form.password"
              type="password"
              placeholder="••••••••"
              class="w-full bg-gray-900/50 border border-gray-700 text-white px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder-gray-600"
            />
          </div>
          <p v-if="errors.password" class="text-rose-400 text-xs mt-1.5 font-medium text-left">
            {{ errors.password }}
          </p>
        </div>

        <button 
          type="submit"
          class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-indigo-500/25 transition-all duration-200 mt-6 active:scale-[0.98]"
        >
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
     window.location.href = "/admin/dashboard"

  } catch (err) {
    serverError.value =
      err.response?.data?.message || "Login failed"
  }
}
</script>
