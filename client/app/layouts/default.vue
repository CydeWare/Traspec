<!-- layouts/default.vue -->
<template>
  <div class="min-h-screen bg-gray-100 flex">
    <Sidebar :unit-kerja-list="unitKerjaList" />
    
    <div class="flex-1 p-6">
      <slot />
    </div>
  </div>
</template>

<script setup lang="ts">
const api = useApi()
const unitKerjaList = ref([])

onMounted(async () => {
  try {
    unitKerjaList.value = await api.getUnitKerja()
  } catch (error) {
    console.error('Error loading unit kerja:', error)
  }
})
</script>