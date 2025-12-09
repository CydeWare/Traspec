// nuxt.config.ts
export default defineNuxtConfig({
  devtools: { enabled: true },
  
  modules: ['@nuxtjs/tailwindcss'],
  
  // css: ['~/assets/css/main.css'],

  imports: {
    dirs: ['composables']  // Explicitly tell Nuxt to import from composables
  },

  pages: true,
  
  runtimeConfig: {
    public: {
      apiBase: 'http://localhost:8000/api'
    }
  },

  app: {
    head: {
      title: 'Sistem Manajemen PNS',
      meta: [
        { charset: 'utf-8' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1' },
        { name: 'description', content: 'Sistem Informasi Pegawai Negeri Sipil' }
      ]
    }
  },

  compatibilityDate: '2024-12-07'
})