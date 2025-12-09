<!-- app.vue -->
<template>
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
</template>

<script setup lang="ts">
  import { useAuth } from '../composables/useAuth.ts'

const { fetchUser, isAuthenticated } = useAuth()

onMounted(async () => {
  if (isAuthenticated.value) {
    await fetchUser()
  }
})
</script>