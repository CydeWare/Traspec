// composables/useApi.ts
export const useApi = () => {
  const config = useRuntimeConfig()
  const token = useCookie('auth_token')

  const apiFetch = $fetch.create({
    baseURL: config.public.apiBase,
    onRequest({ options }) {
      if (token.value) {
        options.headers = {
          ...options.headers,
          Authorization: `Bearer ${token.value}`
        }
      }
    },
    onResponseError({ response }) {
      if (response.status === 401) {
        token.value = null
        navigateTo('/login')
      }
    }
  })

  return {


    // Add this inside the return object of useApi()
    register: (data: any) =>
      apiFetch('/register', { method: 'POST', body: data }),

    
    // Auth
    login: (credentials: { username: string; password: string }) =>
      apiFetch('/login', { method: 'POST', body: credentials }),
    
    logout: () =>
      apiFetch('/logout', { method: 'POST' }),

    
    
    getMe: () =>
      apiFetch('/me'),

    // Pegawai
    getPegawai: (params?: any) =>
      apiFetch('/pegawai', { params }),
    
    getPegawaiById: (id: number) =>
      apiFetch(`/pegawai/${id}`),
    
    createPegawai: (data: FormData) =>
      apiFetch('/pegawai', { method: 'POST', body: data }),
    
    updatePegawai: (id: number, data: FormData) =>
      apiFetch(`/pegawai/${id}`, { method: 'POST', body: data }),
    
    deletePegawai: (id: number) =>
      apiFetch(`/pegawai/${id}`, { method: 'DELETE' }),
    
    uploadFoto: (id: number, formData: FormData) =>
      apiFetch(`/pegawai/${id}/upload-foto`, { method: 'POST', body: formData }),

    // Master Data
    getAgama: () =>
      apiFetch('/master/agama'),
    
    getGolongan: () =>
      apiFetch('/master/golongan'),
    
    getEselon: () =>
      apiFetch('/master/eselon'),
    
    getJabatan: () =>
      apiFetch('/master/jabatan'),
    
    getUnitKerja: () =>
      apiFetch('/master/unit-kerja'),
    
    getTempat: () =>
      apiFetch('/master/tempat')
  }
}