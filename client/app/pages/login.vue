<!-- pages/login.vue -->
<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-2xl p-8 w-full max-w-md">
      <div class="text-center mb-8">
        <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Sistem Manajemen PNS</h1>
        <p class="text-gray-600 mt-2">Silakan login untuk melanjutkan</p>
      </div>

      <form @submit.prevent="handleLogin" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
          <input
            v-model="username"
            type="text"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Masukkan username"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
          <input
            v-model="password"
            type="password"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Masukkan password"
          />
        </div>

        <div v-if="errorMessage" class="bg-red-50 border border-red-200 text-red-600 px-4 py-2 rounded text-sm">
          {{ errorMessage }}
        </div>

        <button
          type="submit"
          :disabled="loading"
          class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium disabled:opacity-50"
        >
          {{ loading ? 'Loading...' : 'Login' }}
        </button>

        <div class="mt-4 text-center">
          <p class="text-sm text-gray-600">
            Belum punya akun?
            <NuxtLink to="/register" class="text-blue-600 hover:text-blue-700 font-medium">
              Daftar di sini
            </NuxtLink>
          </p>
        </div>
      </form>

      <p class="text-xs text-gray-500 text-center mt-4">
        Demo: gunakan username "admin" dan password "password"
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  layout: false,
  middleware: 'guest'
})

const { login } = useAuth()
const username = ref('')
const password = ref('')
const loading = ref(false)
const errorMessage = ref('')

const handleLogin = async () => {
  loading.value = true
  errorMessage.value = ''

  const result = await login(username.value, password.value)

  if (result.success) {
    await navigateTo('/')
  } else {
    errorMessage.value = result.message || 'Login gagal'
  }

  loading.value = false
}
</script>