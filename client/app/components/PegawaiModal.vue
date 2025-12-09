<!-- components/PegawaiModal.vue -->
<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" @click.self="$emit('close')">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
      <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center z-10">
        <h3 class="text-xl font-bold">
          {{ mode === 'add' ? 'Tambah' : mode === 'edit' ? 'Edit' : 'Detail' }} Pegawai
        </h3>
        <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      
      <form @submit.prevent="handleSubmit" class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- NIP -->
          <div>
            <label class="block text-sm font-medium mb-1">NIP <span class="text-red-500">*</span></label>
            <input
              v-model="formData.nip"
              type="text"
              :disabled="mode === 'view'"
              :class="['w-full px-3 py-2 border rounded', mode === 'view' ? 'bg-gray-100' : '']"
              required
              maxlength="18"
            />
          </div>

          <!-- Nama -->
          <div>
            <label class="block text-sm font-medium mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
            <input
              v-model="formData.nama"
              type="text"
              :disabled="mode === 'view'"
              :class="['w-full px-3 py-2 border rounded', mode === 'view' ? 'bg-gray-100' : '']"
              required
            />
          </div>

          <!-- Tempat Lahir -->
          <div>
            <label class="block text-sm font-medium mb-1">Tempat Lahir</label>
            <select
              v-model="formData.tempat_lahir_id"
              :disabled="mode === 'view'"
              :class="['w-full px-3 py-2 border rounded', mode === 'view' ? 'bg-gray-100' : '']"
            >
              <option value="">Pilih Tempat</option>
              <option v-for="t in masterData?.tempat" :key="t.id" :value="t.id">
                {{ t.nama_tempat }}
              </option>
            </select>
          </div>

          <!-- Tanggal Lahir -->
          <div>
            <label class="block text-sm font-medium mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
            <input
              v-model="formData.tanggal_lahir"
              type="date"
              :disabled="mode === 'view'"
              :class="['w-full px-3 py-2 border rounded', mode === 'view' ? 'bg-gray-100' : '']"
              required
            />
          </div>

          <!-- Jenis Kelamin -->
          <div>
            <label class="block text-sm font-medium mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
            <div class="flex space-x-4 mt-2">
              <label class="flex items-center">
                <input
                  v-model="formData.jenis_kelamin"
                  type="radio"
                  value="L"
                  :disabled="mode === 'view'"
                  class="mr-2"
                />
                Laki-laki
              </label>
              <label class="flex items-center">
                <input
                  v-model="formData.jenis_kelamin"
                  type="radio"
                  value="P"
                  :disabled="mode === 'view'"
                  class="mr-2"
                />
                Perempuan
              </label>
            </div>
          </div>

          <!-- Agama -->
          <div>
            <label class="block text-sm font-medium mb-1">Agama <span class="text-red-500">*</span></label>
            <select
              v-model="formData.agama_id"
              :disabled="mode === 'view'"
              :class="['w-full px-3 py-2 border rounded', mode === 'view' ? 'bg-gray-100' : '']"
              required
            >
              <option value="">Pilih Agama</option>
              <option v-for="a in masterData?.agama" :key="a.id" :value="a.id">
                {{ a.nama_agama }}
              </option>
            </select>
          </div>

          <!-- Alamat -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium mb-1">Alamat <span class="text-red-500">*</span></label>
            <textarea
              v-model="formData.alamat"
              :disabled="mode === 'view'"
              :class="['w-full px-3 py-2 border rounded', mode === 'view' ? 'bg-gray-100' : '']"
              rows="2"
              required
            />
          </div>

          <!-- Golongan -->
          <div>
            <label class="block text-sm font-medium mb-1">Golongan <span class="text-red-500">*</span></label>
            <select
              v-model="formData.golongan_id"
              :disabled="mode === 'view'"
              :class="['w-full px-3 py-2 border rounded', mode === 'view' ? 'bg-gray-100' : '']"
              required
            >
              <option value="">Pilih Golongan</option>
              <option v-for="g in masterData?.golongan" :key="g.id" :value="g.id">
                {{ g.kode_golongan }}
              </option>
            </select>
          </div>

          <!-- Eselon -->
          <div>
            <label class="block text-sm font-medium mb-1">Eselon</label>
            <select
              v-model="formData.eselon_id"
              :disabled="mode === 'view'"
              :class="['w-full px-3 py-2 border rounded', mode === 'view' ? 'bg-gray-100' : '']"
            >
              <option value="">Pilih Eselon</option>
              <option v-for="e in masterData?.eselon" :key="e.id" :value="e.id">
                {{ e.kode_eselon }}
              </option>
            </select>
          </div>

          <!-- Jabatan -->
          <div>
            <label class="block text-sm font-medium mb-1">Jabatan <span class="text-red-500">*</span></label>
            <select
              v-model="formData.jabatan_id"
              :disabled="mode === 'view'"
              :class="['w-full px-3 py-2 border rounded', mode === 'view' ? 'bg-gray-100' : '']"
              required
            >
              <option value="">Pilih Jabatan</option>
              <option v-for="j in masterData?.jabatan" :key="j.id" :value="j.id">
                {{ j.nama_jabatan }}
              </option>
            </select>
          </div>

          <!-- Unit Kerja -->
          <div>
            <label class="block text-sm font-medium mb-1">Unit Kerja <span class="text-red-500">*</span></label>
            <select
              v-model="formData.unit_kerja_id"
              :disabled="mode === 'view'"
              :class="['w-full px-3 py-2 border rounded', mode === 'view' ? 'bg-gray-100' : '']"
              required
            >
              <option value="">Pilih Unit Kerja</option>
              <option v-for="u in unitKerjaList" :key="u.id" :value="u.id">
                {{ u.nama_unit }}
              </option>
            </select>
          </div>

          <!-- No HP -->
          <div>
            <label class="block text-sm font-medium mb-1">No. HP</label>
            <input
              v-model="formData.no_hp"
              type="text"
              :disabled="mode === 'view'"
              :class="['w-full px-3 py-2 border rounded', mode === 'view' ? 'bg-gray-100' : '']"
              placeholder="08xxxxxxxxxx"
            />
          </div>

          <!-- NPWP -->
          <div>
            <label class="block text-sm font-medium mb-1">NPWP</label>
            <input
              v-model="formData.npwp"
              type="text"
              :disabled="mode === 'view'"
              :class="['w-full px-3 py-2 border rounded', mode === 'view' ? 'bg-gray-100' : '']"
              placeholder="xxxxxxxxxxxxxxx"
            />
          </div>

          <!-- Upload Foto -->
          <div v-if="mode !== 'view'" class="md:col-span-2">
            <label class="block text-sm font-medium mb-1">Upload Foto</label>
            <input
              type="file"
              accept="image/*"
              @change="handleFileChange"
              class="w-full px-3 py-2 border rounded"
            />
            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 2MB</p>
          </div>
        </div>

        <!-- Buttons -->
        <div v-if="mode !== 'view'" class="flex justify-end space-x-2 mt-6 pt-4 border-t">
          <button
            type="button"
            @click="$emit('close')"
            class="px-4 py-2 border rounded hover:bg-gray-50"
          >
            Batal
          </button>
          <button
            type="submit"
            :disabled="submitting"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50"
          >
            {{ submitting ? 'Menyimpan...' : mode === 'add' ? 'Simpan' : 'Update' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{
  mode: 'add' | 'edit' | 'view'
  pegawai?: any
  masterData: any
  unitKerjaList: any[]
}>()

const emit = defineEmits(['close', 'saved'])
const api = useApi()

const formData = ref({
  nip: '',
  nama: '',
  tempat_lahir_id: '',
  tanggal_lahir: '',
  jenis_kelamin: 'L',
  alamat: '',
  agama_id: '',
  golongan_id: '',
  eselon_id: '',
  jabatan_id: '',
  unit_kerja_id: '',
  no_hp: '',
  npwp: ''
})

const photoFile = ref<File | null>(null)
const submitting = ref(false)

// Initialize form data if editing or viewing
if (props.pegawai && (props.mode === 'edit' || props.mode === 'view')) {
  formData.value = {
    nip: props.pegawai.nip || '',
    nama: props.pegawai.nama || '',
    tempat_lahir_id: props.pegawai.tempat_lahir?.id || '',
    tanggal_lahir: props.pegawai.tanggal_lahir || '',
    jenis_kelamin: props.pegawai.jenis_kelamin || 'L',
    alamat: props.pegawai.alamat || '',
    agama_id: props.pegawai.agama?.id || '',
    golongan_id: props.pegawai.detail_kepegawaian?.golongan?.id || '',
    eselon_id: props.pegawai.detail_kepegawaian?.eselon?.id || '',
    jabatan_id: props.pegawai.detail_kepegawaian?.jabatan?.id || '',
    unit_kerja_id: props.pegawai.detail_kepegawaian?.unit_kerja?.id || '',
    no_hp: props.pegawai.detail_kepegawaian?.no_hp || '',
    npwp: props.pegawai.detail_kepegawaian?.npwp || ''
  }
}

const handleFileChange = (e: Event) => {
  const target = e.target as HTMLInputElement
  if (target.files && target.files[0]) {
    photoFile.value = target.files[0]
  }
}

const handleSubmit = async () => {
  submitting.value = true
  
  try {
    const formDataToSend = new FormData()
    
    Object.keys(formData.value).forEach(key => {
      const value = formData.value[key as keyof typeof formData.value]
      if (value) {
        formDataToSend.append(key, value.toString())
      }
    })
    
    if (photoFile.value) {
      formDataToSend.append('foto', photoFile.value)
    }
    
    if (props.mode === 'add') {
      await api.createPegawai(formDataToSend)
      alert('Data berhasil ditambahkan')
    } else if (props.mode === 'edit') {
      formDataToSend.append('_method', 'PUT')
      await api.updatePegawai(props.pegawai.id, formDataToSend)
      alert('Data berhasil diupdate')
    }
    
    emit('saved')
  } catch (error: any) {
    console.error('Submit error:', error)
    alert(error.data?.message || 'Gagal menyimpan data')
  }
  
  submitting.value = false
}
</script>