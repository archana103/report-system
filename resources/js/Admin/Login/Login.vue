<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white p-6 rounded-xl shadow-md">

      <h2 class="text-2xl font-bold text-center mb-6">Admin Login</h2>

      <form @submit.prevent="login">

        <!-- Email -->
        <div class="mb-4">
          <label class="block mb-1">Email</label>
          <input
            v-model="form.email"
            type="email"
            class="w-full border p-2 rounded"
          />
          <p v-if="errors.email" class="text-red-500 text-sm">
            {{ errors.email }}
          </p>
        </div>

        <!-- Password -->
        <div class="mb-4">
          <label class="block mb-1">Password</label>
          <input
            v-model="form.password"
            type="password"
            class="w-full border p-2 rounded"
          />
          <p v-if="errors.password" class="text-red-500 text-sm">
            {{ errors.password }}
          </p>
        </div>

        <button class="w-full bg-blue-500 text-white py-2 rounded">
          Login
        </button>

        <p v-if="serverError" class="text-red-500 mt-3 text-center">
          {{ serverError }}
        </p>

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
