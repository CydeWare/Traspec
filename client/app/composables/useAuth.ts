// app/composables/useAuth.ts
export const useAuth = () => {
  const token = useCookie('auth_token')
  const user = useState('user', () => null)

  const register = async (data: {
    username: string
    password: string
    password_confirmation: string
    email: string
    nama_lengkap: string
  }) => {
    try {
      const api = useApi()
      const response: any = await api.register(data)
      
      if (response.success) {
        token.value = response.token
        user.value = response.user
        return { success: true }
      }
      
      return { success: false, message: 'Registrasi gagal' }
    } catch (error: any) {
      return { 
        success: false, 
        message: error.data?.message || 'Terjadi kesalahan',
        errors: error.data?.errors || {}
      }
    }
  }

  const login = async (username: string, password: string) => {
    try {
      const api = useApi()
      const response: any = await api.login({ username, password })
      
      if (response.success) {
        token.value = response.token
        user.value = response.user
        return { success: true }
      }
      
      return { success: false, message: 'Login gagal' }
    } catch (error: any) {
      return { success: false, message: error.data?.message || 'Terjadi kesalahan' }
    }
  }

  const logout = async () => {
    try {
      const api = useApi()
      await api.logout()
    } catch (error) {
      console.error('Logout error:', error)
    } finally {
      token.value = null
      user.value = null
      await navigateTo('/login')
    }
  }

  const fetchUser = async () => {
    if (!token.value) return

    try {
      const api = useApi()
      user.value = await api.getMe()
    } catch (error) {
      console.error('Fetch user error:', error)
      token.value = null
      user.value = null
    }
  }

  return {
    token,
    user,
    register,
    login,
    logout,
    fetchUser,
    isAuthenticated: computed(() => !!token.value)
  }
}