<!-- app/pages/register.vue -->
<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-2xl p-8 w-full max-w-md">
      <div class="text-center mb-8">
        <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
          </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Daftar Akun Baru</h1>
        <p class="text-gray-600 mt-2">Buat akun untuk mengakses sistem</p>
      </div>

      <form @submit.prevent="handleRegister" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
          <input
            v-model="formData.nama_lengkap"
            type="text"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Masukkan nama lengkap"
          />
          <p v-if="errors.nama_lengkap" class="text-red-500 text-xs mt-1">{{ errors.nama_lengkap[0] }}</p>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
          <input
            v-model="formData.username"
            type="text"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Masukkan username"
          />
          <p v-if="errors.username" class="text-red-500 text-xs mt-1">{{ errors.username[0] }}</p>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
          <input
            v-model="formData.email"
            type="email"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Masukkan email"
          />
          <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email[0] }}</p>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
          <input
            v-model="formData.password"
            type="password"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Masukkan password (min. 6 karakter)"
          />
          <p v-if="errors.password" class="text-red-500 text-xs mt-1">{{ errors.password[0] }}</p>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
          <input
            v-model="formData.password_confirmation"
            type="password"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Ulangi password"
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
          {{ loading ? 'Mendaftar...' : 'Daftar' }}
        </button>
      </form>

      <div class="mt-4 text-center">
        <p class="text-sm text-gray-600">
          Sudah punya akun?
          <NuxtLink to="/login" class="text-blue-600 hover:text-blue-700 font-medium">
            Login di sini
          </NuxtLink>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  layout: false,
  middleware: 'guest'
})

const { register } = useAuth()

const formData = ref({
  nama_lengkap: '',
  username: '',
  email: '',
  password: '',
  password_confirmation: ''
})

const loading = ref(false)
const errorMessage = ref('')
const errors = ref<any>({})

const handleRegister = async () => {
  loading.value = true
  errorMessage.value = ''
  errors.value = {}

  const result = await register(formData.value)

  if (result.success) {
    await navigateTo('/')
  } else {
    errorMessage.value = result.message || 'Registrasi gagal'
    errors.value = result.errors || {}
  }

  loading.value = false
}
</script>