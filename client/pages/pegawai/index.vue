<!-- pages/pegawai/index.vue -->
<template>
  
  <div>
    <div class="bg-white rounded-lg shadow-lg p-6">
      <!-- Header -->
      <div class="flex justify-between items-center mb-6 print:mb-4">
        <div>
          <h2 class="text-2xl font-bold text-gray-800 print:text-xl">Data Pegawai Negeri Sipil</h2>
          <p v-if="selectedUnit" class="text-sm text-gray-600 mt-1">
            Filter: {{ unitKerjaList.find(u => u.id === parseInt(selectedUnit))?.nama_unit }}
          </p>
        </div>
        <div class="flex space-x-2 print:hidden">
          <button
            @click="handlePrint"
            class="flex items-center space-x-2 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition-colors"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            <span>Cetak</span>
          </button>
          <button
            @click="openModal('add')"
            class="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Pegawai</span>
          </button>
        </div>
      </div>

      <!-- Search Bar -->
      <div class="mb-6 print:hidden">
        <div class="relative">
          <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Cari berdasarkan NIP atau Nama..."
            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
        </div>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse">
          <thead class="bg-gray-50 print:bg-gray-200">
            <tr>
              <th class="px-4 py-3 text-left font-semibold text-gray-700 border">No</th>
              <th class="px-4 py-3 text-left font-semibold text-gray-700 border">NIP</th>
              <th class="px-4 py-3 text-left font-semibold text-gray-700 border">Nama</th>
              <th class="px-4 py-3 text-left font-semibold text-gray-700 border">Tempat Lahir</th>
              <th class="px-4 py-3 text-left font-semibold text-gray-700 border">Tgl Lahir</th>
              <th class="px-4 py-3 text-left font-semibold text-gray-700 border">L/P</th>
              <th class="px-4 py-3 text-left font-semibold text-gray-700 border">Gol</th>
              <th class="px-4 py-3 text-left font-semibold text-gray-700 border">Eselon</th>
              <th class="px-4 py-3 text-left font-semibold text-gray-700 border">Jabatan</th>
              <th class="px-4 py-3 text-left font-semibold text-gray-700 border">Agama</th>
              <th class="px-4 py-3 text-left font-semibold text-gray-700 border">Unit Kerja</th>
              <th class="px-4 py-3 text-left font-semibold text-gray-700 border print:hidden">No. HP</th>
              <th class="px-4 py-3 text-left font-semibold text-gray-700 border print:hidden">NPWP</th>
              <th class="px-4 py-3 text-center font-semibold text-gray-700 border print:hidden">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="loading">
              <td colspan="14" class="text-center py-8 border">
                <div class="flex items-center justify-center">
                  <svg class="animate-spin h-5 w-5 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Loading...
                </div>
              </td>
            </tr>
            <tr v-else-if="pegawaiList.length === 0">
              <td colspan="14" class="text-center py-8 text-gray-500 border">Tidak ada data pegawai</td>
            </tr>
            <tr
              v-else
              v-for="(pegawai, idx) in pegawaiList"
              :key="pegawai.id"
              class="hover:bg-gray-50 print:hover:bg-transparent"
            >
              <td class="px-4 py-2 border">{{ ((pagination.current_page - 1) * pagination.per_page) + idx + 1 }}</td>
              <td class="px-4 py-2 border">{{ pegawai.nip }}</td>
              <td class="px-4 py-2 border font-medium">{{ pegawai.nama }}</td>
              <td class="px-4 py-2 border">{{ pegawai.tempat_lahir?.nama_tempat || '-' }}</td>
              <td class="px-4 py-2 border">{{ formatDate(pegawai.tanggal_lahir) }}</td>
              <td class="px-4 py-2 border text-center">{{ pegawai.jenis_kelamin }}</td>
              <td class="px-4 py-2 border">{{ pegawai.detail_kepegawaian?.golongan?.kode_golongan || '-' }}</td>
              <td class="px-4 py-2 border">{{ pegawai.detail_kepegawaian?.eselon?.kode_eselon || '-' }}</td>
              <td class="px-4 py-2 border">{{ pegawai.detail_kepegawaian?.jabatan?.nama_jabatan || '-' }}</td>
              <td class="px-4 py-2 border">{{ pegawai.agama?.nama_agama || '-' }}</td>
              <td class="px-4 py-2 border">{{ pegawai.detail_kepegawaian?.unit_kerja?.nama_unit || '-' }}</td>
              <td class="px-4 py-2 border print:hidden">{{ pegawai.detail_kepegawaian?.no_hp || '-' }}</td>
              <td class="px-4 py-2 border print:hidden">{{ pegawai.detail_kepegawaian?.npwp || '-' }}</td>
              <td class="px-4 py-2 border text-center print:hidden">
                <div class="flex justify-center space-x-1">
                  <button
                    @click="openModal('view', pegawai)"
                    class="p-1 text-blue-600 hover:bg-blue-50 rounded transition-colors"
                    title="Lihat Detail"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                  </button>
                  <button
                    @click="openModal('edit', pegawai)"
                    class="p-1 text-green-600 hover:bg-green-50 rounded transition-colors"
                    title="Edit Data"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </button>
                  <button
                    @click="handleDelete(pegawai.id)"
                    class="p-1 text-red-600 hover:bg-red-50 rounded transition-colors"
                    title="Hapus Data"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="mt-4 flex justify-between items-center print:hidden">
        <p class="text-sm text-gray-600">
          Halaman {{ pagination.current_page }} dari {{ pagination.last_page }} | 
          Total: {{ pagination.total }} pegawai
        </p>
        <div class="flex space-x-2">
          <button
            @click="changePage(pagination.current_page - 1)"
            :disabled="pagination.current_page === 1"
            class="px-3 py-1 border rounded hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
          >
            ‹ Prev
          </button>
          <button
            v-for="page in paginationPages"
            :key="page"
            @click="changePage(page)"
            :class="[
              'px-3 py-1 border rounded transition-colors',
              pagination.current_page === page 
                ? 'bg-blue-600 text-white border-blue-600' 
                : 'hover:bg-gray-50'
            ]"
          >
            {{ page }}
          </button>
          <button
            @click="changePage(pagination.current_page + 1)"
            :disabled="pagination.current_page === pagination.last_page"
            class="px-3 py-1 border rounded hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
          >
            Next ›
          </button>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <PegawaiModal
      v-if="showModal"
      :mode="modalMode"
      :pegawai="selectedPegawai"
      :master-data="masterData"
      :unit-kerja-list="unitKerjaList"
      @close="closeModal"
      @saved="handleSaved"
    />
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  middleware: 'auth'
})

const agama = ref([])
const golongan = ref([])
const eselon = ref([])
const jabatan = ref([])
const tempat = ref([])

const api = useApi()
const route = useRoute()

const pegawaiList = ref([])
const unitKerjaList = ref([])
const masterData = ref(null)
const loading = ref(false)
const searchQuery = ref('')
const selectedUnit = ref(route.query.unit || null)
const pagination = ref({ 
  current_page: 1, 
  last_page: 1, 
  total: 0,
  per_page: 10 
})
const showModal = ref(false)
const modalMode = ref<'add' | 'edit' | 'view'>('add')
const selectedPegawai = ref(null)

const paginationPages = computed(() => {
  const pages = []
  const total = pagination.value.last_page
  const current = pagination.value.current_page
  
  for (let i = Math.max(1, current - 2); i <= Math.min(total, current + 2); i++) {
    pages.push(i)
  }
  
  return pages
})

const loadData = async () => {

 try {
    const resAgama = await axios.get('/api/master/agama')
    const resGolongan = await axios.get('/api/master/golongan')
    const resEselon = await axios.get('/api/master/eselon')
    const resJabatan = await axios.get('/api/master/jabatan')
    const resTempat = await axios.get('/api/master/tempat')

    agama.value = resAgama.data
    golongan.value = resGolongan.data
    eselon.value = resEselon.data
    jabatan.value = resJabatan.data
    tempat.value = resTempat.data

    console.log('AGAMA:', agama.value)
    console.log('GOLONGAN:', golongan.value)
    console.log('ESELON:', eselon.value)
    console.log('JABATAN:', jabatan.value)
    console.log('TEMPAT:', tempat.value)

  } catch (error) {
    console.error('ERROR MASTER DATA:', error)
  }

  loading.value = true
  try {
    const params: any = {
      page: pagination.value.current_page,
      per_page: 10
    }

    if (searchQuery.value) {
      params.search = searchQuery.value
    }

    if (selectedUnit.value) {
      params.unit_kerja_id = selectedUnit.value
    }

    const [pegawaiData, units, master] = await Promise.all([
      console.log("masterData: ", masterData);
      api.getPegawai(params),
      api.getUnitKerja(),
      Promise.all([
        api.getAgama(),
        api.getGolongan(),
        api.getEselon(),
        api.getJabatan(),
        api.getTempat()
      ]).then(([agama, golongan, eselon, jabatan, tempat]) => ({
        agama, golongan, eselon, jabatan, tempat
      }))
    ])
      console.log("masterData: ", masterData);
    pegawaiList.value = pegawaiData.data
    pagination.value = {
      current_page: pegawaiData.current_page,
      last_page: pegawaiData.last_page,
      total: pegawaiData.total,
      per_page: 10
    }
    unitKerjaList.value = units
    masterData.value = master


    console.log("masterData: ", masterData);
  } catch (error) {
    console.error('Error loading data:', error)
  }
  loading.value = false
}

const changePage = (page: number) => {
  if (page >= 1 && page <= pagination.value.last_page) {
    pagination.value.current_page = page
    loadData()
  }
}

const openModal = (mode: 'add' | 'edit' | 'view', pegawai: any = null) => {
  modalMode.value = mode
  selectedPegawai.value = pegawai
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  selectedPegawai.value = null
}

const handleSaved = () => {
  closeModal()
  loadData()
}

const handleDelete = async (id: number) => {
  if (!confirm('Yakin ingin menghapus data pegawai ini?')) return

  try {
    await api.deletePegawai(id)
    alert('Data berhasil dihapus')
    loadData()
  } catch (error) {
    console.error('Error deleting:', error)
    alert('Gagal menghapus data')
  }
}

const handlePrint = () => {
  window.print()
}

const formatDate = (date: string) => {
  if (!date) return '-'
  const d = new Date(date)
  const day = String(d.getDate()).padStart(2, '0')
  const month = String(d.getMonth() + 1).padStart(2, '0')
  const year = d.getFullYear()
  return `${day}-${month}-${year}`
}

// Watch for search query changes
watch(searchQuery, () => {
  pagination.value.current_page = 1
  loadData()
})

// Watch for route query changes (unit filter from sidebar)
watch(() => route.query.unit, (newUnit) => {
  selectedUnit.value = newUnit || null
  pagination.value.current_page = 1
  loadData()
})

// Load data on mount
onMounted(() => {
  loadData()
})
</script>