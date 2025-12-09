<!-- components/Sidebar.vue -->
<template>
  <div class="w-64 bg-blue-800 text-white p-4 flex flex-col print:hidden">
    <div class="mb-8">
      <h1 class="text-xl font-bold">SIPEG PNS</h1>
      <p class="text-sm text-blue-200">Sistem Informasi Pegawai</p>
    </div>
    
    <div class="mb-6 pb-6 border-b border-blue-700">
      <div class="flex items-center space-x-3">
        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
        </div>
        <div>
          <p class="font-medium">{{ user?.nama_lengkap || 'User' }}</p>
          <p class="text-xs text-blue-200">{{ user?.username || 'user' }}</p>
        </div>
      </div>
    </div>

    <div class="flex-1">
      <h3 class="text-xs font-semibold text-blue-300 mb-2">MENU UTAMA</h3>
      <NuxtLink
        to="/"
        class="block px-3 py-2 rounded mb-1 hover:bg-blue-700 transition-colors"
        :class="{ 'bg-blue-700': $route.path === '/' }"
      >
        Dashboard
      </NuxtLink>
      <NuxtLink
        to="/pegawai"
        class="block px-3 py-2 rounded mb-1 hover:bg-blue-700 transition-colors"
        :class="{ 'bg-blue-700': $route.path.startsWith('/pegawai') }"
      >
        Data Pegawai
      </NuxtLink>
      
      <h3 class="text-xs font-semibold text-blue-300 mt-6 mb-2">UNIT KERJA</h3>
      <div class="space-y-1">
        <div v-for="unit in unitKerjaList" :key="unit.id">
          <button
            @click="toggleUnit(unit.id)"
            class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-blue-700 text-sm transition-colors"
          >
            <span>{{ unit.nama_unit }}</span>
            <svg
              class="w-4 h-4 transition-transform"
              :class="{ 'rotate-90': expandedUnits.includes(unit.id) }"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </button>
          <NuxtLink
            v-if="expandedUnits.includes(unit.id)"
            :to="`/pegawai?unit=${unit.id}`"
            class="block px-6 py-1 text-sm rounded hover:bg-blue-700 transition-colors"
          >
            Lihat Pegawai
          </NuxtLink>
        </div>
      </div>
    </div>

    <button
      @click="handleLogout"
      class="flex items-center space-x-2 px-3 py-2 bg-red-600 rounded hover:bg-red-700 mt-4 transition-colors"
    >
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
      </svg>
      <span>Logout</span>
    </button>
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{
  unitKerjaList: any[]
}>()

const { user, logout } = useAuth()
const expandedUnits = ref([1])

const toggleUnit = (unitId: number) => {
  if (expandedUnits.value.includes(unitId)) {
    expandedUnits.value = expandedUnits.value.filter(id => id !== unitId)
  } else {
    expandedUnits.value.push(unitId)
  }
}

const handleLogout = async () => {
  if (confirm('Yakin ingin logout?')) {
    await logout()
  }
}
</script>