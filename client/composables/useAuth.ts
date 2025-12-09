// composables/useAuth.ts
export const useAuth = () => {
  const token = useCookie('token', { maxAge: 60 * 60 * 24 * 7 }) // 7 days
  const user = useState('user', () => null)
  const isAuthenticated = computed(() => !!token.value)

  const login = async (credentials: { email: string; password: string }) => {
    const { $api } = useNuxtApp()
    
    try {
      const response = await $api.post('/login', credentials)
      
      if (response.success) {
        token.value = response.data.token
        user.value = response.data.user
        return { success: true, data: response.data }
      }
    } catch (error: any) {
      return { 
        success: false, 
        message: error.response?.data?.message || 'Login failed' 
      }
    }
  }

  const logout = async () => {
    const { $api } = useNuxtApp()
    
    try {
      await $api.post('/logout')
    } catch (error) {
      console.error('Logout error:', error)
    } finally {
      token.value = null
      user.value = null
      navigateTo('/login')
    }
  }

  const fetchUser = async () => {
    if (!token.value) return
    
    const { $api } = useNuxtApp()
    
    try {
      const response = await $api.get('/me')
      if (response.success) {
        user.value = response.data
      }
    } catch (error) {
      token.value = null
      user.value = null
    }
  }

  return {
    token,
    user,
    isAuthenticated,
    login,
    logout,
    fetchUser
  }
}